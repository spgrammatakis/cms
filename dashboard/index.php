<?php

use lib\SessionManager;
use lib\UserManager; 
require dirname(__DIR__, 1) . '/vendor/autoload.php';
$username = $_COOKIE['user_name'] ?? "guest";
$session = new lib\SessionManager($username);
$session->sessionCheck();
if(!($session->getUserRole() === "admin")){
    header("HTTP/1.1 403 Not Found");
    exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Security-Policy" content="script-src 'self' ;" >
        <title>A blog application</title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <script type="text/javascript" src="/dashboard/dashboard.js" defer></script>
        <link rel="stylesheet" type="text/css" href="/templates/sidenavbar/sidenavbar.css" type="text/css">
        <link rel="stylesheet" type="text/css" href="/dashboard/dashboard.css" type="text/css">
        <!-- <meta http-equiv="refresh" content="5"> -->
    </head>
    <body>
<?php
require dirname(__DIR__, 1) . '/templates/sidenavbar/sidenavbar.html'; ?>
<section class="content">
<section id="all-user-section">
<section id ="user-section">
<h1 class="users">Users</h1>
<?php $userManager = new lib\UserManager();
$row = $userManager->getAllUsers(3);
for($i = 0, $size = count($row); $i < $size; ++$i):
?>
<table id="<?php echo $i; ?>" class="user-table">
    <tr>
        <th>UserName</th>
        <th>UserID</th>
        <th>Email</th>
        <th>Created at</th>
        <th>Modification Time</th>
        <th>Reported</th>
    </tr>
    <tr>
        <td class="user-id"><?php echo lib\Utilities::htmlEscape($row[$i]['user_id']);?></td>
        <td class="username"><?php echo lib\Utilities::htmlEscape($row[$i]['username']);?></td>
        <td class="email"><?php echo lib\Utilities::htmlEscape($row[$i]['email']);?></td> 
        <td class="created-at"><?php echo lib\Utilities::htmlEscape($row[$i]['created_at']);?></td>  
        <td class="modificiation-time"><?php echo lib\Utilities::htmlEscape($row[$i]['modification_time']);?></td> 
        <td class="reported"><?php echo lib\Utilities::htmlEscape($row[$i]['reported']);?></td>
    </tr>
    <tr>
        <td class="button"><button class="user-table-edit-button">Edit User</button></td>
    </tr>
</table>
<?php endfor; ?>
<p><a href='/dashboard/manageusers/all-users.php'>Show All Users</a></p>
<p><a href='/dashboard/manageusers/reported-users.php'>Show Reported Users</a></p> 
</section>
<section id="reported-users">
<h1 class="reported-comments">Reported Users</h1>
<?php 
    $reportedUser = $userManager->getReportedUsers(3);
    for($r = 0; $r < count($reportedUser); ++$r): 
?>
    <table id="<?php echo $i; ?>" class="reported-user-table">
    <tr>
        <th>UserName</th>
        <th>Email</th>
        <th>Created at</th>
        <th>Modification Time</th>
        <th>Reported</th>
    </tr>
    <tr>
        <td class="username"><?php echo lib\Utilities::htmlEscape($row[$r]['username']);?></td>
        <td class="email"><?php echo lib\Utilities::htmlEscape($row[$r]['email']);?></td> 
        <td class="created-at"><?php echo lib\Utilities::htmlEscape($row[$r]['created_at']);?></td>  
        <td class="modificiation-time"><?php echo lib\Utilities::htmlEscape($row[$r]['modification_time']);?></td> 
        <td class="reported"><?php echo lib\Utilities::htmlEscape($row[$r]['reported']);?></td>
    </tr>
    <tr>
        <td class="button"><button class="reported-user-table-edit-button">Edit User</button></td>
    </tr>
</table>
    <?php endfor; ?>
    <p><a href='/dashboard/manageusers/reported-users.php'>Show All Reported Users</a></p>
</section>
    </section>
<section id="post-section"> 
<h1 class="posts">Posts</h1>
<?php
$postHandler = new lib\PostManager();
$row = $postHandler->getPosts(3);
for($p = 0; $p < count($row); ++$p):
?>
<header>
    <h1 class="post-title"><?php echo lib\Utilities::htmlEscape($row[$p]['title']);?></h1>
    <p class="post-body"><?php echo lib\Utilities::htmlEscape($row[$p]['body']); ?></p>
    <p><time class="post-date"><?php echo lib\Utilities::convertSqlDate($row[$p]['created_at']); ?></time><p>
</header>
<section id="post-comments">
    <h1 class="comments">Post Comments</h1>
    <footer>
        <?php
        $comment = $postHandler->getCommentsForPost($row[$p]['post_id'],3);
        for($c = 0; $c < count($comment); ++$c):
        ?>
        <section class="comment">
        <p>Posted by: <span><?php echo lib\Utilities::htmlEscape($comment[$c]['user_name']); ?></span></p>
        <p class="comment-website"> Website: <span><?php echo lib\Utilities::htmlEscape($comment[$c]['website']); ?></span></p>
        <p><?php echo lib\Utilities::htmlEscape($comment[$c]['content']); ?></p>
        <p><time><?php echo lib\Utilities::htmlEscape($comment[$c]['created_at']);?></time></p>
        </section>
        <?php endfor; ?>
        <p><?php echo $postHandler->countCommentsForPost($row[$p]['post_id']). " comments"; ?></p>
        <p><?php echo "<a href='/lib/posts/view-post.php?post_id=". lib\Utilities::htmlEscape($row[$p]['post_id']) ."'>Read more...</a>";?></p>
    </footer>
    <p><a href='/dashboard/manageposts/all-posts.php'>Show all Posts</a></p>
    <p><a href='/dashboard/manageposts/reported-posts.php'>Show all Reported Posts</a></p>     
</section>
<?php endfor; ?>
</section>
<section id="reported-comments">
<h1 class="reported-comments">Reported Comments</h1>
<?php 
    $reportedComment = $postHandler->getReportedComments(3);
    for($r = 0; $r < count($reportedComment); ++$r): 
?>
    <section class="comment">
        <p>Posted by: <span><?php echo lib\Utilities::htmlEscape($comment[$r]['user_name']); ?></span></p>
        <p><?php echo lib\Utilities::htmlEscape($comment[$r]['content']); ?></p>
        <p><time><?php echo lib\Utilities::htmlEscape($comment[$r]['created_at']);?></time></p>
        <p><?php echo lib\Utilities::htmlEscape($comment[$r]['website']); ?></p>
    </section>
    <?php endfor; ?>
    <p><a href='/dashboard/managecomments/reported-comments.php'>Show All Reported Comments</a></p>
</section>
</section>
    </body>
</html>