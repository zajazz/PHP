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
    if (!$this->hasPermission()) {
      $this->redirect('/', 'No permission');
      return false;
    }

    $user = $this->app->userRepository->getOne($this->getId());
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
    if (!$this->hasPermission()) {
      $this->redirect('/', 'No permission');
      return false;
    }

    $paginator = new Paginator();
    $paginator->setItems($this->app->userRepository, $this->baseRoot, $this->getPage());
    return $this->render(
      'users',
      [
        'paginator' => $paginator,
        'title' => 'Users'
      ]
    );
  }


}