<?php
/** @var array $row
 *  @var mysqli_result $comments
 */
var_dump($_SESSION);
?>
<h1><?= $row['title'] ?></h1>
<div class="col-6 mb-3 ">
  <img src="<?php echo $img . $row['img']; ?>" alt="<?= $row['title'] ?>" class="img-thumbnail mb-n1">
</div>
<p><?= $row['info'] ?></p>
<h3><?= $row['price'] ?></h3>
<a href="?p=addtocart&a=one&id=<?= $row['id'] ?>" class="btn btn-primary my-1">В корзину</a>
<div class="col w-100 mb-5"></div>

<h2>Отзывы</h2>
<?php while($row = mysqli_fetch_assoc($comments)) :?>
  <div class="card mb-2">
    <div class="card-body">
      <?= $row['text'] ?>
    </div>
  </div>
<?php endwhile;?>



<h2> Добавить отзыв </h2>
<form class="form-inline mb-4 " method="GET">
  <input type="hidden" name="p" value="product">
  <input type="hidden" name="a" value="comment">
  <input type="hidden" name="id" value="<?php echo getId(); ?>">
  <div class="row">
    <div class="col">
      <div class="input-group mb-1 w-100">
        <textarea name="comment" class="form-control" rows="3" required=""></textarea>
      </div>
    </div>
    <div class="col-2">
      <div class="input-group mb-1">
        <button type="submit" class="btn btn-primary mb-2">Отправить</button>
      </div>
    </div>
  </div>
</form>
