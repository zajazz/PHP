<?php
/**
 * Отобразить заказы авторизованного пользователя
 */
function indexAction()
{
  //
  $orders = getOrders($_SESSION['user']['id']);

  $error = '';
  if (empty($orders)) $error = 'You have no orders yet.';


  echo render('orders.php', [
    'title' => 'Order list',
    'orders' => $orders,
    'error' => $error,
  ]);

}

/**
 * Админ. Отобразить список заказов всех пользователей
 */
function allAction()
{
  $orders = getOrders();
  $error = '';

  if (empty($orders)) $error = 'You have no orders yet.';

  // Добавляет форму смены статуса к каждому заказу
  else {
    $result = mysqli_query(getLink(), "SELECT * FROM statuses");
    $statuses = mysqli_fetch_all($result, MYSQLI_ASSOC);

    foreach ($orders as $key => $order) {
      $orders[$key]['changeForm'] = renderTemplate('patterns/adminStatusForm.php', [
        'statuses' => $statuses,
        'orderId' => $order['id'],
      ]);
    }
  }

  echo render('ordersAdmin.php', [
    'title' => 'Order list',
    'orders' => $orders,
    'error' => $error,
  ]);
}

/**
 * Возвращает массив заказов из БД по ID пользователя
 * @param int $userId - если не передан, то возвращает заказы всех пользователей
 * @return array
 */
function getOrders($userId = 0)
{
  $idStr = (empty($userId)) ? '' : "= $userId";

  $sql = "SELECT orders.id, users.login, date, SUM(price * qty) AS amount, status FROM orders
            INNER JOIN statuses ON statuses.id = status_id
            INNER JOIN order_product ON orders.id = order_id
            INNER JOIN users on orders.user_id = users.id
            WHERE user_id $idStr GROUP BY orders.id";
  $result = mysqli_query(getLink(), $sql);
  return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function makeAction()
{
  //  !пустая корзина
  if (empty($_SESSION['cart'])) {
    setMsg('Корзина пуста');
    redirect('?p=cart');
    return;
  }

  // Данные с формы
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $error = addNewOrder();

    if (!empty($error)) {
      setMsg($error);
      redirect('?p=order&a=make');
      return;

    }

    $orderId = $_SESSION['orderID'];
    setMsg('Заказ создан');
    unset($_SESSION['cart']);
    unset($_SESSION['orderID']);
    redirect('?p=order&a=one&id=' . $orderId);
    return;

  }

  // Форма подтверждения заказа
  echo render('orderForm.php', [
    'title' => 'Shipping information',
    'amount' => getOrderAmount(),
    'cart' => $_SESSION['cart'],
  ]);
}

function addNewOrder()
{
  if (empty($_POST['address']) || empty($_POST['phone'])) {
    return 'Not all necessary data was transferred';
  }

  $address = clearString($_POST['address']);
  $phone = preg_replace('/[^0-9+]/','',$_POST['phone']);
  $pattern = '/([0-9]{0,3})([0-9]{3})([0-9]{2})([0-9]{2})$/';
  $phone = preg_replace($pattern, ' ($1) $2-$3-$4', $phone);
  $date = date("Y-m-d H:i:s");
  $userId = $_SESSION['user']['id'];

  $sql = "INSERT INTO orders (user_id, date, address, phone, status_id)
            VALUES ($userId, '{$date}', '{$address}', '{$phone}', 1)";
  mysqli_query(getLink(), $sql);

  $orderId = mysqli_insert_id(getLink());

  if (empty($orderId)) {
    return 'An error occurred while creating the order';
  }

  $sql = "INSERT INTO order_product VALUES";
  foreach ($_SESSION['cart'] as $id => $product) {
    $sql .= " ($orderId, $id, '{$product['price']}', {$product['count']}),";
  }
  $sql = substr($sql, 0, -1);

  if (mysqli_query(getLink(), $sql) === FALSE) {
    return 'An error occurred while creating the order';
  }

  $_SESSION['orderID'] = $orderId;
  return '';
}

function getOrderAmount()
{
  $amount = 0;

  foreach ($_SESSION['cart'] as $item) {
    $amount += $item['price'] * $item['count'];
  }
  return $amount;
}

//
/**
 * Function shows detailed order by id
 */
function oneAction()
{
  $id = getId();
  if (empty($id)) {
    redirect();
  }

  $sql = "SELECT orders.id, date, address, phone, status, users.login, users.fio,
       SUM(price * qty) AS amount FROM orders
            INNER JOIN statuses ON statuses.id = status_id
            INNER JOIN order_product ON orders.id = order_id
            INNER JOIN users ON orders.user_id = users.id
            WHERE orders.id = $id";
  $result = mysqli_query(getLink(), $sql);
  $order = mysqli_fetch_assoc($result);

  if (empty($order)) {
    setMsg('Order not found');
    redirect();
  }

  $sql = "SELECT products.id, title, order_product.price, qty FROM products
            INNER JOIN order_product ON products.id = product_id
            INNER JOIN orders ON orders.id = order_id
            WHERE orders.id = $id";
  $result = mysqli_query(getLink(), $sql);
  $products = mysqli_fetch_all($result, MYSQLI_ASSOC);

  // Добавляет форму смены статуса
  $order['changeForm'] = '';
  if (isAdmin()) {
    $result = mysqli_query(getLink(), "SELECT * FROM statuses");
    $statuses = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $order['changeForm'] = renderTemplate('patterns/adminStatusForm.php', [
      'statuses' => $statuses,
      'orderId' => $id,
    ]);

  }
  echo render('order.php', [
    'title' => 'Order #' . getId(),
    'order' => $order,
    'products' => $products,
  ]);
}

function statusAction()
{

  header('Content-Type: application/json');
  if (empty($_POST['orderId']) || empty($_POST['stid'])) {
    echo json_encode(['success' => false, 'error' => 'Not enough data']);
    return;
  }

  $orderId = (int)$_POST['orderId'];
  $stid = (int)$_POST['stid'];

  $sql = "UPDATE orders SET status_id = $stid WHERE id = $orderId";

  if (mysqli_query(getLink(), $sql) === false) {
    echo json_encode(['success' => false, 'error' => 'DB update error']);
    return;
  }

  $result = mysqli_query(getLink(), "SELECT status FROM statuses WHERE id = $stid");
  $row = mysqli_fetch_assoc($result);

  echo json_encode(['success' => true, 'status' => $row['status']]);
  return;
}