<?php


namespace App\repositories;

use App\entities\Product;

class ProductRepository extends Repository
{

  /**
   * @inheritDoc
   */
  public function getTableName(): string
  {
    return 'products';
  }

  public function getEntityName(): string
  {
    return Product::class;
  }
}