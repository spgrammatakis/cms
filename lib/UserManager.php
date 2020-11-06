<?php
namespace lib;
class UserManager extends DbConnection{

    public function __construct(){
        parent::__construct();
    }
    public function getAllUsers($limit = NULL)
    {
        $limit = is_null($limit) ? PHP_INT_MAX : $limit;
        $sql = "SELECT * FROM users LIMIT :limit";    
        $this->prepareStmt($sql);
        $this->bind(':limit',$limit);
        $row  = $this->All();
        return $row;
    }

    public function getUserRow(string $userID){
        $sql = "SELECT * FROM users WHERE user_id=:user_id";
        $this->prepareStmt($sql);
        $this->bind(':user_id',$userID);
        return $this->SingleRow();

    }

    public function getUserRoles(){
        $sql = "SELECT user_role FROM users_metadata";
        $this->prepareStmt($sql);
        $row = $this->All();
        return $row;
    }
    
    public function changeUserRole(string $userID,string $userRole){
        $sql = "UPDATE users_metadata SET user_role=:user_role WHERE user_id=:user_id";
        $this->prepareStmt($sql);
        $this->bind(':user_role',$userRole);
        $this->bind(':user_id',$userID);
        return $this->run();
    }

    public function updateUserAndMetadata(array $userData){
        $sql="SELECT username,password FROM users WHERE username=:username";
        $this->prepareStmt($sql);
        $this->bind(':username',$userData['current-username']);
        if($this->rowCount() == 1){
            $userRow = $this->SingleRow();
            $password = $userRow['password'];
            print_r($userRow);
            if(password_verify($userData['current-password'],$password)){
                $sql = "UPDATE users SET username=:username, password=:password, email=:email WHERE user_id=:user_id";
                $this->prepareStmt($sql);
                $this->bind(':user_id',$userData['user-id']);
                $this->bind(':username',$userData['new-username']);
                $this->bind(':password',$userData['new-password']);
                $this->bind(':email',$userData['new-email']);
                if($this->run()){
                    $sql = "UPDATE users_metadata SET username=:username WHERE user_id=:user_id";
                    $this->prepareStmt($sql);
                    $this->bind(':user_id',$userData['user-id']);
                    $this->bind(':username',$userData['new-username']);
                    $this->run();
                    return $this->run();
                }else{
                    return false;
                }    

            }
        }
    }

    public function getUserIDFromName(string $username){
        $sql = "SELECT user_id FROM users WHERE username=:username";
        $this->prepareStmt($sql);
        $this->bind(':username',$username);
        $row = $this->SingleRow();
        return $row['user_id'];
    }

    public function getUserNameFromID(string $id){
        $sql = "SELECT username FROM users WHERE user_id=:user_id";
        $this->prepareStmt($sql);
        $this->bind(':user_id',$id);
        $row = $this->SingleRow();
        return $row['username'];
    }
    

    public function getReportedUsers($limit = NULL){
        $limit = is_null($limit) ? PHP_INT_MAX : $limit;    
        $sql="SELECT * FROM users WHERE reported = 1 LIMIT :limit";
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
        $sql = "UPDATE users SET reported=:reported WHERE user_id=:user_id"; 
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