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

    public function getUserRow(string $username){
        $this->prepareStmt("SELECT * FROM users WHERE username=:username");
        $this->bind(':username',$username);
        return $this->SingleRow();

    }

    public function getUserRoles(){
        $this->prepareStmt("SELECT user_role FROM users_metadata");
        $row = $this->All();
        return $row;
    }
    
    public function updateUser(array $userData){
        print_r($userData);
        $sql = "
        UPDATE users
        SET username=:username, password=:password, email=:email
        WHERE user_id=:user_id
        ";
        $this->prepareStmt($sql);
        $this->bind(':user_id',$userData['user_id']);
        $this->bind(':username',$userData['username']);
        $this->bind(':password',$userData['password']);
        $this->bind(':email',$userData['email']);
        return $this->run();
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

    public function userNameCheckIfAlreadyExists(string $username){
            $sql = "SELECT username FROM users WHERE username = :username";
            $this->prepareStmt($sql);
            $this->bind(':username', $username);
            $this->run();
            return $this->rowCount() == 1;
    }

    public function userEmailCheckIfAlreadyExists(string $email){
        $sql = "SELECT email FROM users WHERE email = :email";
        $this->prepareStmt($sql);
        $this->bind(':email', $email);
        $this->run();
        return $this->rowCount() == 1;
    }

    public function reportUser(string $id){
        if(!($this->userIDCheckIfAlreadyExists($id))){
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
    
    public function userIDCheckIfAlreadyExists(string $userID){
        $sql = "SELECT user_id FROM users WHERE user_id = :user_id";
        $this->prepareStmt($sql);
        $this->bind(':user_id', $userID);
        $this->run();
        return $this->rowCount() == 1;
    }
}