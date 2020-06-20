<!DOCTYPE html>
<html>
    <head>
        <title>A blog application</title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    </head>
    <body>
        <?php   require 'lib/functions.php'; 
                require 'templates/title.php';
                $row = getAllPosts();
                ?>

        <?php foreach($row as $row): ?>
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
        <?php endforeach ?>
        <a href="./install.php">Install</a>
    </body>
</html>