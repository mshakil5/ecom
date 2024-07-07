<?php
  
use Illuminate\Support\Facades\Route;
  
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\SpecialOfferController;
use App\Http\Controllers\Admin\FlashSellController;
  

// cache clear
Route::get('/clear', function() {
    Auth::logout();
    session()->flush();
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    return "Cleared!";
 });
//  cache clear
  
  
Auth::routes();

Route::fallback(function () {
    return redirect('/');
});
  
  
// Frontend
Route::get('/', [FrontendController::class, 'index'])->name('frontend.homepage');
Route::get('/category/{slug}', [FrontendController::class, 'showCategoryProducts'])->name('category.show');
Route::get('/product/{slug}', [FrontendController::class, 'showProduct'])->name('product.show');
Route::get('/product/{slug}/{offerId?}', [FrontendController::class, 'showProduct'])->name('product.show');

//Check Coupon
Route::get('/check-coupon', [FrontendController::class, 'checkCoupon']);


Route::get('/special-offers/{slug}', [SpecialOfferController::class, 'show'])->name('special-offers.show');

Route::get('flash-sells/{slug}', [FlashSellController::class, 'show'])->name('flash-sells.show');

Route::get('/shop', [FrontendController::class, 'shop'])->name('frontend.shop');

Route::get('/about-us', [FrontendController::class, 'aboutUs'])->name('frontend.shopdetail');

Route::get('/contact', [FrontendController::class, 'contact'])->name('frontend.contact');
Route::post('/contact-us', [FrontendController::class, 'storeContact'])->name('contact.store');

// Wish list
Route::get('/wishlist', [FrontendController::class, 'showWishlist'])->name('wishlist.index');

// Search products
Route::get('/search/products', [FrontendController::class, 'search'])->name('search.products');

// Cart products
Route::post('/cart', [FrontendController::class, 'showCart'])->name('cart.index');

Route::post('/checkout', [FrontendController::class, 'storeCart'])->name('checkout.store');

Route::post('/place-order', [OrderController::class, 'placeOrder'])->name('place.order');

Route::get('/order/{encoded_order_id}', [OrderController::class, 'generatePDF'])->name('generate-pdf');

Route::group(['prefix' =>'user/', 'middleware' => ['auth', 'is_user']], function(){
  
    Route::get('/dashboard', [HomeController::class, 'userHome'])->name('user.dashboard');

    Route::get('/profile', [UserController::class, 'userProfile'])->name('user.profile');

    Route::post('/update-profile', [UserController::class, 'updateProfile'])->name('user.profile.update');

    Route::get('/orders', [OrderController::class, 'getOrders'])->name('orders.index');

});
  

Route::group(['prefix' =>'manager/', 'middleware' => ['auth', 'is_manager']], function(){
  
    Route::get('/dashboard', [HomeController::class, 'managerHome'])->name('manager.dashboard');
});
 