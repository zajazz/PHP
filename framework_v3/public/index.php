<?php
use App\services\TwigRenderer;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$controller = 'product';
if ($_GET['c']) {
  $controller = $_GET['c'];
}

$action = '';
if (!empty($_GET['a'])) {
  $action = $_GET['a'];
}

$controllerName = 'App\\controllers\\' . ucfirst($controller) . 'Controller';

if (class_exists($controllerName)) {
  /** @var App\controllers\UserController $realController */
  $realController = new $controllerName(new TwigRenderer());
  $content = $realController->run($action);

  if (!empty($content)) {
    echo $content;
  }
}
