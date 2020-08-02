<?php
namespace App\services;

use App\repositories\ProductRepository;
use App\repositories\UserRepository;
use App\engine\Container;
use PDO;

/**
 * Class DB
 * @package App\services
 *
 * @property ProductRepository $productRepository
 * @property UserRepository $userRepository
 */
class DB
{
  protected $connect;
  protected $config = [];

  /**
   * DB constructor.
   * @param array $config
   */
  public function __construct(array $config)
  {
    $this->config = $config;
  }

  protected function getConnect()
  {
    if (empty($this->connect)) {
      $this->connect = new PDO(
        $this->getPrepareDsnString(),
        $this->config['user'],
        $this->config['password']
      );
      $this->connect->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    return $this->connect;
  }
  /**
   * @param $sql
   * @param array $params
   * @return bool|\PDOStatement
   */
  protected function query($sql, $params = [])
  {
//    return $PDOStatement = $this->getConnect()->prepare($sql)->debugDumpParams();
    $PDOStatement = $this->getConnect()->prepare($sql);
    $PDOStatement->execute($params);
    return $PDOStatement;
  }

  private function getPrepareDsnString()
  {
    return sprintf("%s:host=%s;dbname=%s;charset=%s;port=%s",
      $this->config['driver'],
      $this->config['host'],
      $this->config['dbname'],
      $this->config['charset'],
      $this->config['port']
    );
  }

  public function find($sql, $params = [])
  {
    return $this->query($sql, $params)->fetch();
  }
  public function findAll($sql, $params = [])
  {
    return $this->query($sql, $params)->fetchAll();
  }
  /**
   * Executes SQL statements returning empty result set
   * @param $sql
   * @param array $params
   * @return bool true if success, or false in case of error
   */
  public function execute($sql, $params = [])
  {

    // return $PDOStatement =$this->query($sql, $params)->debugDumpParams();
    $PDOStatement =$this->query($sql, $params);

    if ($PDOStatement->errorCode() === '00000') {
      return true;
    }

    // return $PDOStatement->errorInfo();
    return false;
  }

  public function getLastInsertId() {

    return $this->connect->lastInsertId();
  }

  public function findObject($sql, $class, $params = [])
  {
    // return $PDOStatement = $this->query($sql, $params)->debugDumpParams();
    $PDOStatement = $this->query($sql, $params);
    $PDOStatement->setFetchMode(PDO::FETCH_CLASS, $class);
    return $PDOStatement->fetch();
  }

  public function findObjects($sql, $class, $params = [])
  {
    $PDOStatement = $this->query($sql, $params);
    $PDOStatement->setFetchMode(PDO::FETCH_CLASS, $class);
    return $PDOStatement->fetchAll();
  }
}