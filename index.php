<?php
include 'lib/includes/autoload.inc.php';
require 'templates/title.php';
$session = new lib\SessionManager();
$username = $_COOKIE['user_name'] || null;
print_r($_COOKIE);
$session->sessionCheck($username);
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
        <a href="./install.php">Install</a>
        
    </body>
</html>