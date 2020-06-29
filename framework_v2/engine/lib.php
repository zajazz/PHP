<?php
function getLink(): mysqli
{
  static $link;
  if(empty($link)) {
    $link = mysqli_connect('localhost', 'root', 'root','gbphp');
  }
  return $link;
}

function run()
{
  $page = 'index';
  if (!empty($_GET['p'])) {
    $page = $_GET['p'];
  }
  $filename = getFileName($page);

  if (!is_file($filename)) {
    $filename = dirname(__DIR__) . '/pages/index.php';
  }
  include $filename;

  $action = 'index';
  if (!empty($_GET['a'])) {
    $action = $_GET['a'];
  }

  $action .= 'Action';
/**
 * TODO: создать здесь метод, который проверяет, есть ли у пользователя права на выполнение этой функции
 * если нет, то редиректить на другую страницу
 */
  if (!function_exists($action)) {
    $action = 'indexAction';
  }
  return $action();
}

/**
 * Возвращает полный путь к файлу из pages по названию
 * @param string $file
 * @return string
 */
function getFileName(string $file) : string
{
  return dirname(__DIR__) . '/pages/' . $file . '.php';
}

function getId() : int
{
  if (!empty($_GET['id'])) {
    return (int) $_GET['id'];
  }
  return 0;
}

function render($template, $params = [], $layout = 'main.php') : string
{
  $params['msg'] = getMsg();
  $content = renderTemplate($template, $params);

  $layout = 'layouts/' . $layout;
  $title = 'Welcome';

  if (!empty($params['title'])) {
    $title = $params['title'];
  }

  return renderTemplate($layout, [
    'content' => $content,
    'title' => $title,
    'user' => $_SESSION['user'],
    'login' => $_SESSION['login'],
    ]);
}

function renderTemplate($template, $params = []) : string
{
  ob_start();
  extract($params);
  include dirname(__DIR__) . '/views/' . $template;
  return ob_get_clean();
}

function redirect($path = '') : void
{
  if (!empty($path)) {
    header("Location: {$path}");
    return;
  }

  if(isset($_SERVER['HTTP_REFERER'])) {
    header("Location: {$_SERVER['HTTP_REFERER']}");
    return;
  }
  header("Location: /");
}

function clearString(string $str) : string
{
  return mysqli_real_escape_string(getLink(), strip_tags(trim($str)));
}

function setMsg($msg) : void
{
  $_SESSION['msg'] = $msg;
}

function getMsg()
{
  $msg = '';
  if (!empty($_SESSION)) {
    $msg = $_SESSION['msg'];
    unset($_SESSION['msg']);
  }
  return $msg;
}

function isAdmin()
{
  return !empty($_SESSION['user']['is_admin']);
}

function getMenu()
{
  return '
  <ul class="navbar-nav mr-auto">
    <li class="nav-item"><a class="nav-link mr-n4 my-n3" href="/">Главная</a></li>
    <li class="nav-item"><a class="nav-link mr-n4 my-n3" href="/?p=user">Пользователи</a></li>
    <li class="nav-item"><a class="nav-link mr-n4 my-n3" href="/?p=product">Товары</a></li>
    <li class="nav-item"><a class="nav-link my-n3" href="/?p=cart">Корзина<sup id="cart-badge" class="badge
    badge-secondary ml-1">{{ cartCount }}</sup></a></li>
  </ul>';
}

function getCartCount() : string
{
  return count($_SESSION['cart']);
}

function getIdPost()
{
  if (empty($_POST['id'])) {
    return 0;
  }

  return (int)$_POST['id'];
}