<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Helpers\CartProductItem;
use App\Models\CustomerCartProduct;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

define('CART_KEY_IN_SESSION', 'cart');
/**
 * @property int getCartItemCount
 * @property void addToCart
 * @property void removeFromCart
 * @property void updateCart
 * @property void clearCart
 * @property void moveToOrder
 */
class CartService
{
    /**
     * @return int|string|null
     */
    protected function getLoggedInCustomer(): int|string|null
    {
        return auth(CUSTOMER_GUARD_NAME)->id();
    }

    /**
     * @return int
     */
    public function getCartItemCount() : int
    {
        if($customerId = $this->getLoggedInCustomer()){
            return CustomerCartProduct::where('customer_id', $customerId)->sum('quantity');
        } else {
            $cart = Session::get(CART_KEY_IN_SESSION, []);
            return collect($cart)->sum('quantity');
        }
    }

    /**
     * @return array
     */
    public function getItemQuantityMap(): array
    {
        if($customerId = $this->getLoggedInCustomer()){
            $itemsInCart = CustomerCartProduct::where('customer_id', $customerId)->get();
            if(empty($itemsInCart)){
                return [];
            }
            $itemQuantityMap = [];
            foreach ($itemsInCart as $item){
                $itemQuantityMap[$item->product_id] = $item->quantity;
            }
            return $itemQuantityMap;
        } else {
            $cart = Session::get(CART_KEY_IN_SESSION, []);
            return collect($cart)->pluck('quantity', 'product_id')->toArray();
        }
    }

    /**
     * @param $productData
     * @param $quantity
     * @return void
     */
    public function addToCart($productData, $quantity): void
    {
        $productId = $productData['id'];
        // Check if the user is logged in
        if(!$customerId = $this->getLoggedInCustomer()){
            // If not logged in, store cart data in session
            $cart = Session::get(CART_KEY_IN_SESSION, []);
            $cart[$productId] = $this->createCartItem($productData, $quantity);

            Session::put(CART_KEY_IN_SESSION, $cart);
            return;
        }

        // Add product to customer's cart
        $product = Product::findOrFail($productId);
        CustomerCartProduct::updateOrCreate(
            ['customer_id' => $customerId, 'product_id' => $product->id],
            ['quantity' => $quantity, 'price' => $product->price]
        );
    }

    /**
     * @param $productId
     * @return void
     */
    public function removeFromCart($productId): void
    {
        // Check if the user is logged in
        $customerId = $this->getLoggedInCustomer();
        if ($customerId) {
            CustomerCartProduct::where('customer_id', $customerId)->where('product_id', $productId)->delete();
        } else {
            // If not logged in, remove product from session cart
            $cart = Session::get(CART_KEY_IN_SESSION, []);
            unset($cart[$productId]);
            Session::put(CART_KEY_IN_SESSION, $cart);
        }
    }

    /**
     * @param $productData
     * @param $quantity
     *
     * @return void
     */
    public function updateCart($productData, $quantity): void
    {
        $productId = $productData['id'] ?? $productData['product_id'];
        $customerId = $this->getLoggedInCustomer();
        if ($customerId) {
            CustomerCartProduct::where('customer_id', $customerId)->where('product_id', $productId)
                ->update(['quantity' => $quantity]);
        } else {

            $cart = Session::get(CART_KEY_IN_SESSION, []);
            $cart[$productId] = $this->createCartItem($productData, $quantity);
            Session::put(CART_KEY_IN_SESSION, $cart);
        }
    }

    /**
     * @return void
     */
    public function clearCart(): void
    {
        // Check if the user is logged in
        $customerId = $this->getLoggedInCustomer();
        if ($customerId) {
            CustomerCartProduct::where('customer_id', $customerId)->delete();
        } else {
            // If not logged in, clear session cart
            Session::put(CART_KEY_IN_SESSION, []);
        }
    }

    /**
     * @return Order|null
     */
    public function moveToOrder(): ?Order
    {
        // Check if the user is logged in
        $customerId = $this->getLoggedInCustomer();
        if ($customerId) {
            $cartItems = CustomerCartProduct::where('customer_id', $customerId)->get();
            if ($cartItems->isEmpty()) {
                return null;
            }
            $totalAmount = 0;
            $order = Order::create(['customer_id' => $customerId, 'amount' => 0, 'order_status' => OrderStatus::PENDING->value]);
            if(empty($order)){
                return null;
            }
            foreach ($cartItems as $cartItem) {
                OrderProduct::create([
                    'order_id' => $order->id,
                    'customer_id' => $order->customer_id,
                    'product_id' => $cartItem->product_id,
                    'price' => $cartItem->price,
                    'quantity' => $cartItem->quantity
                ]);
                $totalAmount += $cartItem->price * $cartItem->quantity;
            }
            $order->update(['amount' => $totalAmount]);
            CustomerCartProduct::where('customer_id', $customerId)->delete();
            $this->clearCart();
            return $order;
        }
        return null;
    }

    /**
     * Creates a new cart item from given inputs.
     *
     * @param array $productData
     * @param int $quantity
     *
     * @return array
     */
    protected function createCartItem(array $productData, int $quantity): array
    {
        return [
            'product_id' => $productData['id'] ?? $productData['product_id'],
            'product_image' => $productData['product_image'],
            'name' => $productData['name'],
            'price' => $productData['price'],
            'quantity' => $quantity
        ];
    }

    public function getItemFromCart($productId): ?CartProductItem
    {
        $customerId = $this->getLoggedInCustomer();
        if ($customerId) {
            /**
             * @var CustomerCartProduct $cartItem
             */
            $cartItem = CustomerCartProduct::with('product')
                ->where('customer_id', $customerId)
                ->where('product_id', $productId)
                ->first();
            if(!$cartItem){
                return null;
            }
            $product = $cartItem->product;
            return new CartProductItem([
                'product_id' => $cartItem->product_id,
                'product_image' => $product->product_image,
                'name' => $product->name,
                'price' => $cartItem->price,
                'quantity' => $cartItem->quantity,
            ]);
        } else {
            $cart = Session::get(CART_KEY_IN_SESSION, []);
            return isset($cart[$productId]) ?
                new CartProductItem($cart[$productId]) : null;
        }
    }

    public function getGuestCartData()
    {
        return Session::get(CART_KEY_IN_SESSION, []);
    }

    public function all()
    {
        if($customerId = $this->getLoggedInCustomer()) {
            $cartProducts = CustomerCartProduct::with('product')
                ->where('customer_id', $customerId)->get();
            if($cartProducts->isEmpty()){
                return [];
            }
            return $cartProducts->map(function (CustomerCartProduct $cartProduct) {
                $product = $cartProduct->product;
                return new CartProductItem([
                    'product_id' => $cartProduct->product_id,
                    'product_image' => $product->product_image,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $cartProduct->quantity,
                ]);
            })->toArray();
        }
        $result = [];
        $cartItems = $this->getGuestCartData();
        if(!empty($cartItems)){
            $result = array_map(function ($item) {
                return new CartProductItem([
                    'product_id' => $item['product_id'],
                    'product_image' => $item['product_image'],
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                ]);
            }, $cartItems);
        }
        return  $result;
    }
}
