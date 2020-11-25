<?php


namespace App\controllers;

use App\models\User;

class UserController extends Controller
{
  protected $actionDefault = 'all';

  public function getDefaultAction(): string
  {
    return $this->actionDefault;
  }

  public function oneAction()
  {
    return $this->render(
      'user',
      [
        'user' => User::getOne($this->getId()),
      ]
    );
  }

  public function allAction()
  {
    return $this->render(
      'users',
      [
        'users' => User::getAll(),
      ]
    );
  }


}