<h2>Задание 6</h2>
*С помощью рекурсии организовать функцию возведения числа в степень. Формат: function power($val, $pow), где $val – заданное число, $pow – степень.

<?php
$a = 2;
$b = -3;

function power($val, $pow) {
    if ($pow == 0) return 1;
    if ($pow == 1) return $val;
    if ($pow < 0) return 1.0 / power($val, -1 * $pow);
    return $val * power($val, $pow - 1);
}

function powerVar2($val, $pow) {
    if ($pow === 0) return 1;
    $pow--;
    $result = powerVar2($val, $pow) * $val;
    return $result;
}

echo "<p>$a<sup>$b</sup> = " . power($a, $b) . "</p>";
?>

