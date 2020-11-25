<?php


namespace App\services;


use Exception;

class Request
{
  private $requestString;
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

  public function getControllerName(): string
  {
    return 'App\\controllers\\' . ucfirst($this->controllerName) . 'Controller';
  }

  public function getActionName(): string
  {
    return $this->actionName;
  }

  /**
   * @return int
   */
  public function getId(): int
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

  public function GET($key = null, $defaultValue = null)
  {
    return $this->getDataByKey('get', $key, $defaultValue);
  }

  public function POST($key = '', $defaultValue = null)
  {
    return $this->getDataByKey('post', $key, $defaultValue);
  }

  public function SESSION($key = null, $defaultValue = null)
  {
    return $this->getDataByKey('session', $key, $defaultValue);
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
    if (!empty($key)) {
      $_SESSION[$key] = $value;
      $this->params['session'] = $_SESSION;
    }
  }
  
  private function startSession(array $options = []): void
  {
    session_start($options);
  }

  protected function getDataByKey($method, $key = '', $defaultValue = null)
  {
    if (empty($key)) return $this->params[$method];

    if (array_key_exists($key, $this->params[$method])) {
      return $this->params[$method][$key];
    }

    return  $defaultValue;
  }

  public function redirect($path = '', $msg = '')
  {
    // TODO message display component
    if (isset($msg)) {
        $this->setSession('msg', $msg);
    }

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

  public function sendJson($data)
  {
    header('Content-Type: application/json');
    echo json_encode($data);
  }
}