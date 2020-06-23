<?php
if($_GET['comment']) {
  $sql = "INSERT INTO comments VALUES (NULL, " . getId() . ", '{$_GET['comment']}')";
  mysqli_query($link, $sql);
  header('Location: /framework/?page=6&id=' . getId());
  exit;
}

$img = '/framework/img/';
$sql = 'SELECT * FROM products WHERE id = ' . getId();
$result = mysqli_query($link, $sql);

$row = mysqli_fetch_assoc($result);
$product = <<<php
    <h1>{$row['title']}</h1>
    <div class="col-6 mb-3 ">
       <img src="{$img}{$row['img']}" alt="{$row['title']}" class="img-thumbnail mb-n1">
    </div>
    <p>{$row['info']}</p>
    <h3>{$row['price']}</h3>
php;


$sql = 'SELECT `text` FROM comments WHERE product_id = ' . getId();
$result = mysqli_query($link, $sql);
$feedback = '';
while($row = mysqli_fetch_assoc($result)) {
  $feedback .= <<<php
  <div class="card mb-2">
    <div class="card-body">
      {$row['text']}
    </div>
  </div>
php;

}

echo $product . '<div class="col w-100 mb-5"></div>';
echo "<h2>Отзывы</h2>" . $feedback;

?>

<h2> Добавить отзыв </h2>
<form class="form-inline mb-4 " method="GET" action="?page=6&id=">
  <input type="hidden" name="page" value="6">
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



<!-- ЗАДАНИЕ -->
  <div class="accordion m-3 pt-5" id="accordionExample">
    <div class="card">
      <div class="card-header" id="headingOne">
        <h5 class="mb-0">
          <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Задание
          </button>
        </h5>
      </div>

      <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample" aria-expanded="false">
        <div class="card-body">
          <p>3. Добавить функционал отзывов в имеющийся у вас проект.</p>
          <p>4. Создать страницу каталога товаров:
            <ul>
              <li>товары хранятся в БД (структура прилагается);</li>
              <li>страница формируется автоматически;</li>
              <li>по клику на товар открывается карточка товара с подробным описанием.</li>
            </ul>
            подумать, как лучше всего хранить изображения товаров.</p>
          </div>
      </div>
    </div>
  </div>