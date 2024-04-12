<section class="section category-posts-div forum-div">
    <div class="container">
        <div class="row marginX">
            <div class="nav col-md-3 paddingR nav-pills sticky-top" id="v-pills-tab" role="tablist"
                 aria-orientation="vertical">
                    <span class="sticky-top">
                        <div class="text-white text-center p-4 border border-bottom-0"
                             style="background-color: #662687;">
                            <a class="d-inline-block" href="#">
                                <img class="img-fluid rounded-circle img-thumbnail p-2 mb-3"
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

            <div class="col-md-9 paddingR tab-content pt-0 table-responsive" id="v-pills-tabContent">
                <div class="article-div">
                    <h4>My Orders</h4>
{{--                    <p class="lead">Your orders in one place.</p>--}}
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <caption>Your orders in one place.</caption>
                            <thead>
                            <tr>
                                <th scope="col">Order</th>
                                <th scope="col">Date</th>
                                <th scope="col">Total</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <livewire:customer-front.orders-list-item
                                    key="{{ $order->id }}"
                                    :order="$order"/>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="text-center">
                        {{ $orders->links('vendor.pagination.customer-front.float-right') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
