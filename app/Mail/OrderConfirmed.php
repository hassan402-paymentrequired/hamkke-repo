<?php

namespace App\Mail;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDownload;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    protected Order $order;
    protected Customer $notifiable;
    protected array|Collection $orderDownloads;

    public function __construct(Order $order, Customer $notifiable)
    {
        $this->order = $order;
        $this->notifiable = $notifiable;
        $this->orderDownloads = $this->order->order_downloads;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Order Confirmation for Your Digital Purchase #{$this->order->id}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.orders.confirmed',
            with: [
                'order' => $this->order,
                'notifiable' => $this->notifiable,
                'encodedOrderId' => urlencode(encryptDecrypt('encrypt', $this->order->id)),
                'orderDownloads' => $this->orderDownloads
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
