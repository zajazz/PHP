<?php
/** @var array $product
 *  @var string $comments
 *  @var string $img
 */
?>
<h1 class="h1 mt-5 mb-3"><?= $product['title'] ?></h1>
<div class="row">
  <div class="col-lg-6 mb-3 ">
    <img src="<?php echo $img . $product['img']; ?>" alt="<?= $product['title'] ?>" class="img-thumbnail mb-n1">
  </div>
  <div class="col-lg-6 mb-3 ">
    <p><?= $product['info'] ?></p>
    <h3><?= $product['price'] ?></h3>
<!--<a href="?p=cart&a=add&id=--><?//= $product['id'] ?><!--" class="btn btn-primary my-1">В корзину</a>-->
    <button class="btn btn-primary my-1" @click="addToCart">В корзину (axios)</button>
  </div>
<div class="col w-100 mb-5"></div>
</div>
<?php echo $comments ?>
<div class="col w-100 mb-5"></div>
<h2> Добавить отзыв </h2>
<form class="form-inline mb-4 " method="POST" action="?p=product&a=comment&id=<?= getId(); ?>">
  <div class="row">
    <div class="col">
      <div class="input-group mb-1 w-100">
        <textarea name="comment" class="form-control" rows="3" required=""></textarea>
      </div>
    </div>
    <div class="col-2">
      <div class="input-group mb-1">
        <button type="submit" class="btn btn-primary mb-2">Отправить</button>
      </div>
    </div>
  </div>
</form>

