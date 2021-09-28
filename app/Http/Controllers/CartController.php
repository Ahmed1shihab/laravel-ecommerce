<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use \Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Cart::content()->count() > 0) {
            foreach (Cart::content() as $item) {
                $migthAlsoLike = Product::where('slug', '!=', $item->model->slug)->inRandomOrder()->take(4)->get();
            }
        } else {
            $migthAlsoLike = Product::inRandomOrder()->take(4)->get();
        }

        return view('cart', [
            'discount' => getNumbers()->get('discount'),
            'tax' => getNumbers()->get('tax'),
            'newSubtotal' => getNumbers()->get('newSubtotal'),
            'newTax' => getNumbers()->get('newTax'),
            'newTotal' => getNumbers()->get('newTotal'),
            'migthAlsoLike' => $migthAlsoLike,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $duplicates = Cart::search(function($cartItem, $rowId) use($request) {
            return $cartItem->id === $request->id;
        });

        if ($duplicates->isNotEmpty()) {
            return redirect()->route("cart.index")->withErrors("Item Is already In Your Cart!");
        }

        Cart::add($request->id, $request->name, 1, $request->price)->associate("App\Models\Product");

        return redirect()->route('cart.index')->with("success_message", "Item Added To Your Cart 🎉");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => ['required', 'numeric', 'between:1,5']
        ]);

        if ($validator->fails()) {
            session()->flash("errors", collect(["We currently do not have enough items in stock. You order $request->quantity items and we have $request->productQuantity items"]));
            return response()->json(['success' => false], 400);
        }

        if ($request->quantity > $request->productQuantity) {
            session()->flash("errors", collect(["We currently do not have enough items in stock. You order $request->quantity items and we have $request->productQuantity items"]));
            return response()->json(['success' => false], 400);
        }

        Cart::update($id, $request->quantity);
        session()->flash("success_message", "Quantity was updated successfully 🥳");
        
        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Cart::remove($id);

        return back();
    }

    public function switchToSaveForLater($id)
    {
        $item = Cart::get($id);

        Cart::instance('default')->remove($id);

        $duplicates = Cart::instance("saveForLater")->search(function($cartItem, $rowId) use($id) {
            return $rowId === $id;
        });

        if ($duplicates->isNotEmpty()) {
            return redirect()->route("cart.index")->with("success_message", "Item Is already Saved For Later!");
        }
        
        Cart::instance('saveForLater')->add($item->id, $item->name, $item->qty, $item->price)->associate("App\Models\Product");

        return back();
    }
}
