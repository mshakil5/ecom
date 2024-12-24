@extends('frontend.layouts.app')

@section('content')

    <!-- Intro Slider Start-->
    @if($section_status->slider == 1)
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
                                    <h2>{{ $slider->title }}</h2>
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

    <!-- Special Offer Start -->
    @if($section_status->special_offer == 1)
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
                        <h3 class="section-title" data-aos="fade-up" data-aos-delay="0">Categories</h3>
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

    {{-- 
    <!-- Recent advertisements start-->
    @if($advertisements->contains('type', 'recent'))
     <div class="container mt-5">
        @foreach($advertisements as $advertisement)
            @if($advertisement->type == 'recent')
                <div class="cta cta-border" style="background-image: url('{{ asset('images/ads/' . $advertisement->image) }}');">
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
    @endif
    <!-- Recent advertisements end-->
    --}}

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

    {{-- 
    <!-- Supplier advertisements start-->
    <div class="container">
        @foreach($advertisements as $advertisement)
            @if($advertisement->type == 'vendor')
                <div class="cta cta-border" style="background-image: url('{{ asset('images/ads/' . $advertisement->image) }}');">
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
    --}}
    
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
    @if($section_status->flash_sell == 1)
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

    {{-- 
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

@endsection