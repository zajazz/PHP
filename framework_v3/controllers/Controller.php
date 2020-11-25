<?php


namespace App\controllers;

use App\engine\App;
use App\services\IRenderer;
use App\services\RenderTemplate;
use App\services\Request;

abstract class Controller
{
  protected $renderer;
  /** @var Request  */
  protected $request;
  /**
   * @var App
   */
  protected $app;
  protected $isDenied = false;

  /**
   * Controller constructor.
   * @param App $app
   * @param Request $request
   */
  public function __construct(App $app, Request $request)
  {
    $this->app = $app;
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
    return $this->app->renderer->render($template, $params);
  }

  protected function getId()
  {
    return $this->request->getId();
  }
  protected function getPage()
  {
    return $this->request->getPage();
  }

  public function redirect($path = '', $msg = ''): void
  {
    $this->request->redirect($path, $msg);
  }
  
  public function hasPermission()
  {
    if (!$this->app->authService->isAdmin()) {
      return false;
    }
    return true;
  }

  public function isAuthorized()
  {
    return $this->app->authService->isAuthorized();
  }

}