<?php


namespace App\services;

use App\repositories\ProductRepository;

class CartService extends Service
{
  const CART = 'cart';

  public function addToCart(Request $request)
  {
    $id = $request->getId();
    $product = $this->container->productRepository->getOne($id);

    if (empty($product)) {
      return false;
    }

    $cart = $request->SESSION(static::CART);
    $count = 1;

    if (isset($cart[$id]['count'])) {
      $count = $cart[$id]['count'] + 1;
    }

    $cart[$id] = [
        'title' => $product->title,
        'price' => $product->price,
        'img' => $product->img,
        'count' => $count,
    ];

    $request->setSession(static::CART, $cart);
    return true;
  }

  public function removeFromCart()
  {
    $id = $this->container->request->getId();
    $cart = $this->container->request->SESSION(static::CART);

    if (empty($cart[$id])) return false;

    $cart[$id]['count'] --;

    if (empty($cart[$id]['count'])) {
      unset($cart[$id]);
    }

    $this->container->request->setSession(static::CART, $cart);
    return true;
  }

  public function getCartCount()
  {
    $cart = $this->container->request->SESSION(static::CART);
    if (empty($cart)) return 0;
    return count($cart);
  }
}
