<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetails;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Stock;
use PDF;
use App\Models\CompanyDetails;
use App\Models\SpecialOfferDetails;
use App\Models\FlashSellDetails;
use App\Models\DeliveryMan;
use DataTables;
use App\Models\CancelledOrder;
use App\Models\OrderReturn;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function placeOrder(Request $request)
    {
        $formData = $request->all();
        $pdfUrl = null;

        DB::transaction(function () use ($formData, &$pdfUrl) {
            $subtotal = 0.00;

            $order = new Order();
            if (auth()->check()) {
                $order->user_id = auth()->user()->id;
            }
            $order->invoice = random_int(100000, 999999);
            $order->purchase_date = date('Y-m-d');
            $order->name = $formData['name'] ?? null;
            $order->surname = $formData['surname'] ?? null;
            $order->email = $formData['email'] ?? null;
            $order->phone = $formData['phone'] ?? null;
            $order->house_number = $formData['house_number'] ?? null;
            $order->street_name = $formData['street_name'] ?? null;
            $order->town = $formData['town'] ?? null;
            $order->postcode = $formData['postcode'] ?? null;
            $order->address = $formData['address'] ?? null;
            $order->payment_method = $formData['payment_method'] ?? null;
            $order->shipping_amount = $formData['delivery_location'] === 'insideDhaka' ? 0.00 : 60.00;
            $order->status = 1;
            $order->admin_notify = 1;
            $order->order_type = 0;

            foreach ($formData['order_summary'] as $item) {
                $product = Product::findOrFail($item['productId']);

                if (isset($item['offerId']) && $item['offerId'] == 1) {
                    // Special Offer Details
                    $specialOfferDetail = SpecialOfferDetails::where('product_id', $item['productId'])
                                    ->where('status', 1)
                                    ->first();

                    if ($specialOfferDetail) {
                        $totalPrice = (float) $item['quantity'] * (float) $specialOfferDetail->offer_price;
                    } else {
                        $totalPrice = (float) $item['quantity'] * (float) $product->price;
                    }
                } elseif (isset($item['offerId']) && $item['offerId'] == 2) {
                    // Flash Sell Details
                    $flashSellDetail = FlashSellDetails::where('product_id', $item['productId'])
                                ->where('status', 1)
                                ->first();

                    if ($flashSellDetail) {
                        $totalPrice = (float) $item['quantity'] * (float) $flashSellDetail->flash_sell_price;
                    } else {
                        $totalPrice = (float) $item['quantity'] * (float) $product->price;
                    }
                } else {
                    $totalPrice = (float) $item['quantity'] * (float) $product->price;
                }

                $subtotal += $totalPrice;
            }

            $discountPercentage = $formData['discount_percentage'] ?? null;
            $discountAmount = $formData['discount_amount'] ?? null;

            if ($discountPercentage !== null) {
                $discountPercent = (float) $discountPercentage;
                $discountAmount = ($subtotal * $discountPercent) / 100;
            } elseif ($discountAmount === null) {
                $discountAmount = 0.00;
            }
            
            $order->discount_amount = $discountAmount;

            $order->subtotal_amount = $subtotal;
            $order->vat_percent = 0;
            $order->vat_amount = 0.00;
            $order->net_amount = $subtotal + $order->vat_amount + $order->shipping_amount - $discountAmount;
            
            if (auth()->check()) { 
                $order->created_by = auth()->user()->id;
            }
            
            $order->save();

            $encoded_order_id = base64_encode($order->id);
            $pdfUrl = route('generate-pdf', ['encoded_order_id' => $encoded_order_id]);

            if (isset($formData['order_summary']) && is_array($formData['order_summary'])) {
                foreach ($formData['order_summary'] as $item) {
                    $product = Product::findOrFail($item['productId']);

                    if (isset($item['offerId']) && $item['offerId'] == 1) {
                        // Special Offer Details for OrderDetails
                        $specialOfferDetail = SpecialOfferDetails::where('product_id', $item['productId'])
                                        ->where('status', 1)
                                        ->first();

                        if ($specialOfferDetail) {
                            $totalPrice = (float) $item['quantity'] * (float) $specialOfferDetail->offer_price;
                        } else {
                            $totalPrice = (float) $item['quantity'] * (float) $product->price;
                        }
                    } elseif (isset($item['offerId']) && $item['offerId'] == 2) {
                        // Flash Sell Details for OrderDetails
                        $flashSellDetail = FlashSellDetails::where('product_id', $item['productId'])
                            ->where('status', 1)
                            ->first();

                        if ($flashSellDetail) {
                            $totalPrice = (float) $item['quantity'] * (float) $flashSellDetail->flash_sell_price;
                        } else {
                            $totalPrice = (float) $item['quantity'] * (float) $product->price;
                        }
                    } else {
                        $totalPrice = (float) $item['quantity'] * (float) $product->price;
                    }

                    $orderDetails = new OrderDetails();
                    $orderDetails->order_id = $order->id;
                    $orderDetails->product_id = $item['productId'] ?? null;
                    $orderDetails->quantity = $item['quantity'] ?? null;
                    $orderDetails->size = $item['size'] ?? null;
                    $orderDetails->color = $item['color'] ?? null;
                    $orderDetails->price_per_unit = (float) $item['price'] ?? null;
                    $orderDetails->total_price = $totalPrice;
                    $orderDetails->created_by = auth()->user()->id;
                    $orderDetails->save();

                    $stock = Stock::where('product_id', $item['productId'])
                        ->where('size', $item['size'])
                        ->where('color', $item['color'])
                        ->first();

                    if ($stock) {
                        $stock->quantity -= $item['quantity'];
                        $stock->save();
                    }
                }
            }
        });

        return response()->json([
            'pdf_url' => $pdfUrl,
            'message' => 'Order placed successfully'
        ], 200);
    }

    public function generatePDF($encoded_order_id)
    {
        $order_id = base64_decode($encoded_order_id);
        $order = Order::with('orderDetails')->findOrFail($order_id);

        $data = [
            'order' => $order,
            'currency' => CompanyDetails::value('currency'),
        ];

        $pdf = PDF::loadView('frontend.order_pdf', $data);

        return $pdf->stream('order_' . $order->id . '.pdf');
    }

    public function getOrders()
    {
        $orders = Order::where('user_id', auth()->user()->id)
                ->orderBy('id', 'desc')
                ->get();
        return view('user.orders', compact('orders'));
    }

    public function allOrders()
    {
        return view('admin.orders.all');
    }

    public function allOrder()
    {
        return DataTables::of(Order::with('user')
                        ->where('order_type',0)
                        ->orderBy('id', 'desc'))
                        ->addColumn('action', function($order){
                            return '<a href="'.route('admin.orders.details', ['orderId' => $order->id]).'" class="btn btn-primary">Details</a>';
                        })
                        ->editColumn('subtotal_amount', function ($order) {
                            return number_format($order->subtotal_amount, 2);
                        })
                        ->editColumn('shipping_amount', function ($order) {
                            return number_format($order->shipping_amount, 2);
                        })
                        ->editColumn('discount_amount', function ($order) {
                            return number_format($order->discount_amount, 2);
                        })
                        ->editColumn('net_amount', function ($order) {
                            return number_format($order->net_amount, 2);
                        })
                        ->editColumn('status', function ($order) {
                            $statusLabels = [
                                1 => 'Pending',
                                2 => 'Processing',
                                3 => 'Packed',
                                4 => 'Shipped',
                                5 => 'Delivered',
                                6 => 'Returned',
                                7 => 'Cancelled'
                            ];
                            return isset($statusLabels[$order->status]) ? $statusLabels[$order->status] : 'Unknown';
                        })
                        ->addColumn('name', function ($order) {
                            return $order->name;
                        })
                        ->addColumn('email', function ($order) {
                            return $order->email;
                        })
                        ->addColumn('phone', function ($order) {
                            return $order->phone;
                        })
                        ->rawColumns(['action'])
                        ->make(true);
    }

    public function pendingOrders()
    {
        $orders = Order::with('user')
                ->where('status', 1)
                ->orderBy('id', 'desc')
                ->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function processingOrders()
    {
        $orders = Order::with('user')
                ->where('status', 2)
                ->orderBy('id', 'desc')
                ->get();
        return view('admin.orders.index', compact('orders'));
    }
    public function packedOrders()
    {
        $orders = Order::with('user')
                ->where('status', 3)
                ->orderBy('id', 'desc')
                ->get();
        return view('admin.orders.index', compact('orders'));
    }
    public function shippedOrders()
    {
        $orders = Order::with('user')
                ->where('status', 4)
                ->orderBy('id', 'desc')
                ->get();
         $deliveryMen = DeliveryMan::orderBy('id', 'desc')
                ->get(); 
        return view('admin.orders.index', compact('orders', 'deliveryMen'));
    }
    public function deliveredOrders()
    {
        $orders = Order::with('user')
                ->where('status', 5)
                ->orderBy('id', 'desc')
                ->get();
        return view('admin.orders.index', compact('orders'));
    }
    public function returnedOrders()
    {
        $orders = Order::with(['user', 'orderReturns.product'])
                    ->where('status', 6)
                    ->orderBy('id', 'desc')
                    ->get();

        return view('admin.orders.returned', compact('orders'));
    }
    public function cancelledOrders()
    {
        $orders = Order::with('user', 'cancelledOrder')
                ->where('status', 7)
                ->orderBy('id', 'desc')
                ->get();
        return view('admin.orders.cancelled', compact('orders'));
    }

    public function updateStatus(Request $request)
    {
        $order = Order::find($request->order_id);
        if ($order) {
            $order->status = $request->status;
            $order->save();

            return response()->json(['success' => true, 'message' => 'Order status updated successfully!']);
        }

        return response()->json(['success' => false, 'message' => 'Order not found.'], 404);
    }

    public function updateDeliveryMan(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'delivery_man_id' => 'required|exists:delivery_men,id',
        ]);

        $order = Order::findOrFail($request->order_id);
        $deliveryMan = DeliveryMan::findOrFail($request->delivery_man_id);
        $order->delivery_man_id = $deliveryMan->id;
        $order->save();
        return response()->json(['success' => true], 200);
    }

    public function showOrder($orderId)
    {
        $order = Order::with(['user', 'orderDetails.product'])
            ->where('id', $orderId)
            ->firstOrFail();
        return view('admin.orders.details', compact('order'));
    }

    public function markAsNotified(Request $request)
    {
        $order = Order::find($request->order_id);

        if ($order) {
            $order->admin_notify = 0;
            $order->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

    public function showOrderUser($orderId)
    {
        $order = Order::with(['user', 'orderDetails.product'])
            ->where('id', $orderId)
            ->firstOrFail();
        return view('user.order_details', compact('order'));
    }

    public function cancel(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        if (in_array($order->status, [4, 5, 6, 7])) {
            return response()->json(['error' => 'Order cannot be cancelled.'], 400);
        }

        $order->status = 7;
        $order->save();

        $orderDetails = OrderDetails::where('order_id', $order->id)->get();

        foreach ($orderDetails as $detail) {
            $stock = Stock::where('product_id', $detail->product_id)
                        ->where('color', $detail->color)
                        ->first();

            if ($stock) {
                $stock->quantity += $detail->quantity;
                $stock->save();
            }
        }

        CancelledOrder::create([
            'order_id' => $order->id,
            'reason' => $request->input('reason'),
            'cancelled_by' => auth()->id(),
        ]);

        return response()->json(['success' => true]);
    }

    public function getOrderDetailsModal(Request $request)
    {
        $orderId = $request->get('order_id');
        $order = Order::with('orderDetails.product')->findOrFail($orderId);
        
        return response()->json([
            'order' => $order,
            'orderDetails' => $order->orderDetails
        ]);
    }

    public function returnStore(Request $request)
    {
        $data = $request->all();

        $order_id = $data['order_id'];

        $order = Order::find($order_id);
        $order->status = 6;
        $order->save();

        $return_items = $data['return_items'];

        foreach ($return_items as $item) {
            $orderReturn = new OrderReturn();
            $orderReturn->product_id = $item['product_id'];
            $orderReturn->order_id = $order_id;
            $orderReturn->quantity = $item['return_quantity'];
            $orderReturn->new_quantity = $item['return_quantity'];
            $orderReturn->reason = $item['return_reason'] ?? '';
            $orderReturn->returned_by = auth()->user()->id;
            $orderReturn->save();
        }

        return response()->json(['message' => 'Order return submitted successfully'], 200);
    }

}
