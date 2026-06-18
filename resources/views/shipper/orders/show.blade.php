@extends('layouts.shipper')

@section('title', 'Chi tiết đơn hàng')

@section('content')
@php
    $fullAddress = trim(collect([
        $order->shipping_address,
        $order->shipping_ward,
        $order->shipping_district,
        $order->shipping_city,
        'Vietnam',
    ])->filter()->implode(', '));

    $mapQuery = urlencode($fullAddress);
    $statusClass = [
        'processing' => 'bg-info text-white',
        'shipped' => 'bg-primary text-white',
        'delivered' => 'bg-success text-white',
        'completed' => 'bg-success text-white',
        'delivery_failed' => 'bg-warning text-dark',
        'cancelled' => 'bg-danger text-white',
    ][$order->status] ?? 'bg-secondary text-white';
@endphp

<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <div class="text-danger fw-semibold mb-1">Chi tiết giao hàng</div>
        <h1 class="h3 fw-bold mb-1">{{ $order->order_number ?? '#' . $order->order_id }}</h1>
        <span class="status-pill {{ $statusClass }}">{{ $order->status_label }}</span>
    </div>
    <a href="{{ route('shipper.orders.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i>Quay lại
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <section class="delivery-panel mb-4">
            <div class="p-3 p-lg-4 border-bottom">
                <h2 class="h5 fw-bold mb-0">Thông tin người nhận</h2>
            </div>
            <div class="p-3 p-lg-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="text-muted small">Người nhận</div>
                        <div class="fw-semibold">{{ $order->shipping_name }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted small">Số điện thoại</div>
                        <div class="fw-semibold">
                            <a href="tel:{{ $order->shipping_phone }}" class="text-decoration-none text-dark">
                                {{ $order->shipping_phone }}
                            </a>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="text-muted small">Địa chỉ</div>
                        <div class="fw-semibold">{{ $fullAddress }}</div>
                    </div>
                </div>
            </div>
        </section>

        <section class="delivery-panel mb-4 overflow-hidden">
            <div class="p-3 p-lg-4 border-bottom d-flex flex-wrap align-items-center justify-content-between gap-2">
                <h2 class="h5 fw-bold mb-0">Bản đồ giao hàng</h2>
                <a class="btn btn-primary btn-sm"
                    href="https://www.google.com/maps/dir/?api=1&destination={{ $mapQuery }}"
                    target="_blank"
                    rel="noopener">
                    <i class="fas fa-route me-1"></i>Mở chỉ đường
                </a>
            </div>
            <iframe
                src="https://www.google.com/maps?q={{ $mapQuery }}&output=embed"
                width="100%"
                height="340"
                style="border:0; display:block;"
                allowfullscreen
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                title="Bản đồ giao hàng {{ $order->order_number ?? $order->order_id }}">
            </iframe>
            <div class="px-3 px-lg-4 py-3 small text-muted bg-white border-top">{{ $fullAddress }}</div>
        </section>

        <section class="delivery-panel">
            <div class="p-3 p-lg-4 border-bottom">
                <h2 class="h5 fw-bold mb-0">Sản phẩm trong đơn</h2>
            </div>
            <div class="p-3 p-lg-4">
                @foreach($order->orderItems as $item)
                    <div class="d-flex align-items-center gap-3 py-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                        @if($item->product)
                            <img src="{{ $item->product->image_src }}" alt="{{ $item->product->name }}" class="rounded border bg-white" style="width: 68px; height: 68px; object-fit: contain;">
                        @endif
                        <div class="flex-grow-1">
                            <div class="fw-semibold">{{ $item->product_name ?? ($item->product->name ?? 'Sản phẩm') }}</div>
                            @if($item->variant_name)
                                <div class="text-muted small">{{ $item->variant_name }}</div>
                            @endif
                            <div class="text-muted small">SL: {{ $item->quantity }} x {{ number_format($item->price, 0, ',', '.') }} VND</div>
                        </div>
                        <div class="fw-bold text-end">{{ number_format($item->total ?? ($item->price * $item->quantity), 0, ',', '.') }} VND</div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>

    <div class="col-lg-4">
        <section class="delivery-panel mb-4">
            <div class="p-3 p-lg-4 border-bottom">
                <h2 class="h5 fw-bold mb-0">Tổng quan</h2>
            </div>
            <div class="p-3 p-lg-4">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Trạng thái</span>
                    <span class="status-pill {{ $statusClass }}">{{ $order->status_label }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Ngày đặt</span>
                    <strong>{{ $order->order_date->format('d/m/Y H:i') }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Thanh toán</span>
                    <strong>{{ $order->payment_method_label }}</strong>
                </div>
                <div class="d-flex justify-content-between pt-3 mt-3 border-top">
                    <span class="text-muted">Tổng thu</span>
                    <strong class="text-danger">{{ number_format($order->total_amount, 0, ',', '.') }} VND</strong>
                </div>
            </div>
        </section>

        @if(in_array($order->status, ['processing', 'shipped']))
            <section class="delivery-panel">
                <div class="p-3 p-lg-4 border-bottom">
                    <h2 class="h5 fw-bold mb-0">Cập nhật giao hàng</h2>
                </div>
                <div class="p-3 p-lg-4">
                    @if($order->status === 'processing')
                        <form method="POST" action="{{ route('shipper.orders.update-status', $order) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="shipped">
                            <button class="btn btn-primary w-100" type="submit">
                                <i class="fas fa-truck me-1"></i>Nhận giao đơn này
                            </button>
                        </form>
                    @endif

                    @if($order->status === 'shipped')
                        <form method="POST" action="{{ route('shipper.orders.update-status', $order) }}" class="mb-3">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="delivered">
                            <button class="btn btn-success w-100" type="submit">
                                <i class="fas fa-check me-1"></i>Xác nhận đã giao
                            </button>
                        </form>

                        <form method="POST" action="{{ route('shipper.orders.update-status', $order) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="delivery_failed">
                            <label class="form-label fw-semibold">Ghi chú khi giao không thành công</label>
                            <textarea class="form-control mb-2" name="notes" rows="3" placeholder="Ví dụ: khách không nghe máy, sai địa chỉ..." required></textarea>
                            <button class="btn btn-outline-danger w-100" type="submit" onclick="return confirm('Xác nhận đơn này giao không thành công?')">
                                <i class="fas fa-triangle-exclamation me-1"></i>Giao không thành công
                            </button>
                        </form>
                    @endif
                </div>
            </section>
        @endif
    </div>
</div>
@endsection
