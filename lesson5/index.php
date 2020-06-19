<?php


define('DIR_IMG', 'img/');

/**
* Подключение в БД
*/
require_once 'dbconnect.php';
$db = db();


/**
* Загружает изображение на сервер и в БД,
* формирует ответ в $uploadInfo
*/
@include 'upload.php';


/**
* Формирует разметку галереи
* @return string - HTML-код галереи
*/
function createGallery() {
  $sql = "SELECT id, filename, title, count FROM images ORDER BY count DESC";
  $result = mysqli_query(db(), $sql);
  $template = file_get_contents('templates/thumbnail.html');
  $html = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $html[] = str_replace([ '{{ID}}', '{{SRC}}', '{{DESC}}', '{{COUNT}}' ],
                          [ $row['id'], $row['filename'], $row['title'], $row['count'] ], $template);
  }
  return implode("\n", $html);
}


$html = file_get_contents('templates/gallery.html');
$html = str_replace(['{{FORM_INFO}}', '{{GALLERY}}'], [$uploadInfo, createGallery()], $html);


echo $html;


?>
