<?php

require 'lib/dbconnection.class.php';
require 'lib/postmanager.class.php';
require 'lib/sessionmanager.class.php'; 
// Get the post ID
if ((isset($_GET['post_id']) && is_numeric($_GET['post_id'])))
{
    $postId = $_GET['post_id'];
}
else
{
    $postId = 0;
}

ini_set('display_errors', 1);
ini_set('log_errors', 1);
    
$pdo = new PostManager();
$row = $pdo->getPostRow($postId);
if(!$row){
    header("HTTP/1.0 404 Not Found");
    echo "psofos";
    exit;
}
$commentData = array(
    'user_name' => '',
    'website' => '',
    'content' => '',
);

$errors = null;
if ($_POST && $postId !== 0)
{
    $commentData = array(
        'user_name' => $_POST['comment-name'],
        'website' => $_POST['comment-website'],
        'content' => $_POST['comment-text'],
    );
    $errors = $pdo->addCommentToPost(
        $postId,
        $commentData
    );

    if (!$errors)
    {
        header('Location: ' . $_SERVER['PHP_SELF'] . "?post_id=" . $postId);
        exit;
    }

}

?>
<!DOCTYPE html>
<html>
    <head>
    <meta http-equiv="Content-Security-Policy" content="script-src 'self';">
    <script type="text/javascript" src="./js/get-parent-id.js" defer></script>
        <title>
            A blog application |
            <?php echo $pdo->htmlEscape($row['title']) ?>
        </title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    </head>
    <body>
    <?php require 'templates/title.php' ?>
    <?php echo "<div class='post' id='" . $postId."'>"; ?>
        <div>
        <h2>
            <?php
            echo $pdo->htmlEscape($row['title']);
            ?>
        </h2>
        </div>
        <div>
            <?php echo $pdo->convertSqlDate($row['created_at']) ?>
        </div>
        <p>
        <div>
        <?php 
        echo $pdo->htmlEscape($row['body']);
        ?>
        </div>
        <button class='post-button'>Edit Post</button>
        </p>
        <h3><?php echo $pdo->countCommentsForPost($postId) ?> comments</h3>
        </div>
        <?php foreach ($pdo->getCommentsForPost($postId) as $comment): ?>
        <hr>
        <?php echo "<div class='comment' id='" . $comment['comment_id']."'>"; ?>
                <div class="comment-meta">
                    Comment from
                    <?php echo $pdo->htmlEscape($comment['user_name']) ?>
                    on
                    <?php echo $pdo->convertSqlDate($comment['created_at']) ?>
                </div>
                <div class="comment-body">
                    <?php echo $pdo->htmlEscape($comment['content']) ?>
                </div>
                <div class="comment-website">
                    <?php echo $pdo->htmlEscape($comment['website']) ?>
                </div>
        <button class='comment-button'>Edit Comment</button>
        </div>
        <?php endforeach ?>
        </div>
        <?php require 'templates/comment-form.php' ?>
    </body>
</html>

<!-- ob_start();

echo "Hello World";

$out = ob_get_clean();
$out = strtolower($out); -->