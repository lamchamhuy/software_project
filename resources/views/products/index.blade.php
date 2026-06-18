@extends('layouts.app')

@section('title', ($currentCategory ?? null) ? $currentCategory->category_name . ' - TechMart' : 'Sản phẩm - TechMart')

@section('content')
    <div class="container">
        <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4">
            <div>
                <div class="tm-kicker mb-1">
                    <i class="fas fa-boxes-stacked"></i>Danh sách sản phẩm
                </div>
                <h1 class="h2 fw-bold mb-2">
                    {{ ($currentCategory ?? null) ? $currentCategory->category_name : 'Tất cả sản phẩm' }}
                </h1>
                <p class="text-muted mb-0">Tìm thấy {{ $products->total() }} sản phẩm phù hợp.</p>
            </div>

            @if($currentCategory ?? null)
                <a href="{{ route('products.index') }}" class="btn btn-outline-danger">
                    <i class="fas fa-list me-2"></i>Tất cả sản phẩm
                </a>
            @endif
        </div>

        <div class="bg-white tm-card p-3 p-lg-4 mb-4">
            <form method="GET" action="{{ route('products.index') }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="search" class="form-label fw-semibold">Tìm kiếm</label>
                    <input type="text" name="search" id="search" value="{{ request()->query('search') }}"
                        class="form-control" placeholder="Tên sản phẩm...">
                </div>

                <div class="col-md-3">
                    <label for="category" class="form-label fw-semibold">Danh mục</label>
                    <select name="category" id="category" class="form-select">
                        <option value="">Tất cả danh mục</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->category_id }}"
                                {{ request()->query('category', ($currentCategory ?? null)?->category_id) == $category->category_id ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="min_price" class="form-label fw-semibold">Giá từ</label>
                    <input type="number" min="0" name="min_price" id="min_price"
                        value="{{ request()->query('min_price') }}" class="form-control">
                </div>

                <div class="col-md-2">
                    <label for="max_price" class="form-label fw-semibold">Giá đến</label>
                    <input type="number" min="0" name="max_price" id="max_price"
                        value="{{ request()->query('max_price') }}" class="form-control">
                </div>

                <div class="col-md-1">
                    <button type="submit" class="btn btn-danger w-100" aria-label="Lọc sản phẩm">
                        <i class="fas fa-filter"></i>
                    </button>
                </div>
            </form>
        </div>

        @if($products->count())
            <div class="row g-3">
                @foreach($products as $product)
                    <div class="col-6 col-md-4 col-xl-3">
                        @include('products.partials.card', ['product' => $product])
                    </div>
                @endforeach
            </div>

            @if($products->hasPages())
                <div class="mt-4">
                    {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
            @endif
        @else
            <div class="text-center bg-white tm-card py-5">
                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                <h2 class="h5 text-muted">Không có sản phẩm nào</h2>
                <p class="text-secondary mb-0">Hãy đổi bộ lọc hoặc chọn danh mục khác.</p>
            </div>
        @endif
    </div>
@endsection
