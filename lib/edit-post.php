<?php
require 'common.php';
// Get the post ID
if (isset($_GET['post_id']))
{
    $postId = $_GET['post_id'];
}
else
{
    // So we always have a post ID var defined
    $postId = 0;
}

// Connect to the database, run a query, handle errors
$pdo = new Connection();
$row = $pdo->getPostRow($postId);

if (!$row)
{
    redirectAndExit('index.php?not-found=1');
}

?>
<!DOCTYPE html>
<html>
    <head>
    <script type="text/javascript" src="../js/get-parent-id.js"></script>
        <title>
            A blog application |
            <?php echo $pdo->htmlEscape($row['title']) ?>
        </title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    </head>
    <body>
    <a href="../index.php"><h1>Homepage</h1></a>
    <?php echo "<div class='post' id='" . $postId."'>"; ?>
        <h2>
            <?php echo $pdo->htmlEscape($row['title']) ?>
        </h2>
        </div>
        <div>
            <?php echo $pdo->convertSqlDate($row['created_at']) ?>
        </div>
        <p>
        <div>
        <?php 
        $bodyText = $pdo->htmlEscape($row['body']);
        $paraText = str_replace("\n", "</p><p>", $bodyText);              
        echo $paraText;
        require '../templates/post-edit-form.php'; 
        ?>
        </div>
        </p>
    </body>
</html>