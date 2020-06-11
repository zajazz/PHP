<h2>Задание 3</h2>
<p><i>Реализовать основные 4 арифметические операции в виде функций с двумя параметрами. Обязательно использовать оператор return.</i></p>

<?php
$a = 3;
$b = 5;

// Сложение
function sum($a, $b) {
    return $a + $b;
}

// Вычитание
function sub($a, $b) {
    return $a - $b;
}

// Умножение
function mult($a, $b) {
    return $a * $b;
}

// Деление
function div($a, $b) {
    return $a / $b;
}

echo "<p>Сумма $a и $b равна " . (sum($a, $b)) . "</p>";
echo "<p>Разность $a и $b равна " . (sub($a, $b)) . "</p>";
echo "<p>Произведение $a и $b равно " . (mult($a, $b)) . "</p>";
echo "<p>Частное от деления $a на $b равно " . (div($a, $b)) . "</p>";

?>
<hr>
<h2>Задание 4</h2>
<p><i>Реализовать функцию с тремя параметрами:
    function mathOperation($arg1, $arg2, $operation),<br>
    где $arg1, $arg2 – значения аргументов,
    $operation – строка с названием операции.</i></p>
<p><i>В зависимости от переданного значения операции выполнить одну из арифметических операций (использовать функции из пункта 3) <br>и вернуть полученное значение (использовать switch).</i></p>

<?php

// function mathOperation($arg1, $arg2, $operation) {
//     switch ($operation) {
//         case 'sum':
//             return sum($arg1, $arg2);
//             break;
//         case 'sub':
//             return sub($arg1, $arg2);
//             break;
//         case 'mult':
//             return mult($arg1, $arg2);
//             break;
//         case 'div':
//             return div($arg1, $arg2);
//             break;
//     }
// }

function mathOperation($arg1, $arg2, $operation) {
  if (!function_exists($operation)) return false;
  return $operation($arg1, $arg2);
}



echo "Сложение: " . mathOperation($a, $b, 'sum') . "<br>";
echo "Вычитание: " . mathOperation($a, $b, 'sub') . "<br>";
echo "Умножение: " . mathOperation($a, $b, 'mult') . "<br>";
echo "Деление: " . mathOperation($a, $b, 'div') . "<br>";

?>