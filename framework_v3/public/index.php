<?php

use App\services\Request;
use App\services\TwigRenderer;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$request = new Request();
$controller = $request->getControllerName();

if (class_exists($request->getControllerName())) {
  /** @var App\controllers\Controller $realController */
  $realController = new $controller(new TwigRenderer(), $request);
  $content = $realController->run($request->getActionName());

  if (!empty($content)) {
    echo $content;
  }
}
