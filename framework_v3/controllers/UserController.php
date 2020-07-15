<?php


namespace App\controllers;

use App\models\User;

class UserController
{
  private $action;
  protected $actionDefault = 'all';

  public function run($action)
  {
    $this->action = $action;
    if (empty($this->action)) {
      $this->action = $this->actionDefault;
    }

    $method = $this->action . 'Action';
    if (!method_exists($this, $method)) {
      return 'Error';
    }

    return $this->$method();
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

  public function render($template, $params = [])
  {
    $content = $this->renderTemplate($template, $params);
    return $this->renderTemplate('layouts/main', [
      'content' => $content,
    ]);
  }

  public function renderTemplate($template, $params = [])
  {
    ob_start();
    extract($params);
    include dirname(__DIR__) . '/views/' . $template . '.php';
    return ob_get_clean();
  }

  protected function getId()
  {
    $id = 0;
    if (!empty((int)$_GET['id'])) {
      $id = (int)$_GET['id'];
    }

    return $id;
  }
}