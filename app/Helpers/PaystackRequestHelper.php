<?php

namespace App\Helpers;

class PaystackRequestHelper
{
    protected  $secretKey;
    protected $publicKey;
    public function __construct()
    {
        $this->secretKey = config('payment.paystack.secret_key');
        $this->publicKey = config('payment.paystack.public_key');
    }

    public function getRequestHeader()
    {
        return [
            "Authorization" => "Bearer {$this->secretKey}",
            "Content-Type" => "application/json"
        ];
    }

    public function initializeTransaction()
    {

    }

    public function listTransactions($perPage = 20, $currentPage = 1, $startDate = null, $endDate = null)
    {

    }
}
