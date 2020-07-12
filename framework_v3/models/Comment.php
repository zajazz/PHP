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
  public function getTableName(): string
  {
    return 'comments';
  }
}