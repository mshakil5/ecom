<header class="header-section d-lg-block d-none">
    <!-- Start Header Center Area -->
    <div class="header-center">
        <div class="container">
            <div class="row d-flex justify-content-between align-items-center">
                <div class="col-3">
                    <!-- Logo Header -->
                    <div class="header-logo">
                        <a href="{{ route('frontend.homepage') }}"><img src="{{ asset('images/company/' . $company->company_logo) }}" alt="{{ $company->company_name }}" width="105" height="25"></a>
                    </div>
                </div>
                <div class="col-6">
                    <!-- Start Header Search -->
                    <div class="header-search">
                        <form action="#" method="post">
                            <div class="header-search-box default-search-style d-flex">
                                <input class="default-search-style-input-box border-around border-right-none" type="search" placeholder="Search entire store here ..." required>
                                <button class="default-search-style-input-btn" type="submit"><i class="icon-search"></i></button>
                            </div>
                        </form>
                    </div> <!-- End Header Search -->
                </div>
                <div class="col-3 text-end">
                    <!-- Start Header Action Icon -->
                    <ul class="header-action-icon">
                        <li>
                            <a href="#offcanvas-wishlish" class="offcanvas-toggle">
                                <i class="icon-heart"></i>
                                <span class="header-action-icon-item-count">3</span>
                            </a>
                        </li>
                        <li>
                            <a href="#offcanvas-add-cart" class="offcanvas-toggle">
                                <i class="icon-shopping-cart"></i>
                                <span class="header-action-icon-item-count">3</span>
                            </a>
                        </li>
                    </ul> <!-- End Header Action Icon -->
                </div>
            </div>
        </div>
    </div> <!-- End Header Center Area -->

    <!-- Start Bottom Area -->
    <div class="header-bottom sticky-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Header Main Menu -->
                    <div class="main-menu">
                        <nav>
                            <ul>
                                <li class="has-dropdown">
                                    <a class="active main-menu-link" href="{{ route('frontend.homepage') }}">Home</a>
                                </li>
                                <li class="has-dropdown">
                                    <a href="#">Categories <i class="fa fa-angle-down"></i></a>
                                    <!-- Sub Menu -->
                                    <ul class="sub-menu">
                                        @foreach($categories as $category)
                                            @if($category->products->count() > 0)
                                                <li>
                                                    <a href="{{ route('category.show', $category->slug) }}">{{ $category->name }}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                                <li>
                                    <a href="{{ route('frontend.shopdetail') }}">About Us</a>
                                </li>
                                <li>
                                    <a href="{{ route('frontend.contact') }}">Contact Us</a>
                                </li>
                            </ul>
                        </nav>
                    </div> <!-- Header Main Menu Start -->
                </div>
            </div>
        </div>
    </div> <!-- End Bottom Area -->
</header>