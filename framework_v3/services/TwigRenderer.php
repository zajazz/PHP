<?php

namespace App\services;

use Twig\Environment as TwigEnvironment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
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
    $loader = new TwigFilesystemLoader(dirname(__DIR__) . '/views/');
    $twig = new TwigEnvironment($loader);
    $this->twig = $twig;
  }


  public function render($template, $params = [])
  {
    try {
      $params['cartCount'] = (new CartService())->getCartCount();
      return $this->twig->render($template . '.twig', $params);

    } catch (LoaderError $e) {
      ErrorService::logError($e, 'render.log');
    } catch (RuntimeError $e) {
      ErrorService::logError($e, 'render.log');
    } catch (SyntaxError $e) {
      ErrorService::logError($e, 'render.log');
    }
  }

}