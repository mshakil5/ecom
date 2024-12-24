<!-- ...:::: Start Footer Section:::... -->
<footer class="footer-section section-top-gap-100">
    <!-- Start Footer Top Area -->
    <div class="footer-top section-inner-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-5">
                    <div class="footer-widget footer-widget-contact" data-aos="fade-up"  data-aos-delay="0">
                        <div class="footer-logo">
                            <a href="index.html"><img src="{{ asset('images/company/' . $company->company_logo) }}" alt="" class="img-fluid"></a>
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
                            <li><a href="" class="facebook"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="" class="twitter"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="" class="youtube"><i class="fa fa-youtube"></i></a></li>
                            <li><a href="" class="pinterest"><i class="fa fa-pinterest"></i></a></li>
                            <li><a href="" class="instagram"><i class="fa fa-instagram"></i></a></li>
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