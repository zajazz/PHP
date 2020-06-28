<?php
/** @var array $comments
 */
?>
<h2>Отзывы</h2>
<?php foreach($comments as $comment) :?>
  <div class="card mb-2">
    <div class="card-body">
      <?= $comment['text'] ?>
    </div>
  </div>
<?php endforeach;?>
