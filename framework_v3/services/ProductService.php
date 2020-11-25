<?php


namespace App\services;


use App\controllers\ProductController;
use App\entities\Entity;
use App\entities\Product;
use App\repositories\ProductRepository;

class ProductService extends Service
{
  protected $img_size = [1048576, '1Mb'];

  public function save(Product $product, $imgFolder, $data, $file)
  {
    if (!$this->isValidData($data)) {
      return 'Not enough data';
    }

    $price = preg_replace('/[^0-9.,]/', '', $data['price']);
    $price = preg_replace('/,/', '.', $price);

    $product->price = $price;
    $product->title = $data['title'];
    $product->info = $data['info'];

    // Loading image
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

    if ($this->container->productRepository->save($product) === false) {
      return 'Error occurred while writing to the database';
    }

    if (file_exists($oldFilename)) {
      unlink($oldFilename);
    }

    return '';
  }

  public function delete(Product $product, $imgFolder)
  {
    if (empty($product)) {
      return 'Product not found';
    }

    // search the product through active orders
    if ($this->container->productRepository->isInOrders($product)) {
      return 'Unable to delete a product which included in user\'s orders';
    }

    if ($this->container->productRepository->delete($product) === false) {
      return 'Error occurred while writing to the database';
    }

    $filename = dirname(__DIR__) . "/public" . $imgFolder . $product->img;
    unlink($filename);

    return '';
  }

  public function getUniqueFilename($file)
  {
    $extension = strtolower(substr(strrchr($file, '.'), 1));
    return uniqid('img_') . "." . $extension;
  }

  protected function isValidData($data)
  {
    if (empty($data['title']) || empty($data['info']) || empty($data['price'])) {
      return false;
    }

    return true;
  }
}