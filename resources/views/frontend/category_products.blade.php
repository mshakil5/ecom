@extends('frontend.layouts.app')
@section('title', $title)
@section('content')

<div class="container-fluid pt-5 pb-3">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
        <span class="bg-secondary pr-3">Explore Products in {{ $category->name }}</span>
    </h2>
    <div class="row px-xl-5">
        @php
            $currency = \App\Models\CompanyDetails::value('currency');
        @endphp

        @foreach($category->products as $product)
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                <div class="product-item bg-light mb-4">
                    <div class="product-img position-relative overflow-hidden" style="height: 250px;">
                        <img class="img-fluid w-100" src="{{ asset('/images/products/' . $product->feature_image) }}" alt="{{ $product->name }}">
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
                            <h5>{{$currency}} {{ $product->price }}</h5>
                        </div>
                        <div class="d-flex align-items-center justify-content-center mb-1">
                            {{-- <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star-half-alt text-primary mr-1"></small>
                            <small>(99)</small> --}}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection