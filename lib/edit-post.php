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
$errors = null;
if ($_POST)
{
    $commentData = array(
        'user_name' => $_POST['comment-name'],
        'website' => $_POST['comment-website'],
        'content' => $_POST['comment-text'],
    );
    $errors = $pdo->updatePost(
        $postId,
        $commentData
    );
    // If there are no errors, redirect back to self and redisplay
    if (!$errors)
    {
        redirectAndExit('edit-post.php?post_id=' . $postId);
    }
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
        <h3><?php echo $pdo->countCommentsForPost($postId) ?> comments</h3>
        </div>
        <?php foreach ($pdo->getCommentsForPost($postId) as $comment): ?>
            <hr style='border: 5px solid red;'>
        <?php echo "<div class='comment' id='" . $comment['comment_id']."'>"; ?>
        <?php //require '' ?>
        </div>
        <?php endforeach ?>
        </div>
    </body>
</html>