<?php
namespace lib;
class UserManager extends DbConnection{

    public function __construct(){
        parent::__construct();
    }
    public function getAllUsers($limit = NULL)
    {
        $limit = is_null($limit) ? PHP_INT_MAX : $limit;    
        $this->prepareStmt("SELECT username, email, created_at, modification_time, reported FROM users LIMIT :limit");
        $this->bind(':limit',$limit);
        $row  = $this->All();
        return $row;
    }

    public function getUserRoles(){
        $this->prepareStmt("SELECT user_role FROM users_metadata");
        $row = $this->All();
        return $row;
    }

    public function getReportedUsers($limit = NULL){
        $limit = is_null($limit) ? PHP_INT_MAX : $limit;    
        $sql="SELECT
                *
            FROM
                users
            WHERE
                reported = TRUE
            LIMIT
                :limit";
        $this->prepareStmt($sql);
        $this->bind(":limit",$limit);
        return $this->All();
    }
}