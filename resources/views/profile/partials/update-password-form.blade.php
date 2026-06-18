<section>
    <div class="d-flex align-items-center mb-4">
        <span class="bg-danger-subtle text-danger rounded-circle d-flex align-items-center justify-content-center me-3"
            style="width: 48px; height: 48px;">
            <i class="fas fa-lock"></i>
        </span>
        <div>
            <h2 class="h5 fw-bold mb-1">Đổi mật khẩu</h2>
            <p class="text-muted mb-0">Dùng mật khẩu dài và khó đoán để bảo vệ tài khoản.</p>
        </div>
    </div>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="mb-3">
            <label for="update_password_current_password" class="form-label fw-semibold">Mật khẩu hiện tại</label>
            <input
                id="update_password_current_password"
                name="current_password"
                type="password"
                class="form-control @if($errors->updatePassword->has('current_password')) is-invalid @endif"
                autocomplete="current-password"
            >
            @foreach($errors->updatePassword->get('current_password') as $message)
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @endforeach
        </div>

        <div class="mb-3">
            <label for="update_password_password" class="form-label fw-semibold">Mật khẩu mới</label>
            <input
                id="update_password_password"
                name="password"
                type="password"
                class="form-control @if($errors->updatePassword->has('password')) is-invalid @endif"
                autocomplete="new-password"
            >
            @foreach($errors->updatePassword->get('password') as $message)
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @endforeach
        </div>

        <div class="mb-4">
            <label for="update_password_password_confirmation" class="form-label fw-semibold">Xác nhận mật khẩu mới</label>
            <input
                id="update_password_password_confirmation"
                name="password_confirmation"
                type="password"
                class="form-control @if($errors->updatePassword->has('password_confirmation')) is-invalid @endif"
                autocomplete="new-password"
            >
            @foreach($errors->updatePassword->get('password_confirmation') as $message)
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-danger px-4">
            <i class="fas fa-key me-2"></i>Cập nhật mật khẩu
        </button>
    </form>
</section>
