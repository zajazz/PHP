<?php
namespace App\models;

use App\services\DB;

abstract class Model
{
  /**
   * @var DB
   */
  protected $db;

  /**
   * Return table name
   * @return string
   */
  abstract public function getTableName(): string;

  public function __construct()
  {
    $this->db = DB::getInstance();
  }

  public function getOne($id)
  {
    $sql = "SELECT * FROM `" . $this->getTableName() . "` WHERE id = :id";
    $result = $this->db->find($sql, [':id' => $id]);

    return $this->createObj($result);
  }
  public function getAll()
  {
    $sql = "SELECT * FROM `{$this->getTableName()}`";
    $rows = $this->db->findAll($sql);
    return array_map(function ($row) {
      return $this->createObj($row);
    }, $rows);
  }
  public function delete($id)
  {
    $sql = "DELETE FROM `" . $this->getTableName() . "` WHERE id = :id";
    return $this->db->execute($sql, [':id' => $id]);
  }
  public function save()
  {
    if (empty($this->id)) {
      return $this->insert();
    }
    return $this->update($this->id);
  }

  protected function insert()
  {
    $fields = '';
    $values = '';
    $params = [];

    foreach ($this->getFields() as $key => $value) {
      if (!empty($value)) {
        $fields .= "`$key`, ";
        $values .= ":$key, ";
        $params[':' . $key] = $value;
      }
    }
    $fields = substr($fields, 0, -2);
    $values = substr($values, 0, -2);

    $sql = "INSERT INTO `{$this->getTableName()}` ($fields) VALUES ($values)";
    return $this->db->insert($sql, $params);
  }
  protected function update($id)
  {
    $updateStr = '';
    $params = [];

    foreach ($this->getFields() as $key => $value) {
      if (!empty($value)) {
        $updateStr .= ($key !== 'id') ? "`$key` = :$key, " : '';
        $params[':' . $key] = $value;
      }
    }
    $updateStr = substr($updateStr, 0, -2);

    $sql = "UPDATE `{$this->getTableName()}` SET $updateStr WHERE id = :id";
    return $this->db->execute($sql, $params);
  }

  private function getFields()
  {
    $fields = [];
    foreach ($this as $key => $value) {
      if ($key !== 'db') {
        $fields[$key] = $value;
      }
    }

    return $fields;
  }
  private function createObj($result)
  {
    $obj = new static();
    foreach ($this->getFields() as $key => $value) {
      $obj->$key = $result[$key];
    }

    return $obj;
  }

}