<?php

namespace App\Helpers;

use Livewire\Wireable;

/**
 * @property string $product_id
 * @property string $product_image
 * @property string $name
 * @property int $price
 * @property int $quantity
 */
class CartProductItem implements Wireable
{
    public int $product_id;
    public string $product_image;
    public string $name;
    public int $price;
    public int $quantity;

    public function __construct($productData)
    {
        $this->product_id = $productData['product_id'];
        $this->product_image = $productData['product_image'];
        $this->name = $productData['name'];
        $this->price = $productData['price'];
        $this->quantity = $productData['quantity'];
    }

    /**
     * @return int
     */
    public function amount(): int
    {
        return $this->price * $this->quantity;
    }
    /**
     * @return string
     */
    public function amountInNaira(): string
    {
        return number_format($this->amount() / 100);
    }

    public function toLivewire()
    {
        return [
            'product_id' => $this->product_id,
            'product_image' => $this->product_image,
            'name' => $this->name,
            'price' => $this->price,
            'quantity' => $this->quantity
        ];
    }

    public static function fromLivewire($value)
    {
        return new static($value);
    }
}
