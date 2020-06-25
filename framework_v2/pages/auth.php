<?php
function indexAction()
{
  echo render('auth.php', [
    'login' => $_SESSION['login'],
    'title' => 'Account',
  ]);
}

function loginAction()
{
  if (empty($_GET['login']) || empty($_GET['passw'])) {
    indexAction();
    exit;
  }
  $login = $_GET['login'];
  $passw = $_GET['passw'];
  $sql = "SELECT fio, password from users WHERE login = '{$login}'";
  $result = mysqli_query(getLink(), $sql);
  $row = mysqli_fetch_assoc($result);
  if (empty($row)) {
    indexAction();
    exit;
  }
  if ($passw === $row['password']) {
    $_SESSION['login'] = $row['fio'];
  }
  indexAction();
}

function logoutAction()
{
  unset($_SESSION['login']);
  header('location: /');
}