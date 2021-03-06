<?php
/**
 *  @var string $title
 */
?>
<h1 class="h1 mt-5 mb-3"><?= $title ?></h1>
<form method="POST" action="?p=auth&a=add">
  <div class="row">
    <div class="col-8">
      <div class="input-group mb-3">
        <div class="input-group-prepend"><span class="input-group-text" id="fio">Name</span></div>
        <input type="text" name="fio" class="form-control" placeholder="John Doe" aria-label="fio"
               aria-describedby="fio">
      </div>
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


