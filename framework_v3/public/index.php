<?php
use App\services\Autoloader;
use App\models\Product;
use App\models\User;

include dirname(__DIR__) . '/services/Autoloader.php';
spl_autoload_register([(new Autoloader()), 'loadClass']);


$user = new User();

var_dump(Product::getAll());
echo "<hr>";
var_dump(Product::getOne(2));

// INSERT
$user->fio = 'Zoja';
$user->login = 'zajazz';
$user->setPassword('123');
//$user->save();
//var_dump($user);
//
//// SELECT ONE
//$user2= $user->getOne(19);
//var_dump($user2);
//// UPDATE
//$user2->fio = 'new fio';
//$user2->save();
//
//// DELETE
//var_dump($product->delete(19));
//
//// SELECT ALL
//echo "<h1>SELECT ALL</h1>>";
//var_dump($user->getAll());
