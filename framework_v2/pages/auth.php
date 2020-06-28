<?php
function indexAction()
{
  if (!empty($_SESSION['login'])) {
    echo render('account.php', [
      'user' => $_SESSION['user'],
      'title' => 'Account',
    ]);
    return;
  }
  echo render('authform.php', [
    'title' => 'Account',
  ]);
}

function loginAction()
{
  if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    redirect('/?p=auth');
    return;
  }

  if (empty($_POST['login']) || empty($_POST['password'])) {
    setMsg('Не все данные переданы');
    redirect('/?p=auth');
    return;
  }

  $login = clearString($_POST['login']);
  $password = clearString($_POST['password']);

  $sql = "SELECT fio, password, is_admin from users WHERE login = '{$login}'";
  $result = mysqli_query(getLink(), $sql);
  $row = mysqli_fetch_assoc($result);
  $msg = 'Неверный логин или пароль';
  if (empty($row)) {
    setMsg($msg);
    redirect('?p=auth');
    return;
  }

  if (password_verify($password, $row['password'])) {
    $_SESSION['login'] = true;
    unset($row['password']);
    $_SESSION['user'] = $row;
    $msg = 'Вы успешно авторизовались';
  }
  setMsg($msg);
  redirect('?p=auth');
}

function logoutAction()
{
  unset($_SESSION['login']);
  unset($_SESSION['user']);
  redirect();
}