<?php


namespace App\entities;


class User extends Entity
{
  public $id;
  public $fio;
  public $login;
  protected $password;
  public $is_admin;

  public function setPassword($password) {
    $this->password = password_hash($password, PASSWORD_DEFAULT);
  }
}