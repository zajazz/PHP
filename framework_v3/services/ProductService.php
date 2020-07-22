<?php


namespace App\services;


use App\controllers\ProductController;
use App\entities\Entity;
use App\entities\Product;
use App\repositories\ProductRepository;

class ProductService
{
  protected $img_size = [1048576, '1Mb'];

  public function saveProduct(Product $product, $imgFolder)
  {
    $price = preg_replace('/[^0-9.,]/', '', $_POST['price']);
    $price = preg_replace('/,/', '.', $price);

    $product->price = $price;
    $product->title = $_POST['title'];
    $product->info = $_POST['info'];

    // Loading image
    if (!empty($_FILES['picture']['name'])) {

      $uniqueName = $this->getUniqueFilename($_FILES['picture']['name']);
      $filename = dirname(__DIR__) . "/public" . $imgFolder . $uniqueName;

      if(stripos($_FILES['picture']['type'], 'image') === false) {
        return 'Incorrect file type. Image expected';
      }

      if ($_FILES['picture']['size'] > $this->img_size[0]) {
        return 'File size exceeds ' . $this->img_size[1];
      }

      if (!copy($_FILES['picture']['tmp_name'], $filename)) {
        return 'Error occurred while loading the image';
      }
      // delete an old image file
      $oldFilename = '';
      if (isset($product->img)) {
        $oldFilename = dirname(__DIR__) . "/public" . $imgFolder . $product->img;
      }

      $product->img = $uniqueName;
    }

    if ((new ProductRepository())->save($product) === false) {
      return 'Error occurred while writing to the database';
    }

    if (file_exists($oldFilename)) {
      unlink($oldFilename);
    }

    return '';
  }

  public function getUniqueFilename($file)
  {
    $extension = strtolower(substr(strrchr($file, '.'), 1));
    return uniqid('img_') . "." . $extension;
  }

  public function isInOrders(Entity $entity)
  {
    $sql = 'SELECT order_id FROM order_product WHERE product_id = :id';
    return (bool)(new ProductRepository())->getDB()->findAll($sql, [':id' => $entity->id]);
  }
}