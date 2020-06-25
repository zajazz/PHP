<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $message = '';
  $size = [1048576, '1Мб'];
  $filename = dirname(__DIR__) . '/img/' . $_FILES['picture']['name'];

  if(stripos($_FILES['picture']['type'], 'image') === false) {
    $message = 'Файл не является изображением';
  }
  else if ($_FILES['picture']['size'] > $size[0]) {
    $message = 'Размер файла превышает ' . $size[1];
  }
  else if ( !copy($_FILES['picture']['tmp_name'], $filename) ) {
    echo dirname(__DIR__) . $filename;
    $message = 'В процессе загрузки изображения произошла ошибка';
  }
  else {
    $sql = "INSERT INTO products
              VALUES (NULL, '{$_POST['title']}', '{$_POST['price']}', '{$_POST['info']}', '{$_FILES['picture']['name']}')";
    if (mysqli_query($link, $sql) === TRUE) {
      header('Location: /?page=7');
      exit;
    } else {
      $message = 'Ошибка записи в базу данных' . mysqli_error($link);
    }
  }
}
?>

<h1>Добавить товар</h1>

<form class="form-inline mb-4 " enctype="multipart/form-data" method="POST">
  <div class="row">
    <div class="col-6">
      <div class="input-group mb-1 w-100">
        <div class="input-group-prepend">
          <span class="input-group-text label-w" id="inputTitle">Title</span>
        </div>
        <input name="title" type="text" class="form-control" placeholder="New product title" required="">
      </div>
    </div>
    <div class="col-6">
      <div class="input-group mb-1 w-100">
        <div class="input-group-prepend">
          <span class="input-group-text label-w" id="inputPrice">Price</span>
        </div>
        <input name="price" type="text" class="form-control" placeholder="99.99" required="">
      </div>
    </div>
    <div class="col-12">
      <div class="input-group mb-1 w-100">
        <div class="input-group-prepend">
          <span class="input-group-text label-w" id="inputInfo">Description</span>
        </div>
        <input name="info" type="text" class="form-control" placeholder="99.99">
      </div>
    </div>
    <div class="col-9">
      <div class="input-group mb-1">
        <div class="input-group-prepend">
          <span class="input-group-text label-w">Image</span>
        </div>
        <div class="custom-file">
          <input name="picture" type="file" class="custom-file-input" id="inputFile" required="">
          <label class="custom-file-label" for="inputFile">Choose file</label>
        </div>
      </div>
    </div>
    <div class="col-2">
      <div class="input-group mb-1">
        <button type="submit" class="btn btn-primary mb-2">Загрузить</button>
      </div>
    </div>
    <div class="col-9">
      <div class="input-group mb-1">
        <div class="align-self-center">
          <p class="text-danger"><?php echo $message; ?>

          </p>
        </div>
      </div>
    </div>
  </div>
</form>
