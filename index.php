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

try{
    $stmte = $pdo->query(
        'SELECT
            comment_id
        FROM
            comments'
    );

}catch (PDOException $e) {
    exit("Connection failed: " . $e->getMessage());
    die();
}

$notFound = isset($_GET['not-found']);

?>
<!DOCTYPE html>
<html>
    <head>
        <title>A blog application</title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    </head>
    <body>

        <?php require 'templates/title.php' ?>

        <?php if ($notFound): ?>
            <div style="border: 1px solid #ff6666; padding: 6px;">
                Error: cannot find the requested blog post
            </div>
        <?php endif ?>

        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <h2>
                <?php echo htmlEscape($row['title'], ENT_HTML5, 'UTF-8') ?>
            </h2>
            <div>
                <?php echo convertSqlDate($row['created_at']) ?>
                <?php echo countCommentsForPost($row['post_id']) ?> comments
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