<?php
function indexAction()
{
  return allAction();
}

function allAction()
{
  echo "Hello, we're users";
  $sql = 'SELECT id, fio, login, password, is_admin FROM users';
  $result = mysqli_query(getLink(), $sql);
  echo render('users.php', [
    'result' => $result,
    'title' => 'Users',
    ]);
}

function oneAction()
{
  echo "Hello, I'm a user";
}