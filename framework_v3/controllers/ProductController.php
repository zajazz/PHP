<?php


namespace App\controllers;

use App\entities\Product;

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
    $product = $this->app->productRepository->getOne($this->getId());
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
    $paginator = $this->app->paginator;
    $paginator->setItems($this->app->productRepository, $this->baseRoot, $this->getPage());

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
    $product = $this->app->productRepository->getOne($this->getId());

    // form data handling
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $error = $this->app->productService->save(
            $product,
            $this->imgFolder,
            $this->request->POST(),
            $this->request->FILES('picture')
          );

          if (!empty($error)) {
            return $this->render('productChange', [
              'title' => 'Product change',
              'product' => $product,
              'img' => $this->imgFolder,
              'error' => $error,
            ]);
          }

          $this->redirect('/product/one?id=' . $product->id);
          return true;
    }

    // show filled product change form
    return $this->render('productChange', [
      'title' => 'Product change',
      'product' => $this->app->productRepository->getOne($this->getId()),
      'img' => $this->imgFolder,
    ]);
  }

  public function addAction()
  {
    if (!$this->hasPermission()) {
      $this->redirect('/');
      return false;
    }
    // form data handling
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $product = new Product();
          $error = $this->app->productService->save(
            $product,
            $this->imgFolder,
            $this->request->POST(),
            $this->request->FILES('picture')
          );

          if (!empty($error)) {
            return $this->render('productAdd', [
              'title' => 'Add new product',
              'product' => $product,
              'error' => $error,
            ]);
          }

          $this->redirect('/product/one?id=' . $product->id);
          return true;
    }

    // show product add form
    return $this->render('productAdd', [
      'title' => 'Add new product',
    ]);
  }
  
  public function removeAction()
  {
    $product = $this->app->productRepository->getOne($this->getId());

    $error = $this->app->productService->delete($product, $this->imgFolder);

    if (empty($error)) {
      $this->redirect($this->baseRoot, $error);
      return false;
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
}