<?php

namespace App\Livewire\CustomerFront;

use App\Facades\Cart;
use App\Helpers\CartProductItem;
use App\Livewire\Forms\OrderPaymentForm;
use App\Models\Country;
use App\Models\Customer;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Title('Cart')]
#[Layout('livewire-layouts.customer-front-layout')]
class CartComponent extends Component
{
    public OrderPaymentForm $customerDetailsForm;
    /**
     * @var CartProductItem[]
     */
    public array $cartProducts;
    public int|float|string $totalAmount;

    public $countries;

    public function mount(): void
    {
        $this->countries = Country::all();
        /**
         * @var Customer $customer;
         */
        $customer = auth(CUSTOMER_GUARD_NAME)->user();
        if($customer) {
            $this->customerDetailsForm->fill([
                'customerEmail' => $customer->email,
                'customerPhone' => $customer->phone,
                'customerCountryId' => $customer->country_id
            ]);
            $customerName = $customer->getName();
            if ($customerName) {
                $namesArr = explode(' ', $customerName);
                $this->customerDetailsForm->customerFirstName = $namesArr[0];
                $this->customerDetailsForm->customerLastName = $namesArr[1] ?? null;
            }
        }
        $this->updateComponent();
    }

    #[On('cart-updated')] public function updateComponent(): void
    {
        $this->cartProducts = Cart::all();
        $sum = array_sum(
            array_map(function (CartProductItem $cartProduct) {
                return $cartProduct->price * $cartProduct->quantity;
            }, $this->cartProducts)
        );
        $this->totalAmount = number_format($sum/100);
    }
    /**
     * Renders the component on the browser.
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire-components.customer-front.cart-component');
    }
}
