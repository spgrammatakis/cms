<?php
include 'lib/includes/autoload.inc.php';
require 'templates/title.php';
$session = new lib\SessionManager();
$session->sessionCheck();
$arr = array(1, 2, 3, 4);
foreach ($arr as $value) {
    $value = $arr;
    echo $value;
break;
}
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