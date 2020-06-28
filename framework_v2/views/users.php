<?php
/** @var mysqli_result $result
 *  @var string $title
 */
?>
<h1 class="h1 mt-5 mb-3"><?= $title ?></h1>
<?php
while($row = mysqli_fetch_assoc($result)) :?>
  <h2><?= $row['fio'] ?></h2>
  <p><a href="?p=user&a=one&id=<?= $row['id'] ?>">Подробнее</a></p>
<?php endwhile;?>
