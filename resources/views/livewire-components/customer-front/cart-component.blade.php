<section class="cart-div">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="items">
                    @forelse($cartProducts as $cp)
                        <livewire:customer-front.cart-product :cartProductItem="$cp" :key="$cp->product_id"/>
                    @empty
                        <div class="text-center m-3">
                            <div style="
                                width: 150px;
                                height: 150px;
                                padding: 2em;
                                border-radius: 50%;
                                margin: 0 auto;
                                background-color: #662687;
                                color: #fff;
                               ">
                                <img src="{{ asset('frontend-assets/cart.svg') }}" height="auto" width="100%" alt="">
                            </div>
                            <h2 class="-pvs -fs16 -m">Your cart is empty!</h2>
                            <p class="-pvs -ws-pl -lh-15">Browse our categories and discover our best deals!</p>
                            <button class="btn" style="background-color: #662687;">
                            <a href="{{ route('store.products_list') }}" class="text-white text-decoration-none">
                                <i class="fa fa-shopping-bag"></i> Visit the Store
                            </a>
                            </button>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="col-md-4">
                <div class="checkout">
                    <div class="total d-flex justify-content-between">
                        <span>Cart Total</span>
                        <span class="naira-prefix">{{ $totalAmount }}</span>
                    </div>

                    <div class="payment">
                        <form action="{{ route('pay') }}" method="POST">
                            @csrf
                            <button>Make Payment</button>
                        </form>
                    </div>

                </div>
            </div>

        </div>

    </div>
</section>
