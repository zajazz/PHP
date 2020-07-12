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


