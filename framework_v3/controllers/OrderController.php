<?php


namespace App\controllers;

use App\entities\Order;
use App\services\Paginator;

class OrderController extends Controller
{
  protected $actionDefault = 'index';
  protected $baseRoot = '/order';

  public function getDefaultAction(): string
  {
    return $this->actionDefault;
  }

  /**
   * Method shows user's order list
   * @return string
   */
  public function indexAction()
  {
    $userId = $this->request->SESSION('user')['id'];

    if (!$this->isAuthorized() || empty($userId)) {
      $this->redirect('/auth', 'Authorization required');
      return false;
    }

    $orders = $this->app->orderRepository->getOrdersByUserId($userId);

    return $this->render(
      'orders',
      [
        'orders' => $orders,
        'title' => 'Orders',
      ]
    );
  }

  public function allAction()
  {
    if (!$this->hasPermission()) {
      $this->redirect('/', 'No permission');
      return false;
    }

    $orders = $this->app->orderRepository->getAllOrders();

    return $this->render(
      'orders',
      [
        'orders' => $orders,
        'title' => 'Orders',
      ]
    );
  }

  public function oneAction()
  {
    if (!$this->isAuthorized()) {
      $this->redirect('/');
      return false;
    }

    $order = $this->app->orderRepository->getOrderById($this->getId());

    if (empty($order)) {
      $this->redirect($this->baseRoot, 'Order not found');
      return false;
    }

    $userId = $this->app->request->SESSION('user')['id'];

    if ($order['user_id'] != $userId && !$this->hasPermission()) {
      $this->redirect($this->baseRoot, 'No permission');
      return false;
    }

    $products = $this->app->productRepository->getProductsInOrder($this->getId());

    return $this->render(
      'order',
      [
        'order' => $order,
        'products' => $products,
        'title' => 'Order #' . $this->getId(),
      ]
    );
  }

  public function addAction()
  {
    if (!$this->isAuthorized()) {
      $this->redirect('/auth', 'Authorization required');
      return false;
    }

    $cart = $this->request->SESSION('cart');
    if (empty($cart)) {
      $this->redirect('/cart', 'Unable to place an order: cart is empty');
      return false;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $order = new Order();
      $error = $this->app->orderService->addOrder($order);

      if (!empty($error)) {
        return $this->render(
          'orderForm',
          [
            'cart' => $cart,
            'amount' => $this->app->orderService->getAmount(),
            'title' => 'Shipping information',
            'error' => $error,
          ]
        );
      }

      $this->redirect('/order/one?id=' . $order->id, 'Заказ создан');
      return true;
    }

    // Order confirmation form
    return $this->render(
      'orderForm',
      [
        'cart' => $cart,
        'amount' => $this->app->orderService->getAmount(),
        'title' => 'Shipping information',
      ]
    );
  }
}
