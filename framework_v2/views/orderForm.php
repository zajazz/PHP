<?php
/**
 * @var string $title
 * @var string $amount
 * @var array $cart
 */
?>
<h1 class="h1 mt-5 mb-3"><?= $title ?></h1>
<div class="row mb-5">
  <!--  FORM-->
  <div class="col-4 ">
    <div class="card">
      <div class="card-body">
        <form method="POST" action="?p=order&a=make">
          <div class="form-group">
            <label for="phone">Phone number</label>
            <input type="text" name="phone" class="form-control" placeholder="+7-294-333-33-33" aria-label="fio"
                   aria-describedby="fio" required>
          </div>
          <div class="form-group">
            <label for="address">Shipping Address</label>
            <textarea name="address" class="form-control" id="address" rows="3" required></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Make order</button>
        </form>
      </div>
    </div>
  </div>
  <!--  DETAILS-->
  <div class="col-8 ">
    <div class="card bg-light">
      <div class="card-header h5">Order summary</div>
      <div class="card-body ">
        <h4 class="list-group-item">Total cost: <?= $amount . " " . getCurrency() ?></h4>
      </div>
      <div class="card-body mt-n4">
        <ul class="list-group">
          <? foreach ($cart as $item) : ?>
          <li class="my-n4">
            <?= $item['title'] ?> &ndash; <?= $item['count'] ?> x <?= $item['price'] . " " . getCurrency() ?>
          </li>
          <? endforeach; ?>
        </ul>
      </div>
    </div>
  </div>
</div>



<!--


  <div class="row">
    <div class="col-8">

    </div>
  </div>
  <div class="row">
    <div class="col-4">
      <div class="input-group mb-3">
        <div class="input-group-prepend"><span class="input-group-text" id="login">Login</span></div>
        <input type="text" name="login" class="form-control" placeholder="login" aria-label="login"
               aria-describedby="login">
      </div>
    </div>
    <div class="col-4">
      <div class="input-group mb-3">
        <div class="input-group-prepend"><span class="input-group-text" id="password">Password</span></div>
        <input type="text" name="password" class="form-control" placeholder="password" aria-label="password"
               aria-describedby="password">
      </div>
    </div>
    <div class="col-3">
      <button type="submit" class="btn btn-info">Register</button>
    </div>
  </div>
</form>
-->

