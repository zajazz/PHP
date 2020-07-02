<?php
/** @var array $products
 * @var string $img
 * @var string $title
 */

?>
<div class="row mt-5">
    <div class="col">
      <h1 class="h1 mb-3"><?= $title ?>
        <a href="?p=product&a=add" class="btn btn-warning my-1 ml-5">Добавить товар</a>
      </h1>
    </div>
</div>
<div class="row">
<?php foreach($products as $product) :?>
  <div class="col-6 col-md-4 col-lg-3 d-flex align-items-stretch">
    <div class="card bg-light">
      <img src="<?php echo $img . $product['img']; ?>" class="card-img-top p-1" alt="<?= $product['title'] ?>">
      <div class="card-body d-flex flex-column">
        <h5 class="card-title"><?= $product['title'] ?></h5>
        <p class="card-text flex-grow-1"><?= $product['info'] ?></p>
        <h3><?= $product['price'] ?> &#8381;</h3>
        <div>
          <a href="?p=product&a=one&id=<?= $product['id'] ?>" class="btn btn-primary my-1">Подробно</a>
          <a href="?p=cart&a=add&id=<?= $product['id'] ?>" class="btn btn-primary my-1">В корзину</a>
          <a href="?p=product&a=remove&id=<?= $product['id'] ?>" class="btn btn-danger my-1">Удалить</a>
        </div>
      </div>
    </div>
  </div>
<?php endforeach;?>
</div>

<script src="/js/jquery.js"></script>