<?php
namespace App\services;

use App\traits\TSingleton;
use PDO;

class DB
{
  use TSingleton;

  protected $connect;
  protected $config = [
    'driver' => 'mysql',
    'host' => 'localhost',
    'dbname' => 'gbphp',
    'charset' => 'UTF8',
    'port' => 3305,
    'user' => 'root',
    'password' => 'root',
  ];

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
   * @return int affected rows count or -1 in case of error
   */
  public function execute($sql, $params = [])
  {
    $PDOStatement =$this->query($sql, $params);

    if ($PDOStatement->errorCode() === '00000') {
      return $PDOStatement->rowCount();
    }

    // return $PDOStatement->errorInfo();
    return -1;
  }
  /**
   * @param $sql
   * @param array $params
   * @return int inserted Id or -1 in case of error
   */
  public function insert($sql, $params = [])
  {
    $PDOStatement = $this->query($sql, $params);

    if ($PDOStatement->errorCode() === '00000'){
      return $this->connect->lastInsertId();
    }

    // return $PDOStatement->errorInfo();
    return -1;

  }
  public function findObject($sql, $class, $params = [])
  {
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