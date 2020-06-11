<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>Document</title>
</head>
<body>
  <h3>*Задание 8</h3>
<p>Повторить третье задание, но вывести на экран только города, начинающиеся с буквы «К».</p>
<hr>

<?php

$cities = [
  'Московская область' => [
    'Москва',
    'Зеленоград',
    'Клин',
  ],
  'Ленинградская область' => [
    'Санкт-Петербург',
    'Всеволожск',
    'Павловск',
    'Кронштадт',
    'Кингисепп'
  ],
  'Приморский край' => [
    'Владивосток',
    'Находка',
    'Уссурийск',
    'Артём',
    'Арсеньев',
  ],
];



foreach ($cities as $key => $value) {
  echo "<p><b>$key</b><br>";
  foreach ($value as $i => $city) {
    if (mb_substr($city, 0, 1) == 'К') {
      echo "$city";
      if ($i !== count($value)-1) echo ", ";
    }
    else echo "</p>";
  }
}

?>
</body>
</html>