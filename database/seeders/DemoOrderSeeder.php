<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemoOrderSeeder extends Seeder
{
    public function run(): void
    {
        $customers = User::where('role', 'customer')->orderBy('id')->get();
        $shipper = User::where('role', 'shipper')->first();
        $products = Product::with('variants')->whereHas('variants')->orderBy('product_id')->get();

        if ($customers->isEmpty() || $products->isEmpty()) {
            $this->command?->warn('Need customers and products with variants before creating demo orders.');
            return;
        }

        DB::transaction(function () use ($customers, $shipper, $products) {
            $demoOrderIds = Order::where('order_number', 'like', 'DEMO%')->pluck('order_id');
            OrderItem::whereIn('order_id', $demoOrderIds)->delete();
            Order::whereIn('order_id', $demoOrderIds)->delete();

            $statuses = [
                'pending',
                'processing',
                'shipped',
                'delivered',
                'completed',
                'delivery_failed',
                'cancelled',
            ];

            $paymentMethods = ['cod', 'bank_transfer', 'momo', 'vnpay', 'stripe'];
            $cities = [
                ['city' => 'Ha Noi', 'district' => 'Cau Giay', 'ward' => 'Dich Vong', 'address' => '12 Tran Thai Tong'],
                ['city' => 'Ha Noi', 'district' => 'Dong Da', 'ward' => 'Lang Thuong', 'address' => '88 Chua Lang'],
                ['city' => 'Da Nang', 'district' => 'Hai Chau', 'ward' => 'Hoa Cuong Bac', 'address' => '210 Duong 2 Thang 9'],
                ['city' => 'TP.HCM', 'district' => 'Quan 1', 'ward' => 'Ben Nghe', 'address' => '45 Le Loi'],
                ['city' => 'TP.HCM', 'district' => 'Quan 7', 'ward' => 'Tan Phong', 'address' => '19 Nguyen Luong Bang'],
                ['city' => 'Hai Phong', 'district' => 'Le Chan', 'ward' => 'Dong Hai', 'address' => '36 To Hieu'],
            ];

            for ($i = 1; $i <= 24; $i++) {
                $status = $statuses[($i - 1) % count($statuses)];
                $customer = $customers[($i - 1) % $customers->count()];
                $paymentMethod = $paymentMethods[($i - 1) % count($paymentMethods)];
                $shipping = $cities[($i - 1) % count($cities)];
                $orderDate = now()->subDays(24 - $i)->subHours($i % 8);

                $subtotal = 0;
                $itemRows = [];
                $itemCount = 1 + ($i % 3);

                for ($j = 0; $j < $itemCount; $j++) {
                    $product = $products[($i + $j * 7) % $products->count()];
                    $variant = $product->variants[($i + $j) % $product->variants->count()];
                    $quantity = 1 + (($i + $j) % 2);
                    $price = (float) $product->price + (float) $variant->additional_price;
                    $lineTotal = $price * $quantity;
                    $subtotal += $lineTotal;

                    $itemRows[] = [
                        'product_id' => $product->product_id,
                        'product_name' => $product->name,
                        'variant_id' => $variant->variant_id,
                        'variant_name' => $variant->variant_name,
                        'quantity' => $quantity,
                        'price' => $price,
                        'total' => $lineTotal,
                    ];
                }

                $shippingFee = $subtotal >= 20000000 ? 0 : 30000 + (($i % 4) * 10000);
                $taxAmount = round($subtotal * 0.08);
                $totalAmount = $subtotal + $shippingFee + $taxAmount;
                $paymentStatus = in_array($status, ['delivered', 'completed'], true) || $paymentMethod !== 'cod'
                    ? 'paid'
                    : 'pending';

                if ($status === 'cancelled') {
                    $paymentStatus = 'refunded';
                }

                if ($status === 'delivery_failed') {
                    $paymentStatus = $paymentMethod === 'cod' ? 'pending' : 'paid';
                }

                $order = Order::create([
                    'user_id' => $customer->id,
                    'shipper_id' => in_array($status, ['processing', 'shipped', 'delivered', 'completed', 'delivery_failed'], true) ? $shipper?->id : null,
                    'order_number' => 'DEMO' . now()->format('ymd') . str_pad((string) $i, 3, '0', STR_PAD_LEFT),
                    'order_date' => $orderDate,
                    'total_amount' => $totalAmount,
                    'notes' => $status === 'delivery_failed' ? '[Shipper] Khach hen giao lai vao ngay hom sau.' : null,
                    'shipped_at' => in_array($status, ['shipped', 'delivered', 'completed', 'delivery_failed'], true) ? $orderDate->copy()->addHours(8) : null,
                    'delivered_at' => in_array($status, ['delivered', 'completed'], true) ? $orderDate->copy()->addDays(2) : null,
                    'status' => $status,
                    'payment_method' => $paymentMethod,
                    'payment_status' => $paymentStatus,
                    'shipping_name' => $customer->name,
                    'shipping_phone' => $customer->phone ?? ('09' . str_pad((string) $i, 8, '0', STR_PAD_LEFT)),
                    'shipping_address' => $shipping['address'],
                    'shipping_city' => $shipping['city'],
                    'shipping_district' => $shipping['district'],
                    'shipping_ward' => $shipping['ward'],
                    'subtotal' => $subtotal,
                    'shipping_fee' => $shippingFee,
                    'tax_amount' => $taxAmount,
                ]);

                foreach ($itemRows as $itemRow) {
                    $itemRow['order_id'] = $order->order_id;
                    OrderItem::create($itemRow);
                }
            }
        });

        $this->command?->info('Created 24 demo orders with mixed statuses.');
    }
}
