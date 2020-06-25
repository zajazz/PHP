<?php
/** @var mysqli_result $result
 */
?>

<?php
while($row = mysqli_fetch_assoc($result)) :?>
  <h2><?= $row['fio'] ?></h2>
  <p><a href="?p=user&a=one&id=<?= $row['id'] ?>">Подробнее</a></p>
<?php endwhile;?>
