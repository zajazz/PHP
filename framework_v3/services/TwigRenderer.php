<?php

namespace App\services;

use Twig\Environment as TwigEnvironment;
use Twig\Loader\FileSystemLoader as TwigFileSystemLoader;

class TwigRenderer implements IRenderer
{
  /**
   * @var TwigEnvironment
   */
  protected $twig;

  /**
   * TwigRenderer constructor.
   */
  public function __construct()
  {
    $loader = new TwigFilesystemLoader(dirname(__DIR__). '/views/');
    $twig = new TwigEnvironment($loader);
    $this->twig = $twig;
  }


  public function render($template, $params = [ ])
  {
    return $this->twig->render($template . '.twig', $params);
  }
}