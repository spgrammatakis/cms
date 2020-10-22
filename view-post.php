<?php

require __DIR__ . '/vendor/autoload.php';

if ((isset($_GET['post_id']) && is_numeric($_GET['post_id'])))
{
    $postId = $_GET['post_id'];
}
else
{
    $postId = 0;
}
    
$pdo = new lib\PostManager();
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
            <?php echo lib\Utilities::htmlEscape($row[0]['title']) ?>
        </title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    </head>
    <body>
    <?php require 'templates/title.php' ?>
    <?php echo "<div class='post' id='" . $postId."'>"; ?>
        <div>
        <h2>
            <?php
            echo lib\Utilities::htmlEscape($row[0]['title']);
            ?>
        </h2>
        </div>
        <div>
            <?php echo lib\Utilities::convertSqlDate($row[0]['created_at']) ?>
        </div>
        <p>
        <div>
        <?php 
        echo lib\Utilities::htmlEscape($row[0]['body']);
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
                    <?php echo lib\Utilities::htmlEscape($comment['user_name']) ?>
                    on
                    <?php echo lib\Utilities::convertSqlDate($comment['created_at']) ?>
                </div>
                <div class="comment-body">
                    <?php echo lib\Utilities::htmlEscape($comment['content']) ?>
                </div>
                <div class="comment-website">
                    <?php echo lib\Utilities::htmlEscape($comment['website']) ?>
                </div>
        <button class='comment-button'>Edit Comment</button>
        </div>
        <?php endforeach ?>
        </div>
        <?php require 'templates/comment-form.php' ?>
    </body>
</html>