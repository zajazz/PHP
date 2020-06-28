<?php
function indexAction()
{
  echo render('cart.php', [
    'cart' => $_SESSION['cart'],
    'title' => 'Cart',
  ]);
}

function delAction()
{
  if (!empty($_SESSION['cart'][getId()])) {
    if ($_SESSION['cart'][getId()]['count'] === 1) {
      unset($_SESSION['cart'][getId()]);
    }
    else {
      $_SESSION['cart'][getId()]['count']--;
    }
  }
  indexAction();
}

function addAction(): void
{
  $error = addProduct(getId());
  if (!empty($error)) {
    setMsg($error);
  }
  redirect();
}

function addProduct($id)
{
  if (empty($id)) {
    return 'Не передан id товара';
  }

  $sql = 'SELECT title, price FROM products WHERE id = ' . getId();
  $result = mysqli_query(getLink(), $sql);
  $row = mysqli_fetch_assoc($result);

  if (empty($row)) {
    return 'Товар не найден';
  }

  if (!empty($_SESSION['cart'][$id]['count'])) {
    $_SESSION['cart'][getId()]['count']++;
    return '';
  }

  $_SESSION['cart'][$id] = [
      'title' => $row['title'],
      'price' => $row['price'],
      'count' => 1,
  ];
  return '';
}