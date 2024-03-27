<tr>
    <td>#{{ $order->id }}</td>
    <td>{{ $order->created_at->format('d/m/Y') }}</td>
    <td><span class="naira-prefix">{{ $order->getPriceInNaira() }}</span></td>
    <td>{!! $order->order_status->statusBadge() !!}</td>
    <td>
        <a href="{{ route('customer.order.view', $order) }}" class="btn btn-hamkke-primary btn-sm">View</a>
    </td>
</tr>
