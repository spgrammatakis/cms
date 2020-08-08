<!DOCTYPE html>
<html>
    <head>
        <title>A blog application</title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <meta http-equiv="refresh" content="5">
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