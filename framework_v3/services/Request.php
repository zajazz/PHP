<?php


namespace App\services;


use Exception;

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
    'files' => array(),
  ];

  public function __construct()
  {
    $this->requestString = $_SERVER['REQUEST_URI'];
    $this->startSession();
    $this->prepareRequest();
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
      'files' => $_FILES,
    ];

    if(!empty($_GET['id'])) {
      $this->id = (int)$_GET['id'];
    }
    else if (!empty($_POST['id'])) {
      $this->id = (int)$_POST['id'];
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

  public function GET($key = null)
  {
    if (empty($key)) return $this->params['get'];

    if (array_key_exists($key, $this->params['get'])) {
        return $this->params['get'][$key];
      }

    return null;
  }

  public function POST($key = null)
  {
    if (empty($key)) return $this->params['post'];

    if (array_key_exists($key, $this->params['post'])) {
      return $this->params['post'][$key];
    }

    return null;
  }

  public function SESSION($key = null)
  {
    if (empty($this->params['session'])) return null;

    if (empty($key)) return $this->params['session'];

    if (array_key_exists($key, $this->params['session'])) {
      return $this->params['session'][$key];
    }

    return null;
  }

  public function FILES($key = null)
  {
    if (empty($key)) return $this->params['files'];

    if (array_key_exists($key, $this->params['files'])) {
      return $this->params['files'][$key];
    }

    return null;
  }

  public function setSession($key, $value)
  {
    if (empty($key)) throw new Exception('Cannot set session with empty key.');
    $_SESSION[$key] = $value;

    $this->params['session'] = $_SESSION;
  }
  
  public function startSession(array $options = []): void
  {
    session_start($options);
  }

}