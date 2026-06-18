@extends(auth()->check() && auth()->user()->isShipper() ? 'layouts.shipper' : 'layouts.app')

@section('title', 'Tài khoản của tôi - TechMart')

@section('content')
    <div class="container">
        <div class="bg-danger text-white rounded p-4 p-md-5 mb-4 shadow-sm">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-4">
                <div>
                    <p class="text-white-50 mb-2">Tài khoản TechMart</p>
                    <h1 class="h2 fw-bold mb-2">Xin chào, {{ $user->name }}</h1>
                    <p class="mb-0 text-white-50">{{ $user->email }}</p>
                </div>

                <div class="bg-white text-danger rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                    style="width: 84px; height: 84px;">
                    <i class="fas fa-user fs-1"></i>
                </div>
            </div>
        </div>

        @if (session('status') === 'profile-updated')
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>Thông tin tài khoản đã được cập nhật.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('status') === 'password-updated')
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>Mật khẩu đã được cập nhật.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h2 class="h5 fw-bold mb-3">Tóm tắt</h2>
                        <div class="d-flex align-items-center mb-3">
                            <span class="bg-danger-subtle text-danger rounded-circle d-flex align-items-center justify-content-center me-3"
                                style="width: 44px; height: 44px;">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <div>
                                <div class="fw-semibold">Email</div>
                                <div class="text-muted small">{{ $user->email }}</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center me-3"
                                style="width: 44px; height: 44px;">
                                <i class="fas fa-shield-alt"></i>
                            </span>
                            <div>
                                <div class="fw-semibold">Bảo mật</div>
                                <div class="text-muted small">Có thể đổi mật khẩu bất cứ lúc nào.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-danger shadow-sm">
                    <div class="card-body p-4">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
