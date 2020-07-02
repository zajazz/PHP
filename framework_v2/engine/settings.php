<?php
function getSettings($key) {
  return [
    'img_folder' => '/img/',
    'img_size' => [1048576, '1Mb'],
    'admin_actions' => [
      'product' => ['add', 'remove'],
      'order' => ['all', 'changeStatus'],
      'user' => ['all', 'one', 'changeStatus'],
    ],
    'auth_actions' => [
      'order' => ['index', 'one', 'make'],
    ],
    'currency' => '&#8381;',
  ][$key];
}
