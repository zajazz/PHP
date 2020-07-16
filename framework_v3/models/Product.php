<?php
namespace App\models;


class Product extends Model
{
  public $id;
  public $title;
  public $price;
  public $info;
  public $img;

  public static function getTableName(): string
  {
    return 'products';
  }

  /**
   * TODO determine echo as json-string for js purposes
   */
  public function __toString()
  {
    return '';
  }
//  public function getCategory()
//  {
//    $sql = '';
//    static::getDB()->findObject($sql, Category::class);
//  }
  public function isInOrders()
  {
    $sql = 'SELECT order_id FROM order_product WHERE product_id = :id';
    return (bool)static::getDB()->findAll($sql, [':id' => $this->id]);
  }

}