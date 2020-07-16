<?php
/** @var App\models\Product $product
 *  @var string $img
 *  @var string $error
 */
?>
<h1 class="h1 mt-5 mb-3"><?= $product->title ?></h1>
<?php if (isset($error)) : ?>
  <div class="row">
    <div class="col"><?= $error ?></div>
  </div>
<?php endif; ?>
<div class="row">
  <div class="col-lg-6 mb-3 ">
    <img src="<?php echo $img . $product->img; ?>" alt="<?= $product->title ?>" class="img-thumbnail mb-n1">
  </div>
  <div class="col-lg-6 mb-3 ">
    <p><?= $product->info ?></p>
    <h3><?= $product->price ?></h3>
    <a href="?c=product&a=change&id=<?= $product->id ?>" class="btn btn-info">Change</a>
    <a href="?c=product&a=remove&id=<?= $product->id ?>" class="btn btn-info">Delete</a>
  </div>
  <div class="col w-100 mb-5"></div>
</div>



