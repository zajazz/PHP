<?php


namespace App\repositories;

use App\entities\Entity;
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

  public function isInOrders(Entity $entity)
  {
    $sql = 'SELECT order_id FROM order_product WHERE product_id = :id';
    return (bool)$this->getDB()->findAll($sql, [':id' => $entity->id]);
  }

  public function getProductsInOrder($orderId)
  {
    $sql = "SELECT products.id, title, order_product.price, qty 
            FROM products
            INNER JOIN order_product ON products.id = product_id
            INNER JOIN orders ON orders.id = order_id
            WHERE orders.id = :orderId";
    return $this->getDB()->findAll($sql, [':orderId' => $orderId]);
  }
}