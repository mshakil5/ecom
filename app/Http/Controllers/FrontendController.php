<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Product;
use session;
use App\Models\CompanyDetails;
use App\Models\Contact;
use App\Models\SpecialOfferDetails;
use App\Models\FlashSell;
use App\Models\FlashSellDetails;
use App\Models\Coupon;
use App\Models\SubCategory;
use App\Models\Stock;
use App\Models\SpecialOffer;
use App\Models\SectionStatus;
use App\Models\Ad;
use App\Models\Supplier;
use App\Models\Slider;

class FrontendController extends Controller
{
    public function index()
    {
        $currency = CompanyDetails::value('currency');

        $specialOffers = SpecialOffer::select('offer_image', 'offer_name', 'offer_title', 'slug')
            ->where('status', 1)
            // ->whereDate('start_date', '<=', now())
            // ->whereDate('end_date', '>=', now())
            ->latest()
            ->get();

        $flashSells = FlashSell::select('flash_sell_image', 'flash_sell_name', 'flash_sell_title', 'slug')
            ->where('status', 1)
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->latest()
            ->get();

        $featuredProducts = Product::where('status', 1)
            ->where('is_featured', 1)
            ->whereDoesntHave('specialOfferDetails')
            ->whereDoesntHave('flashSellDetails')
            ->with('stock')
            ->orderBy('id', 'desc')
            ->select('id', 'name', 'feature_image', 'price', 'slug')
            ->take(12)
            ->get();

        $trendingProducts = Product::where('status', 1)
            ->where('is_trending', 1)
            ->orderByDesc('id')
            ->whereDoesntHave('specialOfferDetails')
            ->whereDoesntHave('flashSellDetails')
            ->with('stock')
            ->select('id', 'name', 'feature_image', 'slug', 'price')
            ->take(12)
            ->get();

        $recentProducts = Product::where('status', 1)
            ->where('is_recent', 1)
            ->orderBy('id', 'desc')
            ->whereDoesntHave('specialOfferDetails')
            ->whereDoesntHave('flashSellDetails')
            ->with('stock')
            ->select('id', 'name', 'feature_image', 'price', 'slug')
            ->take(12)
            ->get();

        $popularProducts = Product::where('status', 1)
            ->where('is_popular', 1)
            ->orderBy('id', 'desc')
            ->whereDoesntHave('specialOfferDetails')
            ->whereDoesntHave('flashSellDetails')
            ->with('stock')
            ->select('id', 'name', 'feature_image', 'price', 'slug')
            ->take(12)
            ->get();

        $initialCategoryProducts = Category::where('status', 1)
            ->with(['products' => function($query) {
                $query->select('id', 'name', 'feature_image', 'price', 'slug', 'category_id')
                    ->where('status', 1)
                    ->whereDoesntHave('specialOfferDetails')
                    ->whereDoesntHave('flashSellDetails')
                    ->orderBy('id', 'desc');
            }])
            ->select('id', 'name')
            ->get();

        $initialCategoryProducts->transform(function ($category) {
            $category->setRelation('products', $category->products->take(6));
            return $category;
        });

        $section_status = SectionStatus::first();
        
        $advertisements = Ad::where('status', 1)->select('type', 'link', 'image')->get();

        $suppliers = Supplier::orderBy('id', 'desc')
                        ->select('id', 'name', 'image')
                        ->get();

         $sliders = Slider::orderBy('id', 'desc')
                        ->select('title', 'sub_title', 'image')
                        ->get();

        $mostViewedProducts = Product::where('status', 1)
            ->where('is_recent', 1)
            ->orderByDesc('watch')
            ->whereDoesntHave('specialOfferDetails')
            ->whereDoesntHave('flashSellDetails')
            ->with('stock')
            ->select('id', 'name', 'feature_image', 'price', 'slug')
            ->take(12)
            ->get();

        $categories = Category::where('status', 1)
            ->with(['products' => function ($query) {
                $query->select('id', 'category_id', 'name', 'price', 'slug', 'feature_image', 'watch')
                    ->orderBy('watch', 'desc');
            }])
            ->select('id', 'name', 'image', 'slug')
            ->orderBy('id', 'asc')
            ->get()
            ->each(function ($category) {
                $category->setRelation('products', $category->products->take(6));
            });

        return view('frontend.index', compact('specialOffers','flashSells','featuredProducts', 'trendingProducts', 'currency', 'recentProducts', 'popularProducts', 'initialCategoryProducts', 'section_status', 'advertisements', 'suppliers', 'sliders', 'categories', 'mostViewedProducts'));
    }

