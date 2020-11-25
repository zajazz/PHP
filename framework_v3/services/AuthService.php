<?php

namespace App\services;


use App\entities\User;

class AuthService extends Service
{
  public function isAdmin()
  {
    return (bool)$this->container->request->SESSION('user')['isAdmin'];
  }

  public function isAuthorized()
  {
    if (!empty($this->container->request->SESSION('user'))) {
      return true;
    }

    return false;
  }

  /**
   * Method saves new user to database
   * @param User $user - empty user Entity
   * @return string - error description or empty string in case of success
   */
  public function save(User $user)
  {
    $post = $this->container->request->POST();
    if (empty($post['fio']) || empty($post['login']) || empty($post['password'])) {
      return 'Not enough data';
    }

    $user->login = $post['login'];

    // check login availability
    if (!empty($this->container->userRepository->getOneByLogin($user->login))) {
      return 'This login is busy, try another';
    }

    $user->fio = $post['fio'];
    $user->setPassword($post['password']);
    $user->is_admin = '0';

    if ($this->container->userRepository->save($user) === false) {
      return 'Error occurred while writing to the database';
    }

    return '';
  }

  public function login(User $user)
  {
    if (empty($user)) {
      return 'Incorrect login or password';
    }

    $password = $this->container->request->POST('password');

    if (empty($user->login) || empty($password)) {
      return 'Not enough data';
    }

    if (!password_verify($password, $user->password)) {
      return 'Incorrect login or password';
    }

    $this->container->request->setSession('user', [
      'id' => $user->id,
      'login' => $user->login,
      'isAdmin' => $user->is_admin,
    ]);

    return '';
  }

  public function logout()
  {
    $this->container->request->setSession('user', null);
  }
}