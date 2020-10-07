<?php

namespace lib;

class SessionManager extends DbConnection{

    private $userID;

    public function __construct(){
        parent::__construct();
    }

    public function sessionCheck(){
        if(!isset($_COOKIE["user_name"]) || empty($_COOKIE['user_name'])) return false; 
        $username = $_COOKIE["user_name"];
        $sql = "SELECT user_id FROM users WHERE username = :username";
        $this->prepareStmt($sql);
        $this->bind(':username', $username);
        if(($this->run())&&($this->rowCount() == 1)){              
                $row = $this->SingleRow();
                $userID = $row['user_id'];
                if($this->sessionCheckIfAlreadyExists($userID)){
                    echo "</br>updating";
                    $this->updateUserMetaData($userID);
                }else{
                    echo "</br>new row";
                    $this->sessionInsertNewRow($userID);
                } 
        }

    }

    public function getUserID(){
        return $userID;
    }

    public function getUserRole(){
        $sql = "SELECT user_role FROM users_metadata WHERE user_id = :user_id";
        $this->prepareStmt($sql);
        $this->bind(':user_id', $userID);
        $this->run();
        return $this->SingleRow();
    }

    public function sessionCheckIfAlreadyExists($userID){
        if(!isset($_COOKIE["user_name"]) || empty($_COOKIE['user_name'])) return false;
        $sql = "SELECT user_id FROM users_metadata WHERE user_id = :user_id";
        $this->prepareStmt($sql);
        $this->bind(':user_id', $userID);
        $this->run();
        return $this->rowCount() == 1;
    }
    
    
    public function updateUserMetaData($userID){
        if(!isset($userID) || empty($userID)) return false;
        $tokensToAppend = $this->sesssionCreateNewToken();  
        $sessionTokenFromDB[] = $this->sessionGetCurrentSessionToken($userID);
        $tokensToAppend = array_merge($tokensToAppend,$sessionTokenFromDB[0]);
        $serializedTokens = serialize($tokensToAppend);
        $sql="
        UPDATE users_metadata
        SET session_tokens = '$serializedTokens'
        WHERE user_id = " . $userID;
        $this->prepareStmt($sql);
        return $this->run();
    }
    
    public function sessionGetCurrentSessionToken($userID){
        if(!isset($_COOKIE["user_name"]) || empty($_COOKIE['user_name'])) return false;
        $sql = "SELECT session_tokens FROM users_metadata WHERE user_id = :user_id";
        $this->prepareStmt($sql);
        $this->bind(':user_id', $userID);
        $this->run();
        $serializedTokens = $this->SingleRow();
        $unserializedTokens =  unserialize($serializedTokens['session_tokens']);
        echo $this->sessionExtractInitiatedAtFromToken($unserializedTokens);
        return unserialize($serializedTokens['session_tokens']);
    }
    
    public function sessionExtractInitiatedAtFromToken($unserializedTokens){
        $initiatedAt = array_column($unserializedTokens[0],"iat");
        return  $initiatedAt[0];
    }
    
    public function sessionExtractUserAgentFromToken($unserializedTokens){
        $userAgent = array_column($unserializedTokens[0],"ua");
        return  $userAgent[0];
    }
    
    public function sessionExtractRemoteAddressFromToken($unserializedTokens){
        return  $remoteAddress = array_column($unserializedTokens[0],"ra");
        return  $remoteAddress[0];
    }
    
    public function sessionExtractExpireFromToken($unserializedTokens){
        return $initiatedAt = array_column($unserializedTokens[0],"iat");
        return $expire[0];
    
    }
    
    public function sessionInsertNewRow($userID){
        $tokensToInsert = serialize($this->sesssionCreateNewToken());   
        $sql = "
        INSERT INTO
        users_metadata
        (user_id, session_tokens)
        VALUES(:user_id, :session_tokens)
        ";
        $this->prepareStmt($sql);
        $this->bind(':user_id',$userID);
        $this->bind(':session_tokens',$tokensToInsert);
        $this->run();
    }
    
    public function sesssionCreateNewToken(){
        return  array(array($_COOKIE["session_token"]=>
                      array(        "ra"=>$_SERVER['REMOTE_ADDR'],
                                    "ua"=>$_SERVER['HTTP_USER_AGENT'],
                                    "iat"=>time(),
                                    "expire"=>time() + (365 * 24 * 60 * 60)
                                ))); 
    }
}
?>