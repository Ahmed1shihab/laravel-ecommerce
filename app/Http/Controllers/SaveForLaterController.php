<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Gloudemans\Shoppingcart\Facades\Cart;

class SaveForLaterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $duplicates = Cart::instance("saveForLater")->search(function($cartItem, $rowId) use($request) {
            return $cartItem->id === $request->id;
        });

        if ($duplicates->isNotEmpty()) {
            return back()->with("success_message", "Item Is already Saved For Later!");
        }

        Cart::instance('saveForLater')->add($request->id, $request->name, 1, $request->price)->associate("App\Models\Product");

        return redirect()->route('cart.index')->with('success_message', 'Item Saved For Later 😀');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Cart::instance('saveForLater')->remove($id);

        return back();
    }

    public function switchToCart($id)
    {
        $item = Cart::instance('saveForLater')->get($id);

        Cart::instance('saveForLater')->remove($id);

        $duplicates = Cart::instance("default")->search(function($cartItem, $rowId) use($id) {
            return $rowId === $id;
        });

        if ($duplicates->isNotEmpty()) {
            return redirect()->route("cart.index")->with("success_message", "Item Is already Saved For Later!");
        }
        
        Cart::instance('default')->add($item->id, $item->name, $item->qty, $item->price)->associate("App\Models\Product");

        return back();
    }
}
