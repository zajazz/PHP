<?php
/*
4. Используя имеющийся HTML-шаблон, сделать так, чтобы главная страница генерировалась через PHP. Создать блок переменных в начале страницы. Сделать так, чтобы h1, title и текущий год генерировались в блоке контента из созданных переменных.
*/
$h1 = "Заголовок H1";
$title = "Название страницы";
$currentYear = getdate()[year];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
</head>
<body>
    <h1><?php echo $h1; ?></h1>
    <p><?php echo "Год $currentYear"; ?></p>
</body>
</html>