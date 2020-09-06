<?php
require 'lib/common.php';
// Get the post ID
if (isset($_GET['post_id']) AND is_numeric($_GET['post_id']))
{
    $postId = $_GET['post_id'];
}
else
{
    $postId = 0;
}
$pdo = new Connection();
$row = $pdo->getPostRow($postId);

$errors = null;
if ($_POST)
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
    // If there are no errors, redirect back to self and redisplay
    if (!$errors)
    {
        redirectAndExit('view-post.php?post_id=' . $postId);
    }
}else
{
    $commentData = array(
        'user_name' => '',
        'website' => '',
        'content' => '',
    );
}
//    script-src 'sha256-dZ9mgGecmXBGZ6+nu6onHRqp0s0CQ2YhnxzHEzsfLv4=';
?>
<!DOCTYPE html>
<html>
    <head>
    <meta http-equiv="Content-Security-Policy" content="script-src 'self';">
    
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
            <?php echo $pdo->htmlEscape($row['title']) ?>
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
    <script type="text/javascript" src="./js/get-parent-id.js"></script>
</html>