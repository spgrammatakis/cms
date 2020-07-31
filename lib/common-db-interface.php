<?php

interface Common_DB_Interface{
public function prepareStmt($query);
public function bind($param, $value, $type=null);
public function run();
}
?>