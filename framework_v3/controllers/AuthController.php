<?php


namespace App\controllers;


use App\entities\User;

class AuthController extends Controller
{
  protected $actionDefault = 'index';
  private $baseRoot = '/auth';

  public function getDefaultAction(): string
  {
    return $this->actionDefault;
  }

  public function indexAction()
  {
    $id = $this->app->request->SESSION('user')['id'];

    if (!empty($id)) {
      
      return $this->render(
        'account',
        [
          'user' => $this->app->userRepository->getOne($id),
          'title' => 'Account',
        ]);
    }

    return $this->loginAction();
  }

  public function addAction()
  {
    if ($this->app->authService->isAuthorized()) {
      $this->redirect();
    }
    // form data handling
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $user = new User();
      $error = $this->app->authService->save($user);

      if (!empty($error)) {
        return $this->render(
          'registerForm',
          [
          'title' => 'Sign up',
          'user' => $user,
          'error' => $error,
        ]);
      }

      // Authorize new user
      $this->app->authService->login($user);
      $this->redirect($this->baseRoot);
      return true;
    }

    return $this->render(
      'registerForm',
      [
        'title' => 'Sign up',
      ]);
  }

  public function loginAction()
  {
    // form data handling
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $login = $this->request->POST('login');
      $user = $this->app->userRepository->getOneByLogin($login);

      $error = $this->app->authService->login($user);

      if (!empty($error)) {
        return $this->render(
          'loginForm',
          [
          'title' => 'Log in',
          'user' => $user,
          'error' => $error,
        ]);
      }

      $this->redirect();
      return true;
    }

    return $this->render(
      'loginForm',
      [
        'title' => 'Log in',
      ]);
  }

  public function logoutAction()
  {
    $this->app->authService->logout();
    $this->redirect();
  }
}
