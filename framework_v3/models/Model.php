<?php
namespace App\models;

use App\services\DB;

abstract class Model
{
  /**
   * @var DB
   */
  protected $db;
  protected $tableName;

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
    $sql = "SELECT * FROM `{$this->getTableName()}` WHERE id = :id";
    return $this->db->find($sql, [':id' => $id]);
  }

  public function getAll()
  {
    echo $this->tableName;
    $sql = "SELECT * FROM `{$this->getTableName()}`";
    return $this->db->findAll($sql);
  }

  public function delete()
  {
    return;
  }

  public function insert()
  {
    return;
  }

  public function update()
  {
    return;
  }

  public function save()
  {
    if (empty($this->id)) {
      return $this->insert();
    }

    return $this->update();
  }

}