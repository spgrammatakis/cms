<?php
/**
 * Blog installer function
 * 
 * @return array(integer postcount, integer commentCount)
 */
function installBlog()
{
    include_once 'lib/common.php';
    $pdo = new Connection();
    $db = $pdo->getDatabase();
    $sql = file_get_contents($db);
    $pdo->prepareStmt($sql);
    $pdo->run();

// See how many rows we created, if any

    $sql = "SELECT * FROM posts";
    $stmt = new Connection();
    $pdo->prepareStmt($sql);
    $postCount = $pdo->rowCount();
    $sql = "SELECT * FROM comments";
    $pdo->prepareStmt($sql);
    $commentCount = $pdo->rowCount();
    return array($postCount, $commentCount);
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Blog installer</title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    </head>
    <body>    
    <div class="create-admin">
    <p><a href="register.php">Create Admin Account</a></p>
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