<?php

$task = '<h2>Задание 5</h2>
<p>Посмотреть на встроенные функции PHP.
Используя имеющийся HTML шаблон, вывести текущий год в подвале при помощи встроенных функций PHP.</p>';

$year = date('Y');

$html = file_get_contents('template.html');

$html = str_replace(['{{CONTENT}}', '{{FOOTER}}'], [$task, $year], $html);

echo $html;

?>
