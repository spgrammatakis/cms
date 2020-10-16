<?php
require __DIR__ . '/vendor/autoload.php';
$username = $_COOKIE['user_name'] ?? "guest";
$session = new lib\SessionManager($username);
$session->sessionCheck();
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