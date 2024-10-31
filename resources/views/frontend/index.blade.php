@extends('frontend.layouts.app')

@section('content')

    <!-- Intro Slider Start-->
    @if($section_status->slider == 1)
    <div class="intro-section pt-3 pb-3 mb-2">
        <div class="container">
            <div class="row">
                <!-- First Column (Slider) -->
                <div class="col-12 col-lg-8 mb-3 mb-lg-0">
                    <div class="intro-slider-container slider-container-ratio mb-2 mb-lg-0">
                        <div class="intro-slider owl-carousel owl-simple owl-dark owl-nav-inside" data-toggle="owl"
                            data-owl-options='{
                                "dots": true,
                                "nav": false,
                                "responsive": {
                                    "1200": {
                                        "nav": true,
                                        "dots": false
                                    }
                                }
                            }'>
                            @foreach($sliders as $slider)
                                <div class="intro-slide" style="background-image: url('{{ asset('images/slider/' . $slider->image) }}'); background-size: cover; background-position: center; height: 500px; display: flex; align-items: center; justify-content: center;">
                                    <div class="container intro-content" style="padding: 20px;">
                                        <div class="row justify-content-left">
                                            <div class="col-auto col-sm-7 col-md-6 col-lg-5" style="background: rgba(0, 0, 0, 0.5); padding: 20px; border-radius: 10px;">
                                                <h3 class="intro-subtitle text-third" style="color: #fff;">{{ $slider->sub_title }}</h3>
                                                <h1 class="intro-title" style="color: #fff;">{{ $slider->title }}</h1>
                                                @if($slider->link)
                                                <a href="{{ $slider->link }}" class="btn btn-primary btn-round">
                                                    <span>Shop More</span>
                                                    <i class="icon-long-arrow-right"></i>
                                                </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <span class="slider-loader"></span>
                    </div>
                </div>
                <!-- End of First Column -->

                <!-- Second Column (Categories) -->
                <div class="col-12 col-lg-4 d-none d-lg-block">
                    <div class="intro-banners">
                        @foreach($categories->take(3) as $category)
                        <div class="banner mb-3">
                            <a href="{{ route('category.show', $category->slug) }}">
                                <img src="{{ asset('images/category/' . $category->image) }}" alt="{{ $category->name }}" class="img-fluid" style="object-fit: cover; height: 153px; width: 100%;">
                            </a>

                            <div class="banner-content" style="background: rgba(0, 0, 0, 0.5); padding: 10px; border-radius: 10px;">
                                <h4 class="banner-title text-center">
                                    <a href="{{ route('category.show', $category->slug) }}" style="color: #fff;">{{ $category->name }}</a>
                                </h4>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <!-- End of Second Column -->
            </div>
        </div>
    </div>
    @endif
    <!-- Intro Slider End -->

    <div class="mb-5"></div>

    <!-- Special Offer Start -->
    @if($section_status->special_offer == 1)
    <div class="row justify-content-center">
        @foreach($specialOffers as $specialOffer)
            <div class="col-md-6 col-lg-4">
                <div class="banner banner-overlay banner-overlay-light">
                    <a href="{{ route('special-offers.show', $specialOffer->slug) }}">
                        <img src="{{ asset('images/special_offer/' . $specialOffer->offer_image) }}" alt="Banner" style="height: 300px; object-fit: cover;">
                    </a>
                    <div class="banner-content" style="background: rgba(0, 0, 0, 0.5); padding: 20px; border-radius: 10px;">
                        <h4 class="banner-subtitle">
                            <a href="{{ route('special-offers.show', $specialOffer->slug) }}" style="color: #fff;">
                                {{ $specialOffer->offer_name }}
                            </a>
                        </h4>
                        <h3 class="banner-title">
                            <a href="{{ route('special-offers.show', $specialOffer->slug) }}">
                                <strong style="color: #fff;">{{ $specialOffer->offer_title }}</strong>
                            </a>
                        </h3>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @endif
    <!-- Special Offer End -->

    <div class="mb-3"></div>

    <!-- Category products slider Start-->
    @if ($section_status->category_products == 1 && count($categories) > 0)
    <div class="container new-arrivals">   
        <div class="heading heading-flex mb-3 pt-3">
            <div class="heading-left" style="display:none;">
                <h2 class="title">Category Products</h2>
            </div>
            <div class="heading-right" style="width: 100%; text-align: center;">
                <ul class="nav nav-pills nav-border-anim nav-big justify-content-center" role="tablist">
                     @foreach($categories->take(3) as $index => $category)
                        <li class="nav-item">
                            <a class="nav-link {{ $index == 0 ? 'active' : '' }}" 
                            id="category-{{ $category->id }}-link" 
                            data-toggle="tab" 
                            href="#category-{{ $category->id }}-tab" 
                            role="tab" 
                            aria-controls="category-{{ $category->id }}-tab" 
                            aria-selected="{{ $index == 0 ? 'true' : 'false' }}"
                            index="{{ $index }}">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="tab-content">
            @foreach($categories as $index => $category)
                <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="category-{{ $category->id }}-tab" role="tabpanel" aria-labelledby="category-{{ $category->id }}-link">
                    <div class="owl-carousel owl-full carousel-equal-height carousel-with-shadow" data-toggle="owl" 
                        data-owl-options='{
                            "nav": true, 
                            "dots": true,
                            "margin": 20,
                            "loop": false,
                            "responsive": {
                                "0": {
                                    "items":2
                                },
                                "480": {
                                    "items":2
                                },
                                "768": {
                                    "items":3
                                },
                                "992": {
                                    "items":4
                                }
                            }
                        }'>
                        @foreach($category->products as $product)
                        <div class="product product-2">
                            <figure class="product-media">
                                <a href="{{ route('product.show', $product->slug) }}">
                                    <img src="{{ asset('images/products/' . $product->feature_image) }}" alt="{{ $product->name }}" class="product-image">
                                </a>
                                @if ($product->stock && $product->stock->quantity > 0)
                                    <div class="product-action-vertical">
                                        <a href="#" class="btn-product-icon btn-wishlist add-to-wishlist btn-expandable" 
                                        title="Add to wishlist" 
                                        data-product-id="{{ $product->id }}" 
                                        data-offer-id="0" 
                                        data-price="{{ $product->price }}"><span>Add to wishlist</span>      
                                        </a>
                                    </div>
                                    <div class="product-action">
                                        <a href="#" class="btn-product btn-cart add-to-cart" title="Add to cart" data-product-id="{{ $product->id }}" data-offer-id="0" 
                                        data-price="{{ $product->price }}"><span>add to cart</span></a>
                                    </div>
                                @else
                                    <span class="product-label label-out-stock">Out of stock</span>
                                @endif
                            </figure>
                            <div class="product-body">
                                <div class="product-cat">
                                    <a href="{{ route('category.show', $category->slug) }}">{{ $category->name }}</a>
                                </div>
                                <h3 class="product-title"><a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a></h3>
                                <div class="product-price">
                                    {{ $currency }}{{ number_format($product->price, 2) }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif
    <!-- Category products slider End-->

    <div class="mb-6"></div>

    <!-- Recent advertisements start-->
    <div class="container">
        @foreach($advertisements as $advertisement)
            @if($advertisement->type == 'recent')
                <div class="cta cta-border mb-5" style="background-image: url('{{ asset('images/ads/' . $advertisement->image) }}');">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="cta-content">
                                <div class="cta-text text-right text-white">
                                </div>
                                <a href="{{ $advertisement->link }}" class="btn btn-primary btn-round" target="_blank">
                                    <span>Shop Now</span><i class="icon-long-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
    <!-- Recent advertisements end-->

    <!-- Recent Products Start -->
    @if($section_status->recent_products == 1)
    <div class="pt-5 pb-6">
        <div class="container trending-products">
            <div class="heading heading-flex mb-3">
                <div class="heading-left">
                    <h2 class="title">Recent Products</h2>
                </div>
            </div>

            <div class="owl-carousel owl-full carousel-equal-height carousel-with-shadow" data-toggle="owl" 
                data-owl-options='{
                    "nav": true, 
                    "dots": true,
                    "margin": 20,
                    "loop": false,
                    "responsive": {
                        "0": {
                            "items":2
                        },
                        "480": {
                            "items":2
                        },
                        "768": {
                            "items":3
                        },
                        "992": {
                            "items":4
                        }
                    }
                }'>
                @if ($recentProducts->count() > 0)
                    @foreach($recentProducts as $product)
                    <div class="product product-2">
                        <figure class="product-media">
                            <a href="{{ route('product.show', $product->slug) }}">
                                <img src="{{ asset('images/products/' . $product->feature_image) }}" alt="{{ $product->name }}" class="product-image">
                            </a>
                            @if ($product->stock && $product->stock->quantity > 0)
                                <div class="product-action-vertical">
                                    <a href="#" class="btn-product-icon btn-wishlist add-to-wishlist btn-expandable" title="Add to wishlist" data-product-id="{{ $product->id }}" data-offer-id="0" data-price="{{ $product->price }}">
                                        <span>Add to wishlist</span>
                                    </a>
                                </div>
                                <div class="product-action">
                                    <a href="#" class="btn-product btn-cart add-to-cart" title="Add to cart" data-product-id="{{ $product->id }}" data-offer-id="0" data-price="{{ $product->price }}"><span>add to cart</span></a>
                                </div>
                            @else
                                <span class="product-label label-out-stock">Out of stock</span>
                            @endif
                        </figure>

                        <div class="product-body">
                            <div class="product-cat">
                                <a href="{{ route('category.show', $category->slug) }}">{{ $category->name }}</a>
                            </div>
                            <h3 class="product-title"><a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a></h3>
                            <div class="product-price">
                            {{ $currency }}{{ number_format($product->price, 2) }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    @endif
    <!-- Recent Products End -->

    <!-- Supplier advertisements start-->
    <div class="container">
        @foreach($advertisements as $advertisement)
            @if($advertisement->type == 'vendor')
                <div class="cta cta-border mb-5" style="background-image: url('{{ asset('images/ads/' . $advertisement->image) }}');">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="cta-content">
                                <div class="cta-text text-right text-white">
                                </div>
                                <a href="{{ $advertisement->link }}" class="btn btn-primary btn-round" target="_blank">
                                    <span>Shop Now</span><i class="icon-long-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
    <!-- Supplier advertisements end-->

    <!-- Trending Products Start -->
    @if($section_status->trending_products == 1)
    <div class="pt-5 pb-6">
        <div class="container trending-products">
            <div class="heading heading-flex mb-3">
                <div class="heading-left">
                    <h2 class="title">Trending Products</h2>
                </div>
            </div>

            <div class="owl-carousel owl-full carousel-equal-height carousel-with-shadow" data-toggle="owl" 
                data-owl-options='{
                    "nav": true, 
                    "dots": true,
                    "margin": 20,
                    "loop": false,
                    "responsive": {
                        "0": {
                            "items":2
                        },
                        "480": {
                            "items":2
                        },
                        "768": {
                            "items":3
                        },
                        "992": {
                            "items":4
                        }
                    }
                }'>
                @if ($trendingProducts->count() > 0)
                    @foreach($trendingProducts as $product)
                    <div class="product product-2">
                        <figure class="product-media">
                            <a href="{{ route('product.show', $product->slug) }}">
                                <img src="{{ asset('images/products/' . $product->feature_image) }}" alt="{{ $product->name }}" class="product-image">
                            </a>
                            @if ($product->stock && $product->stock->quantity > 0)
                                <div class="product-action-vertical">
                                    <a href="#" class="btn-product-icon btn-wishlist add-to-wishlist btn-expandable" title="Add to wishlist" data-product-id="{{ $product->id }}" data-offer-id="0" data-price="{{ $product->price }}">
                                        <span>Add to wishlist</span>
                                    </a>
                                </div>
                                <div class="product-action">
                                    <a href="#" class="btn-product btn-cart add-to-cart" title="Add to cart" data-product-id="{{ $product->id }}" data-offer-id="0" data-price="{{ $product->price }}"><span>add to cart</span></a>
                                </div>
                            @else
                                <span class="product-label label-out-stock">Out of stock</span>
                            @endif
                        </figure>

                        <div class="product-body">
                            <div class="product-cat">
                                <a href="{{ route('category.show', $category->slug) }}">{{ $category->name }}</a>
                            </div>
                            <h3 class="product-title"><a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a></h3>
                            <div class="product-price">
                            {{ $currency }}{{ number_format( $product->price, 2) }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    @endif
    <!-- Trending Products End -->

    <!-- Most Viewed Products Start -->
    @if($section_status->most_viewed_products == 1 && $mostViewedProducts->count() > 0)
    <div class="pt-5 pb-6">
        <div class="container trending-products">
            <div class="heading heading-flex mb-3">
                <div class="heading-left">
                    <h2 class="title">Most Viewed Products</h2>
                </div>
            </div>

            <div class="owl-carousel owl-full carousel-equal-height carousel-with-shadow" data-toggle="owl" 
                data-owl-options='{
                    "nav": true, 
                    "dots": true,
                    "margin": 20,
                    "loop": false,
                    "responsive": {
                        "0": {
                            "items":2
                        },
                        "480": {
                            "items":2
                        },
                        "768": {
                            "items":3
                        },
                        "992": {
                            "items":4
                        }
                    }
                }'>
                @if ($mostViewedProducts->count() > 0)
                    @foreach($mostViewedProducts as $product)
                    <div class="product product-2">
                        <figure class="product-media">
                            <a href="{{ route('product.show', $product->slug) }}">
                                <img src="{{ asset('images/products/' . $product->feature_image) }}" alt="{{ $product->name }}" class="product-image">
                            </a>
                            @if ($product->stock && $product->stock->quantity > 0)

                                <div class="product-action-vertical">
                                    <a href="#" class="btn-product-icon btn-wishlist add-to-wishlist btn-expandable" title="Add to wishlist" data-product-id="{{ $product->id }}" data-offer-id="0" data-price="{{ $product->price }}">
                                        <span>Add to wishlist</span>
                                    </a>
                                </div>
                                <div class="product-action">
                                    <a href="#" class="btn-product btn-cart add-to-cart" title="Add to cart" data-product-id="{{ $product->id }}" data-offer-id="0" data-price="{{ $product->price }}"><span>add to cart</span></a>
                                </div>
                            @else
                                <span class="product-label label-out-stock">Out of stock</span>
                            @endif
                        </figure>

                        <div class="product-body">
                            <div class="product-cat">
                                <a href="{{ route('category.show', $category->slug) }}">{{ $category->name }}</a>
                            </div>
                            <h3 class="product-title"><a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a></h3>
                            <div class="product-price">
                            {{ $currency }}{{ number_format( $product->price, 2) }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    @endif
    <!-- Most Viewed Products End -->

    <!-- Flash Sell Start -->
    @if($section_status->flash_sell == 1)
    <div class="row justify-content-center">
        @foreach($flashSells as $flashSell)
            <div class="col-md-6 col-lg-4">
                <div class="banner banner-overlay banner-overlay-light">
                    <a href="{{ route('flash-sells.show', $flashSell->slug) }}">
                        <img src="{{ asset('images/flash_sell/' . $flashSell->flash_sell_image) }}" alt="Banner" style="height: 300px; object-fit: cover;">
                    </a>
                    <div class="banner-content" style="background: rgba(0, 0, 0, 0.5); padding: 20px; border-radius: 10px;">
                        <h4 class="banner-subtitle">
                            <a href="{{ route('flash-sells.show', $flashSell->slug) }}" style="color: #fff;">
                                {{ $flashSell->flash_sell_name }}
                            </a>
                        </h4>
                        <h3 class="banner-title">
                            <a href="{{ route('flash-sells.show', $flashSell->slug) }}">
                                <strong style="color: #fff;">{{ $flashSell->flash_sell_title }}</strong>
                            </a>
                        </h3>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @endif
    <!-- Flash Sell End -->

    <div class="mb-5"></div>

    <!-- Features Start -->
    @if($section_status->features == 1)
    <div class="icon-boxes-container bg-transparent">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-lg-3">
                    <div class="icon-box icon-box-side">
                        <span class="icon-box-icon text-dark">
                            <i class="icon-rocket"></i>
                        </span>
                        <div class="icon-box-content">
                            <h3 class="icon-box-title">Free Shipping</h3>
                            <p>Orders $50 or more</p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="icon-box icon-box-side">
                        <span class="icon-box-icon text-dark">
                            <i class="icon-rotate-left"></i>
                        </span>

                        <div class="icon-box-content">
                            <h3 class="icon-box-title">Free Returns</h3>
                            <p>Within 30 days</p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="icon-box icon-box-side">
                        <span class="icon-box-icon text-dark">
                            <i class="icon-info-circle"></i>
                        </span>

                        <div class="icon-box-content">
                            <h3 class="icon-box-title">Get 20% Off 1 Item</h3>
                            <p>when you sign up</p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="icon-box icon-box-side">
                        <span class="icon-box-icon text-dark">
                            <i class="icon-life-ring"></i>
                        </span>

                        <div class="icon-box-content">
                            <h3 class="icon-box-title">We Support</h3>
                            <p>24/7 amazing services</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- Features End -->

{{--  
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
                         <x-image-with-loader src="{{ asset('images/ads/' . $advertisement->image) }}" class="img-fluid" alt="Advertisement" style="object-fit: cover; width: 100%; height: auto;"/>
                    </a>
                </div>
            </div>
        </div>
        @endif
    @endforeach
    <!-- Home Page Modal Ad End -->

    <!-- Carousel Slider,  Category Start -->
    <div class="container-fluid mb-3">
        <div class="row px-xl-5">
            @if($section_status->slider == 1)
                <div class="col-lg-8">
                    <div id="header-carousel" class="carousel slide carousel-fade mb-30 mb-lg-0" data-ride="carousel">
                        <ol class="carousel-indicators">
                            @foreach($sliders as $key => $slider)
                                <li data-target="#header-carousel" data-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}"></li>
                            @endforeach
                        </ol>
                        <div class="carousel-inner">
                            @foreach($sliders as $key => $slider)
                                <div class="carousel-item position-relative {{ $key == 0 ? 'active' : '' }}" style="height: 430px;">
                                     <x-image-with-loader class="position-absolute w-100 h-100" src="{{ asset('images/slider/' . $slider->image) }}" style="object-fit: cover;"/>

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

            @if($section_status->categories == 1)
                <div class="col-lg-4">
                    <!-- Categories Start -->
                        @foreach($categories as $category)
                            <div class="product-offer mb-30" style="height: 200px;">
                                <x-image-with-loader class="img-fluid" src="{{ asset('images/category/' . $category->image) }}" alt=""/>
                                <div class="offer-text">
                                    <h3 class="text-white mb-3">{{ $category->name }}</h3>
                                    <a href="{{ route('category.show', $category->slug) }}" class="btn btn-primary">Shop Now</a>
                                </div>
                            </div>
                        @endforeach
                    <!-- Categories End -->
                </div>
            @endif
        </div>
    </div>
    <!-- Carousel Slider, Category End -->

    @if($section_status->features == 1)
    <!-- Features Start -->
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
    <!-- Features End -->
    @endif

    @if($section_status->special_offer == 1)
    <!-- Special Offer Start -->
        <div class="container-fluid pt-5">
            <div class="row px-xl-5">
                @foreach($specialOffers as $specialOffer)
                    <div class="col-md-6">
                        <div class="product-offer mb-30" style="height: 300px;">
                            <x-image-with-loader class="img-fluid" src="{{ asset('images/special_offer/' . $specialOffer->offer_image) }}" alt="{{ $specialOffer->offer_title }}"/>
                            <div class="offer-text">
                                <h6 class="text-white text-uppercase">{{ $specialOffer->offer_name }}</h6>
                                <h3 class="text-white mb-3">{{ $specialOffer->offer_title }}</h3>
                                <a href="{{ route('special-offers.show', $specialOffer->slug) }}" class="btn btn-primary">Shop Now</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    <!-- Special Offer End -->
    @endif

    <!-- Featured Ad Start -->
    @foreach($advertisements as $advertisement)
    @if($advertisement->type == 'featured')
    <div class="container-fluid pt-5 pb-3">
        <div class="px-xl-5">
            @foreach($advertisements as $advertisement)
                @if($advertisement->type == 'featured')
                    <div class="advertisement-image custom-ad-image">
                        <a href="{{ $advertisement->link }}" target="_blank">
                            <x-image-with-loader src="{{ asset('images/ads/' . $advertisement->image) }}" class="img-fluid" alt="Advertisement"/>
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    @endif
    @endforeach  
    <!-- Featured Ad End -->

    @if($section_status->feature_products == 1)
    <!-- Feature Products Start -->
        @if ($featuredProducts->count() > 0)
            <div class="container-fluid pt-5 pb-3">
                <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
                    <span class="bg-secondary pr-3">Feature Products</span>
                </h2>
                <div class="row px-xl-5">
                    @foreach($featuredProducts as $product)
                        <div class="col-lg-3 col-md-4 col-sm-6 pb-1 mb-4">
                            <div class="product-item bg-light d-flex flex-column h-100">
                                <div class="product-img position-relative overflow-hidden" style="height: 250px;">
                                    <x-image-with-loader class="img-fluid w-100 h-100" src="{{ asset('/images/products/' . $product->feature_image) }}" alt="{{ $product->name }}" style="object-fit: cover;"/>
                                    <div class="product-action">
                                        @if ($product->stock && $product->stock->quantity > 0)
                                            <a class="btn btn-outline-dark btn-square add-to-cart" data-product-id="{{ $product->id }}" data-offer-id="0" data-price="{{ $product->price }}">
                                                <i class="fa fa-shopping-cart"></i>
                                            </a>
                                        @else
                                            <a class="btn btn-outline-dark btn-square disabled" aria-disabled="true">
                                                <i class="fa fa-shopping-cart"></i>
                                            </a>
                                        @endif
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
                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                        @if ($product->stock && $product->stock->quantity > 0)
                                            <p>Available: {{ $product->stock->quantity }}</p>
                                        @else
                                            <p>Out of Stock</p>
                                        @endif
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
        @if ($flashSells->count() > 0)
            <div class="container-fluid pt-5 pb-3">
                <div class="row px-xl-5">
                    @foreach($flashSells as $flashSell)
                        <div class="col-md-6">
                            <div class="product-offer mb-30" style="height: 300px;">
                                <x-image-with-loader class="img-fluid" src="{{ asset('images/flash_sell/' . $flashSell->flash_sell_image) }}" alt="{{ $flashSell->flash_sell_title }}"/>
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
        @endif
    <!-- Flash Sell End -->
    @endif

    @if($section_status->trending_products == 1)
    <!-- Trending Products Start -->
        @if ($trendingProducts->count() > 0)
            <div class="container-fluid pt-5 pb-3">
                <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
                    <span class="bg-secondary pr-3">Trending Now</span>
                </h2>
                <div class="row px-xl-5">
                    @foreach($trendingProducts as $product)
                        <div class="col-lg-3 col-md-4 col-sm-6 pb-1 mb-4">
                            <div class="product-item bg-light d-flex flex-column h-100">
                                <div class="product-img position-relative overflow-hidden" style="height: 250px;">
                                    <x-image-with-loader src="{{ asset('/images/products/' . $product->feature_image) }}" alt="{{ $product->name }}" class="img-fluid w-100 h-100" style="object-fit: cover;" />

                                    <div class="product-action">
                                        @if ($product->stock && $product->stock->quantity > 0)
                                            <a class="btn btn-outline-dark btn-square add-to-cart" data-product-id="{{ $product->id }}" data-offer-id="0" data-price="{{ $product->price }}">
                                                <i class="fa fa-shopping-cart"></i>
                                            </a>
                                        @else
                                            <a class="btn btn-outline-dark btn-square disabled" aria-disabled="true">
                                                <i class="fa fa-shopping-cart"></i>
                                            </a>
                                        @endif
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
                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                        @if ($product->stock && $product->stock->quantity > 0)
                                            <p>Available: {{ $product->stock->quantity }}</p>
                                        @else
                                            <p>Out of Stock</p>
                                        @endif
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
    @foreach($advertisements as $advertisement)
    @if($advertisement->type == 'recent')
    <div class="container-fluid pt-5 pb-3">
        <div class="px-xl-5">
            @foreach($advertisements as $advertisement)
                @if($advertisement->type == 'recent')
                    <div class="advertisement-image custom-ad-image">
                        <a href="{{ $advertisement->link }}" target="_blank">
                            <x-image-with-loader src="{{ asset('images/ads/' . $advertisement->image) }}" class="img-fluid" alt="Advertisement"/>
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    @endif
    @endforeach  
    <!-- Recent Ad End -->

    @if($section_status->recent_products == 1)
    <!-- Recent Products Start -->
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
                                    <x-image-with-loader src="{{ asset('/images/products/' . $product->feature_image) }}" alt="{{ $product->name }}" class="img-fluid w-100 h-100" style="object-fit: cover;" />

                                    <div class="product-action">
                                        @if ($product->stock && $product->stock->quantity > 0)
                                            <a class="btn btn-outline-dark btn-square add-to-cart" data-product-id="{{ $product->id }}" data-offer-id="0" data-price="{{ $product->price }}">
                                                <i class="fa fa-shopping-cart"></i>
                                            </a>
                                        @else
                                            <a class="btn btn-outline-dark btn-square disabled" aria-disabled="true">
                                                <i class="fa fa-shopping-cart"></i>
                                            </a>
                                        @endif
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
                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                        @if ($product->stock && $product->stock->quantity > 0)
                                            <p>Available: {{ $product->stock->quantity }}</p>
                                        @else
                                            <p>Out of Stock</p>
                                        @endif
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

    @if ($section_status->category_products == 1)
    <!-- Category Wise Products Start -->
        <div class="container-fluid pt-5 pb-3">
            <div class="row px-xl-5">
                @foreach($initialCategoryProducts as $category)
                    @if($category->products->isNotEmpty())
                        <div class="col-12 mb-4">
                                <h2 class="section-title position-relative text-uppercase mb-4">
                                    <span class="bg-secondary pr-3">{{ $category->name }}</span>
                                </h2>
                            <div class="owl-carousel related-carousel" data-category-id="{{ $category->id }}" data-page="2">
                                @foreach($category->products as $product)
                                    <div class="product-item bg-light">
                                        <div class="product-img position-relative overflow-hidden" style="height: 250px;">
                                            <x-image-with-loader class="img-fluid w-100 h-100" src="{{ asset('/images/products/' . $product->feature_image) }}" alt="{{ $product->name }}" style="object-fit: cover;"/>
                                            <div class="product-action">
                                                @if ($product->stock && $product->stock->quantity > 0)
                                                    <a class="btn btn-outline-dark btn-square add-to-cart" data-product-id="{{ $product->id }}" data-offer-id="0" data-price="{{ $product->price }}">
                                                        <i class="fa fa-shopping-cart"></i>
                                                    </a>
                                                @else
                                                    <a class="btn btn-outline-dark btn-square disabled" aria-disabled="true">
                                                        <i class="fa fa-shopping-cart"></i>
                                                    </a>
                                                @endif
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
                                            <div class="d-flex align-items-center justify-content-center mt-2">
                                                @if ($product->stock && $product->stock->quantity > 0)
                                                    <p>Available: {{ $product->stock->quantity }}</p>
                                                @else
                                                    <p>Out of Stock</p>
                                                @endif
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
    <!-- Popular Products Start -->
        @if ($popularProducts->count() > 0)
            <div class="container-fluid pt-5 pb-3">
                <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
                    <span class="bg-secondary pr-3">Popular Products</span>
                </h2>
                <div class="row px-xl-5">
                    @foreach($popularProducts as $product)
                        <div class="col-lg-3 col-md-4 col-sm-6 pb-1 mb-4">
                            <div class="product-item bg-light d-flex flex-column h-100">
                                <div class="product-img position-relative overflow-hidden" style="height: 250px;">
                                    <x-image-with-loader class="img-fluid w-100 h-100" src="{{ asset('/images/products/' . $product->feature_image) }}" alt="{{ $product->name }}" style="object-fit: cover;"/>
                                    <div class="product-action">
                                        @if ($product->stock && $product->stock->quantity > 0)
                                            <a class="btn btn-outline-dark btn-square add-to-cart" data-product-id="{{ $product->id }}" data-offer-id="0" data-price="{{ $product->price }}">
                                                <i class="fa fa-shopping-cart"></i>
                                            </a>
                                        @else
                                            <a class="btn btn-outline-dark btn-square disabled" aria-disabled="true">
                                                <i class="fa fa-shopping-cart"></i>
                                            </a>
                                        @endif
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
                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                        @if ($product->stock && $product->stock->quantity > 0)
                                            <p>Available: {{ $product->stock->quantity }}</p>
                                        @else
                                            <p>Out of Stock</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    <!-- Popular Products End -->
    @endif

    <!-- Vendor ad Start -->
    @foreach($advertisements as $advertisement)
    @if($advertisement->type == 'vendor')
    <div class="container-fluid pt-5 pb-3">
        <div class="px-xl-5">
            @foreach($advertisements as $advertisement)
                @if($advertisement->type == 'vendor')
                    <div class="advertisement-image custom-ad-image">
                        <a href="{{ $advertisement->link }}" target="_blank">
                            <x-image-with-loader src="{{ asset('images/ads/' . $advertisement->image) }}" class="img-fluid" alt="Advertisement"/>
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    @endif
    @endforeach  
    <!-- Vendor ad End -->

    @if($section_status->vendors == 1 && $suppliers->count() > 0)
    <!-- Vendor Start -->
        <div class="container-fluid py-5">
            <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
                <span class="bg-secondary pr-3">Vendors</span>
            </h2>

            <div class="row px-xl-5">
                <div class="col">
                    <div class="owl-carousel vendor-carousel">
                        @foreach($suppliers as $supplier)
                            <div class="bg-light p-4">
                                <x-image-with-loader src="{{ asset('/images/supplier/' . $supplier->image) }}" alt="{{ $supplier->name }}"/>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    <!-- Vendor End -->
    @endif
--}}
@endsection

