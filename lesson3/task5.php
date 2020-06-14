<h3>Задание 5</h3>
<p>Написать функцию, которая заменяет в строке пробелы на подчеркивания и возвращает видоизмененную строчку.</p>
<hr>

<?php
$string = 'Хорошо в любую погоду или Rain It Out.';

function spaceToUnderscore($string) {
  return str_replace(' ', '_', $string);
}

echo spaceToUnderscore($string);
?>
