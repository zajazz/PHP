<?php


namespace App\repositories;


use App\entities\OrderProduct;

class OrderProductRepository extends Repository
{

  /**
   * @inheritDoc
   */
  public function getTableName(): string
  {
    return 'order_product';
  }

  public function getEntityName(): string
  {
    return OrderProduct::class;
  }
}