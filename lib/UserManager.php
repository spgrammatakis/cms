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

    public function getCurrentSessionToken(string $userID){
        if(!isset($_COOKIE["user_name"]) || empty($_COOKIE['user_name'])) return false;
        $sql = "SELECT session_tokens FROM users_metadata WHERE user_id = :user_id";
        $this->prepareStmt($sql);
        $this->bind(':user_id', $userID);
        $this->run();
        $serializedTokens = $this->SingleRow();
        $unserializedTokens =  unserialize($serializedTokens['session_tokens']);
        return unserialize($serializedTokens['session_tokens']);
    }
    
    public function getInitiatedAtFromToken($unserializedTokens){
        $initiatedAt = array_column($unserializedTokens[0],"iat");
        return  $initiatedAt[0];
    }
    
    public function getUserAgentFromToken($unserializedTokens){
        $userAgent = array_column($unserializedTokens[0],"ua");
        return  $userAgent[0];
    }
    
    public function getRemoteAddressFromToken($unserializedTokens){
        $remoteAddress = array_column($unserializedTokens[0],"ra");
        return  $remoteAddress[0];
    }
    
    public function getExpireFromToken($unserializedTokens){
        $expire = array_column($unserializedTokens[0],"expire");
        return $expire[0];
    
    }
}