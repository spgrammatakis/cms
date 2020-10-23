<?php
namespace lib;
class UserManager extends DbConnection{

    public function __construct(){
        parent::__construct();
    }
    public function getAllUsers()
    {
        $this->prepareStmt("SELECT username, email, created_at, modification_time, is_enabled FROM users");
        $row  = $this->All();
        return $row;
    }
}
?>