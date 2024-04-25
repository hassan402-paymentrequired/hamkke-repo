<div class="col-md-4 col-sm-6">
    <div class="material-card">
        <a href="javascript:void(0);" wire:click="$dispatch('open-modal')" class="text-decoration-none">
            <img class="material-img" src="{{ $product->product_image }}"
                 alt="Image for product : {{ $product->name }}"/>
            <div class="material-details">
                <h6>{{ $product->name }}</h6>
                <span class="badge mb-1" style="background-color: #f78181">{{ $product->product_type->displayName() }}</span>
                <p class="naira-prefix">{{ $product->getPriceInNaira(true) }}</p>
            </div>
        </a>
        <div class="add-to-cart">
            @if($quantity === 0)
                <button wire:click="addToCart()" class="align-items-center w-100 bg-hamkke-primary"
                        type="button">
                    <img src="{{ asset('frontend-assets/cart.svg') }}" alt="cart icon"/>Add To Cart
                </button>
            @else
                <p class="qty">
                    <button wire:click="decreaseQuantity()" class="qtyminus" aria-hidden="true">&minus;</button>
                    <input type="number" min="1" wire:model="quantity" readonly>
                    <button wire:click="increaseQuantity()" class="qtyplus" aria-hidden="true">&plus;</button>
                </p>
            @endif
        </div>
    </div>
</div>

