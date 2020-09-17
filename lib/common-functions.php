<?php

function redirectAndExit($script)
{

    $relativeUrl = $_SERVER['PHP_SELF'];
    $urlFolder = substr($relativeUrl, 0, strrpos($relativeUrl, '/') + 1);
    $host = $_SERVER['HTTP_HOST'];
    $fullUrl = 'http://' . $host . $urlFolder . $script;
    header('Location: ' . $fullUrl);
    exit();
}

function getSqlDateForNow()
{
    return date('Y-m-d H:i:s');
}

function login($username)
{
    session_regenerate_id();
    $_SESSION['logged_in_username'] = $username;
}
?>