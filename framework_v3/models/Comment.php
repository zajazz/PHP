<?php


namespace App\models;


class Comment extends Model
{
  public $id;
  public $product_id;
  public $text;
  /**
   * @inheritDoc
   */
  public static function getTableName(): string
  {
    return 'comments';
  }
}