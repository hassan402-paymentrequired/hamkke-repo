<section class="cart-div">
    <div class="container">
        <div class="row">
            @if(!empty($cartProducts))
                <div class="col-md-8">
                    <div class="items">
                        @foreach($cartProducts as $cp)
                            <livewire:customer-front.cart-product :cartProductItem="$cp" :key="$cp->product_id"/>
                        @endforeach
                    </div>
                </div>

                <div class="col-md-4">
                    <form action="{{ route('pay') }}" method="POST">
                        <div class="checkout">
                            <div class="total d-flex justify-content-between">
                                <span>Cart Total</span>
                                <span class="naira-prefix">{{ $totalAmount }}</span>
                            </div>
                            <div class="personal">
                                <div class="title">Personal Details</div>
                                <p>Fill in your details for Checkout</p>

                                <div class="info-form">
                                    <div class="d-flex justify-content-between">
                                        <input type="text" wire:model.live="customerDetailsForm.customerFirstName" placeholder="First Name">
                                        <input type="text" wire:model.live="customerDetailsForm.customerLastName" placeholder="Last Name">
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <input type="text" class="w-100" wire:model.live="customerDetailsForm.customerEmail" placeholder="Email Address">
                                    </div>

                                    <div class="d-flex justify-content-between">
{{--                                        <select data-live-search="true"  wire:model.live="customerDetailsForm.customerCountry">--}}
{{--                                            <option value="" style="color: #757575">Select Phone Prefix</option>--}}
{{--                                            @foreach($countries as $country)--}}
{{--                                                <option value="{{ $country->id }}">+{{ $country->phone_prefix }}</option>--}}
{{--                                            @endforeach--}}
{{--                                        </select>--}}
                                        <input type="text" wire:model.live="customerDetailsForm.customerPhone" placeholder="Phone Number">
                                    </div>
                                </div>
                            </div>

                            <div class="payment">
                                @csrf
                                <button>Make Payment</button>
                            </div>

                        </div>
                    </form>
                </div>
            @else
                <div class="col-md-12">
                    <div class="items">

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
                    </div>
                </div>
            @endif

        </div>

    </div>
</section>
