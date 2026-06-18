<?php

namespace App\Http\Controllers\Shipper;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class DeliveryController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'active');

        $query = Order::with(['user', 'orderItems.product'])
            ->where('shipper_id', Auth::id());

        if ($status === 'active') {
            $query->whereIn('status', ['processing', 'shipped']);
        } elseif ($status !== 'all') {
            $query->where('status', $status);
        }

        $orders = $query->orderByRaw("FIELD(status, 'processing', 'shipped', 'delivery_failed', 'delivered', 'completed', 'cancelled')")
            ->orderBy('order_date', 'desc')
            ->paginate(12);

        $stats = [
            'active' => Order::where('shipper_id', Auth::id())->whereIn('status', ['processing', 'shipped'])->count(),
            'shipped' => Order::where('shipper_id', Auth::id())->where('status', 'shipped')->count(),
            'delivered' => Order::where('shipper_id', Auth::id())->whereIn('status', ['delivered', 'completed'])->count(),
            'failed' => Order::where('shipper_id', Auth::id())->where('status', 'delivery_failed')->count(),
        ];

        return view('shipper.orders.index', compact('orders', 'stats', 'status'));
    }

    public function show(Order $order)
    {
        $this->authorizeOrder($order);

        $order->load(['user', 'orderItems.product', 'orderItems.productVariant']);

        return view('shipper.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $this->authorizeOrder($order);

        $data = $request->validate([
            'status' => 'required|in:shipped,delivered,delivery_failed',
            'notes' => 'nullable|required_if:status,delivery_failed|string|max:500',
        ]);

        if ($order->status === 'processing' && $data['status'] !== 'shipped') {
            return back()->with('error', 'Hãy nhận đơn trước khi cập nhật kết quả giao hàng.');
        }

        if (! in_array($order->status, ['processing', 'shipped'], true)) {
            return back()->with('error', 'Đơn hàng này không còn trong trạng thái giao hàng.');
        }

        $order->status = $data['status'];

        if ($data['status'] === 'shipped' && Schema::hasColumn('orders', 'shipped_at')) {
            $order->shipped_at = now();
        }

        if ($data['status'] === 'delivered') {
            if (Schema::hasColumn('orders', 'delivered_at')) {
                $order->delivered_at = now();
            }

            if ($order->payment_method === 'cod' && Schema::hasColumn('orders', 'payment_status')) {
                $order->payment_status = 'paid';
            }
        }

        if (! empty($data['notes'])) {
            $order->notes = trim(($order->notes ? $order->notes . "\n" : '') . '[Shipper] ' . $data['notes']);
        }

        $order->save();

        return back()->with('success', 'Cập nhật trạng thái giao hàng thành công.');
    }

    private function authorizeOrder(Order $order): void
    {
        abort_unless($order->shipper_id === Auth::id(), 403);
    }
}
