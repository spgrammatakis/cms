<?php
spl_autoload_register('autoload');

function autoload($className){
    var_dump($className);
    var_dump(file_exists(__DIR__.$className));
    require_once str_replace('\\','/',$className).'.php';
}