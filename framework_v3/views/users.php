<?php
/**
 * @var \App\models\User[] $users
 */
?>

<h1>Users</h1>
<?php foreach ($users as $user) : ?>
<p><a href="?c=user&a=one&id=<?= $user->id ?>"><?= $user->fio ?></a></p>
<?php endforeach; ?>

