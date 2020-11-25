<?php


namespace App\controllers;


use App\services\CartService;

class CartController extends Controller
{
  const CART = 'cart';
  protected $actionDefault = 'show';
  protected $baseRoot = '/cart';

  public function getDefaultAction(): string
  {
    return $this->actionDefault;
  }

  public function showAction()
  {
    return $this->render(
      'cart',
      [
        'cart' => $this->request->SESSION(static::CART),
        'title' => 'Cart',
      ]
    );
  }

  public function addAction()
  {
    $data = ['success' => false];

    if ($this->app->cartService->addToCart($this->request)) {
      $cartCount = $this->app->cartService->getCartCount();
      $data = ['success' => true, 'cartCount' => $cartCount];
    }

    $this->request->sendJson($data);
  }

  public function delAction()
  {
    $data = ['success' => false];

    if ($this->app->cartService->removeFromCart()) {
      $cartCount = $this->app->cartService->getCartCount();
      $data = ['success' => true, 'cartCount' => $cartCount];
    }

    $this->request->sendJson($data);
  }

  public function countAction()
  {
    $data = ['cartCount' => $this->app->cartService->getCartCount()];
    $this->request->sendJson($data);
  }
}