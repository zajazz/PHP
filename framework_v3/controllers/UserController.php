<?php


namespace App\controllers;

use App\models\User;
use App\services\Paginator;

class UserController extends Controller
{
  protected $actionDefault = 'all';
  protected $baseRoot = '/?c=user';

  public function getDefaultAction(): string
  {
    return $this->actionDefault;
  }

  public function oneAction()
  {
    $user = User::getOne($this->getId());
    return $this->render(
      'user',
      [
        'user' => $user,
        'title' => 'User ' . $user->login,
      ]
    );
  }

  public function allAction()
  {
    $paginator = new Paginator();
    $user = new User();
    $paginator->setItems($user, $this->baseRoot, $this->getPage());
    return $this->render(
      'users',
      [
        'paginator' => $paginator,
        'title' => 'Users'
      ]
    );
  }


}