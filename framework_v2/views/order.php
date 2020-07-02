<?php
/**
 * @var string $title
 * @var array $order
 * @var array $products
 * @var string $changeStatus
 */
?>
<div class="row">
  <div class="col"><h1 class="h1 mt-5 mb-3"><?= $title ?></h1></div>
  <div class="col d-flex align-items-end justify-content-end">
    <div class=" mb-3"><a href="?p=order">Back to order list</a></div>
  </div>
</div>

<div class="card bg-secondary text-white px-2 py-1 mt-4">
  <div class="row mb-2 text-nowrap">
    <div class="col-2"><span class="px-3">Number</span></div>
    <div class="col-4"><span class="px-3">Date</span></div>
    <div class="col-2"><span class="px-3">Amount</span></div>
    <div class="col-4 text-center"><span class="px-3">Status</span></div>
  </div>
</div>
<div class="card px-2 py-1 mt-2">
  <div class="row my-3">
    <div class="col-2"><span class="px-3"><b><?= $order['id'] ?></b></span></div>
    <div class="col-4"><span class="px-3"><b><?= $order['date'] ?></b></span></div>
    <div class="col-2"><span class="px-3"><b><?= $order['amount'] . "&nbsp;" . getCurrency() ?></b></span></div>
    <div class="col-4 d-flex mt-n2 justify-content-center ">
      <span class="px-3 alert alert-success" id="statusBadge<?= $order['id'] ?>"><?= $order['status'] ?></span>
      <?= $order['changeForm'] ?>
    </div>
  </div>
  <div class="row mt-3">
    <div class="col mb-2">
      <span class="px-3"><b>Login:</b> <?= $order['login'] ?></span>
      <span class="px-3"><b>Name:</b> <?= $order['fio'] ?></span>
    </div>
  </div>
  <div class="row ">
    <div class="col mb-3">
      <span class="px-3"><b>Phone:</b> <?= $order['phone'] ?></span>
      <span class="px-3"><b>Address:</b> <?= $order['address'] ?></span>
    </div>
  </div>
</div>
<div class="h3 mt-5">Ordered products</div>
<div class="card bg-secondary text-white px-2 py-1 mt-4">
  <div class="row mb-2 text-nowrap">
    <div class="col-6"><span class="px-3">Title</span></div>
    <div class="col-2"><span class="px-3">Price</span></div>
    <div class="col-2"><span class="px-3">Quantity</span></div>
    <div class="col-2"><span class="px-3">Sum</span></div>
  </div>
</div>
<?php if (empty($products)): ?>
  <div class="card bg-light my-2 px-2 py-3" >
    <span>There are no products in the order <i class="fas fa-sad-tear"></i></span>
  </div>
<?php else: ?>
  <?php foreach($products as $product) :?>
  <div class="card bg-light my-2 px-2 py-1" >
    <div class="row mb-1 align-items-center">
      <div class="col-6 py-2"><span class="px-3">
        <a href="?p=product&a=one&id=<?= $product['id'] ?>" class="text-dark">
          <?= $product['title'] ?></a></span></div>
      <div class="col-2"><span class="px-3"><?= $product['price'] . "&nbsp;" . getCurrency() ?></span></div>
      <div class="col-2"><span class="px-3"><?= $product['qty'] ?></span></div>
      <div class="col-2"><span class="px-3"><?= $product['price'] * $product['qty'] . "&nbsp;" . getCurrency() ?></span></div>
    </div>
  </div>
  <?php endforeach; ?>
<? endif; ?>





