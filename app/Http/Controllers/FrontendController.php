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

class FrontendController extends Controller
{
    public function index()
    {
        return view('frontend.index');
    }

    public function showCategoryProducts($slug)
    {
        $category = Category::where('slug', $slug)
                        ->with(['products:id,category_id,name,feature_image,price,slug'])
                        ->firstOrFail();
        $company = CompanyDetails::select('company_name')
                             ->first();
        $title = $company->company_name . ' - ' . $category->name;
        return view('frontend.category_products', compact('category', 'title'));
    }

    public function showProduct($slug, $offerId = null)
    {
        $product = Product::where('slug', $slug)->with('images')->firstOrFail();
        $specialOffer = null;
        $flashSell = null;
        $offerPrice = null;
        $flashSellPrice = null;

        if ($offerId == 1) {
            $specialOffer = SpecialOfferDetails::where('product_id', $product->id)
                ->whereHas('specialOffer', function ($query) {
                    $query->whereDate('start_date', '<=', now())
                        ->whereDate('end_date', '>=', now());
                })
                ->first();
            $offerPrice = $specialOffer ? $specialOffer->offer_price : null;
        } elseif ($offerId == 2) {
            $flashSell = FlashSellDetails::where('product_id', $product->id)
                ->whereHas('flashsell', function ($query) {
                    $query->whereDate('start_date', '<=', now())
                        ->whereDate('end_date', '>=', now());
                })
                ->first();
            
            $flashSellPrice = $flashSell ? $flashSell->flash_sell_price : null;
        }

        $regularPrice = $product->price;

        $company = CompanyDetails::first();
        $title = $company->company_name . ' - ' . $product->name;

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        return view('frontend.product.single_product', compact('product', 'relatedProducts', 'title', 'regularPrice', 'offerPrice', 'flashSellPrice', 'offerId'));
    }

    public function showWishlist(Request $request)
    {
        $wishlistJson = $request->input('wishlist');
        $wishlist = $wishlistJson ? json_decode($wishlistJson, true) : [];

        if (!is_array($wishlist)) {
            $wishlist = [];
        }
        
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

        return view('frontend.wish_list', compact('products'));
    }

    public function showCart(Request $request)
    {
        $cart = $request->input('cart', '[]');
        $cart = json_decode($cart, true);

        if (!is_array($cart)) {
            $cart = [];
        }

        return view('frontend.cart', compact('cart'));
    }

    public function storeCart(Request $request)
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

    public function shop()
    {
         $currency = CompanyDetails::value('currency');
         $products = Product::where('status', 1)
                ->orderBy('id', 'desc')
                ->whereDoesntHave('specialOfferDetails')
                ->whereDoesntHave('flashSellDetails')
                ->get();
        return view('frontend.shop', compact('currency', 'products'));
    }

    public function contact()
    {
        return view('frontend.contact');
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
        return view('frontend.about');
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
    
}
