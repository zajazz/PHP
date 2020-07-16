<?php
/**
 * @var \App\models\User[] $users
 */
?>

<h1 class="h1 mt-5 mb-3">Users</h1>
<?php foreach ($users as $user) : ?>
<p><a href="?c=user&a=one&id=<?= $user->id ?>"><?= $user->fio ?></a></p>
<?php endforeach; ?>

