@extends('layouts.app')

@section('title', 'Giỏ hàng - TechMart')

@section('content')
    <div class="container">
        <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4">
            <div>
                <p class="text-danger fw-semibold mb-1">Giỏ hàng</p>
                <h1 class="h2 fw-bold mb-2">Sản phẩm của bạn</h1>
                <p class="text-muted mb-0">{{ $cartItems->count() }} sản phẩm trong giỏ hàng.</p>
            </div>
            <a href="{{ route('products.index') }}" class="btn btn-outline-danger">
                <i class="fas fa-arrow-left me-2"></i>Tiếp tục mua sắm
            </a>
        </div>

        @if($cartItems->count() > 0)
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="d-flex flex-column gap-3">
                        @foreach($cartItems as $item)
                            <div class="bg-white tm-card p-3">
                                <div class="row g-3 align-items-center">
                                    <div class="col-auto">
                                        <img src="{{ $item->product->image_src }}"
                                            alt="{{ $item->product->name }}"
                                            class="rounded border"
                                            style="width: 96px; height: 96px; object-fit: contain;">
                                    </div>

                                    <div class="col">
                                        <h2 class="h6 fw-bold mb-1">{{ $item->product->name }}</h2>
                                        @if($item->productVariant)
                                            <div class="text-muted small mb-1">Biến thể: {{ $item->productVariant->variant_name }}</div>
                                        @endif
                                        <div class="text-danger fw-bold">{{ number_format($item->price, 0, ',', '.') }} VND</div>
                                    </div>

                                    <div class="col-md-auto">
                                        <form action="{{ route('cart.update', $item) }}" method="POST" class="d-flex align-items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                                                max="{{ $item->product->stock_quantity }}" class="form-control form-control-sm"
                                                style="width: 80px;">
                                            <button type="submit" class="btn btn-outline-danger btn-sm">Cập nhật</button>
                                        </form>
                                    </div>

                                    <div class="col-md-auto text-md-end">
                                        <div class="fw-bold mb-2">{{ number_format($item->price * $item->quantity, 0, ',', '.') }} VND</div>
                                        <form action="{{ route('cart.remove', $item) }}" method="POST"
                                            onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link text-danger p-0 text-decoration-none">
                                                <i class="fas fa-trash me-1"></i>Xóa
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="bg-white tm-card p-4 position-sticky" style="top: 84px;">
                        <h2 class="h5 fw-bold mb-3">Tóm tắt đơn hàng</h2>
                        <div class="d-flex justify-content-between text-muted mb-2">
                            <span>Tạm tính</span>
                            <span>{{ number_format($total, 0, ',', '.') }} VND</span>
                        </div>
                        <div class="d-flex justify-content-between text-muted mb-3">
                            <span>Phí vận chuyển</span>
                            <span>Tính khi thanh toán</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="fw-bold">Tổng cộng</span>
                            <span class="fs-5 fw-bold text-danger">{{ number_format($total, 0, ',', '.') }} VND</span>
                        </div>

                        <a href="{{ route('checkout.index') }}" class="btn btn-danger w-100 mb-3">
                            <i class="fas fa-credit-card me-2"></i>Đặt hàng
                        </a>

                        <form action="{{ route('cart.clear') }}" method="POST"
                            onsubmit="return confirm('Bạn có chắc muốn xóa tất cả sản phẩm?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="fas fa-trash me-2"></i>Xóa tất cả
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center bg-white tm-card py-5">
                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                <h2 class="h5 text-muted">Giỏ hàng trống</h2>
                <p class="text-secondary mb-4">Bạn chưa có sản phẩm nào trong giỏ hàng.</p>
                <a href="{{ route('products.index') }}" class="btn btn-danger px-4">Tiếp tục mua sắm</a>
            </div>
        @endif
    </div>
@endsection
