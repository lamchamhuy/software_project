@extends('layouts.app')

@section('title', $product->name . ' - TechMart')

@section('content')
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-triangle-exclamation me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
            </div>
        @endif

        <div class="bg-white tm-card p-3 p-lg-4">
            <div class="row g-4">
                <div class="col-lg-7">
                    <div class="bg-light rounded text-center p-4">
                        <img src="{{ $product->image_src }}"
                            alt="{{ $product->name }}"
                            class="img-fluid"
                            style="max-height: 460px; object-fit: contain;">
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="mb-3">
                        <span class="badge bg-danger-subtle text-danger mb-3">
                            {{ $product->category->category_name ?? 'Chưa phân loại' }}
                        </span>
                        <h1 class="h2 fw-bold mb-3">{{ $product->name }}</h1>
                        <div class="display-6 fw-bold text-danger mb-3">
                            {{ number_format($product->price, 0, ',', '.') }} VND
                        </div>
                        <div class="mb-4">
                            @if($product->stock_quantity > 0)
                                <span class="badge bg-success-subtle text-success">
                                    <i class="fas fa-check-circle me-1"></i>Còn hàng
                                </span>
                                <span class="text-muted ms-2">{{ $product->stock_quantity }} sản phẩm có sẵn</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger">
                                    <i class="fas fa-times-circle me-1"></i>Hết hàng
                                </span>
                            @endif
                        </div>
                    </div>

                    @auth
                        @if(auth()->user()->isCustomer())
                        <form action="{{ route('cart.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->product_id }}">

                            <div class="mb-3">
                                <label for="quantity" class="form-label fw-semibold">Số lượng</label>
                                <select name="quantity" id="quantity" class="form-select" {{ $product->stock_quantity <= 0 ? 'disabled' : '' }}>
                                    @for($i = 1; $i <= max(1, min(10, $product->stock_quantity)); $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                            @if($product->variants->count() > 0)
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Biến thể</label>
                                    <div class="row g-2">
                                        @foreach($product->variants as $variant)
                                            <div class="col-sm-6">
                                                <input class="btn-check" type="radio" name="variant_id"
                                                    id="variant-{{ $variant->variant_id }}"
                                                    value="{{ $variant->variant_id }}">
                                                <label class="btn btn-outline-danger w-100 text-start" for="variant-{{ $variant->variant_id }}">
                                                    <span class="fw-semibold d-block">{{ $variant->variant_name }}</span>
                                                    <small>
                                                        @if($variant->additional_price > 0)
                                                            +{{ number_format($variant->additional_price, 0, ',', '.') }} VND
                                                        @else
                                                            Không tăng giá
                                                        @endif
                                                    </small>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <button type="submit"
                                id="add-to-cart-btn"
                                class="btn btn-danger btn-lg w-100"
                                @if($product->stock_quantity <= 0 || $product->variants->count() > 0) disabled @endif>
                                <i class="fas fa-cart-plus me-2"></i>
                                {{ $product->stock_quantity > 0 ? 'Thêm vào giỏ' : 'Hết hàng' }}
                            </button>
                        </form>
                        @elseif(auth()->user()->isShipper())
                            <a href="{{ route('shipper.dashboard') }}" class="btn btn-outline-secondary btn-lg w-100">
                                <i class="fas fa-truck me-2"></i>Quay ve trang giao hang
                            </a>
                        @else
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-lg w-100">
                                <i class="fas fa-gauge me-2"></i>Quay ve trang quan tri
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-danger btn-lg w-100">
                            <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập để mua hàng
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        <div class="bg-white tm-card p-4 mt-4">
            <h2 class="h5 fw-bold mb-3">Mô tả sản phẩm</h2>
            <p class="text-secondary mb-0">{{ $product->description ?: 'Sản phẩm chưa có mô tả chi tiết.' }}</p>
        </div>

        @if(isset($relatedProducts) && $relatedProducts->count())
            <section class="mt-5">
                <h2 class="h4 fw-bold mb-3">Sản phẩm liên quan</h2>
                <div class="row g-3">
                    @foreach($relatedProducts as $relatedProduct)
                        <div class="col-6 col-md-4 col-xl-3">
                            @include('products.partials.card', ['product' => $relatedProduct])
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const radios = document.querySelectorAll('input[name="variant_id"]');
                const addToCartBtn = document.getElementById('add-to-cart-btn');

                if (!addToCartBtn || radios.length === 0) {
                    return;
                }

                radios.forEach(radio => {
                    radio.addEventListener('change', () => {
                        addToCartBtn.disabled = false;
                    });
                });
            });
        </script>
    @endpush
@endsection
