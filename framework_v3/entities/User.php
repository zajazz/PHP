<?php


namespace App\entities;


class User extends Entity
{
  public $id;
  public $fio;
  public $login;
  public $is_admin;
  // password hash
  public $password;

  public function setPassword($password) {
    $this->password = password_hash($password, PASSWORD_DEFAULT);
  }
}