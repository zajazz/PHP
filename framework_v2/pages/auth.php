<?php
function indexAction()
{
  if (isAuth()) {
    echo render('account.php', [
      'user' => $_SESSION['user'],
      'title' => 'Account',
    ]);
    return;
  }
  echo render('patterns/authform.php', [
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

  $sql = "SELECT id, fio, password, is_admin from users WHERE login = '{$login}'";
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
  session_destroy();
  redirect('/');
}

/**
 * Метод обрабатывает запрос на регистрацию нового пользователя
 */
function addAction()
{
  // Данные с формы
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $error = addUser();
    if (!empty($error)) {
      setMsg($error);
    }
    // успешно зарегистрирован -> авторизуем
    else {
      $sql = "SELECT id, fio, login, is_admin FROM users 
                WHERE login = '" . clearString($_POST['login']) . "'";
      $result = mysqli_query(getLink(), $sql);
      $row = mysqli_fetch_assoc($result);
      if (empty($row)) {
        setMsg('Ошибка авторизации');
        redirect('?p=auth');
        return;
      }
      $_SESSION['login'] = true;
      $_SESSION['user'] = $row;
      setMsg('Вы успешно авторизовались');
      redirect('?p=auth');
    }
  }

  if (!empty($_SESSION['login'])) {
    redirect('?p=auth');
    return;
  }
  // Вывод формы регистрации
  echo render('patterns/registerForm.php', [
    'title' => 'Регистрация',
  ]);
}

function addUser()
{
  if (empty($_POST['fio']) || empty($_POST['login']) || empty($_POST['password'])) {
    return 'Не все данные переданы';
  }

  $fio = clearString($_POST['fio']);
  $login = clearString($_POST['login']);
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $is_admin = '0';

  // Проверка доступности логина
  $sql = "SELECT login FROM users WHERE login = '$login'";
  $result = mysqli_query(getLink(), $sql);
  if (!empty($result->num_rows)) {
    return 'Логин недоступен';
  }

  $sql = "INSERT INTO users (fio, login, password, is_admin)
          VALUES ('$fio', '$login', '$password', $is_admin)";
  if (mysqli_query(getLink(), $sql) === TRUE) {
    return '';
  }

  return 'Ошибка записи в базу данных' . mysqli_error(getLink());
}