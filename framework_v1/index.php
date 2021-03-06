<?php
require_once __DIR__ . '/engine/lib.php';

$pages = include __DIR__ . '/config/pagesConfig.php';
$page = getPage($pages);

ob_start();
include __DIR__ . '/pages/' . $page;
$content = ob_get_clean();

$html = file_get_contents(__DIR__ . '/templates/main.html');

echo str_replace(
    ['{{CONTENT}}'],
    [$content],
    $html
);

// var_dump($page);