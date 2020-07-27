<?php


namespace App\services;

use App\entities\Product;

class CartService
{
  public function addToCart(Product $product, Request $request)
  {

    $cart = $request->SESSION('cart');
    $count = 1;

    if (isset($cart[$product->id]['count'])) {
      $count = $cart[$product->id]['count'] + 1;
    }

    $cart[$product->id] = [
        'title' => $product->title,
        'price' => $product->price,
        'img' => $product->img,
        'count' => $count,
    ];

    try {
      $request->setSession('cart', $cart);
      return true;
    } catch (\Exception $e) {
      ErrorService::logError($e, 'cart.log');
      return false;
    }
  }

  public function removeFromCart(Product $product, Request $request)
  {
    $cart = $request->SESSION('cart');

    if (empty($cart[$product->id])) return;

    $cart[$product->id]['count'] --;

    if (empty($cart[$product->id]['count'])) {
      unset($cart[$product->id]);
    }

    try {
      $request->setSession('cart', $cart);
      return true;
    } catch (\Exception $e) {
      ErrorService::logError($e, 'cart.log');
      return false;
    }
  }

  public function getCartCount()
  {
    $cart = (new Request())->SESSION('cart');
    if (empty($cart)) return 0;
    return count($cart);
  }
}
