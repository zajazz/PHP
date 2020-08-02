<?php


namespace App\entities;


class OrderProduct extends Entity
{
  public $order_id;
  public $product_id;
  public $price;
  public $qty;

  /**
   * OrderProduct constructor.
   * @param $order_id
   * @param $product_id
   * @param $price
   * @param $qty
   */
  public function __construct($order_id, $product_id, $price, $qty)
  {
    $this->order_id = $order_id;
    $this->product_id = $product_id;
    $this->price = $price;
    $this->qty = $qty;
  }

}