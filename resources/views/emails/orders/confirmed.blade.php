<x-mail::message>
# Order Confirmation for Your Digital Purchase #{{ $order->id }}

Dear {{ $notifiable->getName() }},

This email confirms your recent purchase of the following digital products:

@component('mail::table')
| Product Image | Product Name | Quantity | Amount(₦) |
| ------------- | :------------: | :--------: | --------: |
@foreach ($order->products as $product)
| ![{{ $product->name }}]({{ $product->product_image }}) | {{ $product->name }} | {{ $product->pivot->quantity }} | ₦{{ number_format($product->pivot->quantity * $product->pivot->price/100, 2) }} |
@endforeach
|  |  | **Total Amount:** | **₦{{ $order->getPriceInNaira(true) }}**|
@endcomponent

**Download/Access Instructions:**

*   Click the download products button below
*   Paste the access code provided above in the passcode field

**Please note that each product can only be downloaded once.**

<x-mail::button :url="route('customer.order.view', ['order' => $encodedOrderId])">
    Download the products
</x-mail::button>

If you have any questions or need assistance, feel free to reply to this email or contact our customer support team at [kemmiola@gmail.com](mailto:kemmiola@gmail.com).

Thank you for your purchase.

</x-mail::message>
