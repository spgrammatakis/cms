<?php
require dirname(__DIR__, 2) . '/vendor/autoload.php';
$username = $_COOKIE['user_name'] ?? "guest";
$session = new lib\SessionManager($username);
$session->sessionCheck();
if($session->getUserRole() === "guest"){
    http_response_code(403);
    exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Security-Policy" content="script-src 'self' ;" >
        <title>A blog application</title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="/templates/dashboardNavbar/dashboardNavbar.css" type="text/css">
        <link rel="stylesheet" type="text/css" href="/dashboard/dashboard.css" type="text/css">
    </head>
    <body>
<?php require dirname(__DIR__, 2) . '/templates/dashboardNavbar/dashboardNavbar.html'; ?>
<?php
        $postHandler = new lib\PostManager();
        $postRow = $postHandler->getPosts();
        for($p = 0; $p  < count($postRow); ++$p):
        ?>
<div class="container">
    <article>
        <header>
            <h1 class="post-title"><?php echo lib\Utilities::htmlEscape($postRow[$p]['title']);?></h1>
            <p class="post-body"><?php echo lib\Utilities::htmlEscape($postRow[$p]['body']); ?></p>
            <p><time class="post-date"><?php echo lib\Utilities::convertSqlDate($postRow[$p]['created_at']); ?></time><p>
        </header>
        <section>
            <h1 class="comments">Comments</h1>
            <footer>
                <?php
                $commentRow = $postHandler->getCommentsForPost($postRow[$p]['post_id']);
                $userHandler = new lib\UserManager();
                for($c = 0; $c < count($commentRow); ++$c):
                ?>
                <p>Posted by: <span><?php echo lib\Utilities::htmlEscape($userHandler->getUserNameFromID($commentRow[$c]['user_id'])); ?></span></p>
                <p><?php echo lib\Utilities::htmlEscape($commentRow[$c]['content']); ?></p>
                <p><time><?php echo lib\Utilities::htmlEscape($commentRow[$c]['created_at']);?></time></p>
                <p><?php echo lib\Utilities::htmlEscape($commentRow[$c]['website']); ?></p>
                <p><?php echo $postHandler->countCommentsForPost($postRow[$p]['post_id']). " comments"; ?></p>
                <button class="user-edit-button">Edit User</button>
                <?php endfor; ?>
            </footer>
        </section>
        <section>
        <p><?php echo "<a href='/lib/posts/view-post.php?post_id=". lib\Utilities::htmlEscape($postRow[$p]['post_id']) ."'>Read more...</a>";?></p>
        </section>
    </article>
</div>
        <?php endfor; ?>
    </body>
</html>