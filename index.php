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
        $conn = new Connection();
        $conn->prepareStmt("SELECT * FROM posts");
        $row  = $conn->All();
        ?>
        
        <?php foreach($row as $row): ?>
            <h2>
                <?php echo $conn->htmlEscape($row['title']) ?>
            </h2>
            <div>
                <?php echo $conn->convertSqlDate($row['created_at']) ?>
                <?php echo $conn->countCommentsForPost($row['post_id']) ?> comments
            </div>
            <p>
                <?php echo $conn->htmlEscape($row['body'])?>
            </p>
            <p>
                <a href="view-post.php?post_id=<?php echo $conn->htmlEscape($row['post_id']) ?>">Read more...</a>
            </p>
        <?php endforeach ?>
        <a href="./install.php">Install</a>
    </body>
</html>