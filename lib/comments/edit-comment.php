<?php
require dirname(__DIR__, 2) . '/vendor/autoload.php';
$username = $_COOKIE['user_name'] ?? "guest";
$session = new lib\SessionManager($username);
$session->sessionCheck();
if($session->getUserRole() === "guest"){
    http_response_code(403);
    exit;
}

if (isset($_GET['comment_id']))
{
    $commentID = $_GET['comment_id'];
}
else
{
    http_response_code(403);
    exit;
}
$pdo = new lib\PostManager();
$errors=null;
if($_POST){
    $commentData = array(
        "comment-id" => $commentID,
        "comment-website" => $_POST['comment-website'],
        "comment-text" => $_POST['comment-text']
    );
    $errors=$pdo->updateComment($commentData);
    if (!$errors)
    {
        header('Location: ' . $_SERVER['PHP_SELF'] . "?comment_id=" . $commentID);
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Security-Policy" content="script-src 'self' ;" >
        <title>A blog application</title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="/templates/sidenavbar/sidenavbar.css" type="text/css">
        <link rel="stylesheet" type="text/css" href="/dashboard/dashboard.css" type="text/css">
    </head>
    <body>
<?php require dirname(__DIR__, 2) . '/templates/sidenavbar/sidenavbar.html'; ?>
<section class="container">
<section id ="user-section">
<?php $comment = new lib\PostManager();
$row = $comment->getUserComments($username);
for($c = 0, $size = count($row); $c < $size; ++$c):
?>
<section class="container">
        <section>
            <h1 class="comments">Comments</h1>
                <p>Posted by: <span><?php echo lib\Utilities::htmlEscape($row[$c]['user_name']); ?></span></p>
                <p><?php echo lib\Utilities::htmlEscape($row[$c]['content']); ?></p>
                <p><time><?php echo lib\Utilities::htmlEscape($row[$c]['created_at']);?></time></p>
                <p><?php echo lib\Utilities::htmlEscape($row[$c]['website']); ?></p>
        </section>
        <section>
        <p><?php echo "<a href='/lib/posts/view-post.php?post_id=". lib\Utilities::htmlEscape($row[$c]['post_id']) ."'>Read more...</a>";?></p>
        </section>
</section>
        <?php endfor; ?>
<?php require dirname(__DIR__, 2).'/templates/comment-form.php'; ?>
</section>
    </body>
</html>