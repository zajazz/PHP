<?php
$menuData = [
    'Главная' => [
        'href' => '#linkГлавная',
    ],
    'Новости' => [
        'href' => '#linkНовости',
        "extra" => [
            'Спорт' => [
                'href' => '#linkСпорт',
                "extra" => [
                    'Футбол' => [
                        'href' => '#linkФутбол',
                    ],
                    'Гандбол' => [
                        'href' => '#linkГандбол',
                    ],
                    'Гонки' => [
                        'href' => '#linkГонки',
                        "extra" => [
                            'Автогонки' => [
                                'href' => '#linkАвтогонки',
                            ],
                            'Мотогонки' => [
                                'href' => '#linkМотогонки',
                                "extra" => [
                                    'Купить Билет' => [
                                        'href' => '#linkКупитьБилет',
                                    ],
                                    'Купить Мотоцикл' => [
                                        'href' => '#linkКупитьМотоцикл',
                                    ]
                                ]
                            ]
                        ]
                    ],
                ]
            ],
        ]
    ],
    'Контакты' => [
        'href' => '#linkКонтакты',
    ],
    'ДопИнформация' => [
        'href' => '#linkДопИнформация',
    ],
];

function getMenu($menuData)
{
    $menuItems = '';
    foreach($menuData as $textLink => $data) {
        $menuItem = "<a href=\"{$data['href']}\">$textLink</a>";
        if (!empty($data['extra'])) {
            $menuItem .= getMenu($data['extra']);
        }
        $menuItems .= "<li>{$menuItem}</li>";
    };

    return "<ul>{$menuItems}</ul>";
}

$menu = getMenu($menuData);

echo <<<php
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    {$menu}
</body>
</html>
php;


