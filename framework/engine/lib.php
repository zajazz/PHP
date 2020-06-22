<?php
$link = mysqli_connect('localhost', 'root', 'root','gbphp');

/**
 *
 */
function getPage(array $pages)
{
    $pageNumber = 1;
    if (!empty($_GET['page'])) {
        $pageNumber = (int)$_GET['page'];
    }

    if (empty($pages[$pageNumber])) {
        $pageNumber = 1;
    }

    return $pages[$pageNumber];
}

function getId()
{
    if (!empty($_GET['id'])) {
        return (int) $_GET['id'];
    }

    return 0;
}
