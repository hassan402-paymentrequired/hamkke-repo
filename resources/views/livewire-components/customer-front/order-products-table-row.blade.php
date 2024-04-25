@php use App\Facades\HamkkeOrder; @endphp
<div class="tab-pane fade show active" id="v-pills-all" role="tabpanel"
     aria-labelledby="v-pills-all-tab">
    <div class="p-4 border-bottom">
        <div class="row d-flex align-items-center bord">
            <div class="col-6">
                <div class="d-flex align-items-center">
                    <img class="img-fluid"
                         src="{{ $orderProduct->product_image }}"
                         alt="..." width="70">
                    <div class="ms-3">
                        {{--                        <a href="detail.html" class="text-decoration-none">--}}
                        <h6 class="mb-0 text-dark">{{ $orderProduct->name }}</h6>
                        @if($order->isSuccessful() && $orderProduct->product_type === \App\Enums\ProductType::DIGITAL_PRODUCT)
                        <a class="text-success" style="font-size: small; text-decoration: none"
                           href="javascript:void(0)"
                           wire:click="$parent.startDownload({{ $orderProduct->id }})">
                            <span class="fa fa-download"></span> Download Product
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-2"><span class="naira-prefix">{{ HamkkeOrder::getProductUnitPrice($orderProduct) }}</span>
            </div>
            <div class="col-2"><span>{{ HamkkeOrder::getProductQuantity($orderProduct)}}</span></div>
            <div class="col-2 text-end"><span
                    class="naira-prefix">{{ HamkkeOrder::getProductTotal($orderProduct) }}</span>
            </div>
        </div>
    </div>
</div>
