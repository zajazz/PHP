<?php


namespace App\repositories;

use App\engine\Container;
use App\entities\Entity;
use App\services\DB;

abstract class Repository
{
  protected $db;
  /**
   * @var Container
   */
  protected $container;

  /**
 * Return table name
 */
  abstract public function getTableName(): string;
  abstract public function getEntityName(): string;

  public function setContainer(Container $container)
  {
    $this->container = $container;
  }

  /**
   * @return DB
   */
  public function getDB()
  {
    return $this->container->db;
  }

  public function getOne($id)
  {
    $sql = "SELECT * FROM " . $this->getTableName() . " WHERE id = :id";
    return $this->getDB()->findObject($sql, $this->getEntityName(), [':id' => $id]);
  }

  public function getAll()
  {
    $sql = "SELECT * FROM " . $this->getTableName();
    return $this->getDB()->findObjects($sql, $this->getEntityName());
  }

  public function delete(Entity $entity)
  {
    $sql = "DELETE FROM " . $this->getTableName() . " WHERE id = :id";
    return $this->getDB()->execute($sql, [':id' => $entity->id]);
  }

  public function save(Entity $entity)
  {
    if (empty($entity->id)) {
      return $this->insert($entity);
    }
    return $this->update($entity);
  }

  protected function insert(Entity $entity)
  {
    $columns = [];
    $params = [];

    foreach ($entity as $key => $value) {
      if (isset($value) && $key !== 'id') {
        $columns[] = $key;
        $params[':' . $key] = $value;
      }
    }

    $sql = sprintf(
      "INSERT INTO %s (%s) VALUES (%s)",
      $this->getTableName(),
      implode(', ', $columns),
      implode(', ', array_keys($params))
    );

    if ($this->getDB()->execute($sql, $params)) {
      $entity->id = $this->getDB()->getLastInsertId();
      return true;
    }

    return false;

  }
  protected function update(Entity $entity)
  {
    $updateStr = '';
    $params = [];

    foreach ($entity as $key => $value) {
      if (!empty($value)) {
        $updateStr .= ($key !== 'id') ? "`$key` = :$key, " : '';
        $params[':' . $key] = $value;
      }
    }
    $updateStr = substr($updateStr, 0, -2);

    $sql = "UPDATE ". $this->getTableName() . " SET $updateStr WHERE id = :id";
    if ($this->getDB()->execute($sql, $params)) {
      return true;
    }

    return false;
  }

  public function getModelsByPage(int $page, int $countPerPage)
  {
    $start = ($page - 1) * $countPerPage;
    $sql = "SELECT * FROM ". $this->getTableName() ." LIMIT {$start}, {$countPerPage}";
    return $this->getDB()->findObjects($sql, $this->getEntityName());
  }

  public function getCountList()
  {
    $sql = "SELECT count(*) AS `count` FROM ". $this->getTableName();
    return $this->getDB()->find($sql)['count'];
  }
}