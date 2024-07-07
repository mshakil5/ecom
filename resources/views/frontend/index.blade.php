@extends('frontend.layouts.app')

@section('content')

<style>
    @media (min-width: 992px) {
        .modal-content {
            width: 700px;
            height: 400px;
        }
        .modal-content img {
            width: 700px;
            height: 400px;
        }
    }

    @media (max-width: 991.98px) {
        .modal-content {
            width: 100%;
            height: auto;
        }
        .modal-content img {
            width: 100%;
            height: auto;
        }
    }

    .custom-ad-image {
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

    .custom-ad-image img {
        width: 100%;
        max-height: 180px;
        object-fit: cover;
    }

    @media (max-width: 768px) {
        .custom-ad-image img {
            max-height: 120px;
        }
    }

    @media (max-width: 576px) {
        .custom-ad-image img {
            max-height: 100px; 
        }
    }
</style>

    @php
        $section_status = \App\Models\SectionStatus::first();
    @endphp

    @php
        $advertisements = \App\Models\Ad::where('status', 1)->get();
    @endphp

    <!-- Home Page Modal Ad Start -->
    @foreach($advertisements as $advertisement)
        @if($advertisement->type == 'homepage_modal')
        <div class="modal fade" id="advertisementModal{{ $advertisement->id }}" tabindex="-1" role="dialog" aria-labelledby="advertisementModalLabel{{ $advertisement->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document" style="display: flex; justify-content: center; align-items: center; height: 100vh;">
                <div class="modal-content p-0" style="overflow: hidden;">
                    <button type="button" class="close position-absolute p-2" style="top: 0; right: 0; z-index: 1050;" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                    </button>
                    <a href="{{ $advertisement->link }}" target="_blank">
                        <img src="{{ asset('images/ads/' . $advertisement->image) }}" class="img-fluid" alt="Advertisement" style="object-fit: cover; width: 100%; height: auto;">
                    </a>
                </div>
            </div>
        </div>
        @endif
    @endforeach
    <!-- Home Page Modal Ad End -->

    <!-- Carousel Slider, Special Offer Start -->
    <div class="container-fluid mb-3">
        <div class="row px-xl-5">
            @if($section_status->slider == 1)
                <div class="col-lg-8">
                    <div id="header-carousel" class="carousel slide carousel-fade mb-30 mb-lg-0" data-ride="carousel">
                        <ol class="carousel-indicators">
                            @foreach(\App\Models\Slider::all() as $key => $slider)
                                <li data-target="#header-carousel" data-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}"></li>
                            @endforeach
                        </ol>
                        <div class="carousel-inner">
                            @foreach(\App\Models\Slider::all() as $key => $slider)
                                <div class="carousel-item position-relative {{ $key == 0 ? 'active' : '' }}" style="height: 430px;">
                                    <img class="position-absolute w-100 h-100" src="{{ asset('images/slider/' . $slider->image) }}" style="object-fit: cover;">

                                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                        <div class="p-3" style="max-width: 700px;">
                                            <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">{{ $slider->title }}</h1>
                                            <p class="mx-md-5 px-5 animate__animated animate__bounceIn">{{ $slider->sub_title }}</p>
                                            <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp" href="{{ $slider->link }}">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
             @endif
             @if($section_status->special_offer == 1)
                <div class="col-lg-4">
                    @foreach(\App\Models\SpecialOffer::select('offer_image', 'offer_name', 'offer_title', 'slug')
                        ->where('status', 1)
                        ->whereDate('start_date', '<=', now())
                        ->whereDate('end_date', '>=', now())
                        ->latest()
                        ->get() as $specialOffer)
                        <div class="product-offer mb-30" style="height: 200px;">
                            <img class="img-fluid" src="{{ asset('images/special_offer/' . $specialOffer->offer_image) }}" alt="{{ $specialOffer->title }}">
                            <div class="offer-text">
                                <h6 class="text-white text-uppercase">{{ $specialOffer->offer_name }}</h6>
                                <h3 class="text-white mb-3">{{ $specialOffer->offer_title }}</h3>
                                <a href="{{ route('special-offers.show', $specialOffer->slug) }}" class="btn btn-primary">Shop Now</a>
                            </div>
                        </div>
                    @endforeach
                </div>
             @endif
        </div>
    </div>
    <!-- Carousel Slider, Special Offer End -->

    @if($section_status->features == 1)
    <!-- Featured Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5 pb-3">
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Quality Product</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
                    <h5 class="font-weight-semi-bold m-0">Free Shipping</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">14-Day Return</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">24/7 Support</h5>
                </div>
            </div>
        </div>
    </div>
    <!-- Featured End -->
    @endif

    @if($section_status->categories == 1)
    <!-- Categories Start -->
    <div class="container-fluid pt-5">
        @php
            $categories = \App\Models\Category::where('status', 1)->get();
            $showCategories = false;

            foreach ($categories as $category) {
                $productsCount = $category->products()
                    ->whereDoesntHave('specialOfferDetails')
                    ->whereDoesntHave('flashSellDetails')
                    ->count();

                if ($productsCount > 0) {
                    $showCategories = true;
                    break;
                }
            }
        @endphp

        @if ($showCategories)
            <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
                <span class="bg-secondary pr-3">Categories</span>
            </h2>

            <div class="row px-xl-5 pb-3">
                @foreach($categories as $category)
                    @php
                        $productsCount = $category->products()
                            ->whereDoesntHave('specialOfferDetails')
                            ->whereDoesntHave('flashSellDetails')
                            ->count();
                    @endphp
                    @if ($productsCount > 0)
                        <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                            <a class="text-decoration-none" href="{{ route('category.show', $category->slug) }}">
                                <div class="cat-item d-flex align-items-center mb-4">
                                    <div class="overflow-hidden" style="width: 100px; height: 100px;">
                                        <img class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;" src="{{ asset('images/category/' . $category->image) }}" alt="Category Image">
                                    </div>
                                    <div class="flex-fill pl-3">
                                        <h6>{{ $category->name }}</h6>
                                        <small class="text-body">{{ $productsCount }} Products</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    </div> 
    <!-- Categories End -->
    @endif

    <!-- Featured Ad Start -->
    <div class="container-fluid pt-5 pb-3">
        @foreach($advertisements as $advertisement)
            @if($advertisement->type == 'featured')
                <div class="advertisement-image custom-ad-image">
                    <a href="{{ $advertisement->link }}" target="_blank">
                        <img src="{{ asset('images/ads/' . $advertisement->image) }}" class="img-fluid" alt="Advertisement">
                    </a>
                </div>
            @endif
        @endforeach
    </div>  
    <!-- Featured Ad End -->

    @if($section_status->feature_products == 1)
    <!-- Feature Products Start -->
        @php
            $currency = \App\Models\CompanyDetails::value('currency');
            $products = \App\Models\Product::where('status', 1)
                            ->where('is_featured', 1)
                            ->whereDoesntHave('specialOfferDetails')
                            ->whereDoesntHave('flashSellDetails')
                            ->orderBy('id', 'desc')
                            ->select('id', 'name', 'feature_image', 'price', 'slug')
                            ->take(12)
                            ->get();
        @endphp

        @if ($products->count() > 0)
            <div class="container-fluid pt-5 pb-3">
                <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
                    <span class="bg-secondary pr-3">Feature Products</span>
                </h2>
                <div class="row px-xl-5">
                    @foreach($products as $product)
                        <div class="col-lg-3 col-md-4 col-sm-6 pb-1 mb-4">
                            <div class="product-item bg-light d-flex flex-column h-100">
                                <div class="product-img position-relative overflow-hidden" style="height: 250px;">
                                    <img class="img-fluid w-100 h-100" src="{{ asset('/images/products/' . $product->feature_image) }}" alt="{{ $product->name }}" style="object-fit: cover;">
                                    <div class="product-action">
                                        <a class="btn btn-outline-dark btn-square add-to-cart" data-product-id="{{ $product->id }}" data-offer-id="0" data-price="{{ $product->price }}">
                                            <i class="fa fa-shopping-cart"></i>
                                        </a>
                                        <a class="btn btn-outline-dark btn-square add-to-wishlist" data-product-id="{{ $product->id }}" data-offer-id="0" data-price="{{ $product->price }}">
                                            <i class="fa fa-heart"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="text-center py-4 mt-auto">
                                    <a class="h6 text-decoration-none text-truncate" href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                        <h5>{{ $currency }} {{ $product->price }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    <!-- Feature Products End -->
    @endif

    @if($section_status->flash_sell == 1)
    <!-- Flash Sell Start -->
        <div class="container-fluid pt-5 pb-3">
            <div class="row px-xl-5">
                @php
                    $flashSells = \App\Models\FlashSell::where('status', 1)
                                    ->whereDate('start_date', '<=', now())
                                    ->whereDate('end_date', '>=', now())
                                    ->select('flash_sell_image', 'flash_sell_name', 'flash_sell_title', 'slug')
                                    ->latest()   
                                    ->get();
                @endphp

                @foreach($flashSells as $flashSell)
                    <div class="col-md-6">
                        <div class="product-offer mb-30" style="height: 300px;">
                            <img class="img-fluid" src="{{ asset('images/flash_sell/' . $flashSell->flash_sell_image) }}" alt="{{ $flashSell->flash_sell_title }}">
                            <div class="offer-text">
                                <h6 class="text-white text-uppercase">{{ $flashSell->flash_sell_name }}</h6>
                                <h3 class="text-white mb-3">{{ $flashSell->flash_sell_title }}</h3>
                                <a href="{{ route('flash-sells.show', $flashSell->slug) }}" class="btn btn-primary">Shop Now</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    <!-- Flash Sell End -->
    @endif

    @if($section_status->trending_products == 1)
    <!-- Trending Products Start -->
        @php
            $products = \App\Models\Product::where('status', 1)
                        ->where('is_trending', 1)
                        ->orderBy('id', 'desc')
                        ->whereDoesntHave('specialOfferDetails')
                        ->whereDoesntHave('flashSellDetails')
                        ->select('id', 'name', 'feature_image', 'slug', 'price')
                        ->take(12)
                        ->get();
        @endphp

        @if ($products->count() > 0)
            <div class="container-fluid pt-5 pb-3">
                <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
                    <span class="bg-secondary pr-3">Trending Now</span>
                </h2>
                <div class="row px-xl-5">
                    @foreach($products as $product)
                        <div class="col-lg-3 col-md-4 col-sm-6 pb-1 mb-4">
                            <div class="product-item bg-light d-flex flex-column h-100">
                                <div class="product-img position-relative overflow-hidden" style="height: 250px;">
                                    <img class="img-fluid w-100 h-100" src="{{ asset('/images/products/' . $product->feature_image) }}" alt="{{ $product->name }}" style="object-fit: cover;">
                                    <div class="product-action">
                                        <a class="btn btn-outline-dark btn-square add-to-cart" data-product-id="{{ $product->id }}" data-offer-id="0" data-price="{{ $product->price }}">
                                            <i class="fa fa-shopping-cart"></i>
                                        </a>
                                        <a class="btn btn-outline-dark btn-square add-to-wishlist" data-product-id="{{ $product->id }}" data-offer-id="0" data-price="{{ $product->price }}">
                                            <i class="fa fa-heart"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="text-center py-4 mt-auto">
                                    <a class="h6 text-decoration-none text-truncate" href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                        <h5>{{ $currency }} {{ $product->price }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    <!-- Trending Products End -->
    @endif

    <!-- Recent Ad Start -->
    <div class="container-fluid pt-5 pb-3">
        @foreach($advertisements as $advertisement)
            @if($advertisement->type == 'recent')
                <div class="advertisement-image custom-ad-image">
                    <a href="{{ $advertisement->link }}" target="_blank">
                        <img src="{{ asset('images/ads/' . $advertisement->image) }}" class="img-fluid" alt="Advertisement">
                    </a>
                </div>
            @endif
        @endforeach
    </div>  
    <!-- Recent Ad End -->

    @if($section_status->recent_products == 1)
    <!-- Recent Products Start -->
        @php
            $recentProducts = \App\Models\Product::where('status', 1)
                                ->where('is_recent', 1)
                                ->orderBy('id', 'desc')
                                ->whereDoesntHave('specialOfferDetails')
                                ->whereDoesntHave('flashSellDetails')
                                ->select('id', 'name', 'feature_image', 'price', 'slug')
                                ->take(12)
                                ->get();
        @endphp

        @if($recentProducts->count() > 0)
            <div class="container-fluid pt-5 pb-3">
                <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
                    <span class="bg-secondary pr-3">Recent Products</span>
                </h2>
                <div class="row px-xl-5">
                    @foreach($recentProducts as $product)
                        <div class="col-lg-3 col-md-4 col-sm-6 pb-1 mb-4">
                            <div class="product-item bg-light d-flex flex-column h-100">
                                <div class="product-img position-relative overflow-hidden" style="height: 250px;">
                                    <img class="img-fluid w-100 h-100" src="{{ asset('/images/products/' . $product->feature_image) }}" alt="{{ $product->name }}" style="object-fit: cover;">
                                    <div class="product-action">
                                        <a class="btn btn-outline-dark btn-square add-to-cart" data-product-id="{{ $product->id }}" data-offer-id="0" data-price="{{ $product->price }}">
                                            <i class="fa fa-shopping-cart"></i>
                                        </a>
                                        <a class="btn btn-outline-dark btn-square add-to-wishlist" data-product-id="{{ $product->id }}" data-offer-id="0" data-price="{{ $product->price }}">
                                            <i class="fa fa-heart"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="text-center py-4 mt-auto">
                                    <a class="h6 text-decoration-none text-truncate" href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                        <h5>{{ $currency }} {{ $product->price }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    <!-- Recent Products End -->
    @endif

    @if($section_status->category_products == 1)
    <!-- Category Wise Products Start -->
        <div class="container-fluid pt-5 pb-3">
            <div class="row px-xl-5">
                @php
                    $categories = \App\Models\Category::where('status', 1)
                                    ->with(['products' => function($query) {
                                        $query->select('id', 'name', 'feature_image', 'price', 'slug', 'category_id')
                                            ->where('status', 1)
                                            ->whereDoesntHave('specialOfferDetails')
                                            ->whereDoesntHave('flashSellDetails')
                                            ->orderBy('id', 'desc');
                                    }])
                                    ->select('id', 'name')
                                    ->get();
                @endphp

                @foreach($categories as $category)
                    @if($category->products->isNotEmpty())
                        <div class="col-12 mb-4">
                            <div class="px-3">
                                <h2 class="section-title position-relative text-uppercase mb-4">
                                    <span class="bg-secondary pr-3">{{ $category->name }}</span>
                                </h2>
                            </div>
                            <div class="owl-carousel related-carousel">
                                @foreach($category->products as $product)
                                    <div class="product-item bg-light">
                                        <div class="product-img position-relative overflow-hidden" style="height: 250px;">
                                            <img class="img-fluid w-100 h-100" src="{{ asset('/images/products/' . $product->feature_image) }}" alt="{{ $product->name }}" style="object-fit: cover;">
                                            <div class="product-action">
                                                <a class="btn btn-outline-dark btn-square add-to-cart" data-product-id="{{ $product->id }}" data-offer-id="0" data-price="{{ $product->price }}">
                                                    <i class="fa fa-shopping-cart"></i>
                                                </a>
                                                <a class="btn btn-outline-dark btn-square add-to-wishlist" data-product-id="{{ $product->id }}" data-offer-id="0" data-price="{{ $product->price }}">
                                                    <i class="fa fa-heart"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="text-center py-4">
                                            <a class="h6 text-decoration-none text-truncate" href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                                            <div class="d-flex align-items-center justify-content-center mt-2">
                                                <h5>{{ $currency }} {{ $product->price }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    <!-- Category Wise Products End -->
    @endif

    @if ($section_status->popular_products == 1)
    <!--Popular Products Start -->
        @php
            $products = \App\Models\Product::where('status', 1)
                            ->where('is_popular', 1)
                            ->orderBy('id', 'desc')
                            ->whereDoesntHave('specialOfferDetails')
                            ->whereDoesntHave('flashSellDetails')
                            ->select('id', 'name', 'feature_image', 'price', 'slug')
                            ->take(12)
                            ->get();
        @endphp

        @if ($products->count() > 0)
            <div class="container-fluid pt-5 pb-3">
                <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
                    <span class="bg-secondary pr-3">Popular Products</span>
                </h2>
                <div class="row px-xl-5">
                    @foreach($products as $product)
                        <div class="col-lg-3 col-md-4 col-sm-6 pb-1 mb-4">
                            <div class="product-item bg-light d-flex flex-column h-100">
                                <div class="product-img position-relative overflow-hidden" style="height: 250px;">
                                    <img class="img-fluid w-100 h-100" src="{{ asset('/images/products/' . $product->feature_image) }}" alt="{{ $product->name }}" style="object-fit: cover;">
                                    <div class="product-action">
                                        <a class="btn btn-outline-dark btn-square add-to-cart" data-product-id="{{ $product->id }}" data-offer-id="0" data-price="{{ $product->price }}">
                                            <i class="fa fa-shopping-cart"></i>
                                        </a>
                                        <a class="btn btn-outline-dark btn-square add-to-wishlist" data-product-id="{{ $product->id }}" data-offer-id="0" data-price="{{ $product->price }}">
                                            <i class="fa fa-heart"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="text-center py-4 mt-auto">
                                    <a class="h6 text-decoration-none text-truncate" href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                        <h5>{{ $currency }} {{ $product->price }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    <!--Popular Products End -->
    @endif

    <!-- Vendor ad Start -->
    <div class="container-fluid pt-5 pb-3">
        @foreach($advertisements as $advertisement)
            @if($advertisement->type == 'vendor')
                <div class="advertisement-image custom-ad-image">
                    <a href="{{ $advertisement->link }}" target="_blank">
                        <img src="{{ asset('images/ads/' . $advertisement->image) }}" class="img-fluid" alt="Advertisement">
                    </a>
                </div>
            @endif
        @endforeach
    </div>  
    <!-- Vendor ad End -->

    @if($section_status->vendors == 1)
    <!-- Vendor Start -->
    <div class="container-fluid py-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
            <span class="bg-secondary pr-3">Vendors</span>
        </h2>

        @php
            $suppliers = \App\Models\Supplier::orderBy('id', 'desc')
                            ->select('id', 'name', 'image')
                            ->get();
        @endphp
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel vendor-carousel">
                    @foreach($suppliers as $supplier)
                        <div class="bg-light p-4">
                            <img src="{{ asset('/images/supplier/' . $supplier->image) }}" alt="{{ $supplier->name }}">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Vendor End -->
    @endif

@endsection

@section('script')

    <!-- <script>
        $(document).ready(function() {

            @foreach($advertisements as $advertisement)
                @if($advertisement->type == 'homepage_modal')
                    $('#advertisementModal{{ $advertisement->id }}').modal('show');
                @endif
            @endforeach
        });
    </script> -->

@endsection