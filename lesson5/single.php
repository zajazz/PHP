<?php
if (!$_GET['id']) {
  header('Location: /lesson5');
  exit;
}
$id = (int)$_GET['id'];


/**
* Подключение в БД
*/
require_once 'dbconnect.php';
$db = db();


$sql = "SELECT filename, author, title, count FROM images WHERE id = $id";
$result = mysqli_query($db, $sql);


$card = '<div class="d-flex flex-column align-items-center">
        <p class="text-danger">Изображение не найдено.</p>
        <a href="gallery.php" class="card-link">Вернуться в галерею</a>
        </div>';
$img = '';
$row = mysqli_fetch_assoc($result);

if ($row) {
  // {{COUNT}}
  $count = $row['count'] + 1;
  mysqli_query($db, "UPDATE images SET count = count + 1 WHERE id = $id");

  $title = ($row['title'] == '') ? 'Без названия' : $row['title'];
  $author = ($row['author'] == '') ? 'Автор неизвестен' : '&copy; ' . $row['author'];

  // {{IMG}}
  $img = "<img src=\"{$row['filename']}\" alt=\"{$title}\" class=\"img-thumbnail\">";

  // {{CARD}}
  $template = file_get_contents('templates/card.html');
  $card = str_replace([ '{{DESC}}', '{{AUTHOR}}', '{{COUNT}}' ],
                      [$title, $author, $count ], $template);
}


$html = file_get_contents('templates/single.html');
$html = str_replace(['{{IMG}}', '{{CARD}}'], [$img, $card], $html);

echo $html;
