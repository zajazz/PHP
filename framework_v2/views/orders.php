<?php
/**
 * @var string $title
 * @var array $orders
 * @var string $error
 */
?>
<h1 class="h1 mt-5 mb-3"><?= $title ?></h1>
<div class="card bg-secondary text-white px-2 py-1 my-1">
  <div class="row mb-1">
    <div class="col-2">Number</div>
    <div class="col-4">Date</div>
    <div class="col-3">Amount</div>
    <div class="col-3">Status</div>
  </div>
</div>
<?php if (!empty($error)): ?>
  <div class="card bg-light my-2 px-2 py-3" ><?= $error ?></div>
<?php else: ?>
  <?php foreach($orders as $order) : ?>
    <div class="card bg-light my-2 px-2 py-1 pointer table-row"
         @click="goLink(<?= $order['id'] ?>, $event)">
      <div class="row mb-1 align-items-center">
        <div class="col-2"><?= $order['id'] ?></div>
        <div class="col-4"><?= $order['date'] ?></div>
        <div class="col-3"><?= $order['amount'] ?> <?= getCurrency() ?></div>
        <div class="col-3 "><?= $order['status'] ?></div>
      </div>
    </div>
    <?php endforeach; ?>
<? endif; ?>

