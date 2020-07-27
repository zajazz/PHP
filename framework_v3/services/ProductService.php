<?php


namespace App\services;


use App\controllers\ProductController;
use App\entities\Entity;
use App\entities\Product;
use App\repositories\ProductRepository;

class ProductService
{
  protected $img_size = [1048576, '1Mb'];

  public function saveProduct(Product $product, $imgFolder, Request $request)
  {

    $price = preg_replace('/[^0-9.,]/', '', $request->POST('price'));
    $price = preg_replace('/,/', '.', $price);

    $product->price = $price;
    $product->title = $request->POST('title');
    $product->info = $request->POST('info');

    // Loading image
    $file = $request->FILES('picture');
    if (!empty($file['name'])) {

      $uniqueName = $this->getUniqueFilename($file['name']);
      $filename = dirname(__DIR__) . "/public" . $imgFolder . $uniqueName;

      if(stripos($file['type'], 'image') === false) {
        return 'Incorrect file type. Image expected';
      }

      if ($file['size'] > $this->img_size[0]) {
        return 'File size exceeds ' . $this->img_size[1];
      }

      if (!copy($file['tmp_name'], $filename)) {
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