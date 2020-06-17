<?php
require_once 'lib/dbconnect.php';
require_once 'lib/functions.php';

// Connect to the database, run a query, handle errors
$pdo = new PDO($dsn,$username,$password);
try{
    $stmt = $pdo->query(
        'SELECT
            post_id ,title, created_at, body
        FROM
            posts
        ORDER BY
            created_at DESC'
    );
}catch (PDOException $e) {
    exit("Connection failed: " . $e->getMessage());
    die();
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>A blog application</title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    </head>
    <body>

        <?php require 'templates/title.php' ?>
        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <h2>
                <?php echo htmlEscape($row['title'], ENT_HTML5, 'UTF-8') ?>
            </h2>
            <div>
                <?php echo $row['created_at'] ?>
            </div>
            <p>
                <?php echo htmlEscape($row['body'])?>
            </p>
            <p>
                <a href="view-post.php?post_id=<?php echo $row['post_id'] ?>">Read more...</a>
            </p>
        <?php endwhile ?>

    </body>
</html>