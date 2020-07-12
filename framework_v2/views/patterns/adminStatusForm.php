<?php
/**
 * @var array $statuses
 * @var number $orderId
 */
?><div class="dropdown">
  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">change</a>
  <div class="dropdown-menu" >
    <? foreach ($statuses as $status) : ?>
      <a class="dropdown-item" href="#"
         @click.stop="changeStatus(<?= $orderId . ", " . $status['id'] ?>)"><?= $status['status'] ?></a>
    <? endforeach; ?>

  </div>
</div>
