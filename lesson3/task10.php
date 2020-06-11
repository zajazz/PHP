<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Задание 10</title>
  <style type="text/css">
    #grid {
      display: grid;
      grid-template-columns: repeat(10, 2em);
    }
    #grid div {
      padding: .2em;
      background: #dfd;
      border-radius: 5px;
      border: 1px solid #fff;
    }
    #grid div.cap {
      background: #098;
    }
  </style>
</head>
<body>

<h3>*Задание 10</h3>
<p>Создать таблицу умножения используя циклы https://monosnap.com/file/OoWPKG8DVbiMusiCWHVpi7Z7VxesHo</p>
<hr>
<div id="grid">
  <div class='cap'></div>
<?php


for ($i = 2; $i <= 10; $i++) {
  print("<div class='cap'>$i</div>");
}

for ($i = 2; $i <= 10; $i++) {
  print("<div class='cap'>$i</div>");
  for ($j = 2; $j <= 10; $j++) {
    print("<div>" . $i*$j ."</div>");
  }
}

?>

</body>
</html>