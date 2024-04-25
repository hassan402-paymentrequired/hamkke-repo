@php use App\Enums\OrderStatus; @endphp
<section class="section category-posts-div forum-div">
    <div class="container">
        <div class="row marginX">
            <div class="nav col-md-3 paddingR nav-pills sticky-top" id="v-pills-tab" role="tablist"
                 aria-orientation="vertical">
                    <span class="sticky-top">
                        <div class="text-white text-center p-4 border border-bottom-0"
                             style="background-color: #662687;">
                            <a class="d-inline-block" href="#">
                                <img class="img-fluid rounded-circle img-
                                 p-2 mb-3"
                                     src="{{ asset('frontend-assets/no-avatar-icon.jpg') }}"
                                     width="150" alt="...">
                            </a>
                            <h5>{{ $customerAuthUser->name ??  '@' . $customerAuthUser->username }}</h5>
                        </div>
                        <nav class="navbar navbar-expand-lg navbar-light">
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#navbarNav2" aria-controls="navbarNav2" aria-expanded="false"
                                    aria-label="Toggle navigation">
                                <img src="{{ asset('frontend-assets/tabs.svg') }}" alt="View Tabs Icon"/>
                            </button>


                            <div class="collapse navbar-collapse" id="navbarNav2">
                                <ul class="navbar-nav">
                                    <li class="nav-item @if(isCurrentRoute('customer.orders')) active @endif">
                                        <button
                                            class="nav-link @if(isCurrentRoute('customer.orders')) active @endif d-flex align-items-left align-items-center"
                                            style=""
                                            id="v-pills-language-tab" type="button">
                                            <i class="fa fa-box-open"></i>
                                            <a href="{{ route('customer.orders') }}">Orders</a>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </span>
            </div>

            <div class="col-md-9 paddingR tab-content pt-0" id="v-pills-tabContent">
                <div class="article-div">
                    <h4>Order #{{ $order->id }}</h4>
                    <p class="lead">Order placed on <strong>{{ $order->created_at->format('d/m/Y') }}</strong> and
                        @if($order->order_status->value === OrderStatus::COMPLETED->value)
                            has been confirmed Successful.
                        @elseif($order->order_status->value === OrderStatus::CANCELED->value)
                            has been canceled.
                        @else
                            is currently Pending.
                        @endif

                    </p>
                    @if($download)
                        @if ($downloading)
                            <div>
                                Download in progress ...
                            </div>
                        @endif
                        @if($downloadStatus)
                            <p class="alert alert-{{ $downloadStatus['type'] }}">{{ $downloadStatus['message'] }}
                        @endif
                    @endif
                    <hr>
                    <div class="bg-light px-4 py-3">
                        <div class="row fw-normal text-uppercase">
                            <div class="col-6">Product</div>
                            <div class="col-2">Price</div>
                            <div class="col-2">Quantity</div>
                            <div class="col-2 text-end">Total</div>
                        </div>
                    </div>
                    @foreach($orderProducts as $orderProduct)
                        <livewire:customer-front.order-products-table-row
                            key="{{ $orderProduct->id }}" :order="$order" :orderProduct="$orderProduct"/>
                    @endforeach
                    <div class="border-bottom py-3">
                        <div class="row">
                            <div class="col-md-4 col-6 ms-md-auto"><strong>Order Total</strong></div>
                            <div class="col-md-2 col-6 text-end naira-prefix">
                                <strong>{{ $order->getPriceInNaira(true) }}</strong></div>
                        </div>
                    </div>
                    @if($download)
                        <button type="button" id="download-file" wire:click="startDownload" style="display:none;">
                            Download
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

</section>
@if($download)
    <x-slot name="more_scripts_slot">
        @script
        <script>
            $wire.on('show-toast', (event) => {
                const eventParams = event[0]
                HamkkeJsHelpers.showToast(eventParams.title, eventParams.message, eventParams.toast_type)
            });
            window.onload = function () {
                const result = Swal.fire({
                    title: 'Thank you for your purchase',
                    text: 'Please click confirm to start your download',
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonText: 'Confirm Download',
                    customClass: {
                        confirmButton: 'btn btn-success me-3 waves-effect waves-light',
                        cancelButton: 'btn btn-danger waves-effect waves-light'
                    },
                    buttonsStyling: false
                }).then(response => {
                    if (response.isConfirmed) {
                        $('#download-file').trigger('click')
                    }
                })
            }
        </script>
        @endscript
    </x-slot>
@endif
