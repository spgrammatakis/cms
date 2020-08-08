<?php
require 'lib/common.php';
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
$dbh = new Connection();
$row = $dbh->getPostRow($postId);

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
    $errors = $dbh->addCommentToPost(
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

?>
<!DOCTYPE html>
<html>
    <head>
    <script type="text/javascript" src="./js/get-parent-id.js"></script>
        <title>
            A blog application |
            <?php echo $dbh->htmlEscape($row['title']) ?>
        </title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    </head>
    <body>
    <?php require 'templates/title.php' ?>
        <h2>
            <?php echo $dbh->htmlEscape($row['title']) ?>
        </h2>
        <div>
            <?php echo $dbh->convertSqlDate($row['created_at']) ?>
        </div>
        <p>
        <?php 
        $bodyText = $dbh->htmlEscape($row['body']);
        $paraText = str_replace("\n", "</p><p>", $bodyText);              
        echo $paraText 
        ?>
        <button id='btn' onClick="redirectToEditPost(this)">Edit Post</button>
        </p>
        <?php  ?>
        <h3><?php echo $dbh->countCommentsForPost($postId) ?> comments</h3>
        <?php foreach ($dbh->getCommentsForPost($postId) as $comment): ?>
            <hr style='border: 5px solid red;'>
        <?php echo "<div class='comment' id='" . $comment['comment_id']."'>"; ?>
                <div class="comment-meta">
                    Comment from
                    <?php echo $dbh->htmlEscape($comment['user_name']) ?>
                    on
                    <?php echo $dbh->convertSqlDate($comment['created_at']) ?>
                </div>
                <div class="comment-body">
                    <?php echo $dbh->htmlEscape($comment['content']) ?>
                </div>
                <div class="comment-website">
                    <?php echo $dbh->htmlEscape($comment['website']) ?>
                </div>
        <button id='btn' onClick="redirectToEditComment(this)">Edit Comment</button>
        </div>
        <?php endforeach ?>
        </div>
        <?php require 'templates/comment-form.php' ?>
    </body>
</html>