@section('script')

    <script>
        $(document).ready(function() {
            $('.related-carousel').each(function() {
                var $carousel = $(this);
                var categoryId = $carousel.data('category-id');
                var page = $carousel.data('page');
                var isLoading = false;

                $carousel.on('changed.owl.carousel', function(event) {
                    if (event.item.index + event.page.size >= event.item.count && !isLoading) {
                        isLoading = true;
                        $.ajax({
                            url: '{{ route('getCategoryProducts') }}',
                            method: 'GET',
                            data: {
                                category_id: categoryId,
                                page: page
                            },
                            success: function(response) {
                                // console.log(response);
                                page++;
                                $carousel.data('page', page);
                                $.each(response.data, function(index, product) {
                                    var productHtml = `
                                        <div class="product-item bg-light">
                                            <div class="product-img position-relative overflow-hidden" style="height: 250px;">
                                                <img class="img-fluid w-100 h-100" src="/images/products/${product.feature_image}" alt="${product.name}" style="object-fit: cover;"/>
                                                <div class="product-action">
                                                    ${product.stock && product.stock.quantity > 0 ? 
                                                        `<a class="btn btn-outline-dark btn-square add-to-cart" data-product-id="${product.id}" data-offer-id="0" data-price="${product.price}">
                                                            <i class="fa fa-shopping-cart"></i>
                                                        </a>` :
                                                        `<a class="btn btn-outline-dark btn-square disabled" aria-disabled="true">
                                                            <i class="fa fa-shopping-cart"></i>
                                                        </a>`
                                                    }
                                                    <a class="btn btn-outline-dark btn-square add-to-wishlist" data-product-id="${product.id}" data-offer-id="0" data-price="${product.price}">
                                                        <i class="fa fa-heart"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="text-center py-4">
                                                <a class="h6 text-decoration-none text-truncate" href="/product/${product.slug}">${product.name}</a>
                                                <div class="d-flex align-items-center justify-content-center mt-2">
                                                    <h5>${product.price}</h5>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-center mt-2">
                                                    ${product.stock && product.stock.quantity > 0 ? 
                                                        `<p>Available: ${product.stock.quantity}</p>` : 
                                                        `<p>Out of Stock</p>`
                                                    }
                                                </div>
                                            </div>
                                        </div>`;
                                    $carousel.trigger('add.owl.carousel', [$(productHtml)]).trigger('refresh.owl.carousel');
                                });
                                isLoading = false;
                            },
                            error: function(xhr, status, error) {
                                console.error('Error fetching products:', error);
                                isLoading = false;
                            }
                        });
                    }
                });
            });
        });
    </script>

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