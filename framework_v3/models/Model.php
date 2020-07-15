<?php
namespace App\models;

use App\services\DB;

abstract class Model
{
  /**
   * Return table name
   * @return string
   */
  abstract public static function getTableName(): string;

  /**
   * @return DB
   */
  protected static function getDB()
  {
    return DB::getInstance();
  }

  public static function getOne($id)
  {
    $sql = "SELECT * FROM " . static::getTableName() . " WHERE id = :id";
    return static::getDB()->findObject($sql, static::class, [':id' => $id]);

  }
  public static function getAll()
  {
    $sql = "SELECT * FROM " . static::getTableName();
    return static::getDB()->findObjects($sql, static::class);
  }

  public function delete($id)
  {
    $sql = "DELETE FROM " . static::getTableName() . " WHERE id = :id";
    return static::getDB()->execute($sql, [':id' => $id]);
  }
  public function save()
  {
    if (empty($this->id)) {
      $this->insert();
    }
    return $this->update();
  }

  protected function insert()
  {
    $columns = [];
    $params = [];

    foreach ($this as $key => $value) {
      if (isset($value) && $key !== 'id') {
        $columns[] = $key;
        $params[':' . $key] = $value;
      }
    }

    $sql = sprintf(
      "INSERT INTO %s (%s) VALUES (%s)",
      static::getTableName(),
      implode(', ', $columns),
      implode(', ', array_keys($params))
    );

    $id = static::getDB()->insert($sql, $params);

    if ($id !== -1) $this->id = $id;
  }
  protected function update()
  {
    $updateStr = '';
    $params = [];

    foreach ($this as $key => $value) {
      if (!empty($value)) {
        $updateStr .= ($key !== 'id') ? "`$key` = :$key, " : '';
        $params[':' . $key] = $value;
      }
    }
    $updateStr = substr($updateStr, 0, -2);

    $sql = "UPDATE ". static::getTableName() . " SET $updateStr WHERE id = :id";
    return static::getDB()->execute($sql, $params);
  }
}