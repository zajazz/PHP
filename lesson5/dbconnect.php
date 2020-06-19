<?php
/**
* Осуществляет подключение в БД
* @return mysqli - объект БД
*/
function db() {
  static $db;
  if (!$db) {
    $db = mysqli_connect('localhost', 'root', 'root', 'gallery');
    if (mysqli_connect_errno()) {
        echo "Не удалось подключиться к MySQL: " . mysqli_connect_error();
    }
  }
  return $db;
}
?>