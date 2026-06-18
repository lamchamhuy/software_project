<section>
    <div class="d-flex align-items-center mb-3">
        <span class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-3"
            style="width: 44px; height: 44px;">
            <i class="fas fa-triangle-exclamation"></i>
        </span>
        <div>
            <h2 class="h5 fw-bold mb-1 text-danger">Xóa tài khoản</h2>
            <p class="text-muted mb-0">Thao tác này sẽ xóa vĩnh viễn tài khoản của bạn.</p>
        </div>
    </div>

    <button type="button" class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
        <i class="fas fa-trash me-2"></i>Xóa tài khoản
    </button>

    <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="modal-header">
                        <h2 class="modal-title h5 fw-bold" id="confirmUserDeletionLabel">Xác nhận xóa tài khoản</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <p class="text-muted">
                            Sau khi xóa, dữ liệu tài khoản sẽ không thể khôi phục. Vui lòng nhập mật khẩu để xác nhận.
                        </p>

                        <label for="password" class="form-label fw-semibold">Mật khẩu</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            class="form-control @if($errors->userDeletion->has('password')) is-invalid @endif"
                            placeholder="Nhập mật khẩu"
                        >
                        @foreach($errors->userDeletion->get('password') as $message)
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @endforeach
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-2"></i>Xóa tài khoản
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@if($errors->userDeletion->isNotEmpty())
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const modal = new bootstrap.Modal(document.getElementById('confirmUserDeletionModal'));
                modal.show();
            });
        </script>
    @endpush
@endif
