<?php
function indexAction()
{
  redirect('?p=user&a=all');
}

function allAction()
{
  $sql = 'SELECT id, fio, login, is_admin FROM users';
  $result = mysqli_query(getLink(), $sql);
  $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
  echo render('users.php', [
    'users' => $users,
    'title' => 'Users',
    ]);
}

function oneAction()
{
  if (empty(getId())) {
    redirect('p=user');
  }
  
  $sql = "SELECT id, fio, login, is_admin FROM users WHERE id = " . getId();
  $result = mysqli_query(getLink(), $sql);
  $user = mysqli_fetch_assoc($result);
  
  if (empty($user)) {
    setMsg('User is not found');
    redirect('?p=user');
  }

  $user['role'] = $user['is_admin'] ? 'Admin' : 'User';
  echo render('user.php', [
    'title' => 'User profile',
    'user' => $user,
  ]);
}

function roleAction()
{
  header('Content-Type: application/json');
  if (empty($_POST['userId']) || empty($_POST['newRole'])) {
    echo json_encode(['success' => false, 'error' => 'Not enough data']);
    return;
  }

  $id = (int)$_POST['userId'];
  $is_admin = 0;

  if ($_POST['newRole'] === 'User') $is_admin = 1;

  $sql = "UPDATE users SET is_admin = $is_admin WHERE id = $id";

  if (mysqli_query(getLink(), $sql) === false) {
    echo json_encode(['success' => false, 'error' => 'DB update error']);
    return;
  }

  $role = $is_admin ? "Admin" : "User";
  echo json_encode(['success' => true, 'role' => $role]);
  return;
}