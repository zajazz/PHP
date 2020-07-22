<?php


namespace App\controllers;

use App\entities\Product;
use App\repositories\ProductRepository;
use App\services\Paginator;
use App\services\ProductService;

class ProductController extends Controller
{
  protected $actionDefault = 'all';
  protected $imgFolder = '/img/';
  private $baseRoot = '/product';

  public function getDefaultAction(): string
  {
    return $this->actionDefault;
  }

  public function oneAction()
  {
    $product = (new ProductRepository())->getOne($this->getId());
    return $this->render(
      'product',
      [
        'product' => $product,
        'img' => $this->imgFolder,
        'title' => $product->title,
      ]
    );
  }

  public function allAction()
  {
    $paginator = new Paginator();
    $paginator->setItems(new ProductRepository(), $this->baseRoot, $this->getPage());

    return $this->render(
      'products',
      [
        'paginator' => $paginator,
        'img' => $this->imgFolder,
        'title' => 'Catalog',
      ]
    );

  }

  public function changeAction()
  {
    $product = (new ProductRepository())->getOne($this->getId());

    // form data handling
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $error = (new ProductService())->saveProduct($product, $this->imgFolder);
          if (!empty($error)) {
            return $this->render('productChange', [
              'title' => 'Product change',
              'product' => $product,
              'img' => $this->imgFolder,
              'error' => $error,
            ]);
          }
          $this->redirect('/product/one?id=' . $product->id);
          return;
    }

    // show filled product change form
    return $this->render('productChange', [
      'title' => 'Product change',
      'product' => (new ProductRepository())->getOne($this->getId()),
      'img' => $this->imgFolder,
    ]);
  }

  public function addAction()
  {
    // form data handling
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $product = new Product();
          $error = (new ProductService())->saveProduct($product, $this->imgFolder);
          if (!empty($error)) {
            return $this->render('productAdd', [
              'title' => 'Add new product',
              'product' => $product,
              'error' => $error,
            ]);
          }
          $this->redirect('/product/one?id=' . $product->id);
          return;
    }

    // show product add form
    return $this->render('productAdd', [
      'title' => 'Add new product',
    ]);
  }
  
  public function removeAction()
  {
    $product = (new ProductRepository())->getOne($this->getId());

    if (empty($product)) {
      $this->redirect();
      return;
    }

    $error = $this->removeProduct($product);

    if (empty($error)) {
      $this->redirect('/product/');
      return;
    }

    return $this->render(
      'product',
      [
        'product' => $product,
        'img' => $this->imgFolder,
        'error' => $error,
      ]
    );
  }
  

  private function removeProduct(Product $product)
  {
    // search the product through active orders
    if ((new ProductService())->isInOrders($product)) {
      return 'Unable to delete a product which included in user\'s orders';
    }

    if ((new ProductRepository())->delete($product) === false) {
      return 'Error occurred while writing to the database';
    }

    $filename = dirname(__DIR__) . "/public" . $this->imgFolder . $product->img;
    unlink($filename);

    return '';
  }

}