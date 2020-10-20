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
        <meta http-equiv="Content-Security-Policy" content="script-src 'none' ;" >
        <title>A blog application</title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="/lib/includes/sidenavbar.css">
        <!-- <meta http-equiv="refresh" content="5"> -->
    </head>
    <body>
    <nav role="full-horizontal">
    <ul>
    <li><a href="#">Manage Users</a></li>
    <li><a href="#">Manage Posts</a></li>
    <li><a href="#">Manage Comments</a></li>
    <li><a href="#">Homepage</a></li>
    </ul>
    </nav>
<?php
echo "</br>";
$userManager = new lib\UserManager();
$userManager->getAllUsers();
?>
    </body>
</html>