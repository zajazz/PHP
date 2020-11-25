<?php


namespace App\services;

use App\entities\Order;
use App\entities\OrderProduct;

class OrderService extends Service
{

  public function addOrder(Order $order)
  {
    $order->address = $this->container->request->POST('address');
    $order->phone = preg_replace(
      ['/[^0-9+]/', '/([0-9]{0,3})([0-9]{3})([0-9]{2})([0-9]{2})$/'],
      ['',          ' ($1) $2-$3-$4'],
      $this->container->request->POST('phone'));

    if (empty($order->address) || empty($order->phone)) {
      return 'Not enough data';
    }

    $order->date = date("Y-m-d H:i:s");
    $order->user_id = $this->container->request->SESSION('user')['id'];
    $order->status_id = 1;

    if ($this->container->orderRepository->save($order) === false) {
      return 'An error occurred while creating the order';
    }

    $error = '';
    foreach ($this->container->request->SESSION('cart') as $id => $product) {
      $orderProduct = new OrderProduct($order->id, $id, $product['price'], $product['count']);
      if ($this->container->orderProductRepository->save($orderProduct) === false) {
        $error = 'An error occurred while writing to the database';
        break;
      }
    }

    if (!empty($error)) {
      return $error;
    }

    $this->container->request->setSession('cart', null);
    return '';
  }

  public function getAmount()
  {
    $amount = 0;

    foreach ($this->container->request->SESSION('cart') as $item) {
      $amount += $item['price'] * $item['count'];
    }
    return $amount;
  }
}