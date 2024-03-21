<div class="item-row d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">
        <div class="image-div">
            <img src="{{ $cartProductItem->product_image }}" alt="{{ $cartProductItem->name }} - Product image"/>
        </div>

        <div class="desc-div">
            <h6>{{ $cartProductItem->name }}</h6>
        </div>
    </div>

    <div class="quantity-div">
        <p class="qty">
            <button wire:click="decreaseQuantity()" class="qtyminus" aria-hidden="true">&minus;</button>
            <input type="number" min="1" wire:model="quantity" readonly>
            <button wire:click="increaseQuantity()" class="qtyplus" aria-hidden="true">&plus;</button>
        </p>
    </div>

    <div class="price-div">
        <div class="naira-prefix">{{ $amount }}</div>
    </div>

    <div class="close-div">
        <button wire:click="removeFromCart()"><i class="fa fa-circle-xmark text-danger"></i> </button>
    </div>

</div>
