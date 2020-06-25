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