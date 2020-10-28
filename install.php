<?php
function installBlog()
{
    
    $pdo = new lib\DbConnection();
    $db = $pdo->getDatabase();
    $sql = file_get_contents($db);
    $pdo->prepareStmt($sql);
    $pdo->run();

    $sql = "SELECT * FROM posts";
    $pdo->prepareStmt($sql);
    $pdo->run();
    $postCount = $pdo->rowCount();
    $sql = "SELECT * FROM comments";
    $pdo->prepareStmt($sql);
    $pdo->run();
    $commentCount = $pdo->rowCount();
    return array($postCount, $commentCount);
}
?>

<html>
    <head>
        <title>Blog installer</title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    </head>
    <body>    
    <div class="create-admin">
    </div>
    <?php?>
            <div class="success-box">
                The database and demo data was created OK.<br>
                <?php installBlog(); ?>
                <?php if (installBlog()[0] and installBlog()[1]): ?>
                    <?php echo "<br>",installBlog()[0] ?> new posts were created.
                    <?php echo "<br>",installBlog()[1] ?> new comments were created.
                <?php endif ?>
            </div>
            <a href="./index.php">Homepage</a>
    </body>
</html>