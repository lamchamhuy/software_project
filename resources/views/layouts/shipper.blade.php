<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Giao hàng') - TechMart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --tm-red: #dc2626;
            --tm-red-soft: #fee2e2;
            --tm-ink: #111827;
            --tm-muted: #6b7280;
            --tm-border: #e5e7eb;
            --tm-surface: #ffffff;
            --tm-bg: #f4f6fb;
        }

        body {
            min-height: 100vh;
            background: var(--tm-bg);
            color: var(--tm-ink);
        }

        .shipper-nav {
            min-height: 64px;
            background: #111827;
            box-shadow: 0 8px 24px rgba(17, 24, 39, .16);
        }

        .shipper-shell {
            min-height: calc(100vh - 64px);
        }

        .shipper-sidebar {
            position: sticky;
            top: 64px;
            width: 268px;
            height: calc(100vh - 64px);
            flex: 0 0 268px;
            overflow-y: auto;
            background: var(--tm-surface);
            border-right: 1px solid var(--tm-border);
        }

        .shipper-link {
            display: flex;
            align-items: center;
            gap: .75rem;
            min-height: 44px;
            padding: .72rem .9rem;
            color: #374151;
            text-decoration: none;
            border-radius: 8px;
            transition: .16s ease;
        }

        .shipper-link:hover,
        .shipper-link.active {
            color: var(--tm-red);
            background: var(--tm-red-soft);
        }

        .shipper-link i {
            width: 18px;
            text-align: center;
        }

        .metric-card,
        .order-card,
        .delivery-panel {
            border: 1px solid var(--tm-border);
            border-radius: 8px;
            background: var(--tm-surface);
            box-shadow: 0 10px 26px rgba(15, 23, 42, .06);
        }

        .metric-icon {
            width: 42px;
            height: 42px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .order-card {
            transition: border-color .16s ease, box-shadow .16s ease;
        }

        .order-card:hover {
            border-color: #cbd5e1;
            box-shadow: 0 14px 34px rgba(15, 23, 42, .09);
        }

        .status-pill {
            border-radius: 999px;
            padding: .35rem .62rem;
            font-weight: 700;
            font-size: .76rem;
        }

        .text-muted-soft {
            color: var(--tm-muted);
        }

        @media (max-width: 991.98px) {
            .shipper-shell {
                display: block !important;
            }

            .shipper-sidebar {
                position: static;
                width: auto;
                height: auto;
                border-right: 0;
                border-bottom: 1px solid var(--tm-border);
            }

            .shipper-menu {
                display: flex;
                gap: .5rem;
                overflow-x: auto;
                padding-bottom: .2rem;
            }

            .shipper-link {
                white-space: nowrap;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark shipper-nav px-3 px-lg-4">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('shipper.dashboard') }}">
            <span class="bg-danger text-white rounded d-inline-flex align-items-center justify-content-center me-2"
                style="width: 36px; height: 36px;">
                <i class="fas fa-truck-fast"></i>
            </span>
            TechMart Delivery
        </a>

        <div class="dropdown">
            <button class="btn btn-outline-light btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                <i class="fas fa-user me-1"></i>{{ Auth::user()->name }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Thông tin cá nhân</a></li>
                <li><a class="dropdown-item" href="{{ route('shipper.dashboard') }}">Bảng giao hàng</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="dropdown-item" type="submit">Đăng xuất</button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <div class="shipper-shell d-flex">
        <aside class="shipper-sidebar p-3">
            <div class="small text-uppercase text-muted fw-bold mb-2">Công việc</div>
            <nav class="shipper-menu">
                <a class="shipper-link {{ request('status', 'active') === 'active' ? 'active' : '' }}" href="{{ route('shipper.orders.index') }}">
                    <i class="fas fa-route"></i><span>Đơn cần xử lý</span>
                </a>
                <a class="shipper-link {{ request('status') === 'processing' ? 'active' : '' }}" href="{{ route('shipper.orders.index', ['status' => 'processing']) }}">
                    <i class="fas fa-clipboard-list"></i><span>Mới phân công</span>
                </a>
                <a class="shipper-link {{ request('status') === 'shipped' ? 'active' : '' }}" href="{{ route('shipper.orders.index', ['status' => 'shipped']) }}">
                    <i class="fas fa-truck"></i><span>Đang giao</span>
                </a>
                <a class="shipper-link {{ request('status') === 'delivered' ? 'active' : '' }}" href="{{ route('shipper.orders.index', ['status' => 'delivered']) }}">
                    <i class="fas fa-circle-check"></i><span>Đã giao</span>
                </a>
                <a class="shipper-link {{ request('status') === 'delivery_failed' ? 'active' : '' }}" href="{{ route('shipper.orders.index', ['status' => 'delivery_failed']) }}">
                    <i class="fas fa-triangle-exclamation"></i><span>Giao thất bại</span>
                </a>
            </nav>
        </aside>

        <main class="flex-grow-1 p-3 p-lg-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-circle-exclamation me-2"></i>{{ session('error') }}
                    <button class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
