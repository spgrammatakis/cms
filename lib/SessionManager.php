<?php

namespace lib;

class SessionManager extends DbConnection{

    private $userID;
    private $userName;  
    private $userRole;
    

    public function __construct(){
        parent::__construct();
    }

    public function sessionCheck(){
        if(!isset($_COOKIE['user_name']) || empty($_COOKIE['user_name'])){
            $this->setCookiesParams();
            return; 
        }
        $this->userName = $_COOKIE['user_name'];
        echo "</br> this username </br>";
        if($this->userName = "guest"){
            echo "DO GUEST WORK";
            return;
        }
        $user_name = $this->getUserName();
        $_COOKIE['user_name'] = $this->getUserName();
        $username = $_COOKIE['user_name'];
        $sql = "SELECT user_id FROM users WHERE username = :username";
        $this->prepareStmt($sql);
        $this->bind(':username', $_COOKIE['user_name']);
        if($this->run()){  
            echo "</br>PRINT R</br>"; 
            print_r($this->All());
            echo "</br>AFTER RUN</br>";           
                $row = $this->SingleRow();
                echo "row user id in session check";
                var_dump($row['user_id']);  
                $this->userID = $row['user_id'];
                $this->setUserID($row['user_id']);
                if($this->sessionCheckIfAlreadyExists($this->getUserID())){
                    $this->updateUserMetaData($this->getUserID());
                }else{
                    $this->sessionInsertNewRow($this->getUserID());
                } 
        }

    }

    private function setUserID($id){
        $this->userID = $id;
        return;
    }

    public function getUserID(){
        return $this->userID;
    }

    private function setCookieUserName(){
        $sql = "SELECT users.username 
        FROM users 
        INNER JOIN users_metadata ON users_metadata.user_id = users.user_id 
        WHERE users.user_id = :user_id";
        $this->prepareStmt($sql);
        echo "inside set cookie user name";
        var_dump($this->getUserID());
        $this->bind(':user_id', $this->getUserID());
        $row['user_name'] = $this->run();
        $this->userName = $row['user_name'];
        return;
    }

    private function setCookiesParams(){
        if(!isset($_COOKIE["user_name"])){
            setcookie("user_name", "guest", [
                "expires" => mktime(0, 0, 0, date("m"),   date("d"),   date("Y")+1),
                "path" => '/',
                "domain" => "",
                "secure" => false,
                "httponly" => true,
                "samesite" => "Strict"]);
            }
        if(!isset($_COOKIE["session_token"])){    
            setcookie("session_token", bin2hex(random_bytes(20)), [
            "expires" => mktime(0, 0, 0, date("m"),   date("d"),   date("Y")+1),
            "path" => '/',
            "domain" => "",
            "secure" => false,
            "httponly" => true,
            "samesite" => "Strict"]);
        }
        return;
    }

    public function getUserName(){
        return $this->userName;
    }

    private function setUserRole($userRole){
        $this->userRole = $userRole;
        return;
    }

    public function getUserRole(){
        if(!isset($_COOKIE['user_name']) || $_COOKIE['user_name'] == "guest") return "guest";
        echo "</br>get user id is before</br>";
        var_dump($this->getUserID());
        $sql = "SELECT user_role FROM users_metadata WHERE user_id = :user_id";
        $this->prepareStmt($sql);
        $this->bind(':user_id', $this->getUserID());
        $this->run();
        $row = $this->SingleRow();
        echo "</br>get user id is after</br>";
        var_dump($this->getUserID());
        echo "</br>single row is</br>";
        var_dump($row);
        $this->setUserRole($row['user_role']);
        $this->setCookieUserName();
        return $this->userRole;
    }

    public function redirectUser($userRole){
        if($userRole === "admin"){
            $_COOKIE['user_name'] = $this->getUserName();
            echo "redirecting to admin";
            return;
        }elseif($userRole === "author"){
            $_COOKIE['user_name'] = $this->getUserName();
            echo "redirecting to author";
            return;
        }else{
            echo "redirecting to guest";
            return;
        }
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