<?php
function indexAction()
{
  allAction();
}

function allAction()
{
  addToCart();
  header('location: /?p=product');
}

function oneAction()
{
  addToCart();
  header('location: /?p=product&a=one&id=' . getId());
}

function cartAction()
{
  addToCart();
  header('location: /?p=cart');
}

function addToCart(): void {
  $sql = 'SELECT title, price FROM products WHERE id = ' . getId();
  $result = mysqli_query(getLink(), $sql);
  $row = mysqli_fetch_assoc($result);
  if (!empty($row)) {
    if (empty($_SESSION['cart'][getId()])) {
      $_SESSION['cart'][getId()] = [
        'title' => $row['title'],
        'price' => $row['price'],
        'count' => 1,
      ];
    }
    else {
      $_SESSION['cart'][getId()]['count']++;
    }
  }
}
