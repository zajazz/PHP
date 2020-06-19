<?php
$sql = 'SELECT id, fio, login, password, is_admin FROM users WHERE id = ' . getId();
$result = mysqli_query($link, $sql);

$row = mysqli_fetch_assoc($result);
$user = <<<php
    <h2>{$row['fio']}</h2>
    <h2>{$row['login']}</h2>
php;

echo '<h1>ПОльзователь </h1>' . $user;
