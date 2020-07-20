<?php


namespace App\controllers;

use App\models\Product;
use App\services\Paginator;

class ProductController extends Controller
{
  protected $actionDefault = 'all';
  protected $img_folder = '/img/';
  protected $img_size = [1048576, '1Mb'];
  private $baseRoot = '/?c=product';

  public function getDefaultAction(): string
  {
    return $this->actionDefault;
  }

  public function oneAction()
  {
    $product = Product::getOne($this->getId());
    return $this->render(
      'product',
      [
        'product' => $product,
        'img' => $this->img_folder,
        'title' => $product->title,
      ]
    );
  }

  public function allAction()
  {
    $paginator = new Paginator();
    $product = new Product();
    $paginator->setItems($product, $this->baseRoot, $this->getPage());

    return $this->render(
      'products',
      [
        'paginator' => $paginator,
        'img' => $this->img_folder,
        'title' => 'Catalog',
      ]
    );

  }

  public function changeAction()
  {
    $product = Product::getOne($this->getId());

    // form data handling
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $error = $this->saveProduct($product);
          if (!empty($error)) {
            return $this->render('productChange', [
              'title' => 'Product change',
              'product' => $product,
              'img' => $this->img_folder,
              'error' => $error,
            ]);
          }
          $this->redirect('?c=product&a=one&id=' . $product->id);
          return;
    }

    // show filled product change form
    return $this->render('productChange', [
      'title' => 'Product change',
      'product' => Product::getOne($this->getId()),
      'img' => $this->img_folder,
    ]);
  }

  public function addAction()
  {
    // form data handling
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $product = new Product();
          $error = $this->saveProduct($product);
          if (!empty($error)) {
            return $this->render('productAdd', [
              'title' => 'Add new product',
              'product' => $product,
              'error' => $error,
            ]);
          }
          $this->redirect('?c=product&a=one&id=' . $product->id);
          return;
    }

    // show product add form
    return $this->render('productAdd', [
      'title' => 'Add new product',
    ]);
  }
  
  public function removeAction()
  {
    $product = Product::getOne($this->getId());

    if (empty($product)) {
      $this->redirect();
      return;
    }

    $error = $this->removeProduct($product);

    if (empty($error)) {
      $this->redirect('?c=product');
      return;
    }

    return $this->render(
      'product',
      [
        'product' => $product,
        'img' => $this->img_folder,
        'error' => $error,
      ]
    );
  }
  
  private function saveProduct($product)
  {
    $price = preg_replace('/[^0-9.,]/', '', $_POST['price']);
    $price = preg_replace('/,/', '.', $price);

    $product->price = $price;
    $product->title = $_POST['title'];
    $product->info = $_POST['info'];

    // Loading image
    if (!empty($_FILES['picture']['name'])) {

      $uniqueName = $this->getUniqueFilename($_FILES['picture']['name']);
      $filename = dirname(__DIR__) . "/public" . $this->img_folder . $uniqueName;

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
      if (isset($product->img)) {
        $oldFilename = dirname(__DIR__) . "/public" . $this->img_folder . $product->img;
        if (file_exists($oldFilename)) {
          unlink($oldFilename);
        }
      }

      $product->img = $uniqueName;
    }

    if ($product->save() === false) {
      return 'Error occurred while writing to the database';
    }

    return '';
  }
  private function removeProduct($product)
  {
    // search the product through active orders
    if ($product->isInOrders()) {
      return 'Unable to delete a product which included in user\'s orders';
    }

    if ($product->delete() === false) {
      return 'Error occurred while writing to the database';
    }

    $filename = dirname(__DIR__) . "/public" . $this->img_folder . $product->img;
    unlink($filename);

    return '';
  }

}