<?php
function getLink(): mysqli
{
  static $link;
  if (empty($link)) {
    $link = mysqli_connect('localhost', 'root', 'root', 'gbphp');
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

  if (!function_exists($action . 'Action')) {
    $action = 'index';
  }

  $error = checkAvailability($action, $page);
  if (!empty($error)) {
    setMsg($error);
    redirect('?p=auth');
    exit;
  }

  $action .= 'Action';
  return $action();
}

function checkAvailability($action, $page)
{
  $adminActions = getSettings('admin_actions');
  if (array_key_exists($page, $adminActions)) {
    if (in_array($action, $adminActions[$page])) {
      if (!isAdmin()) return 'Права на доступ к этой странице ограничены';
    }
  }

  $authActions = getSettings('auth_actions');
  if (array_key_exists($page, $authActions)) {
    if (in_array($action, $authActions[$page])) {
      if (!isAuth()) return 'Авторизуйтесь, чтобы выполнить это действие';
    }
  }

  return '';
}

/**
 * Возвращает полный путь к файлу из pages по названию
 * @param string $file
 * @return string
 */
function getFileName(string $file): string
{
  return dirname(__DIR__) . '/pages/' . $file . '.php';
}

function getId(): int
{
  if (!empty($_GET['id'])) {
    return (int)$_GET['id'];
  }
  return 0;
}

function render($template, $params = [], $layout = 'main.php'): string
{
  $content = renderTemplate($template, $params);
  $layout = 'layouts/' . $layout;
  $title = 'Welcome';

  if (!empty($params['title'])) {
    $title = $params['title'];
  }

  $msg = getMsg();
  $modal = '';
  if (!empty($msg)) {
    $modal = getModal($msg);
  }

  return renderTemplate($layout, [
    'content' => $content,
    'title' => $title,
    'user' => $_SESSION['user'],
    'modal' => $modal,
  ]);
}

function renderTemplate($template, $params = []): string
{
  ob_start();
  extract($params);
  include dirname(__DIR__) . '/views/' . $template;
  return ob_get_clean();
}

/**
 * Возвращает html-код модального окна
 * @param string $content
 * @param bool $mode переключатель отображения окна (true - показать, false - cкрыть)
 * @return string
 */
function getModal($content, $mode = true)
{
  $class = ($mode) ? 'd-block' : '';
  return renderTemplate('patterns/modal.php', [
    'content' => $content,
    'mode' => $class,
  ]);
}

function redirect($path = ''): void
{
  if (!empty($path)) {
    header("Location: {$path}");
    return;
  }

  if (isset($_SERVER['HTTP_REFERER'])) {
    header("Location: {$_SERVER['HTTP_REFERER']}");
    return;
  }
  header("Location: /");
}

function clearString(string $str): string
{
  return mysqli_real_escape_string(getLink(), strip_tags(trim($str)));
}

function setMsg($msg): void
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

function isAuth()
{
  return !empty($_SESSION['login']);
}

function getMenu()
{
  $menuTemplate = 'patterns/';
  $menuTemplate .= isAdmin() ? 'adminMenu.php' : 'userMenu.php';
  return renderTemplate($menuTemplate);
}

function getCartCount(): string
{
  if (empty($_SESSION['cart'])) {
    return 0;
  }
  return count($_SESSION['cart']);
}

function getIdPost()
{
  if (empty($_POST['id'])) {
    return 0;
  }

  return (int)$_POST['id'];
}

function getAuthSection()
{
  if (isAuth()) {
    return renderTemplate('patterns/navAccount.php', [
      'user' => $_SESSION['user'],
    ]);
  }
  return renderTemplate('patterns/navAuth.php');
}

function getCurrency()
{
  return getSettings('currency');
}