<?php
function indexAction()
{
  return allAction();
}

function allAction()
{
  if (!isAdmin()) {
    redirect('/');
  }
  $sql = 'SELECT id, fio, login, password, is_admin FROM users';
  $result = mysqli_query(getLink(), $sql);
  echo render('users.php', [
    'result' => $result,
    'title' => 'Users',
    ]);
}

function oneAction()
{
  echo render('user.php', [
    'msg' => "Hello, I'm a user",
    'title' => 'User',
  ]);
}