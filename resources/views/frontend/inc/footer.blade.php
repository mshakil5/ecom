<!-- ...:::: Start Footer Section:::... -->
<footer class="footer-section section-top-gap-100">
    <!-- Start Footer Top Area -->
    <div class="footer-top section-inner-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-5">
                    <div class="footer-widget footer-widget-contact" data-aos="fade-up"  data-aos-delay="0">
                        <div class="footer-logo">
                        <a href="{{ route('frontend.homepage') }}">
                            <img 
                                src="{{ asset('images/company/' . $company->company_logo) }}" 
                                alt="{{ $company->company_name }}" 
                                class="img-fluid" 
                                style="width: 150px; height: 50px; object-fit: contain; display: block;">
                        </a>
                        </div>
                        <div class="footer-contact">
                            <p>{{ $company->footer_content }}</p>
                            <div class="customer-support">
                                <div class="customer-support-icon">
                                    <img src="{{ asset('frontend/images/icon/support-icon.png') }}" alt="">
                                </div>
                                <div class="customer-support-text">
                                    <span>Customer Support</span>
                                    <a class="customer-support-text-phone" href="tel:{{ $company->phone1 }}">{{ $company->phone1 }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-7">
                    <div class="footer-widget footer-widget-subscribe" data-aos="fade-up"  data-aos-delay="200">
                        <ul class="footer-social">
                            @if($company->facebook)
                                <li><a href="{{ $company->facebook }}" class="facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
                            @endif
                            @if($company->twitter)
                                <li><a href="{{ $company->twitter }}" class="twitter" target="_blank"><i class="fa fa-twitter"></i></a></li>
                            @endif
                            @if($company->youtube)
                                <li><a href="{{ $company->youtube }}" class="youtube" target="_blank"><i class="fa fa-youtube"></i></a></li>
                            @endif
                            @if($company->instagram)
                                <li><a href="{{ $company->instagram }}" class="instagram" target="_blank"><i class="fa fa-instagram"></i></a></li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="footer-widget footer-widget-menu" data-aos="fade-up"  data-aos-delay="600">
                        <h3 class="footer-widget-title">Information</h3>
                        <div class="footer-menu">
                            <ul class="footer-menu-nav">
                                <li><a href="{{ route('frontend.homepage') }}">Home</a></li>
                                <li><a href="{{ route('frontend.shop') }}">Shop</a></li>
                                <li><a href="{{ route('frontend.shopdetail') }}">About Us</a></li>
                                <li><a href="{{ route('frontend.contact') }}">Contact Us</a></li>
                            </ul>
                            <ul class="footer-menu-nav">
                                <li><a href="{{ route('cart.index') }}">Cart</a></li>
                                <li><a href="{{ route('wishlist.index') }}">Wish List</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End Footer Top Area -->
    <!-- Start Footer Bottom Area -->
</footer> <!-- ...:::: End Footer Section:::... -->

<!-- material-scrolltop button -->
<button class="material-scrolltop" type="button"></button>