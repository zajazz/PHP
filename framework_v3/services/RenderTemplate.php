<?php


namespace App\services;


class RenderTemplate implements IRenderer
{
  public function render($template, $params = [])
  {
    $content = $this->renderTemplate($template, $params);
    return $this->renderTemplate('layouts/main', [
      'content' => $content,
    ]);
  }

  public function renderTemplate($template, $params = [])
  {
    ob_start();
    extract($params);
    include dirname(__DIR__) . '/views/' . $template . '.php';
    return ob_get_clean();
  }
}