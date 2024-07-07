@extends('frontend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-2">
            <nav class="navbar">
                <div class="nav-links px-3">
                    <a href="{{ route('user.profile') }}" class="{{ Request::routeIs('user.profile') ? 'active' : '' }} nav-item nav-link bg-primary text-white d-block w-100">Profile</a>

                    <a href="{{ route('cart.index') }}" class="{{ Request::routeIs('cart.index') ? 'active' : '' }} nav-item nav-link d-block my-3 bg-primary text-white w-100 cartBtn">Cart</a>

                    <a href="{{ route('wishlist.index') }}" class="{{ Request::routeIs('wishlist.index') ? 'active' : '' }} nav-item nav-link d-block my-3 bg-primary text-white w-100 wishlistBtn">Wishlist</a>

                    <a href="{{ route('orders.index') }}" class="{{ Request::routeIs('orders.index') ? 'active' : '' }} nav-item nav-link d-block my-3 bg-primary text-white w-100">Orders</a>

                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-item nav-link d-block my-3 bg-primary text-white w-100">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </nav>
        </div>

        <div class="col-lg-1 d-none d-lg-block">
            <div class="vertical-divider"></div>
        </div>

        <div class="col-lg-9">
            <div class="main-content">
                @yield('user_content')
            </div>
        </div>
    </div>
</div>

<style>
    .vertical-divider {
        width: 1px;
        background-color: #ddd;
        height: 100%;
    }

    .nav-item.active {
        font-weight: bold;
    }
</style>
@endsection