    public function getCategoryProducts(Request $request)
    {
        $categoryId = $request->input('category_id');
        $page = $request->input('page', 1);
        $perPage = 6;

        $query = Product::where('category_id', $categoryId)
                        ->where('status', 1)
                        ->whereDoesntHave('specialOfferDetails')
                        ->whereDoesntHave('flashSellDetails')
                        ->select('id', 'name', 'feature_image', 'price', 'slug')
                        ->orderBy('id', 'desc');

        $shownProducts = $request->input('shown_products', []);
        if (!empty($shownProducts)) {
            $query->whereNotIn('id', $shownProducts);
        }

        $products = $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json($products);
    }

    public function showCategoryProducts($slug)
    {
        $currency = CompanyDetails::value('currency');

        $category = Category::where('slug', $slug)->firstOrFail();

        $products = Product::where('category_id', $category->id)
                            ->select('id', 'category_id', 'name', 'feature_image', 'price', 'slug')
                            ->paginate(20);
        
        $company = CompanyDetails::select('company_name')->first();
        $title = $company->company_name . ' - ' . $category->name;
        
        return view('frontend.category_products', compact('category', 'products', 'title', 'currency'));
    } 

    public function showSubCategoryProducts($slug)
    {
        $currency = CompanyDetails::value('currency');

        $sub_category = SubCategory::where('slug', $slug)->firstOrFail();

        $products = Product::where('sub_category_id', $sub_category->id)
                            ->select('id', 'sub_category_id', 'name', 'feature_image', 'price', 'slug')
                            ->paginate(20);

        $company = CompanyDetails::select('company_name')->first();
        $title = $company->company_name . ' - ' . $sub_category->name;

        return view('frontend.sub_category_products', compact('sub_category', 'products', 'title', 'currency'));
    }

    public function showProduct($slug, $offerId = null)
    {
        $product = Product::where('slug', $slug)->with('images')->firstOrFail();
        $product->watch = $product->watch + 1;
        $product->save();
        $specialOffer = null;
        $flashSell = null;
        $offerPrice = null;
        $flashSellPrice = null;
        $oldOfferPrice = null;
        $OldFlashSellPrice = null;

        if ($offerId == 1) {
            $specialOffer = SpecialOfferDetails::where('product_id', $product->id)
                ->whereHas('specialOffer', function ($query) {
                    $query->whereDate('start_date', '<=', now())
                        ->whereDate('end_date', '>=', now());
                })
                ->first();
            $offerPrice = $specialOffer ? $specialOffer->offer_price : null;
            $oldOfferPrice = $specialOffer ? $specialOffer->old_price : null;
        } elseif ($offerId == 2) {
            $flashSell = FlashSellDetails::where('product_id', $product->id)
                ->whereHas('flashsell', function ($query) {
                    $query->whereDate('start_date', '<=', now())
                        ->whereDate('end_date', '>=', now());
                })
                ->first();
            
            $flashSellPrice = $flashSell ? $flashSell->flash_sell_price : null;
            $OldFlashSellPrice = $flashSell ? $flashSell->old_price : null;
        }

        $regularPrice = $product->price;

        $company_name = CompanyDetails::value('company_name');
        $title = $company_name . ' - ' . $product->name;
        $currency = CompanyDetails::value('currency');

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->whereDoesntHave('specialOfferDetails')
            ->whereDoesntHave('flashSellDetails')
            ->where('id', '!=', $product->id)
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        return view('frontend.product.single_product', compact('product', 'relatedProducts', 'title', 'regularPrice', 'offerPrice', 'flashSellPrice', 'offerId', 'currency', 'oldOfferPrice', 'OldFlashSellPrice'));
    }

    public function storeWishlist(Request $request)
    {
        $request->session()->put('wishlist', $request->input('wishlist'));
        return response()->json(['success' => true]);
    }

