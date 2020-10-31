<?php
require __DIR__ . '/vendor/autoload.php';
$username = $_COOKIE['user_name'] ?? "guest";
$session = new lib\SessionManager($username);
$session->sessionCheck();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Security-Policy" content="script-src 'self' ;" >
        <title>A blog application</title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
        <script type="text/javascript" src="/js/report-post-comment.js" defer></script>
        <link rel="stylesheet" type="text/css" href="/lib/includes/style.css" type="text/css">
        <!-- <meta http-equiv="refresh" content="5"> -->
    </head>
    <body>
    <a href="/setup.php">Setup</a>  
        <?php
        require 'templates/title.php';
        $postHandler = new lib\PostManager();
        $row = $postHandler->getPosts();
        ?>
<div class="container">
<?php for($p = 0; $p  < count($row); ++$p): ?>
    <?php echo "<section class='post' id='" . $row[$p]['post_id']."'>"; ?>
    <article>
        <header>
            <h1 class="post-title"><?php echo lib\Utilities::htmlEscape($row[$p]['title']);?></h1>
            <p class="post-body"><?php echo lib\Utilities::htmlEscape($row[$p]['body']); ?></p>
            <p><time class="post-date"><?php echo lib\Utilities::convertSqlDate($row[$p]['created_at']); ?></time><p>
            <p><button class='post-report-button'>Report Post</button></p>
        </header>
        <?php
                $comment = $postHandler->getCommentsForPost($row[$p]['post_id']);

                for($c = 0; $c < count($comment); ++$c):
                ?>
        <?php echo "<section class='comment' id='" . $comment[$c]['comment_id']."'>"; ?>
        <h1 class="comments">Comments</h1>  
            <footer id="user-report-footer">
                <p>Posted by: <span><?php echo lib\Utilities::htmlEscape($comment[$c]['user_name']); ?></span>
                <span><button class='user-report-button'>Report User</button></span></p>
                <p><?php echo lib\Utilities::htmlEscape($comment[$c]['content']); ?></p>
                <p><time><?php echo lib\Utilities::htmlEscape($comment[$c]['created_at']);?></time></p>
                <p><?php echo lib\Utilities::htmlEscape($comment[$c]['website']); ?></p>
                <p><button class='comment-report-button'>Report Comment</button></p>
                <?php endfor; ?>
            </footer>
        </section>
        <section>
        <p><?php echo $postHandler->countCommentsForPost($row[$p]['post_id']). " comments"; ?></p>
        <p><?php echo "<a href='/lib/posts/view-post.php?post_id=". lib\Utilities::htmlEscape($row[$p]['post_id']) ."'>Read more...</a>";?></p>
        </section>
    </article>
    </section>
    <?php endfor; ?>
</div>
    </body>
</html>