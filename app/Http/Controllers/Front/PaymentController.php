<?php

namespace App\Http\Controllers\Front;

use App\Enums\OrderStatus;
use App\Events\OrderSuccessful;
use App\Facades\Cart;
use App\Facades\HamkkePayment;
use App\Http\Controllers\Controller;
use Mockery\Exception;
use Unicodeveloper\Paystack\Facades\Paystack;

class PaymentController extends Controller
{
    public function redirectToGateway()
    {
        try {
            if (!$order = Cart::moveToOrder()) {
                flashErrorMessage('No items found in your cart. Visit our store');
                return redirect()->route('store.products_list');
            }
            Cart::clearCart();
            $paymentData = HamkkePayment::createTransaction($order);
            /**
             * @var \Unicodeveloper\Paystack\Paystack $paystack
             */
            return Paystack::getAuthorizationUrl($paymentData)->redirectNow();
        } catch (\Exception $exception){
            flashErrorMessage('The paystack token has expired. Please refresh the page and try again.');
            return back()->withInput();
        }
    }

    /**
     * Obtain Paystack payment information
     */
    public function handleGatewayCallback()
    {
        try {
            $paystackResponse = Paystack::getPaymentData();
            $data = $paystackResponse['data'];
            $paymentTransaction = HamkkePayment::getPayment($data['reference']);
            $paymentSuccessful = HamkkePayment::updatePayment($paymentTransaction, $data);
            if ($paymentSuccessful) {
                $paymentTransaction->order()->update([
                    'order_status' => OrderStatus::COMPLETED->value
                ]);
                flashSuccessMessage('Payment Successful! ');
                event(new OrderSuccessful($paymentTransaction->order));
            } else {
                $paymentTransaction->order()->update([
                    'order_status' => OrderStatus::CANCELED->value
                ]);
                flashErrorMessage($paymentTransaction->payment_status->description());
            }
            return redirect()->route('customer.orders');
        } catch (Exception $exception){
            dd($exception);
        }
    }
}