    public function showWishlist(Request $request)
    {
        $wishlistJson = $request->session()->get('wishlist', '[]');
        $wishlist = json_decode($wishlistJson, true);
 
        $productIds = array_column($wishlist, 'productId');
        $products = Product::whereIn('id', $productIds)->get();

        foreach ($products as $product) {
            foreach ($wishlist as $item) {
                if ($item['productId'] == $product->id) {
                    if ($item['offerId'] == 1) {
                        $product->offer_price = $item['price'];
                        $product->offer_id = 1; 
                    } elseif ($item['offerId'] == 2) {
                        $product->flash_sell_price = $item['price'];
                        $product->offer_id = 2;
                    } else {
                        $product->price = $item['price'];
                        $product->offer_id = 0;
                    }
                }
            }
        }

        $request->session()->forget('wishlist');
        return view('frontend.wish_list', compact('products'));
    }

    public function storeCart(Request $request)
    {
        $request->session()->put('cart', $request->input('cart'));

        return response()->json(['success' => true]);
    }

    public function showCart(Request $request)
    {
        $cartJson = $request->session()->get('cart', '[]');
        $cart = json_decode($cartJson, true);
        return view('frontend.cart', compact('cart'));
    }

    public function checkout(Request $request)
    {
        $cart = json_decode($request->input('cart'), true);
        return view('frontend.checkout', compact('cart'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = Product::where('name', 'LIKE', "%$query%")
                            ->where('status', 1)
                            ->orderBy('id', 'desc')
                            ->whereDoesntHave('specialOfferDetails')
                            ->whereDoesntHave('flashSellDetails')
                            ->take(15)
                            ->get();

        if ($products->isEmpty()) {
            return response()->json('<div class="p-2">No products found</div>');
        }

        $output = '<ul class="list-group">';
        foreach ($products as $product) {
            $output .= '<li class="list-group-item">
                            <a href="'.route('product.show', $product->slug).'">
                                '.$product->name.'
                            </a>
                        </li>';
        }
        $output .= '</ul>';

        return response()->json($output);
    }

    public function shop(Request $request)
    {
         $currency = CompanyDetails::value('currency');

         $categories = Category::where('status', 1)
            ->orderBy('id', 'desc')
            ->select('id', 'name')
            ->get();

        $perPage = $request->input('per_page', 10);

        $minPrice = Product::where('status', 1)->min('price'); 
        $maxPrice = Product::where('status', 1)->max('price');

        $products = Product::where('status', 1)
            ->orderBy('id', 'desc')
            ->whereDoesntHave('specialOfferDetails')
            ->whereDoesntHave('flashSellDetails')
            ->with('stock')
            ->select('id', 'name', 'feature_image', 'price', 'slug')
            ->paginate($perPage);
        return view('frontend.shop', compact('currency', 'products', 'categories', 'perPage', 'minPrice', 'maxPrice'));
    }

    public function contact()
    {
        $companyDetails = CompanyDetails::select('google_map', 'address1', 'email1', 'phone1')->first();
        return view('frontend.contact', compact('companyDetails'));
    }

    public function storeContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        $contact = new Contact();
        $contact->name = $request->input('name');
        $contact->email = $request->input('email');
        $contact->subject = $request->input('subject');
        $contact->message = $request->input('message');
        $contact->save();

        return back()->with('success', 'Your message has been sent successfully!');
    }

    public function aboutUs()
    {
        $companyDetails = CompanyDetails::select('about_us')->first();
        return view('frontend.about', compact('companyDetails'));
    }

    public function checkCoupon(Request $request)
    {
        $coupon = Coupon::where('coupon_name', $request->coupon_name)->first();

        if ($coupon && $coupon->status == 1) {
            return response()->json([
                'success' => true,
                'coupon_type' => $coupon->coupon_type,
                'coupon_value' => $coupon->coupon_value
            ]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function filter(Request $request)
    {
        $startPrice = $request->input('start_price');
        $endPrice = $request->input('end_price');
        $categoryId = $request->input('category');

        $productsQuery = Product::select('id', 'name', 'price', 'slug', 'feature_image')
                                ->where('status', 1)
                                ->orderBy('id', 'desc')
                                ->whereDoesntHave('specialOfferDetails')
                                ->whereDoesntHave('flashSellDetails')
                                ->with('stock');

        if ($startPrice !== null && $endPrice !== null) {
            $productsQuery->whereBetween('price', [$startPrice, $endPrice]);
        }

        if (!empty($categoryId)) {
            $productsQuery->where('category_id', $categoryId);
        }

        $products = $productsQuery->get();

        return response()->json(['products' => $products]);
    }

}
