<?php
namespace App\models;

use App\services\DB;

abstract class Model
{
  protected $db;
  protected $tableName;

  /**
   * Return table name
   * @return string
   */
  abstract public function getTableName(): string;

  public function __construct(DB $db)
  {
    $this->db = $db;
  }

  public function getOne($id)
  {
    $sql = "SELECT * FROM `{$this->getTableName()}` WHERE id = $id";
    return $this->db->find($sql);
  }

  public function getAll()
  {
    echo $this->tableName;
    $sql = "SELECT * FROM `{$this->getTableName()}`";
    return $this->db->findAll($sql);
  }
}