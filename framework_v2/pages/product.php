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
  $template = 'products.php';
  if (isAdmin()) $template = 'productsAdmin.php';

  echo render($template, [
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

  if (empty($product)) {
    setMsg('Product was not found');
    redirect();
    return;
  }

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
  return;
}

function addAction()
{
  // Данные с формы
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $error = addProduct();
    if (!empty($error)) {
      setMsg($error);
      redirect('?p=product&a=add');
      return;
    }
    redirect('?p=product');
    return;
  }

  // Вывод формы добавления товара
  echo render('addProduct.php', [
    'title' => 'Add a new product',
  ]);
}

function addProduct()
{
  $size = getSettings('img_size');
  $filename = dirname(__DIR__) . "/public" . getSettings('img_folder') . $_FILES['picture']['name'];


  if(stripos($_FILES['picture']['type'], 'image') === false) {
    return 'Файл не является изображением';
  }
  if ($_FILES['picture']['size'] > $size[0]) {
    return 'Размер файла превышает ' . $size[1];
  }
  if (!copy($_FILES['picture']['tmp_name'], $filename)) {
    return 'В процессе загрузки изображения произошла ошибка';
  }
  $title = clearString($_POST['title']);
  $price = preg_replace('/[^0-9.,]/', '', $_POST['price']);
  $price = preg_replace('/,/', '.', $_POST['price']);
  $info = clearString($_POST['info']);

  $sql = "INSERT INTO products
            VALUES (NULL, '$title', '$price', '$info', '{$_FILES['picture']['name']}')";
  if (mysqli_query(getLink(), $sql) === false) {
    return 'An error occurred while writing to the database' . mysqli_error(getLink());
  }

  return '';
}

function removeAction()
{
  $id = getId();
  if (empty($id)) {
    redirect();
    return;
  }
  // поиск в текущих заказах
  $sql = "SELECT product_id FROM order_product WHERE product_id = $id";
  $result = mysqli_query(getLink(), $sql);
  if (!empty($result->num_rows)) {
    setMsg('Unable to delete a product which included in user\'s orders');
    redirect('?p=product');
    return;
  }

  // путь к изображению
  $sql = "SELECT img FROM products WHERE id = $id";
  $result = mysqli_query(getLink(), $sql);
  $img = mysqli_fetch_assoc($result)['img'];
  $filename = dirname(__DIR__) . "/public" . getSettings('img_folder') . $img;

  $sql = "DELETE FROM products WHERE id = $id";
  if (mysqli_query(getLink(), $sql) === false) {
    setMsg('An error occurred while writing to the database' . mysqli_error(getLink()));
    redirect();
    return;
  }

  unlink($filename);
  setMsg("The product #$id was successfully removed");
  redirect('?p=product');
  return;
}
