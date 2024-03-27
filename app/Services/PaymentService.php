<?php

namespace App\Services;

use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\PaymentTransaction;
use Reliese\Database\Eloquent\Model;

class PaymentService
{
    /**
     * @param Order $order
     *
     * @return array
     */
    public function createTransaction(Order $order) : array
    {
        $productNames = $order->products->map(function ($product) {
            return "{$product->quantity} {$product->name}";
        })->toArray();
        $paymentReference = generateUniqueRef('HMK', $order->id);
        $paymentTransaction = PaymentTransaction::create([
            'order_id' => $order->id,
            'customer_id' => $order->customer_id,
            'reference' => $paymentReference,
            'currency' => 'NGN',
            'amount_expected' => $order->amount,
            'metadata' => null
        ]);
        return [
            "email" => $order->customer->email,
            "orderID" => $order->id,
            "amount" => $order->amount,
            "reference" => $paymentTransaction->reference,
            "currency" => "NGN",
            "metadata" => [
                "custom_fields" => [
                    ['variable_name' => 'customer_id', 'display_name' => 'CustomerID', 'value' => $order->customer_id],
                    ['variable_name' => 'cart_items', 'display_name' => 'Cart Items', 'value' => implode(',', $productNames)]
                ]
            ],
            "callback_url" => route('pay.callback')
        ];
    }

    /**
     * @param string $reference
     *
     * @return PaymentTransaction|Model|null
     */
    public function getPayment(string $reference): Model|PaymentTransaction|null
    {
        return PaymentTransaction::where('reference', $reference)->first();
    }

    public function updatePayment(PaymentTransaction $paymentTransaction, array $verificationData)
    {
        $transactionStatus = PaymentStatus::valueFromName($verificationData['status']);
        $paymentTransaction->update([
            'amount_paid' => $verificationData['amount'],
            'payment_status' => $transactionStatus->value
        ]);
        return $transactionStatus->value === PaymentStatus::SUCCESS->value;
    }

}
