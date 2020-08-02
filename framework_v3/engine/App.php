<?php

namespace App\engine;

use App\controllers\CartController;
use App\repositories\OrderRepository;
use App\repositories\ProductRepository;
use App\repositories\UserRepository;
use App\controllers\Controller;
use App\services\AuthService;
use App\services\CartService;
use App\services\OrderService;
use App\services\Paginator;
use App\services\ProductService;
use App\services\TwigRenderer;
use App\traits\TSingleton;
use App\services\Request;
use App\services\DB;


/**
 * Class App
 * @package App\engine
 *
 * @property Request $request
 * @property DB $db
 * @property TwigRenderer $renderer
 * @property Paginator $paginator
 * @property ProductRepository $productRepository
 * @property ProductService $productService
 * @property OrderRepository $orderRepository
 * @property UserRepository $userRepository
 * @property AuthService $authService
 * @property OrderService $orderService
 * @property CartService $cartService
 */
class App
{
  use TSingleton;

  protected $config = [];
  protected $container;
  /**
   * @return App
   */
  public static function call()
  {
    return static::getInstance();
  }
  
  public function run($config)
  {
    $this->config = $config;
    $this->setContainer();
    return $this->runController();
  }

  protected function setContainer()
  {
    $this->container = new Container($this->config['components']);
  }

  protected function runController()
  {
    $request = $this->request;
    $controller = $request->getControllerName();

    if (class_exists($request->getControllerName())) {
      /** @var Controller $realController */
      $realController = new $controller($this, $request);

      return $realController->run($request->getActionName());
    }

    return '404';
  }

  public function __get($name)
  {
    return $this->container->$name;
  }

  public function getSettings($key = '', $defaultValue = null)
  {
    if (empty($key)) return $this->config;

    if (array_key_exists($key, $this->config)) {
      return $this->config[$key];
    }

    return  $defaultValue;
  }
}