<?php


namespace App\repositories;

use App\entities\Order;
use App\entities\OrderProduct;

class OrderRepository extends Repository
{

  /**
   * @inheritDoc
   */
  public function getTableName(): string
  {
    return 'orders';
  }

  public function getEntityName(): string
  {
    return Order::class;
  }

  public function getOrdersByUserId($userId)
  {
    $sql = "SELECT orders.id, users.login, date, status,
            SUM(price * qty) AS amount 
            FROM orders 
            INNER JOIN statuses ON statuses.id = status_id
            INNER JOIN order_product ON orders.id = order_id
            INNER JOIN users on orders.user_id = users.id
            WHERE user_id = :user_id GROUP BY orders.id";

    return $this->getDB()->findAll($sql, [':user_id' => $userId]);
  }

  public function getOrderById($id)
  {
    $sql = "SELECT orders.id, date, address, phone, status, 
        users.id AS user_id, users.login, users.fio, SUM(price * qty) AS amount 
        FROM orders
        INNER JOIN statuses ON statuses.id = status_id
        INNER JOIN order_product ON orders.id = order_id
        INNER JOIN users ON orders.user_id = users.id
        WHERE orders.id = :id";

    return $this->getDB()->find($sql, [':id' => $id]);
  }

  public function getAllOrders()
  {
    $sql = "SELECT orders.id, date, address, phone, status, 
        users.login, users.fio, SUM(price * qty) AS amount 
        FROM orders
        INNER JOIN statuses ON statuses.id = status_id
        INNER JOIN order_product ON orders.id = order_id
        INNER JOIN users ON orders.user_id = users.id
        GROUP BY orders.id";

    return $this->getDB()->findAll($sql);
  }
}
