<?php


namespace App\services;


class ErrorService
{
  public static function logError(\Exception $e, $file)
  {
    $log = sprintf(
      "%s -- %s Line: %s%s",
      $e->getMessage(),
      $e->getFile(),
      $e->getLine(),
      PHP_EOL);

    $dirname = dirname(__DIR__) . '/tmp/logs/';
    if (!file_exists($dirname)) mkdir($dirname, 0777, true);

    file_put_contents($dirname . $file, $log, FILE_APPEND);
  }
}