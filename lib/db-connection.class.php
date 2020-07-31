<?php
class Db_Connection{
    private $host = "127.0.0.1";
    private $dbName = "cms";
    private $username = "admin";
    private $password = "admin";
    private $charset = 'utf8';
    
    private $pdo;
    private $error;
    private $stmt;
    
    public function __construct(){
        $pdo     = "mysql:host=" . $this->host . ";dbname=" . $this->dbName . ";charset=" . $this->charset;  
        $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => true    
        );
    try{
        $this->pdo = new PDO($dsn, $this->username, $this->password, $options);
    }
    catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
   }
    
    }//EOF CONSTRUCTOR   
}