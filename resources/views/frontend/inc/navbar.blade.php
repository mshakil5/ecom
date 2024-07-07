<div class="container-fluid bg-dark mb-30">
    <div class="row px-xl-5">

        <div class="col-lg-3 d-none d-lg-block">
            <a class="btn d-flex align-items-center justify-content-between bg-primary w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; padding: 0 30px;">
                <h6 class="text-dark m-0"><i class="fa fa-bars mr-2"></i>Categories</h6>
                <i class="fa fa-angle-down text-dark"></i>
            </a>
            <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 bg-light" id="navbar-vertical" style="width: calc(100% - 30px); z-index: 999;">
                <div class="navbar-nav w-100">
                    @foreach(\App\Models\Category::with(['products' => function($query) {
                        $query->select('id', 'category_id');
                    }])->where('status', 1)->get(['id', 'name', 'slug']) as $category)
                        <a href="{{ route('category.show', $category->slug) }}" class="nav-item nav-link">{{ $category->name }}</a>
                    @endforeach
                </div>
            </nav>
        </div>

        <div class="col-lg-9">
            <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3 py-lg-0 px-0">
                <a href="{{ route('frontend.homepage') }}" class="text-decoration-none d-block d-lg-none">
                   @php
                        $company = \App\Models\CompanyDetails::select('company_logo')->first();
                    @endphp  

                    @if (!empty($company) && !empty($company->company_logo))
                        <img src="{{ asset('images/company/' . $company->company_logo) }}" alt="Company Logo" class="img-fluid" style="max-height: 50px;">
                    @endif
                </a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav mr-auto py-0">
                        <a href="{{ route('frontend.homepage') }}" class="nav-item nav-link active">Home</a>
                        <a href="{{ route('frontend.shop') }}" class="nav-item nav-link">Shop</a>
                        <a href="{{ route('frontend.shopdetail') }}" class="nav-item nav-link">Shop Detail</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Pages <i class="fa fa-angle-down mt-1"></i></a>
                            <div class="dropdown-menu bg-primary rounded-0 border-0 m-0">
                                <a href="{{ route('cart.index') }}" class="dropdown-item cartBtn">Shopping Cart</a>
                                <a href="{{ route('wishlist.index') }}" class="dropdown-item wishlistBtn">WishList</a>
                            </div>
                        </div>
                        <a href="{{ route('frontend.contact') }}" class="nav-item nav-link">Contact</a>
                    </div>
                    <div class="navbar-nav ml-auto py-0 d-none d-lg-block">

                        <a href="{{ route('cart.index') }}" class="btn px-0 cartBtn">
                            <i class="fas fa-shopping-cart text-primary"></i>
                            <span class="badge text-secondary border border-secondary rounded-circle cartCount" style="padding-bottom: 2px;">0</span>
                        </a>

                        <a href="{{ route('wishlist.index') }}" class="btn px-0 wishlistBtn">
                            <i class="fas fa-heart text-primary"></i>
                            <span class="badge text-secondary border border-secondary rounded-circle wishlistCount" style="padding-bottom: 2px;">0</span>
                        </a>
        
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>