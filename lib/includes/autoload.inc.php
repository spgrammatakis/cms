<?php
spl_autoload_register('autoload');

function autoload($className){
    require_once str_replace('\\','/',$className).'.php';
}