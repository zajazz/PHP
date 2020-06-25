<?php
/** @var mysqli_result $result
 */
$img = '/img/';
?>
<h1>Товары </h1>
<div class="row">
<?php while($row = mysqli_fetch_assoc($result)) :?>
  <div class="col-6 col-md-4 col-lg-3">
    <div class="card bg-light" >
      <img src="<?php echo $img . $row['img']; ?>" class="card-img-top p-1" alt="<?= $row['title'] ?>">
      <div class="card-body">
        <h5 class="card-title"><?= $row['title'] ?></h5>
        <p class="card-text"><?= $row['info'] ?></p>
        <h3><?= $row['price'] ?> &#8381;</h3>
        <a href="?p=product&a=one&id=<?= $row['id'] ?>" class="btn btn-primary my-1">Подробно</a>
        <a href="?p=addtocart&id=<?= $row['id'] ?>" class="btn btn-primary my-1">В корзину</a>
      </div>
    </div>
  </div>
<?php endwhile;?>
</div>
