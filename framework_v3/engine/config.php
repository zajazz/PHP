<?php
return [
  'name' => 'E-shop',
  'defaultController' => 'product',
  'components' => [
    'db' => [
      'class' => \App\services\DB::class,
      'config' => [
        'driver' => 'mysql',
        'host' => 'localhost',
        'dbname' => 'gbphp',
        'charset' => 'UTF8',
        'port' => 3305,
        'user' => 'root',
        'password' => 'root',
      ],
    ],
    'request' => [
      'class' => \App\services\Request::class,
    ],
    'renderer' => [
      'class' => \App\services\TwigRenderer::class,
    ],
    'productRepository' => [
      'class' => \App\repositories\ProductRepository::class,
    ],
    'userRepository' => [
      'class' => \App\repositories\UserRepository::class,
    ],
    'orderRepository' => [
      'class' => \App\repositories\OrderRepository::class,
    ],
    'orderProductRepository' => [
      'class' => \App\repositories\OrderProductRepository::class,
    ],
    'productService' => [
      'class' => \App\services\ProductService::class,
    ],
    'orderService' => [
      'class' => \App\services\OrderService::class,
    ],
    'authService' => [
      'class' => \App\services\AuthService::class,
    ],
    'cartService' => [
      'class' => \App\services\CartService::class,
    ],
    'paginator' => [
      'class' => \App\services\Paginator::class,
    ],
  ],
];
