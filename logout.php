<?php
setcookie("session_token", "", time() - 3600);
setcookie("user_name", "", time() - 3600);
header("Content-Security-Policy: default-src 'self'");
header('Location: index.php');
exit;
?>