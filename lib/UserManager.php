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

    public function getMostUsersCountry(){
        $this->prepareStmt("SELECT session_tokens FROM users_metadata");
        $row = $this->All();
        print_r($row);
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
        return  $remoteAddress = array_column($unserializedTokens[0],"ra");
        return  $remoteAddress[0];
    }
    
    public function getExpireFromToken($unserializedTokens){
        return $expire = array_column($unserializedTokens[0],"expire");
        return $expire[0];
    
    }
}