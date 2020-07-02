<?php
/** @var array $user
 *  @var string $title
 */
?>
<h1 class="h1 mt-5 mb-3"><?= $title ?></h1>

<h3>Welcome, <?= $user['fio'] ?></h3>
<div class="text-success m-2"><?= $msg ?></div>
<div>
  <p><a href="?p=order">Заказы</a></p>
</div>

