<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TechMart')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('styles')

    <style>
        :root {
            --tm-red: #e62f45;
            --tm-red-dark: #bd2033;
            --tm-blue: #2563eb;
            --tm-green: #0f9f75;
            --tm-ink: #172033;
            --tm-muted: #667085;
            --tm-soft: #f5f7fb;
            --tm-panel: rgba(255, 255, 255, 0.9);
            --tm-border: #e5e8ef;
            --tm-shadow: 0 18px 45px rgba(23, 32, 51, 0.1);
            --tm-shadow-soft: 0 10px 28px rgba(23, 32, 51, 0.08);
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            min-height: 100vh;
            color: var(--tm-ink);
            background:
                radial-gradient(circle at 8% 0%, rgba(230, 47, 69, 0.12), transparent 26rem),
                radial-gradient(circle at 88% 12%, rgba(37, 99, 235, 0.1), transparent 24rem),
                linear-gradient(180deg, #fff 0%, #f8fafc 24rem, var(--tm-soft) 100%);
            overflow-x: hidden;
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            z-index: -1;
            pointer-events: none;
            background-image:
                linear-gradient(rgba(23, 32, 51, 0.035) 1px, transparent 1px),
                linear-gradient(90deg, rgba(23, 32, 51, 0.035) 1px, transparent 1px);
            background-size: 34px 34px;
            mask-image: linear-gradient(180deg, rgba(0, 0, 0, 0.45), transparent 62%);
        }

        ::selection {
            color: #fff;
            background: var(--tm-red);
        }

        .tm-shell {
            display: flex;
            min-height: calc(100vh - 64px);
        }

        .tm-sidebar {
            position: sticky;
            top: 64px;
            width: 260px;
            height: calc(100vh - 64px);
            flex: 0 0 260px;
            padding: 1.25rem;
            overflow-y: auto;
            background: var(--tm-panel);
            border-right: 1px solid var(--tm-border);
            backdrop-filter: blur(16px);
        }

        .tm-content {
            min-width: 0;
            flex: 1;
            padding: 1.5rem 0 0;
            animation: tmPageIn 0.48s ease both;
        }

        .tm-category-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.72rem 0.85rem;
            color: #3b4354;
            text-decoration: none;
            border-radius: 8px;
            transition: transform 0.18s ease, color 0.18s ease, background 0.18s ease, box-shadow 0.18s ease;
        }

        .tm-category-link:hover,
        .tm-category-link.active {
            color: var(--tm-red);
            background: rgba(230, 47, 69, 0.08);
            transform: translateX(3px);
        }

        .tm-category-link.active {
            box-shadow: inset 3px 0 0 var(--tm-red);
        }

        .tm-card {
            border: 1px solid var(--tm-border);
            border-radius: 8px;
            box-shadow: var(--tm-shadow-soft);
            transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
        }

        .tm-card:hover {
            border-color: rgba(230, 47, 69, 0.22);
            box-shadow: var(--tm-shadow);
            transform: translateY(-3px);
        }

        .tm-kicker {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            color: var(--tm-red);
            font-weight: 700;
            font-size: 0.88rem;
        }

        .tm-hero {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            color: #fff;
            background:
                linear-gradient(135deg, rgba(189, 32, 51, 0.94), rgba(230, 47, 69, 0.86)),
                url("https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1600&q=80") center/cover;
            box-shadow: 0 28px 70px rgba(189, 32, 51, 0.22);
        }

        .tm-hero::after {
            content: "";
            position: absolute;
            inset: auto -10% -30% 48%;
            height: 18rem;
            background: rgba(255, 255, 255, 0.16);
            transform: rotate(-8deg);
        }

        .tm-hero > * {
            position: relative;
            z-index: 1;
        }

        .tm-glass-panel {
            border: 1px solid rgba(255, 255, 255, 0.22);
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.13);
            backdrop-filter: blur(12px);
        }

        .tm-product-card .card-img-top {
            transition: transform 0.25s ease;
        }

        .tm-product-card:hover .card-img-top {
            transform: scale(1.04);
        }

        .tm-product-title {
            display: -webkit-box;
            min-height: 2.65rem;
            overflow: hidden;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .tm-price {
            color: var(--tm-red);
            font-weight: 800;
        }

        .btn-danger {
            --bs-btn-bg: var(--tm-red);
            --bs-btn-border-color: var(--tm-red);
            --bs-btn-hover-bg: var(--tm-red-dark);
            --bs-btn-hover-border-color: var(--tm-red-dark);
        }

        .btn {
            border-radius: 8px;
            transition: transform 0.18s ease, box-shadow 0.18s ease, background-color 0.18s ease, border-color 0.18s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn-danger:hover {
            box-shadow: 0 12px 24px rgba(230, 47, 69, 0.24);
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            border-color: var(--tm-border);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: rgba(230, 47, 69, 0.65);
            box-shadow: 0 0 0 0.22rem rgba(230, 47, 69, 0.12);
        }

        .text-danger {
            color: var(--tm-red) !important;
        }

        @keyframes tmPageIn {
            from {
                opacity: 0;
                transform: translateY(12px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 991.98px) {
            .tm-shell {
                display: block;
            }

            .tm-sidebar {
                position: static;
                width: auto;
                height: auto;
                border-right: 0;
                border-bottom: 1px solid var(--tm-border);
            }

            .tm-category-scroll {
                display: flex;
                gap: 0.5rem;
                overflow-x: auto;
                padding-bottom: 0.25rem;
            }

            .tm-category-link {
                white-space: nowrap;
            }

            .tm-category-link:hover,
            .tm-category-link.active {
                transform: translateY(-1px);
            }
        }
    </style>
</head>
<body>
    @include('partials.navbar')

    <div class="tm-shell">
        <aside class="tm-sidebar">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h2 class="h6 fw-bold mb-0">
                    <i class="fas fa-layer-group text-danger me-2"></i>Danh mục
                </h2>
                <a href="{{ route('products.index') }}" class="small text-danger text-decoration-none">Tất cả</a>
            </div>

            <nav class="tm-category-scroll">
                @foreach ($categories as $category)
                    <a href="{{ route('products.category', $category) }}"
                        class="tm-category-link {{ request()->routeIs('products.category') && optional(request()->route('category'))->category_id === $category->category_id ? 'active' : '' }}">
                        <i class="fas fa-tag small"></i>
                        <span>{{ $category->category_name }}</span>
                    </a>
                @endforeach
            </nav>
        </aside>

        <main class="tm-content">
            @yield('content')
            @include('partials.footer')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
