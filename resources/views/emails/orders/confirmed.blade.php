@php use App\Facades\HamkkeOrder;
 /**
 * @var \App\Models\OrderDownload[] $orderDownloads
 */
 @endphp
<x-mail::message>
# Order Confirmation for Your Digital Purchase #{{ $order->id }}

Dear {{ $notifiable->getName() }},

This email confirms your recent purchase of the following digital products:

@component('mail::table')
    | Product Image | Product Name | Quantity | Amount(₦) |
    | ------------- | :------------: | :--------: | --------: |
    @foreach ($order->products as $product)
        | ![{{ $product->name }}]({{ $product->product_image }}) | {{ $product->name }}| {{ HamkkeOrder::getProductQuantity($product) }} | {{ number_format(HamkkeOrder::getProductTotal($product), 2) }} |
    @endforeach
    |  |  | **Total Amount:** | **₦{{ $order->getPriceInNaira(true) }}**|
@endcomponent

## Download/Access Links:
@foreach($orderDownloads as $orderDownload)
- [{{ $orderDownload->product->name }}]({{ $orderDownload->download_url }})
@endforeach

**Important Note:** All digital/downloadable products can only be downloaded once.

<x-mail::button :url="route('customer.order.view', ['order' => $encodedOrderId])">
    View Order Details
</x-mail::button>

If you have any questions or need assistance, feel free to reply to this email or contact our customer support team
at [kemmiola@gmail.com](mailto:kemmiola@gmail.com).

Thank you for your purchase.

</x-mail::message>
