<?php
namespace App\services;

class Autoloader
{
  public function loadClass($className)
  {
    $file = str_replace('App', '', $className);
    $file = dirname(__DIR__) . str_replace('\\', DIRECTORY_SEPARATOR, $file) . '.php';

    if (is_file($file)) {
      include $file;
    }
  }
}