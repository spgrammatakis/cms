<?php

if(!(isset($_COOKIE["user_name"]))){
    setcookie("user_name", "admin", [
        "expires" => mktime(0, 0, 0, date("m"),   date("d"),   date("Y")+1),
        "path" => '/',
        "domain" => "",
        "secure" => false,
        "httponly" => true,
        "samesite" => "Strict"]);
}
    setcookie("session_token", bin2hex(random_bytes(20)), [
        "expires" => mktime(0, 0, 0, date("m"),   date("d"),   date("Y")+1),
        "path" => '/',
        "domain" => "",
        "secure" => false,
        "httponly" => true,
        "samesite" => "Strict"]);
        include 'lib/includes/autoload.inc.php';
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
        $session = new lib\SessionManager();
        $session->sessionCheck();
        $postHandler->getPosts();
        ?>
        <a href="./install.php">Install</a>
        
    </body>
</html>