<?php
/**
 * @var App\services\Paginator $paginator
 */
?>

<h1 class="h1 mt-5 mb-3">Users</h1>

<?php foreach ($paginator->getUrls() as $page => $url) : ?>
  <a href="<?= $url ?>"><?= $page ?></a>
<?php endforeach; ?>
<hr>
<?php foreach ($paginator->getItems() as $user) : ?>
<p><a href="?c=user&a=one&id=<?= $user->id ?>"><?= $user->fio ?></a></p>
<?php endforeach; ?>


