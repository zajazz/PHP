<?php


namespace App\services;


class Request
{
  private $requestString = '';
  private $controllerName = 'product';
  private $actionName = '';
  private $id;
  private $page = 1;
  private $params = [
    'get' => array(),
    'post' => array(),
    'session' => array(),
  ];
  
  public function __construct()
  {
    $this->requestString = $_SERVER['REQUEST_URI'];
    $this->prepareRequest();
    $this->getError();
  }

  protected function getError()
  {
    try {
      throw new \Exception();
    } catch (\Exception $exception) {
      var_dump($exception);
    }
  }

  protected function prepareRequest()
  {
    $pattern = "#(?P<controller>\w+)[/]?(?P<action>\w+)?[/]?[?]?(?P<params>.*)#ui";
    if (preg_match_all($pattern, $this->requestString, $matches)) {
      $this->controllerName = $matches['controller'][0];
      $this->actionName = $matches['action'][0];
    }

    $this->params = [
      'get' => $_GET,
      'post' => $_POST,
      'session' => $_SESSION,
    ];

    if(!empty($_GET['id'])) {
      $this->id = (int)$_GET['id'];
    }

    if(!empty($_GET['p'])) {
      $this->page = (int)$_GET['p'];
    }
  }

  /**
   * @return string
   */
  public function getControllerName(): string
  {
    return 'App\\controllers\\' . ucfirst($this->controllerName) . 'Controller';
  }

  /**
   * @return string
   */
  public function getActionName(): string
  {
    return $this->actionName;
  }

  /**
   * @return mixed
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * @return int
   */
  public function getPage(): int
  {
    return $this->page;
  }
}