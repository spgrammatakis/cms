<?php
include 'lib/includes/autoload.inc.php';
require 'templates/title.php';
$username = $_COOKIE['user_name'] ?? "guest";
var_dump("USERNAME:".$username);
$session = new lib\SessionManager($username);
$session->sessionCheck();
var_dump($session->getUserRole());
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