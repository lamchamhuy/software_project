<section>
    <div class="d-flex align-items-center mb-4">
        <span class="bg-danger-subtle text-danger rounded-circle d-flex align-items-center justify-content-center me-3"
            style="width: 48px; height: 48px;">
            <i class="fas fa-id-card"></i>
        </span>
        <div>
            <h2 class="h5 fw-bold mb-1">Thông tin cá nhân</h2>
            <p class="text-muted mb-0">Cập nhật tên hiển thị và địa chỉ email của bạn.</p>
        </div>
    </div>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div class="mb-3">
            <label for="name" class="form-label fw-semibold">Họ tên</label>
            <input
                id="name"
                name="name"
                type="text"
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $user->name) }}"
                required
                autofocus
                autocomplete="name"
            >
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="form-label fw-semibold">Email</label>
            <input
                id="email"
                name="email"
                type="email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email', $user->email) }}"
                required
                autocomplete="username"
            >
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="alert alert-warning mt-3 mb-0">
                    Email của bạn chưa được xác minh.
                    <button form="send-verification" class="btn btn-link p-0 align-baseline">
                        Gửi lại email xác minh
                    </button>
                    @if (session('status') === 'verification-link-sent')
                        <div class="text-success mt-2">Đã gửi link xác minh mới đến email của bạn.</div>
                    @endif
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-danger px-4">
            <i class="fas fa-save me-2"></i>Lưu thay đổi
        </button>
    </form>
</section>
