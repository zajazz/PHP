<?php
/**
 * @var array $cart
 */
$sum = 0;
?>
<h1 class="h1 mt-5 mb-3">Cart</h1>
<div class="card bg-secondary text-white px-2 py-1 my-1">
  <div class="row mb-1">
    <div class="col-4">Product</div>
    <div class="col-2">Price</div>
    <div class="col-2">Quantity</div>
    <div class="col-2">Plus one</div>
    <div class="col-2">Minus one</div>
  </div>
</div>
<?php if (empty($cart)): ?>
<div class="card bg-light my-2 px-2 py-3" >
  <span>Your cart is empty. Let's start <a href="?p=product" >shopping</a>!</span></div>
<?php else: ?>
  <?php foreach($cart as $id => $item) :?>
    <div class="card bg-light my-2 px-2 py-1" >
      <div class="row mb-1 align-items-center">
        <div class="col-4"><a href="?p=product&a=one&id=<?= $id ?>" class="text-dark"><?= $item['title'] ?></a></div>
        <div class="col-2"><?= $item['price'] ?></div>
        <div class="col-2"><?= $item['count'] ?></div>
        <div class="col-2">
          <a href="?p=cart&a=add&id=<?= $id ?>" class="btn btn-outline-secondary my-1">
            <i class="fas fa-plus"></i></a></div>
        <div class="col-2"><a href="?p=cart&a=del&id=<?= $id ?>" class="btn btn-outline-secondary my-1">
            <i class="fas fa-minus"></i></a></div>
      </div>
    </div>
  <?php $sum += $item['price'] * $item['count']; endforeach; ?>
  <div class="card bg-secondary font-weight-bold text-white my-2 px-2 py-3" >
    <div class="row mb-1">
      <div class="col-8"></div>
      <div class="col-2 text-right ">Total:</div>
      <div class="col-2"><?= $sum ?></div>
    </div>
  </div>

<? endif; ?>

