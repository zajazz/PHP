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
  
//  public function getCategory()
//  {
//    $sql = '';
//    static::getDB()->findObject($sql, Category::class);
//  }

}