<?php


namespace App\controllers;

use App\services\IRenderer;
use App\services\RenderTemplate;
use App\services\Request;

abstract class Controller
{
  protected $renderer;
  protected $request;

  /**
   * Controller constructor.
   * @param IRenderer $renderer
   * @param Request $request
   */
  public function __construct(IRenderer $renderer, Request $request)
  {
    $this->renderer = $renderer;
    $this->request = $request;
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
    return $this->request->getId();
  }
  protected function getPage()
  {
    return $this->request->getPage();
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



}