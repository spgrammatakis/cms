<?php
require_once 'lib/common.php';
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
$pdo = getPDO();
$row = getPostRow($pdo, $postId);

if (!$row)
{
    echo $postId;
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
    $errors = addCommentToPost(
        $pdo,
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


// Swap carriage returns for paragraph breaks
$bodyText = htmlEscape($row['body']);
$paraText = str_replace("\n", "</p><p>", $bodyText);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>
            A blog application |
            <?php echo htmlEscape($row['title']) ?>
        </title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    </head>
    <body>
    <?php require 'templates/title.php' ?>

        <h2>
            <?php echo htmlEscape($row['title']) ?>
        </h2>
        <div>
            <?php echo convertSqlDate($row['created_at']) ?>
        </div>
        <p>
        <?php echo $paraText ?>
        </p>
        <h3><?php echo countCommentsForPost($postId) ?> comments</h3>
        <?php foreach (getCommentsForPost($postId) as $comment): ?>
            <?php // For now, we'll use a horizontal rule-off to split it up a bit ?>
            <hr />
            <div class="comment">
                <div class="comment-meta">
                    Comment from
                    <?php echo htmlEscape($comment['user_name']) ?>
                    on
                    <?php echo convertSqlDate($comment['created_at']) ?>
                </div>
                <div class="comment-body">
                    <?php echo htmlEscape($comment['content']) ?>
                </div>
                <div class="comment-website">
                    <?php echo htmlEscape($comment['website']) ?>
                </div>
            </div>
        <?php endforeach ?>
        <?php require 'templates/comment-form.php' ?>
    </body>
</html>