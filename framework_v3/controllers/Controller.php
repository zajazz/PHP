<?php


namespace App\controllers;

use App\services\IRenderer;
use App\services\RenderTemplate;

abstract class Controller
{
  protected $renderer;

  /**
   * Controller constructor.
   * @param $renderer
   */
  public function __construct(IRenderer $renderer)
  {
    $this->renderer = $renderer;
  }

  abstract public function getDefaultAction(): string;

  public function run($action)
  {
    if (empty($action)) {
      $action = $this->getDefaultAction();
    }

    $method = $action . 'Action';
    if (!method_exists($this, $method)) {
      return 'Error';
    }

    return $this->$method();
  }
  public function render($template, $params)
  {
    return $this->renderer->render($template, $params);
  }

  protected function getId()
  {
    $id = 0;
    if (!empty((int)$_GET['id'])) {
      $id = (int)$_GET['id'];
    }

    return $id;
  }
  protected function getPage()
  {
    $page = 1;
    if (!empty($_GET['p'])) {
      $page = (int)$_GET['p'];
    }

    return $page;
  }

  public function redirect($path = ''): void
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

  public function getUniqueFilename($file)
  {
    $extension = strtolower(substr(strrchr($file, '.'), 1));
    return uniqid('img_') . "." . $extension;
  }

}