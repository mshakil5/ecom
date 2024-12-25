@extends('frontend.layouts.app')

@section('content')

    <!-- Intro Slider Start-->
    @if($section_status->slider == 1 && count($sliders) > 0)
    <div class="hero-area">
        <div class="hero-area-wrapper hero-slider-dots fix-slider-dots">
            @foreach($sliders as $slider)
                <div class="hero-area-single">
                    <div class="hero-area-bg">
                        <img class="hero-img" src="{{ asset('images/slider/' . $slider->image) }}" alt="{{ $slider->title }}">
                    </div>
                    <div class="hero-content">
                        <div class="container">
                            <div class="row">
                                <div class="col-10 col-md-8 col-xl-6">
                                    <h5>{{ $slider->sub_title }}</h5>
                                    <h2 class="text-white">{{ $slider->title }}</h2>
                                    <p>{{ $slider->description }}</p>
                                    @if($slider->link)
                                        <a href="{{ $slider->link }}" class="hero-button">Shopping Now</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif
    <!-- Intro Slider End -->

    <!-- Categories slider Start -->
    @if($section_status->categories == 1 && count($categories) > 0)
    <div class="product-catagory-section section-top-gap-100">
        <div class="section-content-gap">
            <div class="container">
                <div class="row">
                    <div class="section-content">
                        <h3 class="section-title" data-aos="fade-up" data-aos-delay="50">Popular Categories</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="product-catagory-wrapper">
            <div class="container">
                <div class="row">
                    @foreach($categories as $index => $category)
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                            <a href="{{ route('category.show', $category->slug) }}" class="product-catagory-single" data-aos="fade-up" data-aos-delay="{{ $index * 200 }}">
                                <div class="product-catagory-img">
                                    <img src="{{ asset('images/category/' . $category->image) }}" alt="{{ $category->name }}" class="img-fluid" style="height: 200px; object-fit: cover;">
                                </div>
                                <div class="product-catagory-content">
                                    <h5 class="product-catagory-title">{{ $category->name }}</h5>
                                    <span class="product-catagory-items">({{ $category->products->count() }} Items)</span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- Categories slider End -->

    <!-- Special Offer Start -->
    @if($section_status->special_offer == 1 && count($specialOffers) > 0)
    <div class="banner-section section-top-gap-100">
        <div class="banner-wrapper">
            <div class="container">
                <div class="row">
                    @foreach($specialOffers as $index => $offer)
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="banner-single" data-aos="fade-up" data-aos-delay="{{ $index * 200 }}">
                                <a href="{{ route('product.show', $offer->slug) }}" class="banner-img-link">
                                    <img class="banner-img img-fluid" src="{{ asset('images/special_offers/' . $offer->offer_image) }}" alt="{{ $offer->offer_name }}" style="height: 200px; object-fit: cover;">
                                </a>
                                <div class="banner-content">
                                    <span class="banner-text-tiny">{{ $offer->offer_name }}</span>
                                    <h3 class="banner-text-large">{{ $offer->offer_title }}</h3>
                                    <a href="{{ route('product.show', $offer->slug) }}" class="banner-link">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- Special Offer End -->

    <!-- Category products slider Start-->
    @if ($section_status->category_products == 1 && count($categories) > 0)
    <div class="product-tab-section section-top-gap-100">
        <div class="section-content-gap">
            <div class="container">
                <div class="row">
                    <div class="section-content d-flex justify-content-between align-items-md-center align-items-start flex-md-row flex-column">
                        <h3 class="section-title" data-aos="fade-up" data-aos-delay="0">Products</h3>
                        <ul class="tablist nav product-tab-btn" data-aos="fade-up" data-aos-delay="400">
                            @foreach($categories as $index => $category)
                                <li>
                                    <a class="nav-link {{ $index === 0 ? 'active' : '' }}" data-bs-toggle="tab" href="#{{ $category->slug }}">{{ $category->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="product-tab-wrapper" data-aos="fade-up" data-aos-delay="50">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="tab-content tab-animate-zoom">
                            @foreach($categories as $index => $category)
                                <div class="tab-pane {{ $index === 0 ? 'show active' : '' }}" id="{{ $category->slug }}">
                                    <div class="product-default-slider product-default-slider-4grids-1row">
                                        @foreach($category->products as $product)
                                            <div class="product-default-single border-around">
                                                <div class="product-img-warp">
                                                    <a href="{{ route('product.show', $product->slug) }}" class="product-default-img-link">
                                                        <img src="{{ asset('images/products/' . $product->feature_image) }}" alt="{{ $product->name }}" class="product-default-img img-fluid" style="height: 200px; object-fit: cover;">
                                                    </a>
                                                    <div class="product-action-icon-link">
                                                        <ul>
                                                            <li><a href="#"><i class="icon-heart"></i></a></li>
                                                            <li><a href="#" data-bs-toggle="modal" data-bs-target="#modalQuickview"><i class="icon-eye"></i></a></li>
                                                            <li><a href="#" data-bs-toggle="modal" data-bs-target="#modalAddcart"><i class="icon-shopping-cart"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="product-default-content">
                                                    <h6 class="product-default-link"><a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a></h6>
                                                    <span class="product-default-price"><del class="product-default-price-off">${{ number_format($product->price + 5, 2) }}</del> ${{ number_format($product->price, 2) }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- Category products slider End-->

    <!-- Recent Products Start -->
    @if($section_status->recent_products == 1 && $recentProducts->count() > 0)
    <div class="product-tab-section section-top-gap-100">
        <div class="section-content-gap">
            <div class="container">
                <div class="row">
                    <div class="section-content d-flex justify-content-between align-items-md-center align-items-start flex-md-row flex-column">
                        <h3 class="section-title" data-aos="fade-up" data-aos-delay="0">Recent Products</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="product-tab-wrapper" data-aos="fade-up" data-aos-delay="50">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="product-default-slider product-default-slider-4grids-1row">
                            @if ($recentProducts->count() > 0)
                                @foreach($recentProducts as $product)
                                    <div class="product-default-single border-around">
                                        <div class="product-img-warp">
                                            <a href="{{ route('product.show', $product->slug) }}" class="product-default-img-link">
                                                <img src="{{ asset('images/products/' . $product->feature_image) }}" alt="{{ $product->name }}" class="product-default-img img-fluid" style="height: 200px; object-fit: cover;">
                                            </a>
                                            <div class="product-action-icon-link">
                                                <ul>
                                                    <li><a href="#"><i class="icon-heart"></i></a></li>
                                                    <li><a href="#" data-bs-toggle="modal" data-bs-target="#modalQuickview"><i class="icon-eye"></i></a></li>
                                                    <li><a href="#" data-bs-toggle="modal" data-bs-target="#modalAddcart"><i class="icon-shopping-cart"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="product-default-content">
                                            <h6 class="product-default-link"><a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a></h6>
                                            <span class="product-default-price"><del class="product-default-price-off">${{ number_format($product->price + 5, 2) }}</del> ${{ number_format($product->price, 2) }}</span>
                                        </div>
                                    </div> <!-- End Product Default Single -->
                                @endforeach
                            @else
                                <p>No recent products available.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- Recent Products End -->
    
    <!-- Trending Products Start -->
    @if($section_status->trending_products == 1 && $trendingProducts->count() > 0)
    <div class="product-tab-section section-top-gap-100">
        <div class="section-content-gap">
            <div class="container">
                <div class="row">
                    <div class="section-content d-flex justify-content-between align-items-md-center align-items-start flex-md-row flex-column">
                        <h3 class="section-title" data-aos="fade-up" data-aos-delay="0">Trending Products</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="product-tab-wrapper" data-aos="fade-up" data-aos-delay="50">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="product-default-slider product-default-slider-4grids-1row">
                            @if ($trendingProducts->count() > 0)
                                @foreach($trendingProducts as $product)
                                    <div class="product-default-single border-around">
                                        <div class="product-img-warp">
                                            <a href="{{ route('product.show', $product->slug) }}" class="product-default-img-link">
                                                <img src="{{ asset('images/products/' . $product->feature_image) }}" alt="{{ $product->name }}" class="product-default-img img-fluid" style="height: 200px; object-fit: cover;">
                                            </a>
                                            <div class="product-action-icon-link">
                                                <ul>
                                                    <li><a href="#"><i class="icon-heart"></i></a></li>
                                                    <li><a href="#" data-bs-toggle="modal" data-bs-target="#modalQuickview"><i class="icon-eye"></i></a></li>
                                                    <li><a href="#" data-bs-toggle="modal" data-bs-target="#modalAddcart"><i class="icon-shopping-cart"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="product-default-content">
                                            <h6 class="product-default-link"><a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a></h6>
                                            <span class="product-default-price"><del class="product-default-price-off">${{ number_format($product->price + 5, 2) }}</del> ${{ number_format($product->price, 2) }}</span>
                                        </div>
                                    </div> <!-- End Product Default Single -->
                                @endforeach
                            @else
                                <p>No trending products available.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- Trending Products End -->

    <!-- Most Viewed Products Start -->
    @if($section_status->most_viewed_products == 1 && $mostViewedProducts->count() > 0)
    <div class="product-tab-section section-top-gap-100">
        <div class="section-content-gap">
            <div class="container">
                <div class="row">
                    <div class="section-content d-flex justify-content-between align-items-md-center align-items-start flex-md-row flex-column">
                        <h3 class="section-title" data-aos="fade-up" data-aos-delay="0">Most Viewed Products</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="product-tab-wrapper" data-aos="fade-up" data-aos-delay="50">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="product-default-slider product-default-slider-4grids-1row">
                            @if ($mostViewedProducts->count() > 0)
                                @foreach($mostViewedProducts as $product)
                                    <div class="product-default-single border-around">
                                        <div class="product-img-warp">
                                            <a href="{{ route('product.show', $product->slug) }}" class="product-default-img-link">
                                                <img src="{{ asset('images/products/' . $product->feature_image) }}" alt="{{ $product->name }}" class="product-default-img img-fluid" style="height: 200px; object-fit: cover;">
                                            </a>
                                            <div class="product-action-icon-link">
                                                <ul>
                                                    <li><a href="#"><i class="icon-heart"></i></a></li>
                                                    <li><a href="#" data-bs-toggle="modal" data-bs-target="#modalQuickview"><i class="icon-eye"></i></a></li>
                                                    <li><a href="#" data-bs-toggle="modal" data-bs-target="#modalAddcart"><i class="icon-shopping-cart"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="product-default-content">
                                            <h6 class="product-default-link"><a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a></h6>
                                            <span class="product-default-price"><del class="product-default-price-off">${{ number_format($product->price + 5, 2) }}</del> ${{ number_format($product->price, 2) }}</span>
                                        </div>
                                    </div> <!-- End Product Default Single -->
                                @endforeach
                            @else
                                <p>No most viewed products available.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- Most Viewed Products End -->

    <!-- Flash Sell Start -->
    @if($section_status->flash_sell == 1 && count($flashSells) > 0)
    <div class="banner-section section-top-gap-100">
        <div class="banner-wrapper">
            <div class="container">
                <div class="row">
                    @foreach($flashSells as $index => $flashSell)
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="banner-single" data-aos="fade-up" data-aos-delay="{{ $index * 200 }}">
                                <a href="{{ route('flash-sells.show', $flashSell->slug) }}" class="banner-img-link">
                                    <img class="banner-img img-fluid" src="{{ asset('images/flash_sell/' . $flashSell->flash_sell_image) }}" alt="{{ $flashSell->flash_sell_name }}" style="height: 200px; object-fit: cover;">
                                </a>
                                <div class="banner-content">
                                    <span class="banner-text-tiny">{{ $flashSell->flash_sell_name }}</span>
                                    <h3 class="banner-text-large">{{ $flashSell->flash_sell_title }}</h3>
                                    <a href="{{ route('flash-sells.show', $flashSell->slug) }}" class="banner-link">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- Flash Sell End -->

    <!-- Start Modal Quickview cart -->
    <div class="modal fade" id="modalQuickview" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col text-end">
                                <button type="button" class="close modal-close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true"> <i class="fa fa-times"></i></span>
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="product-details-gallery-area">
                                    <div class="product-large-image modal-product-image-large">
                                        <div class="product-image-large-single">
                                            <img class="img-fluid" src="assets/images/products_images/aments_products_image_1.jpg" alt="">
                                        </div>
                                        <div class="product-image-large-single">
                                            <img class="img-fluid" src="assets/images/products_images/aments_products_image_2.jpg" alt="">
                                        </div>
                                        <div class="product-image-large-single">
                                            <img class="img-fluid" src="assets/images/products_images/aments_products_image_3.jpg" alt="">
                                        </div>
                                        <div class="product-image-large-single">
                                            <img class="img-fluid" src="assets/images/products_images/aments_products_image_4.jpg" alt="">
                                        </div>
                                        <div class="product-image-large-single">
                                            <img class="img-fluid" src="assets/images/products_images/aments_products_image_5.jpg" alt="">
                                        </div>
                                        <div class="product-image-large-single">
                                            <img class="img-fluid" src="assets/images/products_images/aments_products_image_6.jpg" alt="">
                                        </div>
                                    </div>
                                    <div class="product-image-thumb modal-product-image-thumb">
                                        <div class="zoom-active product-image-thumb-single">
                                            <img class="img-fluid" src="assets/images/products_images/aments_products_image_1.jpg" alt="">
                                        </div>
                                        <div class="product-image-thumb-single">
                                            <img class="img-fluid" src="assets/images/products_images/aments_products_image_2.jpg" alt="">
                                        </div>
                                        <div class="product-image-thumb-single">
                                            <img class="img-fluid" src="assets/images/products_images/aments_products_image_3.jpg" alt="">
                                        </div>
                                        <div class="product-image-thumb-single">
                                            <img class="img-fluid" src="assets/images/products_images/aments_products_image_4.jpg" alt="">
                                        </div>
                                        <div class="product-image-thumb-single">
                                            <img class="img-fluid" src="assets/images/products_images/aments_products_image_5.jpg" alt="">
                                        </div>
                                        <div class="product-image-thumb-single">
                                            <img class="img-fluid" src="assets/images/products_images/aments_products_image_6.jpg" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="product-details-content-area">
                                    <!-- Start  Product Details Text Area-->
                                    <div class="product-details-text">
                                        <h4 class="title">Nonstick Dishwasher PFOA</h4>
                                        <div class="price"><del>$70.00</del>$80.00</div>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia iste laborum ad impedit pariatur esse optio tempora sint ullam autem deleniti nam in quos qui nemo ipsum numquam, reiciendis maiores quidem aperiam, rerum vel recusandae</p>
                                    </div> <!-- End  Product Details Text Area-->
                                    <!-- Start Product Variable Area -->
                                    <div class="product-details-variable">
                                        <!-- Product Variable Single Item -->
                                        <div class="variable-single-item">
                                            <span>Color</span>
                                            <div class="product-variable-color">
                                                <label for="modal-product-color-red">
                                                    <input name="modal-product-color" id="modal-product-color-red" class="color-select" type="radio" checked>
                                                    <span class="product-color-red"></span>
                                                </label>
                                                <label for="modal-product-color-tomato">
                                                    <input name="modal-product-color" id="modal-product-color-tomato" class="color-select" type="radio">
                                                    <span class="product-color-tomato"></span>
                                                </label>
                                                <label for="modal-product-color-green">
                                                    <input name="modal-product-color" id="modal-product-color-green" class="color-select" type="radio">
                                                    <span class="product-color-green"></span>
                                                </label>
                                                <label for="modal-product-color-light-green">
                                                    <input name="modal-product-color" id="modal-product-color-light-green" class="color-select" type="radio">
                                                    <span class="product-color-light-green"></span>
                                                </label>
                                                <label for="modal-product-color-blue">
                                                    <input name="modal-product-color" id="modal-product-color-blue" class="color-select" type="radio">
                                                    <span class="product-color-blue"></span>
                                                </label>
                                                <label for="modal-product-color-light-blue">
                                                    <input name="modal-product-color" id="modal-product-color-light-blue" class="color-select" type="radio">
                                                    <span class="product-color-light-blue"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <!-- Product Variable Single Item -->
                                        <div class="variable-single-item ">
                                            <span>Quantity</span>
                                            <div class="product-variable-quantity">
                                                <input min="1" max="100" value="1" type="number">
                                            </div>
                                        </div>
                                    </div> <!-- End Product Variable Area -->
                                    <!-- Start  Product Details Meta Area-->
                                    <div class="product-details-meta mb-20">
                                        <ul>
                                            <li><a href=""><i class="icon-heart"></i>Add to wishlist</a></li>
                                            <li><a href="#" data-bs-toggle="modal" data-bs-target="#modalQuickview"><i class="icon-shopping-cart"></i>Add To Cart</a></li>
                                        </ul>
                                    </div> <!-- End  Product Details Meta Area-->
                                    <!-- Start  Product Details Social Area-->
                                    <ul class="modal-product-details-social">
                                        <li><a href="#" class="facebook"><i class="fa fa-facebook"></i></a></li>
                                        <li><a href="#" class="twitter"><i class="fa fa-twitter"></i></a></li>
                                        <li><a href="#" class="pinterest"><i class="fa fa-pinterest"></i></a></li>
                                        <li><a href="#" class="google-plus"><i class="fa fa-google-plus"></i></a></li>
                                        <li><a href="#" class="linkedin"><i class="fa fa-linkedin"></i></a></li>
                                    </ul> <!-- End  Product Details Social Area-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End Modal Quickview cart -->

    <!-- Start Modal Add cart -->
    <div class="modal fade" id="modalAddcart" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col text-end">
                                <button type="button" class="close modal-close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true"> <i class="fa fa-times"></i></span>
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="modal-add-cart-product-img">
                                            <img class="img-fluid" src="assets/images/products_images/aments_products_image_1.jpg" alt="">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="modal-add-cart-info"><i class="fa fa-check-square"></i>Added to cart successfully!</div>
                                        <div class="modal-add-cart-product-cart-buttons">
                                            <a href="cart.html">View Cart</a>
                                            <a href="checkout.html">Checkout</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 modal-border">
                                <ul class="modal-add-cart-product-shipping-info">
                                    <li> <strong><i class="icon-shopping-cart"></i> There Are 5 Items In Your Cart.</strong></li>
                                    <li> <strong>TOTAL PRICE: </strong> <span>$187.00</span></li>
                                    <li class="modal-continue-button"><a href="#" data-bs-dismiss="modal">CONTINUE SHOPPING</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End Modal Add cart -->

@endsection

@section('script')

@endsection