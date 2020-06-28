<?php
function indexAction()
{
  allAction();
}

function allAction()
{
  $sql = 'SELECT * FROM products';
  $result = mysqli_query(getLink(), $sql);
  $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
  echo render('products.php', [
    'products' => $products,
    'title' => 'Products',
    'img' => getSettings('img_folder'),
  ]);
}

function oneAction()
{
  if (!getId()) {
    redirect('?p=product');
    return;
  }

  $sql = 'SELECT * FROM products WHERE id = ' . getId();
  $result = mysqli_query(getLink(), $sql);
  $product = mysqli_fetch_assoc($result);

  echo render('product.php', [
    'product' => $product,
    'title' => $product['title'],
    'img' => getSettings('img_folder'),
    'comments' => getComments(getId()),
  ]);
}

function getComments($id) {
  $sql = "SELECT `text` FROM comments WHERE product_id = $id";
  $result = mysqli_query(getLink(), $sql);
  $comments = mysqli_fetch_all($result, MYSQLI_ASSOC);

  if (empty($comments)) return 'There are no comments yet. Leave the first one!';
  return renderTemplate('patterns/comments.php', [
    'comments' => $comments,
  ]);
}

 /**
 * Добавить комментарий
 */
function commentAction()
{
  if($_POST['comment']) {
    $sql = "INSERT INTO comments VALUES (NULL, " . getId() . ", '" . clearString($_POST['comment']) . "')";
    mysqli_query(getLink(), $sql);
  }
  redirect('?p=product&a=one&id=' . getId());
}
