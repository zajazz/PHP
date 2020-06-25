<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['fio']) || empty($_POST['login']) || empty($_POST['password'])) {
        header('Location: /?page=4');
        exit();
    }

    $fio = $_POST['fio'];
    $login = $_POST['login'];
    $password = $_POST['password'];
    $is_admin = '0';

    $sql = "INSERT INTO
            users
                (fio, login, password, is_admin)
            VALUES
                ('$fio', '$login', '$password', $is_admin)";
    mysqli_query($link, $sql) or die(mysqli_error($link));

    header('Location: /framework/?page=2');
    exit;
}
?>


<form method="post">
    <input type="text" placeholder="fio" name="fio" >
    <input type="text" placeholder="login" name="login">
    <input type="text" placeholder="password" name="password">
    <input type="submit">
</form>