<button class="bg-filled">
    <a class="nav-link"
       href="{{ route('store.cart') }}">
        <span class="custom-cart-icon">
            <span class="custom-cart-count">{{ $cartItemsQuantity }}</span><img src="{{ asset('frontend-assets/cart.svg') }}" alt="Cart icon"/>
        </span>Cart

    </a>
</button>
