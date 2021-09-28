<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\OrderProduct;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use ErrorException;
use Exception;
use Gloudemans\Shoppingcart\Facades\Cart;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Cart::content()->count() <= 0) {
            return back();
        }

        $email = auth()->user()->email ?? null;

        return view('checkout', [
            'discount' => getNumbers()->get('discount'),
            'tax' => getNumbers()->get('tax'),
            'newSubtotal' => getNumbers()->get('newSubtotal'),
            'newTax' => getNumbers()->get('newTax'),
            'newTotal' => getNumbers()->get('newTotal'),
            'email' => $email
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CheckoutRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CheckoutRequest $request)
    {
        
        if ($this->productsAreNoLongerAvailable()) {
            return back()->withErrors("Sorry! One of the items in your cart is no longer avialble.");
        }
        
        $content = Cart::instance('default')->content()->map( function ($item) {
            return $item->model->slug . ' - ' . $item->qty;
        })->values()->toJson();

        try {
            Stripe::charges()->create([
                'amount' => getNumbers()->get('newTotal') / 100,
                'currency' => 'USD',
                'source' => $request->stripeToken,
                'description' => 'Order Form My Ecommerce',
                'receipt_email' => $request->email,
                'metadata' => [
                    'content' => $content,
                    'quantity' => Cart::instance('default')->count(),
                    'discount' => collect(session()->get('coupon'))->toJson()
                ]
            ]);

            $this->addOrderToDatabase($request, null);
            $this->decreaseQuantities();

            Cart::instance('default')->destroy();
            session()->forget('coupon');

        }  catch (Exception $e) {
            $this->addOrderToDatabase($request, $e->getMessage());
            return back()->withErrors("Error! " . $e->getMessage());
        }
        return redirect()->route('landing-page')->with('success_message', 'Thank you! Your payment has successfully accepted 🎉');
    }

    protected function addOrderToDatabase($request, $error)
    {
        $order = Order::create([
            'user_id' => auth()->user()->id ?? null,
            'billing_email' => $request->email,
            'billing_name' => $request->name,
            'billing_address' => $request->address,
            'billing_phone' => $request->phone,
            'billing_name_on_card' => $request->name_on_card,
            'billing_discount' => getNumbers()->get('discount'),
            'billing_discount_code' => getNumbers()->get('code'),
            'billing_subtotal' => getNumbers()->get('newSubtotal'),
            'billing_tax' => getNumbers()->get('newTax'),
            'billing_total' => getNumbers()->get('newTotal'),
            'error' => $error,
        ]);

        foreach (Cart::instance('default')->content() as $item) {
            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $item->model->id,
                'quantity' => $item->qty,
            ]);
        }
    }

    protected function decreaseQuantities()
    {
        foreach (Cart::instance('deafult')->content() as $item) {
            $product = Product::find($item->model->id);

            $product->update(['quantity' => $product->quantity - $item->qty]);
        }
    }

    protected function productsAreNoLongerAvailable()
    {
        foreach (Cart::instance('default') as $item) {
            $product = Product::find($item->model->id);

            if ($product->quantity < $item->qty) {
                return true;
            }

            return null;
        }
    }
}
