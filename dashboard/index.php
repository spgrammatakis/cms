<?php
require dirname(__DIR__, 1) . '/vendor/autoload.php';

$username = $_COOKIE['user_name'] ?? "guest";
$session = new lib\SessionManager($username);
$session->sessionCheck();
if($session->getUserRole() === "guest"){
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
        <link rel="stylesheet" type="text/css" href="/templates/dashboardNavbar/dashboardNavbar.css" type="text/css">
        <link rel="stylesheet" type="text/css" href="/dashboard/dashboard.css" type="text/css">
    </head>
    <body>
<?php
require dirname(__DIR__, 1) . '/templates/dashboardNavbar/dashboardNavbar.html'; ?>
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
                        <th>UserID</th>
                        <th>Username</th>
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
                </table>
                <p class="report"><?php echo "<a href='/lib/users/edit-user.php?user_id=". lib\Utilities::htmlEscape($row[$i]['user_id']) ."'>Edit User</a>";?></p>
                <?php endfor; ?>
                <p><a href='/dashboard/manageusers/all-users.php'>Show All Users</a></p>
                <p><a href='/dashboard/manageusers/reported-users.php'>Show Reported Users</a></p> 
            </section>
            <section id="reported-users">
                <h1 class="reported-users">Reported Users</h1>
                <?php 
                    $reportedUser = $userManager->getReportedUsers(3);
                    for($i = 0; $i < count($reportedUser); ++$i): 
                ?>
                <table id="<?php echo $i; ?>" class="reported-user-table">
                <tr>
                    <th>UserID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Created at</th>
                    <th>Modification Time</th>
                    <th>Reported</th>
                </tr>
                <tr>
                    <td class="username"><?php echo lib\Utilities::htmlEscape($row[$i]['user_id']);?></td>
                    <td class="username"><?php echo lib\Utilities::htmlEscape($row[$i]['username']);?></td>
                    <td class="email"><?php echo lib\Utilities::htmlEscape($row[$i]['email']);?></td> 
                    <td class="created-at"><?php echo lib\Utilities::htmlEscape($row[$i]['created_at']);?></td>  
                    <td class="modificiation-time"><?php echo lib\Utilities::htmlEscape($row[$i]['modification_time']);?></td> 
                    <td class="reported"><?php echo lib\Utilities::htmlEscape($row[$i]['reported']);?></td>
                </tr>
                </table>
                <p class="report"><?php echo "<a href='/lib/users/edit-user.php?user_id=". lib\Utilities::htmlEscape($row[$r]['user_id']) ."'>Edit User</a>";?></p>
                <?php endfor; ?>
                <p><a href='/dashboard/manageusers/reported-users.php'>Show All Reported Users</a></p>
            </section>
    </section>
<section id="all-post-section">
<section id="non-reported-posts-section">
<h1 class="posts">Posts</h1>
<?php
$postHandler = new lib\PostManager();
$postRow = $postHandler->getPosts(3);
for($i = 0; $i < count($postRow); ++$i):
?>
<header>
    <h1 class="post-title"><?php echo lib\Utilities::htmlEscape($postRow[$i]['title']);?></h1>
    <p class="post-body"><?php echo lib\Utilities::htmlEscape($postRow[$i]['body']); ?></p>
    <p><time class="post-date"><?php echo lib\Utilities::convertSqlDate($postRow[$i]['created_at']); ?></time><p>
    <p><?php echo "<a href='/lib/posts/edit-post.php?post_id=". lib\Utilities::htmlEscape($postRow[$i]['post_id']) ."'>Edit Post</a>";?></p>
</header>
    <p><a href='/dashboard/manageposts/all-posts.php'>Show all Posts</a></p>
    <p><a href='/dashboard/manageposts/reported-posts.php'>Show all Reported Posts</a></p>     
<?php endfor; ?>
</section>
<section id="reported-posts">
<h1 class="reported-posts">Reported Posts</h1>
<?php
$postHandler = new lib\PostManager();
$reportedPostRow = $postHandler->getReportedPosts(3);
for($i = 0; $i < count($reportedPostRow); ++$i):
?>
<header>
    <h1 class="post-title"><?php echo lib\Utilities::htmlEscape($reportedPostRow[$i]['title']);?></h1>
    <p class="post-body"><?php echo lib\Utilities::htmlEscape($reportedPostRow[$i]['body']); ?></p>
    <p><time class="post-date"><?php echo lib\Utilities::convertSqlDate($reportedPostRow[$i]['created_at']); ?></time><p>
    <p><?php echo "<a href='/lib/posts/edit-post.php?post_id=". lib\Utilities::htmlEscape($reportedPostRow[$i]['post_id']) ."'>Edit Post</a>";?></p>
</header>     
<?php endfor; ?>
<p><a href='/dashboard/manageposts/reported-posts.php'>Show all Reported Posts</a></p>
</section>
</section>
<section id="all-comments-section">
<section id="comments-section">
<h1 class="non-reported-comments">Comments</h1>
<?php 
    $commentRow = $postHandler->getAllComments(3);
    for($i = 0; $i < count($commentRow); ++$i): 
?>
    <section class="non-reported-comment">
        <p>Posted by: <span><?php echo lib\Utilities::htmlEscape($userManager->getUserNameFromID($commentRow[$i]['user_id'])); ?></span></p>
        <p><?php echo lib\Utilities::htmlEscape($commentRow[$i]['content']); ?></p>
        <p><time><?php echo lib\Utilities::htmlEscape($commentRow[$i]['created_at']);?></time></p>
        <p><?php echo "<a href='/lib/comments/edit-comment.php?comment_id=". lib\Utilities::htmlEscape($commentRow[$i]['comment_id']) ."'>Edit comment</a>";?></p>
    </section>
    <?php endfor; ?>
    <p><a href='/dashboard/managecomments/all-comments.php'>Show All Comments</a></p>
    <p><a href='/dashboard/managecomments/reported-comments.php'>Show All Reported Comments</a></p>
</section>
<section id="reported-comments">
<h1 class="reported-comments">Reported Comments</h1>
<?php 
    $reportedCommentRow = $postHandler->getReportedComments(3);
    for($i = 0; $i < count($reportedCommentRow); ++$i): 
?>
    <section class="comment">
        <p>Posted by: <span><?php echo lib\Utilities::htmlEscape($userManager->getUserNameFromID($reportedCommentRow[$i]['user_id'])); ?></span></p>
        <p><?php echo lib\Utilities::htmlEscape($reportedCommentRow[$i]['content']); ?></p>
        <p><time><?php echo lib\Utilities::htmlEscape($reportedCommentRow[$i]['created_at']);?></time></p>
        <p><?php echo "<a href='/lib/comments/edit-comment.php?comment_id=". lib\Utilities::htmlEscape($reportedCommentRow[$i]['comment_id']) ."'>Edit comment</a>";?></p>
    </section>
    <?php endfor; ?>
    <p><a href='/dashboard/managecomments/reported-comments.php'>Show All Reported Comments</a></p>
</section>
</section>
</section>
    </body>
</html>