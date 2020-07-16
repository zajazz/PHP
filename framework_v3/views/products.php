<?php
/** @var App\models\Product $products
 *  @var string $img
 *  @var string $paging
 */
?>
<h1 class="h1 mt-5 mb-3">Catalog</h1>
<div class="row">
  <div class="col">
    <?= $paging ?>
  </div>
</div>

<div class="row">
  <?php foreach($products as $product) :?>
    <div class="col-6 col-md-4 col-lg-3 d-flex align-items-stretch">
      <div class="card bg-light mb-3">
        <img src="<?php echo $img . $product->img; ?>" class="card-img-top p-1" alt="<?= $product->title ?>">
        <div class="card-body d-flex flex-column">
          <h5 class="card-title"><a href="?c=product&a=one&id=<?= $product->id ?>"><?= $product->title ?></a></h5>
          <p class="card-text flex-grow-1"><?= $product->info ?></p>
          <h3><?= $product->price ?> &#8381;</h3>
          <div>
            <a href="?c=product&a=one&id=<?= $product->id ?>" class="btn btn-info my-1">Подробно</a>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach;?>
</div>

