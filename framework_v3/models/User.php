<?php
namespace App\models;

class User extends Model
{
  public $id;
  public $fio;
  public $login;
  protected $password;
  public $is_admin;

  public function setPassword($password) {
    $this->password = password_hash($password, PASSWORD_DEFAULT);
  }

  public static function getTableName(): string
  {
    return 'users';
  }
}