<?php
/** @var array $users
 *  @var string $title
 */
?>
<h1 class="h1 mt-5 mb-3"><?= $title ?></h1>

<div class="card-deck">
  <?php foreach ($users as $user) :?>
<div class="card mw-100 my-2" style="min-width: 15em;">
  <div class="card-body">
    <h5 class="card-title"><?= $user['login'] ?>
      <? if ($user['is_admin'] == 1) : ?>
        <sup><span class="badge badge-danger">A</span></sup>
      <? endif; ?></h5>
  <a class="card-link" href="?p=user&a=one&id=<?= $user['id'] ?>">Подробнее</a>
  </div>
</div>
<?php endforeach; ?>
</div>