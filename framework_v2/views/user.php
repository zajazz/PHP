<?php
/** @var array $user
 * @var string $title
 */

?>
<div class="row">
  <div class="col"><h1 class="h1 mt-5 mb-3"><?= $title ?></h1></div>
  <div class="col d-flex align-items-end justify-content-end">
    <div class=" mb-3"><a href="?p=user&a=all">Back to user list</a></div>
  </div>
</div>
<div class="row">
  <div class="col-6">
    <div class="card">
      <div class="card-header d-flex justify-content-between">
        <h5 class="card-title"><?= $user['login'] ?></h5>
      </div>
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <h6 class="text-muted mb-2">Role: <span id="user-role"><?= $user['role']?></span></h6>
          <a href="#" class="mb-2" @click="changeRole" id="role-changer" data-role="<?= $user['role'] ?>">Change
            role</a>
        </div>

        <p class="card-text"><b>Name:</b> <?= $user['fio'] ?></p>
        <a href="?p=order&a=user&id=<?= $user['id'] ?>" class="card-link">See orders</a>
      </div>
    </div>
  </div>
</div>
