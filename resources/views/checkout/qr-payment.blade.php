@extends('layouts.app')

@section('title', 'Thanh toan bang ma QR')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="text-center mb-4">
                    <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                        style="width: 68px; height: 68px;">
                        <i class="fas fa-qrcode fa-2x text-danger"></i>
                    </div>
                    <h1 class="h3 fw-bold">Thanh toan bang ma QR</h1>
                    <p class="text-muted mb-0">Don hang {{ $order->order_number }}</p>
                </div>

                <div class="row g-4">
                    <div class="col-md-5">
                        <div class="card shadow-sm h-100">
                            <div class="card-body text-center">
                                <div class="border rounded bg-white p-3 d-inline-block">
                                    <img src="{{ $qrImageUrl }}" alt="QR thanh toan {{ $order->order_number }}"
                                        class="img-fluid" style="max-width: 260px;">
                                </div>
                                <p class="small text-muted mt-3 mb-0">
                                    Quet ma bang ung dung ngan hang va kiem tra dung so tien, noi dung chuyen khoan.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3">Thong tin chuyen khoan</h5>

                                <div class="table-responsive">
                                    <table class="table table-sm align-middle">
                                        <tbody>
                                            <tr>
                                                <th class="text-muted fw-normal">Ngan hang</th>
                                                <td class="fw-semibold text-end">{{ $bank['name'] }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-muted fw-normal">So tai khoan</th>
                                                <td class="fw-semibold font-monospace text-end">{{ $bank['account_number'] }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-muted fw-normal">Chu tai khoan</th>
                                                <td class="fw-semibold text-end">{{ $bank['account_name'] }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-muted fw-normal">Chi nhanh</th>
                                                <td class="fw-semibold text-end">{{ $bank['branch'] }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-muted fw-normal">So tien</th>
                                                <td class="fw-bold text-danger text-end">
                                                    {{ number_format($order->total_amount, 0, ',', '.') }} VND
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="text-muted fw-normal">Noi dung</th>
                                                <td class="fw-bold font-monospace text-end">{{ $order->order_number }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="alert alert-warning small mb-0">
                                    Don hang se duoc xu ly sau khi TechMart xac nhan da nhan thanh toan.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm mt-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Tom tat don hang</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Tam tinh</span>
                            <span>{{ number_format($order->subtotal, 0, ',', '.') }} VND</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Phi van chuyen</span>
                            <span>{{ number_format($order->shipping_fee, 0, ',', '.') }} VND</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Thue VAT</span>
                            <span>{{ number_format($order->tax_amount, 0, ',', '.') }} VND</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold fs-5">
                            <span>Tong cong</span>
                            <span class="text-danger">{{ number_format($order->total_amount, 0, ',', '.') }} VND</span>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-column flex-sm-row gap-3 mt-4">
                    <a href="{{ route('orders.show', $order) }}" class="btn btn-danger flex-fill">
                        <i class="fas fa-eye me-2"></i>Xem don hang
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary flex-fill">
                        Tiep tuc mua hang
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
