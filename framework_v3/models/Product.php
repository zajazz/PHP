<?php
namespace App\models;


class Product extends Model
{
  public $id;
  public $title;
  public $price;
  public $info;

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

}