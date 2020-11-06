<?php
require dirname(__DIR__, 2) . '/vendor/autoload.php';
$username = $_COOKIE['user_name'] ?? "guest";
$session = new lib\SessionManager($username);
$session->sessionCheck();
if ((isset($_GET['post_id'])))
{
    $postId = $_GET['post_id'];
}
else
{
    http_response_code(403);
    exit;
}

$pdo = new lib\PostManager();
$postRow = $pdo->getPostRow($postId);
$userHandler = new lib\UserManager();
if(!$postRow){
    http_response_code(404);
    exit;
}

$errors = null;

if ($_POST)
{
    $commentData = array(
        'user_id' => $session->getUserID(),
        'content' => $_POST['comment-text'],
    );
    
    $errors = $pdo->addCommentToPost($postId,$commentData); 
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
    <link rel="stylesheet" type="text/css" href="/templates/navbar/navbar.css" type="text/css">
        <title>
            A blog application |
            <?php echo lib\Utilities::htmlEscape($postRow['title']) ?>
        </title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    </head>
    <body>
    <?php require dirname(__DIR__, 2).'/templates/navbar/navbar.html' ?>
    <?php echo "<div class='post' id='" . $postId."'>"; ?>
        <div>
        <h2>
            <?php
            echo lib\Utilities::htmlEscape($postRow['title']);
            ?>
        </h2>
        </div>
        <div>
            <?php echo lib\Utilities::convertSqlDate($postRow['created_at']) ?>
        </div>
        <p>
        <div>
        <?php 
        echo lib\Utilities::htmlEscape($postRow['body']);
        ?>
        </div>
        <button class='post-button'>Edit Post</button>
        </p>
        <h3><?php echo $pdo->countCommentsForPost($postId) ?> comments</h3>
        </div>
        <?php foreach ($pdo->getCommentsForPost($postId) as $commentRow): ?>
        <hr>
        <?php echo "<div class='comment' id='" . $commentRow['comment_id']."'>"; ?>
                <div class="comment-meta">
                    Comment from
                    <?php echo lib\Utilities::htmlEscape($userHandler->getUserNameFromID($commentRow['user_id'])); ?>
                    on
                    <?php echo lib\Utilities::convertSqlDate($commentRow['created_at']); ?>
                </div>
                <div class="comment-body">
                    <?php echo lib\Utilities::htmlEscape($commentRow['content']); ?>
                </div>
        <button class='comment-button'>Edit Comment</button>
        </div>
        <?php endforeach; ?>
        </div>
        <?php
        if($session->getUserRole() === "guest"){
            echo "<h1>You must be logged in to Comment</h1>";
        }else{
            echo "<h3>Add your comment</h3>";
            require dirname(__DIR__, 2).'/templates/comment-form.php';
        }
        ?>
    </body>
</html>