<?php

session_start();

error_reporting(E_ALL);
ini_set('display_errors', 'on');
mb_internal_encoding('UTF-8');

$link = include 'db.php';

if (isset($_SESSION['id'])) {
    $user = mysqli_fetch_assoc(mysqli_query($link,"SELECT * FROM `users` WHERE id= '$_SESSION[id]'"));
}
error_reporting(E_ALL);
ini_set('display_errors', 'on');
mb_internal_encoding('UTF-8');

$url = $_SERVER['REQUEST_URI'];

ob_start();
include 'layout.php';
$layout = ob_get_clean();


if (preg_match('#/#', $url, $params)) {
    $page = require 'main.php';

    $layout = str_replace("{{ title }}", 'Main Page', $layout);
}

if (preg_match('#/auth#', $url, $params)) {
    $page = require 'auth.php';

    $layout = str_replace("{{ title }}", 'Auth', $layout);
}

if (preg_match('#/register#', $url, $params)) {
    $page = require 'register.php';

    $layout = str_replace("{{ title }}", 'Register', $layout);
}

if (preg_match('#/logout#', $url, $params)) {
    $page = require 'logout.php';

    $layout = str_replace("{{ title }}", 'Log out', $layout);
}

$layout = str_replace("{{ content }}", $page, $layout);
echo $layout;