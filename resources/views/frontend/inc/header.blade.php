<header class="header-section d-lg-block d-none">
    <div class="header-center">
        <div class="container">
            <div class="row d-flex justify-content-between align-items-center">
                <div class="col-3">
                    <div class="header-logo">
                        <a href="{{ route('frontend.homepage') }}">
                            <img 
                            src="{{ asset('images/company/' . $company->company_logo) }}" 
                            alt="{{ $company->company_name }}" 
                            width="105" 
                            height="25" 
                            style="object-fit: contain; display: block;">
                        </a>
                    </div>
                </div>
                <div class="col-6">
                    <div class="header-search">
                        <form action="#" method="post">
                            <div class="header-search-box default-search-style d-flex">
                                <input class="default-search-style-input-box border-around border-right-none" type="search" placeholder="Search entire store here ..." required>
                                <button class="default-search-style-input-btn" type="submit"><i class="icon-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-3 text-end">
                    <ul class="header-action-icon">
                        <li>
                            <a href="{{ route('wishlist.index') }}" class="offcanvas-toggle wishlistBtn">
                                <i class="icon-heart"></i>
                                <span class="header-action-icon-item-count wishlistCount">0</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('cart.index') }}" class="offcanvas-toggle cartBtn">
                                <i class="icon-shopping-cart"></i>
                                <span class="header-action-icon-item-count cartCount">0</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="header-bottom sticky-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="main-menu">
                        <nav>
                            <ul>
                                <li class="has-dropdown">
                                    <a class="main-menu-link {{ request()->routeIs('frontend.homepage') ? 'active' : '' }}" href="{{ route('frontend.homepage') }}">Home</a>
                                </li>
                                <li class="has-dropdown">
                                    <a class="main-menu-link {{ request()->routeIs('frontend.shop') ? 'active' : '' }}" href="{{ route('frontend.shop') }}">Shop</a>
                                </li>
                                <li class="has-dropdown">
                                    <a href="">Categories <i class="fa fa-angle-down"></i></a>
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
                                    <a href="{{ route('frontend.shopdetail') }}" class="{{ request()->routeIs('frontend.shopdetail') ? 'active' : '' }}">About Us</a>
                                </li>
                                <li>
                                    <a href="{{ route('frontend.contact') }}" class="{{ request()->routeIs('frontend.contact') ? 'active' : '' }}">Contact Us</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>