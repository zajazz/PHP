<?php


namespace App\controllers;


use App\repositories\ProductRepository;
use App\services\CartService;

class CartController extends Controller
{
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
        'cart' => $this->request->SESSION('cart'),
        'title' => 'Cart',
      ]
    );
  }

  public function addAction()
  {
    header('Content-Type: application/json');

    $product = (new ProductRepository())->getOne($this->getId());
    $json = json_encode(['success' => false]);

    if (!empty($product)) {
      if ((new CartService())->addToCart($product, $this->request)) {
        $cartCount = (new CartService())->getCartCount();
        $json = json_encode(['success' => true, 'cartCount' => $cartCount]);
      };
    }

    echo $json;
  }

  public function delAction()
  {
    header('Content-Type: application/json');

    $product = (new ProductRepository())->getOne($this->getId());
    $json = json_encode(['success' => false]);

    if (!empty($product)) {
      if ((new CartService())->removeFromCart($product, $this->request)) {
        $cartCount = (new CartService())->getCartCount();
        $json = json_encode(['success' => true, 'cartCount' => $cartCount]);
      }
    }

    echo $json;
  }

  public function countAction()
  {
    header('Content-Type: application/json');

    echo json_encode(['cartCount' => (new CartService())->getCartCount()]);

  }
}