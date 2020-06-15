<?php

$path = 'img/';
$size = [1048576, '1Мб'];
$message = '';
$style = ' class="text-danger" ';

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  if(stripos($_FILES['picture']['type'], 'image') === false) {
    $message = 'Файл не является изображением';
  }
  else if ($_FILES['picture']['size'] > $size[0]) {
    $message = 'Размер файла превышает ' . $size[1];
  }
  else if ( !@copy($_FILES['picture']['tmp_name'], $path . $_FILES['picture']['name']) )
    $message = 'В процессе загрузки изображения произошла ошибка';
  else {
    $message = 'Изображение загружено';
    $style = ' class="text-success" ';
  }
}


function getClass($type) {
  switch ($type) {
    case 'gallery': return [ 'div' => 'col-6 col-md-4 col-lg-3 mb-3',  'img' => 'img-thumbnail' ];
    case 'modal':   return [ 'div' => 'carousel-item',   'img' => 'd-block w-100' ];
  }
}


function createGallery($path, $type) {
  $imgArr = array_slice(scandir(__DIR__ . "/$path"), 2);
  $html = [];
  $class = getClass($type);

  foreach ($imgArr as $imgName) {
    $img = '<img src="' . $path . $imgName . '" alt="' . $imgName . '" class="' . $class['img'] . '" >';
    if ($type === 'gallery') {
      $img = "<a href=\"#\" data-toggle=\"modal\" data-target=\"#myModal\" data-alt=\"{$imgName}\">{$img}</a>";
    }
    $html[] = "<div class=\"{$class['div']}\">{$img}</div>";
  }
  return implode("\n", $html);
}

?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <title>Photo gallery</title>
  <style>
    .bb {
      border: 1px solid red;
    }
  </style>
</head>
<body>


<!-- MODAL -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" >
  <div class="modal-dialog modal-lg" role="document" >
    <div class="modal-content" >
      <div class="row position-relative">
        <div class="col">

          <button type="button" class="close position-absolute" data-dismiss="modal" aria-label="Close"
                  style="outline: none; z-index: 100; right: 20px;">
            <span aria-hidden="true">&times;</span>
          </button>

          <div id="carouselControls" class="carousel slide w-100 m-1 pr-2"  style="min-height:200px;">
            <div class="carousel-inner">
              <? echo createGallery($path, 'modal'); ?>

            </div>
            <a class="carousel-control-prev" href="#carouselControls" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Предыдущее</span>
            </a>
            <a class="carousel-control-next" href="#carouselControls" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Следующее</span>
            </a>
          </div>

        </div>
      </div>

    </div>
  </div>
</div>


<div class="container">
  <div class="row justify-content-center">

    <h1 class="mt-5">Photo gallery</h1>
    <div class="w-100 m-3"></div>



    <!-- ФОРМА ЗАГРУЗКИ -->
    <form class="form-inline mb-4" enctype="multipart/form-data" method="POST">
      <div class="form-group mx-sm-3 mb-2">
        <input type="file" class="form-control-file" name="picture" >
      </div>
      <button type="submit" class="btn btn-primary mb-2">Загрузить</button>
    </form>


    <div class="w-100"></div>
    <?php
    if ($message) echo "<p $style>$message</p>"
    ?>
    <div class="w-100"></div>


    <!-- ГАЛЕРЕЯ -->
    <div class="row m-3">
      <? echo createGallery($path, 'gallery'); ?>
    </div>
  </div>


  <div class="accordion m-3" id="accordionExample">
    <div class="card">
      <div class="card-header" id="headingOne">
        <h5 class="mb-0">
          <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Задание для фотогалереи
          </button>
        </h5>
      </div>

      <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample" aria-expanded="false">
        <div class="card-body">
          <p>1. Создать галерею фотографий. Она должна состоять всего из одной странички, на которой пользователь видит все картинки в уменьшенном виде и форму для загрузки нового изображения. При клике на фотографию она должна открыться в браузере в новой вкладке. Размер картинок можно ограничивать с помощью свойства width. При загрузке изображения необходимо делать проверку на тип и размер файла.</p>

          <p>2. *Строить фотогалерею, не указывая статичные ссылки к файлам, а просто передавая в функцию построения адрес папки с изображениями. Функция сама должна считать список файлов и построить фотогалерею со ссылками в ней.</p>
          <p>3. *При клике по миниатюре нужно показывать полноразмерное изображение в модальном окне (материал в помощь: http://dontforget.pro/javascript/prostoe-modalnoe-okno-na-jquery-i-css-bez-plaginov/)</p>
        </div>
      </div>
    </div>
  </div>


</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script>
$('#myModal').on('show.bs.modal', function (event) {
  var recipient = $(event.relatedTarget).data('alt');
  $('.carousel-item').filter((idx, item) => {
    $(item).removeClass("active");
    return $(item).find("img").attr("alt") === recipient;
  }).addClass("active");
});
</script>
</body>
</html>

