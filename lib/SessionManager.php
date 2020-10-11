<?php
namespace lib;
class SessionManager extends DbConnection{
    
    protected $userID;
    protected $userName;
    protected $userRole;

    public function __construct($userName){
        parent::__construct();
        $this->userName = $userName;    
    }

    public function setUserName($name){
        $this->userName = $name;
        return;
    }

    public function setUserID($id){
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
        $sql = "SELECT user_role FROM users_metadata WHERE user_id = :user_id";
        $this->prepareStmt($sql);
        $this->bind(':user_id', $this->userID);
        $this->run();
        $row = $this->SingleRow() ? $this->SingleRow() : array('user_role'=>"guest");
        $this->userRole = $row['user_role'] ?? "guest";
        var_dump($this->userRole());
        $this->setCookieUserName();
        return;
    }

    public function checkIfUserRoleExists(){

    }

    public function sessionCheck(){
        $this->setCookiesParams();
        $sql = "SELECT user_id FROM users WHERE username = :username";
        $this->prepareStmt($sql);
        $this->bind(':username',  $this->getUserName());
        if($this->run()){    
                $row =$this->SingleRow() ? $this->SingleRow():array('user_id'=>0);
                $this->setUserID($row['user_id']);
                var_dump($this->userID);
                if($this->sessionCheckIfAlreadyExists($this->userID)){
                    $this->updateUserMetaData($this->userID);
                }else{
                    $this->sessionInsertNewRow($this->userID);
                } 
        }

    }

    private function setCookieUserName(){
        $sql = "SELECT users.username 
        FROM users 
        INNER JOIN users_metadata ON users_metadata.user_id = users.user_id 
        WHERE users.user_id = :user_id";
        $this->prepareStmt($sql);
        $this->bind(':user_id', $this->userID);
        $row['user_name'] = $this->run();
        $this->userName = $row['user_name'];
        return;
    }

    private function setCookiesParams(){
        if(!isset($_COOKIE['user_name']) || empty($_COOKIE['user_name'])|| $this->getUserName() === "guest"){
            setcookie("user_name", "guest", [
                "expires" => mktime(0, 0, 0, date("m"),   date("d"),   date("Y")+1),
                "path" => '/',
                "domain" => "",
                "secure" => false,
                "httponly" => true,
                "samesite" => "Strict"]);
            }
        if(!isset($_COOKIE['session_token']) || empty($_COOKIE['session_token']) || $this->getUserName() === "guest"){    
            setcookie("session_token", bin2hex(random_bytes(20)), [
            "expires" => mktime(0, 0, 0, date("m"),   date("d"),   date("Y")+1),
            "path" => '/',
            "domain" => "",
            "secure" => false,
            "httponly" => true,
            "samesite" => "Strict"]);
        }
        return;
        if(time() > $this->getExpireFromToken(($this->getCurrentSessionToken($this->getUserID())))){
            setCookiesParams();
            return;
        }
    }

    public function redirectUser($userRole){
        if($userRole === "admin"){
            echo "redirecting to admin";
            return;
        }elseif($userRole === "author"){
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
    
    public function sesssionCreateNewToken(){
        if(!isset($_COOKIE['session_token']) || empty($_COOKIE['session_token'])){
            return array(array(bin2hex(random_bytes(20))=>
            array(        "ra"=>$_SERVER['REMOTE_ADDR'],
                          "ua"=>$_SERVER['HTTP_USER_AGENT'],
                          "iat"=>time(),
                          "expire"=>mktime(0, 0, 0, date("m"),   date("d"),   date("Y")+1)
                      ))); 
}   
        return  array(array($_COOKIE["session_token"]=>
                      array(        "ra"=>$_SERVER['REMOTE_ADDR'],
                                    "ua"=>$_SERVER['HTTP_USER_AGENT'],
                                    "iat"=>time(),
                                    "expire"=>mktime(0, 0, 0, date("m"),   date("d"),   date("Y")+1)
                                ))); 
    }   

    public function sessionInsertNewRow($userID){
        $tokensToInsert = serialize($this->sesssionCreateNewToken());   
        $sql="INSERT INTO users_metadata(user_id,username,session_tokens,user_role,expire_at)
        VALUES (:user_id,:username,:session_tokens,:user_role,:expire_at)";
        $this->prepareStmt($sql);
        $this->bind(':user_id',$this->userID);
        $this->bind(':username',$this->userName);
        $this->bind(':session_tokens',$tokensToInsert);
        $this->bind(':user_role',$this->userRole);
        $this->bind(':expire_at',mktime(0, 0, 0, date("m"),   date("d"),   date("Y")+1));
        $this->run();
    }
    
    public function updateUserMetaData($userID){
        if(!isset($userID) || empty($userID)) return false;
        $tokensToAppend = $this->sesssionCreateNewToken();  
        $userRole = $this->userRole;
        $sessionTokenFromDB[] = $this->getCurrentSessionToken($userID);
        $tokensToAppend = array_merge($tokensToAppend,$sessionTokenFromDB[0]) ?? $tokensToAppend;
        $serializedTokens = serialize($tokensToAppend);
        $sql="
        UPDATE users_metadata
        SET session_tokens = '$serializedTokens', user_role = '$userRole'
        WHERE user_id =  '$userID' "; 
        $this->prepareStmt($sql);
        return $this->run();
    }
    
    public function getCurrentSessionToken($userID){
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
?>