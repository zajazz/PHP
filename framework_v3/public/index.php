<?php
use App\services\Autoloader;
use App\models\Product;
use App\models\User;

include dirname(__DIR__) . '/services/Autoloader.php';
spl_autoload_register([(new Autoloader()), 'loadClass']);


$user = new User();
$product = new Product();

// INSERT
$user->fio = 'my fio';
$user->login = 'my login';
$user->setPassword('123');
var_dump($user->save());

// SELECT ONE
$user2= $user->getOne(19);
// UPDATE
$user2->fio = 'new fio';
$user2->save();

// DELETE
var_dump($product->delete(20));

// SELECT ALL
var_dump($user->getAll());
