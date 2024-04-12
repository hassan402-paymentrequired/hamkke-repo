@php use App\Facades\HamkkeOrder; @endphp

<?php
/**
 * @var \App\Services\OrderService $orderService
 */
?>
<div>
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">eCommerce /</span> Order Details</h4>
    <div
        class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
        <div class="d-flex flex-column justify-content-center gap-2 gap-sm-0">
            <h5 class="mb-1 mt-3 d-flex flex-wrap gap-2 align-items-end">
                Order #{{ $order->id }} {!! $order->order_status->statusBadge() !!}
            </h5>
            <p class="text-body">{{ $order->created_at->format('M d, Y, H:i') }}</p>
        </div>
    </div>

    <!-- Order Details Table -->

    <div class="row">
        <div class="col-12 col-lg-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title m-0">Order details</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th class="w-50">products</th>
                                <th class="w-25">price</th>
                                <th class="w-25">qty</th>
                                <th>total</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orderProducts as $orderProduct)
                                <tr :key="$orderProduct->id">
                                    <td class="sorting_1">
                                        <div class="d-flex justify-content-start align-items-center text-nowrap">
                                            <div class="avatar-wrapper">
                                                <div class="avatar me-2">
                                                    <img src="{{ $orderProduct->product_image }}"
                                                         alt="product-{{ $orderProduct->name }}" class="rounded-2">
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <h6 class="text-body mb-0">{{ $orderProduct->name }}</h6>
                                                <small class="text-muted">
                                                    Category: {{ $orderProduct->product_category->name }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                    <span class="naira-prefix">
                                        {{ HamkkeOrder::getProductUnitPrice( $orderProduct ) }}
                                    </span>
                                    </td>
                                    <td>
                                    <span class="text-body">
                                        {{ HamkkeOrder::getProductQuantity( $orderProduct ) }}
                                    </span>
                                    </td>
                                    <td>
                                        <h6 class="mb-0 naira-prefix">
                                            {{ HamkkeOrder::getProductTotal( $orderProduct ) }}
                                        </h6>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>

                        <div class="d-flex justify-content-end align-items-center m-3 mb-2 p-1">
                            <div class="order-calculations">
                                <div class="d-flex justify-content-between">
                                    <h6 class="w-px-100 mb-0">Order Total:</h6>
                                    <h6 class="mb-0 naira-prefix">{{ $order->getPriceInNaira(true) }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title m-0">Customer details</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-start align-items-center mb-4">
                        <div class="avatar me-2">
                            @component('components.front.profile-image', ['avatar' => $orderCustomer->avatar]) @endcomponent
                        </div>
                        <div class="d-flex flex-column">
                            <h6 class="mb-0">{{ $orderCustomer->getName() }}</h6>
                            <small class="text-muted">Customer ID: #{{ $orderCustomer->id }}</small>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start align-items-center mb-4">
                        <span
                            class="avatar rounded-circle bg-label-success me-2 d-flex align-items-center justify-content-center"
                        ><i class="ti ti-shopping-cart ti-sm"></i
                            ></span>
                        <h6 class="text-body text-nowrap mb-0">{{ $orderCustomer->completedOrders() }} Completed
                            Orders</h6>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6>Contact info</h6>
                        {{-- TODO Implement customers CRUD and enable the edit button to edit the customer --}}
                        {{-- <h6>--}}
                        {{--    <a href=" javascript:void(0)" data-bs-toggle="modal" data-bs-target="#editUser">Edit</a>--}}
                        {{-- </h6>--}}
                    </div>
                    <p class="mb-1">Email: {{ $orderCustomer->email }}</p>
                    <p class="mb-0">Mobile: {{ $orderCustomer->phone }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
