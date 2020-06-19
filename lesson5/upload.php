<?php
/**
* Загрузка изображений на сервер
*/

$message = '';
$size = [1048576, '1Мб'];
$style = ' class="text-danger" ';


if ($_POST)
{
  $filename = DIR_IMG . $_FILES['picture']['name'];
  if(stripos($_FILES['picture']['type'], 'image') === false) {
    $message = 'Файл не является изображением';
  }
  else if ($_FILES['picture']['size'] > $size[0]) {
    $message = 'Размер файла превышает ' . $size[1];
  }
  else if ( !@copy($_FILES['picture']['tmp_name'], $filename) )
    $message = 'В процессе загрузки изображения произошла ошибка';
  else {
    $sql = "INSERT INTO images
              VALUES (NULL, '$filename', '{$_POST['author']}', '{$_POST['title']}', {$_FILES['picture']['size']}, 0)";
    if (mysqli_query($db, $sql) === TRUE) {
      $message = 'Изображение загружено';
      $style = ' class="text-success" ';
    } else {
      $message = 'Ошибка записи в базу данных' . mysqli_error($db);
    }
  }
}

$uploadInfo = "<p $style>$message</p>";

?>
