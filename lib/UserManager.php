<?php
namespace lib;
class UserManager extends DbConnection{

    public function __construct(){
        parent::__construct();
    }
    public function getAllUsers($limit = NULL)
    {
        $limit = is_null($limit) ? PHP_INT_MAX : $limit;    
        $this->prepareStmt("SELECT * FROM users LIMIT :limit");
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

    public function reportUser(string $id){
        if(!($this->userCheckIfAlreadyExists($id))){
            return http_response_code(404);
        }
        $sql = "UPDATE users
        SET reported=:reported
        WHERE user_id=:user_id
        "; 
        $this->prepareStmt($sql);
        $this->bind(':reported',1);
        $this->bind(':user_id',$id);
        $this->run();
        return http_response_code(200);
    }
    
    public function userCheckIfAlreadyExists(string $userID){
        $sql = "SELECT user_id FROM users WHERE user_id = :user_id";
        $this->prepareStmt($sql);
        $this->bind(':user_id', $userID);
        $this->run();
        return $this->rowCount() == 1;
    }
}