<section class="section category-posts-div forum-div">
    <div class="container">
        <div class="row marginX">
            <div class="nav col-md-3 paddingR nav-pills sticky-top" id="v-pills-tab" role="tablist"
                 aria-orientation="vertical">
                    <span class="sticky-top">
                        <nav class="navbar navbar-expand-lg navbar-light pt-0">
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#navbarNav2" aria-controls="navbarNav2" aria-expanded="false"
                                    aria-label="Toggle navigation">
                                <img src="{{ asset('frontend-assets/tabs.svg') }}" alt="View Tabs Icon"/>
                            </button>

                            <div class="collapse navbar-collapse" id="navbarNav2">
                                <ul class="navbar-nav">
                                    <li class="nav-item @if(empty($currentProductCategory)) active @endif">
                                        <button
                                            class="nav-link @if(empty($productCategory)) active @endif d-flex align-items-left align-items-center"
                                            id="v-pills-language-tab" type="button">
                                            <a href="{{ route('store.products_list') }}">All</a>
                                        </button>
                                    </li>
                                    @foreach($productCategories as $productCat)
                                        <li class="nav-item @if($this->category == $productCat->slug) active @endif"
                                            :key="{{ "nav-item-{$productCat->id}" }}">
                                            <button
                                                class="nav-link @if($this->category == $productCat->slug) active @endif d-flex align-items-left align-items-center"
                                                id="v-pills-language-tab" type="button">
                                                <img src="{{ $productCat->navigation_icon }}"
                                                     alt="{{ $productCat->name }} nav icon"/>
                                                <a href="{{ route('store.products_list', ['category' => $productCat->slug]) }}">{{ $productCat->name }}</a>
                                            </button>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </nav>
                    </span>
            </div>

            <div class="col-md-9 paddingR tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills{{ $this->category ? "-$this->category": "" }}"
                     role="tabpanel"
                     aria-labelledby="v-pills{{ $this->category ? "-$this->category": "" }}-tab">
                    <div class="forum row">
                        @forelse($products as $product)
                            <livewire:customer-front.store-product-card
                                :product="$product"
                                :quantity="$cartItemQuantities[$product->id] ?? 0"
                                :selected="$productsInCart[$product->id] ?? false"
                                :key="$product->id" />
                        @empty
                            <div class="col-md-12">
                                <p class="text-center bg-hamkke-primary p-2">
                                    @if(!$currentProductCategory)
                                        No products found
                                    @else
                                        No Products found in the '{{ strtolower($currentProductCategory->name) }}' category
                                    @endif
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<x-slot name="more_scripts_slot">
    @script
    <script>
        // $wire.on('show-toast', (event) => {
        //     const eventParams = event[0]
        //     HamkkeJsHelpers.showToast(eventParams.title, eventParams.message, eventParams.toast_type)
        // });
        $wire.on('close-modal', (event) => {
            const eventParams = event[0]
            console.log({eventParams});
            $('#productDetailsModal').modal('hide');
        });
        $wire.on('open-modal', (event) => {
            const eventParams = event[0]
            console.log({eventParams});
            $('#productDetailsModal').modal('show');
        });
    </script>
    @endscript
</x-slot>
