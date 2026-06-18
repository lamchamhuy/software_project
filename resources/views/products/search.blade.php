@extends('layouts.app')

@section('title', 'Kết quả tìm kiếm: ' . $query)

@section('content')
    <div class="container">
        <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4">
            <div>
                <div class="tm-kicker mb-1">
                    <i class="fas fa-magnifying-glass"></i>Tìm kiếm
                </div>
                <h1 class="h2 fw-bold mb-2">Kết quả cho “{{ $query }}”</h1>
                <p class="text-muted mb-0">Tìm thấy {{ $products->total() }} sản phẩm.</p>
            </div>
            <a href="{{ route('home') }}" class="btn btn-outline-danger">
                <i class="fas fa-home me-2"></i>Về trang chủ
            </a>
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
                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                <h2 class="h5 text-muted">Không tìm thấy sản phẩm nào</h2>
                <p class="text-secondary mb-4">Hãy thử từ khóa khác hoặc xem các danh mục sản phẩm.</p>
                <a href="{{ route('products.index') }}" class="btn btn-danger px-4">
                    Xem tất cả sản phẩm
                </a>
            </div>
        @endif
    </div>
@endsection
