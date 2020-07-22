<?php


namespace App\controllers;

use App\entities\User;
use App\repositories\UserRepository;
use App\services\Paginator;

class UserController extends Controller
{
  protected $actionDefault = 'all';
  protected $baseRoot = '/user';

  public function getDefaultAction(): string
  {
    return $this->actionDefault;
  }

  public function oneAction()
  {
    $user = (new UserRepository())->getOne($this->getId());
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
    $paginator->setItems(new UserRepository(), $this->baseRoot, $this->getPage());
    return $this->render(
      'users',
      [
        'paginator' => $paginator,
        'title' => 'Users'
      ]
    );
  }


}