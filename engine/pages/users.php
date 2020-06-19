<?php

$sql = 'SELECT id, fio, login, password, is_admin FROM users';
$result = mysqli_query($link, $sql);

$users = '';
while($row = mysqli_fetch_assoc($result)) {
    $users .= <<<php
    <h2>{$row['fio']}</h2>
    <p><a href="?page=3&id={$row['id']}">Подробнее</a></p>

php;
}
echo '<h1>ПОльзователи </h1>' . $users;
