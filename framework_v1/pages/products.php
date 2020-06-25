<?php

$sql = 'SELECT * FROM products';
$result = mysqli_query($link, $sql);
$img = '/img/';

$products = '<div class="row">';
while($row = mysqli_fetch_assoc($result)) {
    $products .= <<<php
    <div class="col-6 col-md-4 col-lg-3">
      <div class="card bg-light" >
        <img src="{$img}{$row['img']}" class="card-img-top p-1" alt="{$row['title']}">
        <div class="card-body">
          <h5 class="card-title">{$row['title']}</h5>
          <p class="card-text">{$row['info']}</p>
          <h3>{$row['price']} &#8381;</h3>
          <a href="?page=6&id={$row['id']}" class="btn btn-primary">Подробно</a>
        </div>
      </div>
    </div>
php;
}
$products .= '</div>';
echo '<h1>Товары </h1>' . $products;
