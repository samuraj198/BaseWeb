<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 'on');
mb_internal_encoding('UTF-8');

$link = include 'db.php';

error_reporting(E_ALL);
ini_set('display_errors', 'on');
mb_internal_encoding('UTF-8');

$url = $_SERVER['REQUEST_URI'];

ob_start();
include 'layout.php';
$layout = ob_get_clean();


if ($url === '/') {
    $page = require 'main.php';

    $layout = str_replace("{{ title }}", 'Main Page', $layout);
}

if ($url === '/auth') {
    $page = require 'auth.php';

    $layout = str_replace("{{ title }}", 'Auth', $layout);
}

if ($url === '/register') {
    $page = require 'register.php';

    $layout = str_replace("{{ title }}", 'Register', $layout);
}

if ($url === '/logout') {
    $page = require 'logout.php';

    $layout = str_replace("{{ title }}", 'Log out', $layout);
}

if ($url === '/profile') {
    $page = require 'profile.php';

    $layout = str_replace("{{ title }}", 'Profile', $layout);
}

if (!isset($page)) {
    $page = require '404.php';

    $layout = str_replace("{{ title }}", 'Page Not Found', $layout);
}

$layout = str_replace("{{ content }}", $page, $layout);
echo $layout;