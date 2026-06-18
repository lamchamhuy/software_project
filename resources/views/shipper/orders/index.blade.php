@extends('layouts.shipper')

@section('title', 'Đơn giao hàng')

@section('content')
@php
    $statusLabels = [
        'active' => 'Đơn cần xử lý',
        'processing' => 'Mới phân công',
        'shipped' => 'Đang giao',
        'delivered' => 'Đã giao',
        'delivery_failed' => 'Giao thất bại',
        'all' => 'Tất cả đơn',
    ];

    $badgeClasses = [
        'processing' => 'bg-info text-white',
        'shipped' => 'bg-primary text-white',
        'delivered' => 'bg-success text-white',
        'completed' => 'bg-success text-white',
        'delivery_failed' => 'bg-warning text-dark',
        'cancelled' => 'bg-danger text-white',
        'pending' => 'bg-secondary text-white',
    ];
@endphp

<div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4">
    <div>
        <div class="text-danger fw-semibold mb-1">Bảng điều phối</div>
        <h1 class="h3 fw-bold mb-1">Đơn hàng của tôi</h1>
        <div class="text-muted-soft">Theo dõi các đơn đã được quản trị viên phân công.</div>
    </div>
    <form method="GET" action="{{ route('shipper.orders.index') }}" class="d-flex gap-2">
        <select class="form-select" name="status" onchange="this.form.submit()" aria-label="Lọc trạng thái đơn hàng">
            <option value="active" {{ $status === 'active' ? 'selected' : '' }}>Đơn cần xử lý</option>
            <option value="processing" {{ $status === 'processing' ? 'selected' : '' }}>Mới phân công</option>
            <option value="shipped" {{ $status === 'shipped' ? 'selected' : '' }}>Đang giao</option>
            <option value="delivered" {{ $status === 'delivered' ? 'selected' : '' }}>Đã giao</option>
            <option value="delivery_failed" {{ $status === 'delivery_failed' ? 'selected' : '' }}>Giao thất bại</option>
            <option value="all" {{ $status === 'all' ? 'selected' : '' }}>Tất cả</option>
        </select>
    </form>
</div>

<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="metric-card p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small">Cần xử lý</div>
                    <div class="h3 fw-bold mb-0">{{ $stats['active'] }}</div>
                </div>
                <span class="metric-icon bg-danger-subtle text-danger"><i class="fas fa-route"></i></span>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="metric-card p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small">Đang giao</div>
                    <div class="h3 fw-bold mb-0">{{ $stats['shipped'] }}</div>
                </div>
                <span class="metric-icon bg-primary-subtle text-primary"><i class="fas fa-truck"></i></span>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="metric-card p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small">Đã hoàn tất</div>
                    <div class="h3 fw-bold mb-0">{{ $stats['delivered'] }}</div>
                </div>
                <span class="metric-icon bg-success-subtle text-success"><i class="fas fa-circle-check"></i></span>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="metric-card p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small">Giao thất bại</div>
                    <div class="h3 fw-bold mb-0">{{ $stats['failed'] }}</div>
                </div>
                <span class="metric-icon bg-warning-subtle text-warning"><i class="fas fa-triangle-exclamation"></i></span>
            </div>
        </div>
    </div>
</div>

<div class="delivery-panel p-3 p-lg-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
        <h2 class="h5 fw-bold mb-0">{{ $statusLabels[$status] ?? 'Đơn hàng' }}</h2>
        <span class="text-muted small">{{ $orders->total() }} đơn</span>
    </div>

    <div class="d-flex flex-column gap-3">
        @forelse($orders as $order)
            @php
                $fullAddress = trim(collect([
                    $order->shipping_address,
                    $order->shipping_ward,
                    $order->shipping_district,
                    $order->shipping_city,
                    'Vietnam',
                ])->filter()->implode(', '));
            @endphp

            <article class="order-card p-3">
                <div class="row g-3 align-items-center">
                    <div class="col-lg">
                        <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                            <a href="{{ route('shipper.orders.show', $order) }}" class="fw-bold text-decoration-none text-dark">
                                {{ $order->order_number ?? '#' . $order->order_id }}
                            </a>
                            <span class="status-pill {{ $badgeClasses[$order->status] ?? 'bg-secondary text-white' }}">
                                {{ $order->status_label }}
                            </span>
                        </div>

                        <div class="fw-semibold mb-1">{{ $order->shipping_name }}</div>
                        <div class="d-flex flex-wrap gap-3 text-muted small mb-1">
                            <span><i class="fas fa-phone me-1"></i>{{ $order->shipping_phone }}</span>
                            <span><i class="fas fa-box me-1"></i>{{ $order->orderItems->count() }} sản phẩm</span>
                            <span><i class="fas fa-calendar me-1"></i>{{ $order->order_date->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="text-muted small">
                            <i class="fas fa-location-dot me-1"></i>{{ $fullAddress }}
                        </div>
                    </div>

                    <div class="col-lg-auto text-lg-end">
                        <div class="fw-bold text-danger mb-2">{{ number_format($order->total_amount, 0, ',', '.') }} VND</div>
                        <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                            <a class="btn btn-outline-primary btn-sm"
                                href="https://www.google.com/maps/dir/?api=1&destination={{ urlencode($fullAddress) }}"
                                target="_blank"
                                rel="noopener">
                                <i class="fas fa-map-location-dot me-1"></i>Bản đồ
                            </a>
                            <a class="btn btn-outline-secondary btn-sm" href="{{ route('shipper.orders.show', $order) }}">
                                <i class="fas fa-eye me-1"></i>Chi tiết
                            </a>
                            @if($order->status === 'processing')
                                <form method="POST" action="{{ route('shipper.orders.update-status', $order) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="shipped">
                                    <button class="btn btn-primary btn-sm" type="submit">
                                        <i class="fas fa-truck me-1"></i>Nhận giao
                                    </button>
                                </form>
                            @elseif($order->status === 'shipped')
                                <form method="POST" action="{{ route('shipper.orders.update-status', $order) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="delivered">
                                    <button class="btn btn-success btn-sm" type="submit">
                                        <i class="fas fa-check me-1"></i>Đã giao
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </article>
        @empty
            <div class="text-center bg-white border rounded p-5">
                <i class="fas fa-clipboard-check fa-3x text-muted mb-3"></i>
                <h2 class="h5">Chưa có đơn nào</h2>
                <p class="text-muted mb-0">Khi quản trị viên phân công đơn hàng, đơn sẽ xuất hiện tại đây.</p>
            </div>
        @endforelse
    </div>
</div>

<div class="mt-4">{{ $orders->appends(request()->query())->links() }}</div>
@endsection
