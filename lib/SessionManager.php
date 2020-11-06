<?php
namespace lib;
class SessionManager extends DbConnection{
    
    protected string $userID;
    protected string $userName;
    protected string $userRole;

    public function __construct(string $userName){
        parent::__construct();
        $this->userName = $userName;    
    }

    public function setUserName(string $name){
        $this->userName = $name;
        return;
    }

    public function setUserID(string $id){
        $this->userID = $id;
        return;
    }

    public function getUserID(){
        return $this->userID;
    }

    
    public function getUserName(){
        return $this->userName;
    }

    public function getUserRole(){
        return $this->userRole;
    }

    public function setUserRole(string $userRole){
        $this->userRole = $userRole;
        return;
    }

    public function sessionCheck(){
        $this->setCookiesParams();
        $sql = "SELECT user_id,user_role FROM users_metadata WHERE username = :username";
        $this->prepareStmt($sql);
        $this->bind(':username',  $this->getUserName());
        if($this->run()){    
                $row =$this->SingleRow() ? $this->SingleRow():array('user_id'=>"guest");
                if($row['user_id'] === "guest"){
                $this->setUserRole("guest");
                $this->setUserID("guest");
                }else{
                $this->setUserRole($row['user_role']);
                $this->setUserID($row['user_id']);
                };             
                if($this->sessionCheckIfAlreadyExists($this->userID)){
                    $this->updateUserMetaData($this->userID);
                }else{
                    $this->sessionInsertNewRow($this->userID);
                } 
        }
    }

    public function getUserPrivileges(string $userRole){
        $sql =" SELECT user_privileges  FROM users_options WHERE user_role=:user_role";
        $this->prepareStmt($sql);
        $this->bind(':user_role',$userRole);
        return $this->SingleRow();
    }

    private function setCookiesParams(){
        if( !isset($_COOKIE['user_name'])   
            || empty($_COOKIE['user_name'])    
            || $this->getUserName() === "guest"){
            setcookie("user_name", "guest", [
                "expires" => strtotime("+1 year"),
                "path" => '/',
                "domain" => "",
                "secure" => false,
                "httponly" => true,
                "samesite" => "Strict"]);
            }
        if(!isset($_COOKIE['session_token']) 
        || empty($_COOKIE['session_token']) 
        || $this->getUserName() === "guest"){    
            setcookie("session_token", bin2hex(random_bytes(20)), [
            "expires" => strtotime("+1 year"),
            "path" => '/',
            "domain" => "",
            "secure" => false,
            "httponly" => true,
            "samesite" => "Strict"]);
        }
        return;
        $expireTime = $this->getExpireFromToken(($this->getCurrentSessionToken($this->getUserID())));
        if(time() < $expireTime[0]){
            $this->setCookiesParams();
            return;
        }
    }

    public function redirectUser($userRole){
        if($userRole === "admin"){
            header('Location: /dashboard/');
            return;
        }elseif($userRole === "author"){
            echo "redirecting to author";
            return;
        }else{
            header('Location: /index.php');
             return;
        }
    }

    public function sessionCheckIfAlreadyExists(string $userID){
        if(!isset($_COOKIE["user_name"]) || empty($_COOKIE['user_name'])) return false;
        $sql = "SELECT user_id FROM users_metadata WHERE user_id = :user_id";
        $this->prepareStmt($sql);
        $this->bind(':user_id', $userID);
        $this->run();
        return $this->rowCount() == 1;
    }
    
    public function sesssionCreateNewToken(){
            return array(array(bin2hex(random_bytes(20))=>
            array(        "ra"=>$_SERVER['REMOTE_ADDR'],
                          "ua"=>$_SERVER['HTTP_USER_AGENT'],
                          "iat"=>Utilities::getSqlDateForNow(),
                          "expire"=>mktime(0, 0, 0, date("m"),   date("d"),   date("Y")+1)
                      )));    
    }   

    public function sessionInsertNewRow(string $userID){
        $tokensToInsert = serialize($this->sesssionCreateNewToken());
        $sql="INSERT INTO users_metadata(user_id,username,session_tokens,user_role,expire_at)
        VALUES (:user_id,:username,:session_tokens,:user_role,:expire_at)";
        $this->prepareStmt($sql);
        $this->bind(':user_id',$this->userID);
        $this->bind(':username',$this->userName);
        $this->bind(':session_tokens',$tokensToInsert);
        $this->bind(':user_role',$this->userRole);
        $this->bind(':expire_at',date('Y-m-d H:i:s', strtotime('+1 year')));
        $this->run();
        return;
    }
    
    public function updateUserMetaData(string $userID){
        if(!isset($userID) || empty($userID)) {return false;}
        $expireTime = $this->getExpireFromToken(($this->getCurrentSessionToken($this->getUserID())));
        if(time() < $expireTime[0]){
        return false;
        }
        $tokensToAppend = $this->sesssionCreateNewToken();  
        $userRole = $this->userRole;
        $sessionTokenFromDB[] = $this->getCurrentSessionToken($userID);
        $tokensToAppend = array_merge($tokensToAppend,$sessionTokenFromDB[0]) ?? $tokensToAppend;
        $serializedTokens = serialize($tokensToAppend);
        $sql="
        UPDATE users_metadata
        SET session_tokens = '$serializedTokens', user_role = '$userRole'
        WHERE user_id =  '$userID'"; 
        $this->prepareStmt($sql);
        return $this->run();
    }
    
    public function getCurrentSessionToken(string $userID){
        if(!isset($_COOKIE["user_name"]) || empty($_COOKIE['user_name'])) {return false;}
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
?>