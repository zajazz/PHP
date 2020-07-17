<?php


namespace App\services;


use App\models\Model;

class Paginator
{
  protected $items = [];
  protected $count = 0;
  protected $baseRoot;

  public function setItems(Model $model, $baseRoot, $pageNumber = 1)
  {
    $this->count = $model->getCountList();
    $this->items = $model->getModelsByPage($pageNumber);
    $this->baseRoot = $baseRoot;
  }

  public function getItems(): array
  {
    return $this->items;
  }

  public function getUrls()
  {
    $counter = intdiv($this->count, 10);
    if ($this->count % 10) {
      $counter++;
    }

    $urls = [];

    for ($i = 1; $i <= $counter; $i++) {
      $urls[$i] = $this->baseRoot . '&p=' . $i;
    }

    return $urls;
  }

}