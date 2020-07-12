<?php
use App\services\Autoloader;
use App\services\DB;
use App\models\Product;
use App\models\User;

include dirname(__DIR__) . '/services/Autoloader.php';
spl_autoload_register([(new Autoloader()), 'loadClass']);


$product = new Product();

var_dump($product->getOne(2));
var_dump($product->getAll());


