<div class="card h-100 tm-card tm-product-card overflow-hidden bg-white">
    <a href="{{ route('products.show', $product) }}" class="d-block bg-white">
        <img
            src="{{ $product->image_src }}"
            alt="{{ $product->name }}"
            class="card-img-top"
            style="aspect-ratio: 1 / 1; width: 100%; object-fit: contain; padding: 0.85rem;"
        >
    </a>

    <div class="card-body d-flex flex-column">
        <div class="d-flex align-items-center justify-content-between gap-2 mb-2">
            <span class="badge rounded-pill bg-danger-subtle text-danger">
                {{ $product->category->category_name ?? 'Chưa phân loại' }}
            </span>
            @if($product->stock_quantity > 0)
                <span class="small text-success"><i class="fas fa-check-circle me-1"></i>Còn hàng</span>
            @else
                <span class="small text-danger"><i class="fas fa-times-circle me-1"></i>Hết hàng</span>
            @endif
        </div>

        <h3 class="h6 fw-bold mb-2 tm-product-title">
            <a href="{{ route('products.show', $product) }}" class="text-decoration-none text-dark">
                {{ $product->name }}
            </a>
        </h3>

        <div class="fs-5 tm-price mb-1">{{ number_format($product->price, 0, ',', '.') }} VND</div>
        <div class="small text-muted mb-3">
            @if($product->stock_quantity > 0)
                {{ $product->stock_quantity }} sản phẩm sẵn sàng
            @else
                Tạm thời chưa thể đặt mua
            @endif
        </div>

        <div class="mt-auto">
            @guest
                <a href="{{ route('login') }}" class="btn btn-outline-danger btn-sm w-100">
                    <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập để mua
                </a>
            @else
                @if(auth()->user()->isCustomer())
                    @if($product->stock_quantity > 0)
                        <form action="{{ route('cart.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-danger btn-sm w-100">
                                <i class="fas fa-cart-plus me-2"></i>Thêm vào giỏ
                            </button>
                        </form>
                    @else
                        <button class="btn btn-secondary btn-sm w-100" disabled>Hết hàng</button>
                    @endif
                @elseif(auth()->user()->isShipper())
                    <a href="{{ route('shipper.dashboard') }}" class="btn btn-outline-secondary btn-sm w-100">
                        <i class="fas fa-truck me-2"></i>Trang giao hàng
                    </a>
                @else
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm w-100">
                        <i class="fas fa-gauge me-2"></i>Trang quản trị
                    </a>
                @endif
            @endguest
        </div>
    </div>
</div>
