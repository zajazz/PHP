<p>Дополнительно</p>
<p>1* - Создать функцию, которая будет при каждом запросе файла index.php сохранять в файл log.txt данные о времени запроса.</p>
<p>2* - Доработать логирование таким образом, чтобы после каждой 10 записи в файл log.txt, он пересохранялся с новым именем. Например logX.txt (под Х понимаются числа от 0 до бесконечности). А новые записи снова записывались в файл log.txt. Таким образом должен формироваться архив логирований. В каждом файле не более 10 записей.
Подробности в записе урока)</p>
<hr>


<?php
function makeLog() {
  $filename = 'log.txt';

  if (!file_exists($filename)) {
    touch($filename);
  }

  $file = fopen($filename, 'r+');
  $fc = [];
  while ($str = fgets($file)) {
    $fc[] = trim($str);
  }
  ftruncate($file, 0);
  rewind($file);

  if (count($fc) >= 10) {
    // создаём новый файл
    $archive = fopen('log_' . date("Ymd_His") . '.txt', 'w');
    fwrite($archive, implode(PHP_EOL, $fc));
    $fc = [];
    fclose($archive);
  }

  $fc[] = date("Y-m-d H:i:s");
  fwrite($file, implode(PHP_EOL, $fc));
  fclose($file);

}

var_dump(explode(PHP_EOL, file_get_contents('log.txt')));
makeLog();

?>

<?php

// function getArchvieFileNumber() {
//   $fileArr = array_slice(scandir(__DIR__), 2);
//   $fileArr = array_filter($fileArr, function ($val) {
//     return strpos($val, 'log') === 0;
//   });
//   return $fileArr;
// }

?>
