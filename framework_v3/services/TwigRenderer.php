<?php


namespace App\services;


class TwigRenderer implements IRenderer
{
  /**
   * @var \Twig\Environment
   */
  protected $twig;

  public function render($template, $params = [ ])
  {
    // TODO: Implement render() method.
    return $this->twig->render($template, $params);
  }
}