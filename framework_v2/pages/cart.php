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

function axiosAddAction() : void
{
  header('Content-Type: application/json');
  if (empty($_POST['productId'])) {
    echo json_encode(['success' => false]);
    return;
  }
  $error = addProduct((int)$_POST['productId']);

  if (!empty($error)) {
    echo json_encode(['success' => false]);
    return;
  }

  echo json_encode(['success' => true, 'cartCount' => count($_SESSION['cart'])]);
  return;
}

function jqueryAction() : void
{
  header('Content-Type: application/json');
  $error = addProduct(getIdPost());

  if (!empty($error)) {
    echo json_encode(['success' => false, 'error' => $error]);
    return;
  }

  echo json_encode(['success' => true, 'cartCount' => count($_SESSION['cart'])]);
  return;

}


function addProduct($id)
{
  if (empty($id)) {
    return 'Не передан id товара';
  }

  $sql = 'SELECT title, price FROM products WHERE id = ' . $id;
  $result = mysqli_query(getLink(), $sql);
  $row = mysqli_fetch_assoc($result);

  if (empty($row)) {
    return 'Товар не найден';
  }

  if (!empty($_SESSION['cart'][$id]['count'])) {
    $_SESSION['cart'][$id]['count']++;
    return '';
  }

  $_SESSION['cart'][$id] = [
      'title' => $row['title'],
      'price' => $row['price'],
      'count' => 1,
  ];
  return '';
}