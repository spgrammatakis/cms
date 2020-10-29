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
        <script type="text/javascript" src="/dashboard/admin.js" defer></script>
        <link rel="stylesheet" type="text/css" href="/templates/sidenavbar/sidenavbar.css" type="text/css">
        <link rel="stylesheet" type="text/css" href="/dashboard/admin.css" type="text/css">
        <!-- <meta http-equiv="refresh" content="5"> -->
    </head>
    <body>
<?php require dirname(__DIR__, 1) . '/templates/sidenavbar/sidenavbar.html'; ?>
<?php print_r($_GET);?>
<footer>
    footer
</footer>
    </body>
</html>