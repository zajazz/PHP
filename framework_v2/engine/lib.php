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
  session_start();
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

  if (!function_exists($action)) {
    $action = 'indexAction';
  }
  return $action();
}

/**
 * Возвращает полный путь к файлу из pages по названию
 */
function getFileName($file)
{
  return dirname(__DIR__) . '/pages/' . $file . '.php';
}

function getId()
{
  if (!empty($_GET['id'])) {
    return (int) $_GET['id'];
  }
  return 0;
}

function render($template, $params = [], $layout = 'main.php')
{
  $content = renderTemplate($template, $params);
  $layout = 'layouts/' . $layout;
  $title = 'Welcome';
  if (!empty($params['title'])) {
    $title = $params['title'];
  }
  return renderTemplate($layout, [
    'content' => $content,
    'title' => $title,
    'login' => $_SESSION['login'],
    ]);
}

function renderTemplate($template, $params = [])
{
  ob_start();
  extract($params);
  include dirname(__DIR__) . '/views/' . $template;
  return ob_get_clean();
}