<nav class="navbar navbar-expand-lg sticky-top border-bottom" style="min-height: 64px; background: rgba(255, 255, 255, 0.88); backdrop-filter: blur(16px);">
    <div class="container-fluid px-3 px-lg-4">
        <a class="navbar-brand text-danger fw-bold d-flex align-items-center" href="{{ auth()->check() && auth()->user()->isShipper() ? route('shipper.dashboard') : route('home') }}">
            <span class="bg-danger text-white rounded d-inline-flex align-items-center justify-content-center me-2 shadow-sm"
                style="width: 38px; height: 38px;">
                <i class="fas fa-store"></i>
            </span>
            TechMart
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
            aria-controls="mainNavbar" aria-expanded="false" aria-label="Mở menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse gap-3" id="mainNavbar">
            @unless(auth()->check() && auth()->user()->isShipper())
                <form class="d-flex flex-grow-1 mx-lg-4 my-3 my-lg-0" action="{{ route('search') }}" method="GET">
                    <div class="input-group shadow-sm rounded overflow-hidden">
                        <span class="input-group-text bg-white border-end-0 text-muted">
                            <i class="fas fa-magnifying-glass"></i>
                        </span>
                        <input class="form-control border-start-0" type="search" name="q" placeholder="Tìm kiếm sản phẩm..."
                            value="{{ request('q') }}">
                        <button class="btn btn-danger px-4" type="submit" aria-label="Tìm kiếm">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            @endunless

            <ul class="navbar-nav align-items-lg-center ms-lg-auto gap-lg-1">
                @guest
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link">
                            <i class="fas fa-shopping-cart me-1"></i>Giỏ hàng
                        </a>
                    </li>
                @else
                    @if(auth()->user()->isCustomer())
                        <li class="nav-item">
                            <a href="{{ route('cart.index') }}" class="nav-link position-relative">
                                <i class="fas fa-shopping-cart me-1"></i>Giỏ hàng
                                @if(auth()->user()->cartItems->count() > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-count">
                                        {{ auth()->user()->cartItems->sum('quantity') }}
                                    </span>
                                @endif
                            </a>
                        </li>
                    @endif
                @endguest

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user me-1"></i>Tài khoản
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                        @auth
                            <li><span class="dropdown-item-text fw-semibold">{{ auth()->user()->name }}</span></li>
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Thông tin cá nhân</a></li>

                            @if(auth()->user()->isCustomer())
                                <li><a class="dropdown-item" href="{{ route('cart.index') }}">Giỏ hàng</a></li>
                                <li><a class="dropdown-item" href="{{ route('orders.index') }}">Đơn hàng của tôi</a></li>
                            @elseif(auth()->user()->isShipper())
                                <li><a class="dropdown-item" href="{{ route('shipper.dashboard') }}">Trang giao hàng</a></li>
                            @elseif(auth()->user()->isAdmin())
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Trang quản trị</a></li>
                            @endif

                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item" type="submit">Đăng xuất</button>
                                </form>
                            </li>
                        @else
                            <li><a class="dropdown-item" href="{{ route('login') }}">Đăng nhập</a></li>
                            <li><a class="dropdown-item" href="{{ route('register') }}">Đăng ký</a></li>
                        @endauth
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

@auth
@if(auth()->user()->isCustomer())
<script>
document.addEventListener('DOMContentLoaded', function() {
    updateCartCount();
});

function updateCartCount() {
    fetch('{{ route("cart.count") }}')
        .then(response => response.json())
        .then(data => {
            const cartBadge = document.querySelector('.cart-count');
            if (cartBadge) {
                cartBadge.textContent = data.count;
                cartBadge.style.display = data.count > 0 ? 'inline' : 'none';
            }
        })
        .catch(error => console.error('Error updating cart count:', error));
}

window.updateCartCount = updateCartCount;
</script>
@endif
@endauth
