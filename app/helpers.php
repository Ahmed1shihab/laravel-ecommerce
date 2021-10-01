<?php

use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;

function presentPrice($price) {
    $formatter = new \NumberFormatter('en_US', \NumberFormatter::CURRENCY);
    return $formatter->formatCurrency($price / 100, 'USD');
}

function presentDate($date) {
    return Carbon::parse($date)->format('M d, Y');
}

function getNumbers() {
  
    $tax = config('cart.tax') / 100;
    $discount = session()->get('coupon')['discount'] ?? 0;
    $code = session()->get('coupon')['code'] ?? null;
    $newSubtotal = (Cart::subtotal()) - $discount;
    if ($newSubtotal < 0) {
      $newSubtotal = 0;
    }
    $newTax = $newSubtotal * $tax;
    $newTotal = ($newSubtotal + $newTax);

    return collect([
        'discount' => $discount,
        'tax' => $tax,
        'code' => $code,
        'newSubtotal' => $newSubtotal,
        'newTax' => $newTax,
        'newTotal' => $newTotal
    ]);
}

function setActiveCategory($category) {
    return request()->category == $category ? 'underline bg-gray-400 bg-opacity-10' : '';
}