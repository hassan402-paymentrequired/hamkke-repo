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
{{--                            <span class="text-muted text-sm">Order ID: {{ $orderProduct->order_id }}</span>--}}
{{--                        </a>--}}
                    </div>
                </div>
            </div>
            <div class="col-2"><span class="naira-prefix">{{ $this->getUnitPrice() }}</span></div>
            <div class="col-2"><span>{{ $orderProduct->pivot->quantity }}</span></div>
            <div class="col-2 text-end"><span
                    class="naira-prefix">{{ $this->getTotalPrice() }}</span>
            </div>
        </div>
    </div>
</div>
