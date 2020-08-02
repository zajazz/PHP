<?php


namespace App\engine;

use App\repositories\OrderProductRepository;
use App\repositories\OrderRepository;
use App\repositories\ProductRepository;
use App\repositories\UserRepository;
use App\services\DB;
use App\services\ProductService;
use App\services\Request;

/**
 * Class Container
 * @package App\engine
 *
 * @property DB $db
 * @property UserRepository $userRepository
 * @property ProductRepository $productRepository
 * @property OrderRepository $orderRepository
 * @property OrderProductRepository $orderProductRepository
 * @property Request $request
 */
class Container
{
  // a list from config.php ['components']
  protected $components = [];
  // class instances
  protected $componentsItems = [];

  /**
   * Container constructor.
   * @param array $components
   */
  public function __construct(array $components)
  {
    $this->components = $components;
  }

  public function __get($name)
  {
    if (array_key_exists($name, $this->componentsItems)) {
      return $this->componentsItems[$name];
    }

    if (empty($this->components[$name])) {
      return null;
    }

    $class = $this->components[$name]['class'];
    if (!class_exists($class)) {
      return null;
    }

    $config = [];
    if (array_key_exists('config', $this->components[$name])) {
      $config = $this->components[$name]['config'];
    }
    $this->componentsItems[$name] = new $class($config);

    if (method_exists($this->componentsItems[$name], 'setContainer')) {
      $this->componentsItems[$name]->setContainer($this);
    }

    return $this->componentsItems[$name];
  }
}