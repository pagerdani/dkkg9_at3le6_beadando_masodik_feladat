<?php
define('SERVER_ROOT', $_SERVER['DOCUMENT_ROOT'].'/feladat2/');
define('SITE_ROOT', 'http://localhost/feladat2/');

define('DB_CREDENTIALS', [
    'host'     => 'localhost',
    'dbname'   => 'feladat2',
    'username' => 'root',
    'password' => ''
]);

require_once(SERVER_ROOT . 'controllers/' . 'router.php');
?>