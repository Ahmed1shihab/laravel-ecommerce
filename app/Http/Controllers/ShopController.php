<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::with('products')->get();

        if (request()->category) {
            $category = Category::where('slug', request()->category)->firstOrFail();

            $products = Product::with("categories")->whereHas("categories", function ($query) {
                $query->where("slug", request()->category);
            })->get();
            
        } else {
            $products = Product::all();
        }

        if (request()->sort === 'low_high') {
            $products = $products->sortBy('price');
        } elseif (request()->sort === 'high_low') {
            $products = $products->sortByDesc('price');
        } else {
            $products = $products;
        }
        

        return view('shop', compact('products', 'categories'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $migthAlsoLike = Product::where('slug', '!=', $slug)->inRandomOrder()->take(4)->get();

        return view('product', compact('product', 'migthAlsoLike'));
    }
}
