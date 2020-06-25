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
<body>
<div class="container">
<ul>
  <li><a href="/">Главная</a></li>
  <li><a href="/?p=user">Пользователи</a></li>
  <li><a href="/?p=product">Товары</a></li>
  <li><a href="/?p=cart">Корзина</a></li>
  <li><? if (empty($login)): ?>
    <a href="/?p=auth" class="btn btn-outline-primary my-1 ">Вход</a>
    <? else: echo $_SESSION['login']; ?>
    <a href="/?p=auth&a=logout" class="btn btn-outline-primary my-1 ">Выйти</a>
    <? endif; ?>
  </li>
</ul>


<?= $content ?>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>