<?php
namespace App\models;


class Product extends Model
{
  public $id;
  public $name;
  public $price;
  public $info;

  public function getTableName(): string
  {
    return 'products';
  }

}