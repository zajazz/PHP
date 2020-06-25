<?php
function indexAction()
{
  allAction();
}

function allAction()
{
  echo "Products";
  $sql = 'SELECT * FROM products';
  $result = mysqli_query(getLink(), $sql);
  echo render('products.php', [
    'result' => $result,
    'title' => 'Products',
  ]);
}

function oneAction()
{
  echo "Product";
  $img = '/img/';
  $sql = 'SELECT * FROM products WHERE id = ' . getId();
  $result = mysqli_query(getLink(), $sql);
  $product = mysqli_fetch_assoc($result);
  // comments
  $sql = 'SELECT `text` FROM comments WHERE product_id = ' . getId();
  $comments = mysqli_query(getLink(), $sql);

  echo render('product.php', [
    'row' => $product,
    'title' => $row['title'],
    'img' => $img,
    'comments' => $comments,
  ]);
}

 /**
 * Добавить комментарий
 */
function commentAction()
{
  if($_GET['comment']) {
    $sql = "INSERT INTO comments VALUES (NULL, " . getId() . ", '{$_GET['comment']}')";
    mysqli_query(getLink(), $sql);
  }
  header('location: /?p=product&a=one&id=' . getId());
}
