<?php
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
        <script type="text/javascript" src="admin.js" defer></script>
        <link rel="stylesheet" type="text/css" href="/templates/sidenavbar/sidenavbar.css" type="text/css">
        <link rel="stylesheet" type="text/css" href="admin.css" type="text/css">
        <!-- <meta http-equiv="refresh" content="5"> -->
    </head>
    <body>
<?php
require dirname(__DIR__, 1) . '/templates/sidenavbar/sidenavbar.html'; ?>
<div class="content">
<?php $userManager = new lib\UserManager();
$row = $userManager->getAllUsers();
for($i = 0, $size = count($row); $i < $size; ++$i):
?>
<table id="<?php echo $i; ?>" class="user-table-block">
    <tr>
        <th>UserName</th>
        <th>Email</th>
        <th>Created at</th>
        <th>Modification Time</th>
        <th>Is Enabled</th>
    </tr>
    <tr>
        <td class="username"><?php echo lib\Utilities::htmlEscape($row[$i]['username']);?></td>
        <td class="email"><?php echo lib\Utilities::htmlEscape($row[$i]['email']);?></td> 
        <td class="created-at"><?php echo lib\Utilities::htmlEscape($row[$i]['created_at']);?></td>  
        <td class="modificiation-time"><?php echo lib\Utilities::htmlEscape($row[$i]['modification_time']);?></td> 
        <td class="is-enabled"><?php echo lib\Utilities::htmlEscape($row[$i]['is_enabled']);?></td>
    </tr>
    <tr>
        <td class="button"><button class="user-table-edit-button">Edit User</button></td>
    </tr>
</table>
<?php endfor; ?>
<?php   $postHandler = new lib\PostManager();
        $postHandler->getPosts();
?>
<?php //comments ?>
</div>
<footer>
    footer
</footer>
    </body>
</html>