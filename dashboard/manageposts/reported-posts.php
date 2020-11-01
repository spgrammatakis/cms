<?php
require dirname(__DIR__, 2) . '/vendor/autoload.php';
$username = $_COOKIE['user_name'] ?? "guest";
$session = new lib\SessionManager($username);
$session->sessionCheck();
if(!($session->getUserRole() === "admin")){
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
        $row = $postHandler->getReportedPosts();
        if(count($row) === 0){
            echo "No Reported Posts";
            exit;
        }
        for($p = 0; $p  < count($row); ++$p):
        ?>
<section class="container">
    <article>
        <header>
        <h1 class="posts">Reported Posts</h1>
            <h1 class="post-title"><?php echo lib\Utilities::htmlEscape($row[$p]['title']);?></h1>
            <p class="post-body"><?php echo lib\Utilities::htmlEscape($row[$p]['body']); ?></p>
            <p><time class="post-date"><?php echo lib\Utilities::convertSqlDate($row[$p]['created_at']); ?></time><p>
        </header>
        <section>
            <h1 class="comments">Comments</h1>
            <footer>
                <?php
                $comment = $postHandler->getCommentsForPost($row[$p]['post_id']);
                for($c = 0; $c < count($comment); ++$c):
                ?>
                <p>Posted by: <span><?php echo lib\Utilities::htmlEscape($comment[$c]['user_name']); ?></span></p>
                <p><?php echo lib\Utilities::htmlEscape($comment[$c]['content']); ?></p>
                <p><time><?php echo lib\Utilities::htmlEscape($comment[$c]['created_at']);?></time></p>
                <p><?php echo lib\Utilities::htmlEscape($comment[$c]['website']); ?></p>
                <p><?php echo $postHandler->countCommentsForPost($row[$p]['post_id']). " comments"; ?></p>
                <?php endfor; ?>
            </footer>
        </section>
        <section>
        <p><?php echo "<a href='/lib/posts/view-post.php?post_id=". lib\Utilities::htmlEscape($row[$p]['post_id']) ."'>Read more...</a>";?></p>
        </section>
    </article>
</section>
        <?php endfor; ?>
    </body>
</html>