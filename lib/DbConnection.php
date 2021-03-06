<?php

namespace lib;
use \PDO;


class DbConnection{
private $host = "127.0.0.1";
private $dbName = "cms";
private $username = "admin";
private $password = "admin";
private $charset = 'utf8';

protected $dbh;
protected $error;
protected $stmt;

public function __construct(){
    $dsn     = "mysql:host=" . $this->host . ";dbname=" . $this->dbName . ";charset=" . $this->charset;  
    $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => true
    );
try{
	$this->dbh = new \PDO($dsn, $this->username, $this->password, $options);
}
catch(\PDOException $e)
{
    $this->error = $e->getMessage();
    echo "Connection failed: " . $e->getMessage();
	die();
 }

}

public function prepareStmt($query){
    $this->stmt = $this->dbh->prepare($query);
}

public function bind($param, $value, $type=null){
    if (is_null($type)) {
        switch (true) {
            case is_int($value):
                $type = PDO::PARAM_INT;
                break;
            case is_bool($value):
                $type = PDO::PARAM_BOOL;
                break;  
            case is_null($value):
                $type = PDO::PARAM_NULL;
                break;
            default:
                $type = PDO::PARAM_STR;
        }
    }
    $this->stmt->bindValue($param, $value, $type);
}

public function run()
{   
    return $this->stmt->execute();

}

public function runArray($data)
{   
    return $this->stmt->execute($data);
}

public function All(){
    $this->run();
    return $this->stmt->fetchall();
}

public function fetchCollumn(){
    $this->run();
    return $this->stmt->fetchall(PDO::FETCH_COLUMN);
}

public function rowCount(){
    $this->run();
    return $this->stmt->rowCount();
}

public function SingleRow(){
    $this->run();
    return $this->stmt->fetch();
    } 

public function getDatabase():string{
    return dirname(__DIR__, 1).'/data/init.sql';
}

}
?>