<?php

namespace App\Http\Controllers\Front;

use App\Facades\Cart;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Auth\Authenticatable;
use JetBrains\PhpStorm\NoReturn;
use Unicodeveloper\Paystack\Facades\Paystack;

class PaymentController extends Controller
{
    public function redirectToGateway()
    {
        try {
            /**
             * @var Customer|Authenticatable $customer
             */
            $customer = auth(CUSTOMER_GUARD_NAME)->user();
            if (!$order = Cart::moveToOrder()) {
                flashErrorMessage('No items found in your cart. Visit our store');
                return redirect()->route('store.products_list');
            }
            $productNames = $order->products()->pluck('name')->toArray();
            $paymentData = [
                "email" => $customer->email,
                "orderID" => $order->id,
                "amount" => $order->amount,
                "reference" => generateUniqueRef('HMK', $order->id),
                "currency" => "NGN",
                "metadata" => [
                    "custom_fields" => [
                        ['variable_name' => 'customer_id', 'display_name' => 'CustomerID', 'value' => $customer->id],
                        ['variable_name' => 'cart_items', 'display_name' => "Cart Items", 'value' => json_encode($productNames)]
                    ]
                ],
                "callback_url" => route('pay.callback')
            ];
            return Paystack::getAuthorizationUrl($paymentData)->redirectNow();
        } catch (\Exception $exception){
            dd($exception);
        }
    }

    /**
     * Obtain Paystack payment information
     * @return void
     */
    #[NoReturn] public function handleGatewayCallback(): void
    {
        $paymentDetails = Paystack::getPaymentData();

        dd($paymentDetails);
        // Now you have the payment details,
        // you can store the authorization_code in your db to allow for recurrent subscriptions
        // you can then redirect or do whatever you want
    }
}
