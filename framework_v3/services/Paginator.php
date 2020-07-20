<?php


namespace App\services;


use App\models\Model;

class Paginator
{
  public $countPerPage = 4;
  protected $items = [];
  protected $count = 0;
  protected $baseRoot;
  public $current;


  public function setItems(Model $model, $baseRoot, $pageNumber = 1)
  {
    $this->count = $model->getCountList();
    $this->items = $model->getModelsByPage($pageNumber, $this->countPerPage);
    $this->baseRoot = $baseRoot;
    $this->current = $pageNumber;
  }

  public function getItems(): array
  {
    return $this->items;
  }

  public function getUrls()
  {

    $counter = ceil($this->count / $this->countPerPage);

    $urls = [];

    for ($i = 1; $i <= $counter; $i++) {
      $urls[$i] = $this->baseRoot . '&p=' . $i;
    }
    return $urls;
  }

  public function getNextUrl() {
    return $this->baseRoot . '&p=' . ($this->current + 1);
  }

  public function getPrevUrl() {
    return $this->baseRoot . '&p=' . ($this->current - 1);
  }


}