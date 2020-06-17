<?php
// Work out the path to the database, so SQLite/PDO can connect
/* $root = __DIR__;
$database = $root . '/data/data.sqlite'; */
$dsn = 'mysql:dbname=cms;host:127.0.0.1';
$username = "admin";
$password = "admin";


// Connect to the database, run a query, handle errors
$pdo = new PDO($dsn,$username,$password);
try{
    $stmt = $pdo->query(
        'SELECT
            title, created_at, body
        FROM
            posts
        ORDER BY
            created_at DESC'
    );
} catch (PDOException $e) {
    exit("Connection failed: " . $e->getMessage());
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>A blog application</title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    </head>
    <body>
        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <h2>
                <?php echo htmlspecialchars($row['title'], ENT_HTML5, 'UTF-8') ?>
            </h2>
            <div>
                <?php echo $row['created_at'] ?>
            </div>
            <p>
                <?php echo htmlspecialchars($row['body'], ENT_HTML5, 'UTF-8') ?>
            </p>
            <p>
                <a href="#">Read more...</a>
            </p>
        <?php endwhile ?>

    </body>
</html>