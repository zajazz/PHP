<?php
include dirname(__DIR__) . '/services/Autoloader.php';
use App\services\Autoloader;
spl_autoload_register([(new Autoloader()), 'loadClass']);


$db = new App\services\DB();

$order = new App\models\Order($db);
$comment = new App\models\Comment($db);
$user = new App\models\User($db);
$product = new App\models\Product($db);

echo $order->getAll() . '<br>';
echo $comment->getOne(2) . '<br>';
echo $user->getAll() . '<br>';
echo $product->getOne(1);
