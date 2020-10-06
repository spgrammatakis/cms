<?php
spl_autoload_register('autoload');

function autoload($className){
    $path = "lib/";
    $extention = ".class.php";
    $fullPath = $path . $className . $extention;
    require_once $fullPath;
}