<?php

if (!$_GET['id']) {
  header('Location: /lesson5');
  exit;
}

/**
* Подключение в БД
*/
require_once 'dbconnect.php';
$db = db();
$id = (int)$_GET['id'];


$sql = "SELECT filename, author, title, count FROM images WHERE id = $id";
$result = mysqli_query($db, $sql);


$card = '<p class="text-danger">Изображение не найдено.</p>
         <a href="gallery.php" class="card-link">Вернуться в галерею</a>';
$img = '';
$row = mysqli_fetch_assoc($result);

if ($row) {
  $count = $row['count'] + 1;
  $sql = "UPDATE images SET count = $count WHERE id = $id";
  mysqli_query($db, $sql);

  // {{IMG}}
  $img = "<img src=\"{$row['filename']}\" alt=\"{$row['title']}\" class=\"img-thumbnail\">";

  // {{CARD}}
  $template = file_get_contents('templates/card.html');
  $card = str_replace([ '{{DESC}}', '{{AUTHOR}}', '{{COUNT}}' ],
                      [$row['title'], $row['author'], $count ], $template);
}


$html = file_get_contents('templates/single.html');
$html = str_replace(['{{IMG}}', '{{CARD}}'], [$img, $card], $html);

echo $html;

