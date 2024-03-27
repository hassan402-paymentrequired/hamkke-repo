<?php

namespace App\Listeners;

use App\Events\OrderSuccessful;
use App\Mail\OrderConfirmed;
use App\Models\OrderDownload;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CreateOrderDownloadEntry
{
    /**
     * Handle the event.
     */
    public function handle(OrderSuccessful $event): void
    {
        $order = $event->order;
        $products = $order->products;
        foreach ($products as $product) {
            $uuid = Str::uuid()->toString();
            OrderDownload::create([
                'uuid' => $uuid,
                'order_id' => $order->id,
                'product_id' => $product->id,
                'customer_id' => $order->customer_id,
                'download_url' => $product->generateDownloadUrl($uuid)
            ]);
        }
        $notifiable = $order->customer;
        Mail::to($notifiable)->send(new OrderConfirmed($order, $notifiable));

    }
}
