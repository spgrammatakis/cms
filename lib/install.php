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

    $sql = "SELECT * FROM users";
    $pdo->prepareStmt($sql);
    $pdo->run();
    $userCount = $pdo->rowCount();
    echo "</br>The database and demo data was created OK.</br>";
    echo "<br>" . $postCount . "new posts were created";
    echo "<br>" . $commentCount . "new comments were created";
    echo "<br>" . $userCount . "new users were created";
    
}
installBlog();
?>