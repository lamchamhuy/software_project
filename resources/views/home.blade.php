@extends('layouts.app')

@section('title', 'TechMart - Trang chủ')

@section('content')
    <div class="container">
        <section class="tm-hero p-4 p-lg-5 mb-5">
            <div class="row align-items-center g-4">
                <div class="col-lg-7">
                    <p class="text-white-50 fw-semibold mb-2">
                        <i class="fas fa-bolt me-2"></i>Mua sắm công nghệ dễ dàng
                    </p>
                    <h1 class="display-5 fw-bold mb-3">TechMart</h1>
                    <p class="lead mb-4">Khám phá điện thoại, laptop và phụ kiện mới với mức giá hợp lý, thông tin rõ ràng và thao tác mua nhanh.</p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('products.index') }}" class="btn btn-light text-danger fw-semibold px-4">
                            Xem sản phẩm <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                        @guest
                            <a href="{{ route('register') }}" class="btn btn-outline-light fw-semibold px-4">
                                Tạo tài khoản
                            </a>
                        @endguest
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="tm-glass-panel p-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-truck-fast fs-3 me-3"></i>
                            <div>
                                <div class="fw-bold">Giao hàng nhanh</div>
                                <div class="text-white-50 small">Theo dõi đơn hàng rõ ràng</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-shield-halved fs-3 me-3"></i>
                            <div>
                                <div class="fw-bold">Mua sắm an tâm</div>
                                <div class="text-white-50 small">Sản phẩm có thông tin minh bạch</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-headset fs-3 me-3"></i>
                            <div>
                                <div class="fw-bold">Hỗ trợ thuận tiện</div>
                                <div class="text-white-50 small">Quản lý giỏ hàng và đơn hàng dễ dàng</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @if ($categoriesWithProducts)
            @foreach ($categoriesWithProducts as $categoryData)
                <section class="mb-5">
                    <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-3">
                        <div>
                            <div class="tm-kicker mb-1">
                                <i class="fas fa-tag"></i>{{ $categoryData['category']->category_name }}
                            </div>
                            <h2 class="h4 fw-bold mb-1">Sản phẩm nổi bật</h2>
                            <p class="text-muted mb-0">Những lựa chọn mới trong danh mục này.</p>
                        </div>
                        <a href="{{ route('products.category', $categoryData['category']) }}" class="btn btn-outline-danger">
                            Xem tất cả <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>

                    <div class="row g-3">
                        @foreach ($categoryData['products'] as $product)
                            <div class="col-6 col-md-4 col-xl-3">
                                @include('products.partials.card', ['product' => $product])
                            </div>
                        @endforeach
                    </div>
                </section>
            @endforeach
        @else
            <div class="text-center bg-white tm-card py-5">
                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                <h2 class="h5 text-muted">Chưa có sản phẩm nào</h2>
                <p class="text-secondary mb-0">Vui lòng quay lại sau.</p>
            </div>
        @endif
    </div>
@endsection
