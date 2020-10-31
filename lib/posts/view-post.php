<?php
require dirname(__DIR__, 2) . '/vendor/autoload.php';
$username = $_COOKIE['user_name'] ?? "guest";
$session = new lib\SessionManager($username);

if ((isset($_GET['post_id'])))
{
    $postId = $_GET['post_id'];
}
else
{
    $postId = 0;
}
ini_set('display_errors', '1');
$pdo = new lib\PostManager();
$row = $pdo->getPostRow($postId);
if(!$row){
    http_response_code(404);
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
    <script type="text/javascript" src="/js/redirect-to-edit.js" defer></script>
    <link rel="stylesheet" type="text/css" href="/lib/includes/style.css" type="text/css">
        <title>
            A blog application |
            <?php echo lib\Utilities::htmlEscape($row['title']) ?>
        </title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    </head>
    <body>
    <?php require dirname(__DIR__, 2).'/templates/title.php' ?>
    <?php echo "<div class='post' id='" . $postId."'>"; ?>
        <div>
        <h2>
            <?php
            echo lib\Utilities::htmlEscape($row['title']);
            ?>
        </h2>
        </div>
        <div>
            <?php echo lib\Utilities::convertSqlDate($row['created_at']) ?>
        </div>
        <p>
        <div>
        <?php 
        echo lib\Utilities::htmlEscape($row['body']);
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
                    <?php echo lib\Utilities::htmlEscape($comment['user_name']); ?>
                    on
                    <?php echo lib\Utilities::convertSqlDate($comment['created_at']); ?>
                </div>
                <div class="comment-body">
                    <?php echo lib\Utilities::htmlEscape($comment['content']); ?>
                </div>
                <div class="comment-website">
                    <?php echo lib\Utilities::htmlEscape($comment['website']); ?>
                </div>
        <button class='comment-button'>Edit Comment</button>
        </div>
        <?php endforeach; ?>
        </div>
        <?php
        $session->sessionCheck();
        if($session->getUserRole() === "guest"){
            echo "<h1>You must be logged in to Comment</h1>";
        }else{
            require dirname(__DIR__, 2).'/templates/comment-form.php';
        }
        ?>
    </body>
</html>