<?php

function redirectAndExit($script)
{
    header('HTTP/1.0 404 Not Found');
    include '../templates/404.php';
    exit;
}

function getSqlDateForNow()
{
    return date('Y-m-d H:i:s');
}

?>