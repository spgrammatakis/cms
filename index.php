<?php
if(isset($_COOKIE["user_name"])){
    echo $_COOKIE["user_name"];
}else{
    echo $_SERVER['HTTP_HOST'];
    setcookie("user_name", "spyros", time()+ 60,'/', $_SERVER['HTTP_HOST'], false, true);
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
        require 'lib/common.php'; 
        require 'templates/title.php';
        $pdo = new Connection();
        $pdo->getPosts();
        ?>
        <a href="./install.php">Install</a>
        
    </body>
</html>