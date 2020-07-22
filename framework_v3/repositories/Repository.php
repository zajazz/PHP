<?php


namespace App\repositories;

use App\entities\Entity;
use App\services\DB;

abstract class Repository
{
  /**
 * Return table name
 */
  abstract public function getTableName(): string;
  abstract public function getEntityName(): string;

   /**
   * @return DB
   */
  public static function getDB()
  {
    return DB::getInstance();
  }

  public function getOne($id)
  {
    $sql = "SELECT * FROM " . $this->getTableName() . " WHERE id = :id";
    return static::getDB()->findObject($sql, $this->getEntityName(), [':id' => $id]);

  }
  public function getAll()
  {
    $sql = "SELECT * FROM " . $this->getTableName();
    return static::getDB()->findObjects($sql, $this->getEntityName());
  }

  public function delete(Entity $entity)
  {
    $sql = "DELETE FROM " . $this->getTableName() . " WHERE id = :id";
    return static::getDB()->execute($sql, [':id' => $entity->id]);
  }

  public function save(Entity $entity)
  {
    if (empty($entity->id)) {
      $this->insert($entity);
    }
    $this->update($entity);
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

    if (static::getDB()->execute($sql, $params)) {
      $entity->id = static::getDB()->getLastInsertId();
    }

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
    static::getDB()->execute($sql, $params);
  }

  public function getModelsByPage(int $page, int $countPerPage)
  {
    $start = ($page - 1) * $countPerPage;
    $sql = "SELECT * FROM ". $this->getTableName() ." LIMIT {$start}, {$countPerPage}";
    return static::getDB()->findObjects($sql, $this->getEntityName());
  }

  public function getCountList()
  {
    $sql = "SELECT count(*) AS `count` FROM ". $this->getTableName();
    return static::getDB()->find($sql)['count'];
  }
}