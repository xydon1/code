<?php 

class Login{
   
  public $username;
  public $password;
  
  public function __construc($username, $password){
    $this->username = $username;
    $this->password = $password;
  }
  
  public function encrypt($text){ 
    return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, SALT, $text, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)))); 
  } 
  
  public static function fixtextlogin($text){
    return strval($text);
  }
  
  public function validateLogin(){
    
    require("config.htm");
    
    $this->encrypted=$this->encrypt($this->encrypt($this->password));
    $q="SELECT a.authid,a.chpass,a.username,a.password,a.groupid,a.qaid,a.firstname,a.lastname,a.role,a.email,a.phone,a.photo
    FROM auth AS a
  	WHERE a.username='".$this->username."' AND password='".$this->encrypted."'";
    $STH = $DBH->query($q);
    $STH->setFetchMode(PDO::FETCH_ASSOC);
        
    while($row = $STH->fetch()){      
      session_start();
      $_SESSION['authid'] = $row['authid'];
      $_SESSION['chpass'] = $row['chpass'];
      $_SESSION['username'] = $row['username'];
      $_SESSION['password'] = $this->encrypted;
      $_SESSION['groupid'] = $row['groupid'];
      $_SESSION['qaid'] = $row['qaid'];
      $_SESSION['firstname'] = $row['firstname'];
      $_SESSION['lastname'] = $row['lastname'];
      $_SESSION['role'] = $row['role'];
      $_SESSION['email'] = $row['email'];
      $_SESSION['phone'] = $row['phone'];
      $_SESSION['phone'] = $row['phone'];      
    } 
      
    return $_SESSION['authid']?"loggedIn_dashboard":"invalid"; 

  }
   
}?>