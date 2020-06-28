<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $title ?></title>
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.1/css/all.css" integrity="sha384-xxzQGERXS00kBmZW/6qxqJPyxW3UR0BPsL4c8ILaIWXva5kFi7TxkIIaMiKtqV1Q" crossorigin="anonymous">
  <link rel="stylesheet" href="/css/style.css">
<!--  <script crossorigin="anonymous" src="https://kit.fontawesome.com/d026af0d1d.js"></script>-->
</head>
<body class="d-flex flex-column min-vh-100">
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="/">Framework v2</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar1" aria-controls="navbar1" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbar1">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item"><a class="nav-link mr-n4 my-n3" href="/">Главная</a></li>
        <li class="nav-item"><a class="nav-link mr-n4 my-n3" href="/?p=user">Пользователи</a></li>
        <li class="nav-item"><a class="nav-link mr-n4 my-n3" href="/?p=product">Товары</a></li>
        <li class="nav-item"><a class="nav-link my-n3" href="/?p=cart">Корзина<sup class="badge badge-secondary ml-1
        "><?= $cartCount ?></sup></a></li>
      </ul>

        <? if (empty($login)): ?>
          <a href="?p=auth" class="btn btn-outline-info my-2 my-sm-0">Вход</a>
        <? else: ?>
          <a class="nav-item" href="?p=auth" ><span class="navbar-text mr-3 text-info"><?= $user['fio']; ?></span></a>
          <a href="?p=auth&a=logout" class="btn btn-outline-info my-1 ">Выйти</a>
        <? endif; ?>

    </div>
  </div>
</nav>

<div class="container">
  <?= $content ?>
</div>

<div class="wrapper flex-grow-1"></div>
<footer class="navbar navbar-dark bg-dark">
  <div class="container">
    <span class="navbar-text">&copy; Ivanova Zoya, 2020</span>
  </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>