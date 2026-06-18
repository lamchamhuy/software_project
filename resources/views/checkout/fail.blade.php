@extends('layouts.app')

@section('title', 'Thanh toan that bai')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                    style="width: 64px; height: 64px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" stroke="#dc3545"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6L6 18" />
                        <path d="M6 6l12 12" />
                    </svg>
                </div>

                <h1 class="h3 fw-bold text-dark">Thanh toan khong thanh cong</h1>
                <p class="text-muted">
                    {{ session('error') ?? ($message ?? 'Giao dich da bi huy hoac khong the hoan tat. Vui long thu lai.') }}
                </p>

                <div class="d-flex gap-2 justify-content-center mt-4">
                    <a href="{{ route('cart.index') }}" class="btn btn-primary">Quay lai gio hang</a>
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary">Ve trang chu</a>
                </div>
            </div>
        </div>
    </div>
@endsection
