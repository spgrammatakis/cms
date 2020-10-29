<?php

namespace lib;
use \Datetime;

class Utilities{
    public static function redirectAndExit()
    {
        header('HTTP/1.0 404 Not Found');
        include '/templates/404.php';
        exit;
    }
    
    public static function getSqlDateForNow()
    {
        return date('Y-m-d H:i:s');
    }
    
    public static function htmlEscape($html)
    {
        //return htmlentities($html, ENT_HTML5, 'UTF-8');
        $array = array(
            1 => "<b>",
            2 => "<strong>",
            3 => "<a>",
            4 => "<i>",
            5 => "<u>"
        );
        return strip_tags($html,$array);
    }
    
    public static function convertSqlDate($sqlDate)
    {
        $date = DateTime::createFromFormat('Y-m-d H:i:s', $sqlDate);
        return $date->format('Y-m-d H:i:s');
    }
    
    
    public static function convertNewlinesToParagraphs($text)
    {
        $escaped = Utilities::htmlEscape($text);
        return '<p>' . str_replace("\n", "</p><p>", $escaped) . '</p>';
    }
    
}

?>