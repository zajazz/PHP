<?php
/**
 * @var array $user
 */
?>
<div class="nav-item dropdown position-relative">

  <a class="nav-link " href="#" id="navAccount" role="button" data-toggle="dropdown"
     aria-haspopup="true" aria-expanded="false">
    <span class="d-inline-block align-middle text-info" style="font-size: 40px;">
            <i class="fas fa-user-circle"></i>
    </span>
  </a>
  <div class="dropdown-menu position-absolute" style="left: -5em;" aria-labelledby="navAccount">
    <div class="dropdown-header"><h5><?= $user['fio'] ?></h5></div>
    <a class="dropdown-item" href="?p=auth">Аккаунт</a>
    <a class="dropdown-item" href="?p=order">Заказы</a>
    <a class="dropdown-item" href="?p=auth&a=logout">Выйти</a>
  </div>
</div>

