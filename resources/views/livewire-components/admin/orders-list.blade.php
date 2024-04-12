<div>
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">eCommerce /</span> Order List</h4>

    <div class="card mb-4">
        <div class="card-widget-separator-wrapper">
            <div class="card-body card-widget-separator">
                <div class="row gy-4 gy-sm-1">
                    <div class="col-sm-6 col-lg-3">
                        <div
                            class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
                            <div>
                                <h4 class="mb-2">{{ $pendingOrders }}</h4>
                                <p class="mb-0 fw-medium">Pending Payment</p>
                            </div>
                            <span class="avatar me-sm-4">
                                    <span class="avatar-initial bg-label-secondary rounded">
                                        <i class="ti-md ti ti-calendar-stats text-body"></i>
                                    </span>
                                </span>
                        </div>
                        <hr class="d-none d-sm-block d-lg-none me-4">
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div
                            class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
                            <div>
                                <h4 class="mb-2">{{ $completedOrders }}</h4>
                                <p class="mb-0 fw-medium">Completed</p>
                            </div>
                            <span class="avatar p-2 me-lg-4">
                                    <span class="avatar-initial bg-label-secondary rounded">
                                        <i class="ti-md ti ti-checks text-body"></i>
                                    </span>
                                </span>
                        </div>
                        <hr class="d-none d-sm-block d-lg-none">
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div
                            class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                            <div>
                                <h4 class="mb-2">{{ $canceledOrders }}</h4>
                                <p class="mb-0 fw-medium">Canceled/Refunded</p>
                            </div>
                            <span class="avatar p-2 me-sm-4">
                                    <span class="avatar-initial bg-label-secondary rounded">
                                        <i class="ti-md ti ti-wallet text-body"></i>
                                    </span>
                                </span>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h4 class="mb-2">{{ $failedOrders }}</h4>
                                <p class="mb-0 fw-medium">Failed</p>
                            </div>
                            <span class="avatar p-2">
                                    <span class="avatar-initial bg-label-secondary rounded">
                                        <i class="ti-md ti ti-alert-octagon text-body"></i>
                                    </span>
                                </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <h5 class="card-header">Orders</h5>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered">
                    <caption>All Orders</caption>
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Customer</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Manage</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($orders as $order)
                        <tr :key="{{ $order->id }}">
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->created_at->toDateTimeString() }}</td>
                            @php $customer = $order->customer; @endphp
                            <td>
                                <div class="d-flex justify-content-start align-items-center order-name text-nowrap">
                                    @if($customer->avatar)
                                        <div class="avatar-wrapper">
                                            <div class="avatar me-2">
                                                <img src="{{ getCorrectAbsolutePath($customer->avatar) }}"
                                                     alt="Avatar" class="rounded-circle">
                                            </div>
                                        </div>
                                    @endif
                                    <div class="d-flex flex-column">
                                        <h6 class="m-0">{{ $customer->getName() }}</h6>
                                        <small class="text-muted">{{ $customer->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="naira-prefix">{{ $order->getPriceInNaira(true)}}</td>
                            <td>{!! $order->order_status->statusBadge() !!}</td>
                            <td>
                                @can('admin.order.view')
                                    <a href="{{ route('admin.order.view', $order) }}"
                                       class="btn btn-primary btn-sm">View</a>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No Orders Found..</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {{ $orders->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
