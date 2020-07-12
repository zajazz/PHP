<?php


namespace App\models;


class Order extends Model
{
  public $id;
  public $user_id;
  public $status_id;
  public $date;
  public $address;
  public $phone;

  /**
   * @inheritDoc
   */
  public function getTableName(): string
  {
    return 'orders';
  }
}