<?php
require __DIR__ . '/vendor/autoload.php';
$username = $_COOKIE['user_name'] ?? "guest";
$session = new lib\SessionManager($username);
$session->sessionCheck();
$date_formated = date('Y-m-d H:i:s', mktime(date("Y"),   date("m"),   date("d")));
var_dump($date_formated);
$date_formated = date('Y-m-d H:i:s',mktime(date("d"), date("m"), date("Y")));
var_dump($date_formated);
var_dump(date('Y-m-d H:i:s',mktime()));
date('Y-m-d H:i:s', strtotime('+1 year'));
require 'templates/title.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Security-Policy" content="script-src 'none' ;" >
        <title>A blog application</title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <!-- <meta http-equiv="refresh" content="5"> -->
    </head>
    <body>
        <?php
        $postHandler = new lib\PostManager();
        $postHandler->getPosts();
        ?>
        <a href="./setup.php">Setup</a>
        
    </body>
</html>