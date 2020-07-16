<?php


namespace App\controllers;


abstract class Controller
{
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

  public function render($template, $params = [])
  {
    $content = $this->renderTemplate($template, $params);
    return $this->renderTemplate('layouts/main', [
      'content' => $content,
    ]);
  }

  public function renderTemplate($template, $params = [])
  {
    ob_start();
    extract($params);
    include dirname(__DIR__) . '/views/' . $template . '.php';
    return ob_get_clean();
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
    if (!empty((int)$_GET['p'])) {
      $page = (int)$_GET['p'];
    }

    return $page;
  }

  /**
   * Returns modal window html
   * @param string $content
   * @param bool $mode visibility switcher (true - show, false - hidden until an explicit call)
   * @return string
   */

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