<?php

class auth extends merchant {
     
    private $username;
    private $password;
    private $merchantData;
    
    public $loginError;     
    public $loginSuccess;     
    public $status;     
    private $objapp;     

    public function __construct( $username='' , $password='' ) {
        
        global $objapp;
        
        $this->username = trim($username);
        $this->password = trim($password);
        $this->merchantData = '';
        $this->loginError = '';        
        $this->loginSuccess = '';        
        $this->status = 'ERROR'; 
        $this->conn = $objapp->conn(); 
        $this->objapp = $objapp;
    }
    
    
    public function login(){
        
        if($this->validLoginDetails())
        {
            $isValidUser = $this->isValidUser();
            
            if($isValidUser == false) {
                $this->loginError = "User details not available.";
                $this->status = 'ERROR';  
                return false;
            } else {
                
                if($this->merchantData['password'] === $this->password){
                    
                    if($this->merchantData['is_delete'] == 1){
                        $this->loginError = "Your access has been restricted / suspended by Admin. Please contact Simply Pos.";
                        $this->status = 'ERROR';  
                        return false;
                    }
                    if($this->merchantData['is_active'] == 0){
                        $this->loginError = "Your access has been limited by Admin / Not Verified. Please contact Simply Pos.";
                        $this->status = 'ERROR';  
                        return false;
                    }
                    
                    $this->setUserLogin();
                    $this->loginSuccess = "Login success.";
                    $this->status = 'SUCCESS';  
                    return true;
                } else {
                    $this->loginError = "Login failed.";
                    $this->status = 'ERROR';
                    return false;
                }
            }
            
        } else {
            $this->loginError = "User login details is invalid.";
            return false;
        }
    }
    
    public function setUserLogin() {
        
        $_SESSION[SESSION_MERCHANT_KEY] = $this->merchantData['id'];        
        $_SESSION['sess_merchant_name'] = $this->merchantData['name'];        
    }
    
    public function unsetUserLogin() {
        
        unset($_SESSION[SESSION_MERCHANT_KEY]);        
    }
    
    public function logout() {
        $this->unsetUserLogin();
    }
    
    public function isValidUser() {
        
        $sql = "SELECT `id`, `name`, `email`, `phone` , `password` , `is_active`, `is_delete` ,  COUNT(`id`) as num 
                FROM ".TABLE_MERCHANTS."
                WHERE ( `email` = '".$this->username."' OR `phone` = '".$this->username."' ) "
               
                . " LIMIT 1";
         
        $result = $this->conn->query($sql);
        
        if($result)
        {
           $row = $result->fetch_array(MYSQLI_ASSOC);
            
            if($row['num']) {
                $this->merchantData = $row;
                return true;
            } else {                
                return false;
            }
            
        }
        
        return false;
    }
          
    public function random_auth_token($length = 25) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $password = substr(str_shuffle($chars), 0, $length);
        return $password;
    }
    
    public function CreateToken($email_id){
        $data = array();
        $data['status'] ='ERROR';
    	$emailID = isset($email_id)?$email_id:'';
    	if(empty($emailID)){
            $data['msg'] ='Email-Id is  required ';  
            return $data;
    	}
        $query = "SELECT id, name FROM  ".TABLE_MERCHANTS."  WHERE email='$emailID' order by `id` DESC  ";
        $result = $this->conn->query($query);
        if(!$result->num_rows):
            $data['msg'] ='Email-Id is  not  found ';  
            return $data;
        endif;
        
        if($result->num_rows!=1):
            $data['msg'] ='Invalid Email-Id   ';  
            return $data;
        endif;
        $row = $result->fetch_assoc();     
    	$token = $this->random_auth_token(40);
        $updateFields['pass_token'] = $token;
        $token_s = date('Y-m-d H:i:s',strtotime('now'));
        $token_e  =  date('Y-m-d H:i:s',strtotime('now')+3600); 
        
            $sql = "UPDATE `merchants`  SET pass_token = '$token' , pass_token_start_date='$token_s' , pass_token_end_date ='$token_e' ";
            $sql .= "  WHERE `email` = '$emailID' ";
             
            $result = $this->conn->query($sql);

            if($result){
                $data['status'] = 'SUCCESS'; 
                $data['msg'] = $token; 
                $data['name'] = $row['name']; 
                $data['id']     = md5('reset'.$row['id']); 
                return $data;
            } else {
                $data['msg'] ='<b>Sql Error:</b> ' . $objapp->conn->error;
                return $data;
            } 
    }
        
    public function validateToken($pass_token,$auth_token,$password){
        $data = array();
        $data['status'] ='ERROR';
        $dt = date('Y-m-d H:i:s');
        if(empty($pass_token) || empty($auth_token) || empty($password)  ):
             $data['msg'] ='<b>Invalid Paramenter</b> '  ;
             return $data;
        endif;
        
        $sql="SELECT * FROM `merchants` WHERE  MD5( CONCAT('reset',`id`)) ='$auth_token' "
                . "and pass_token='$pass_token' "
                . "and pass_token_start_date  < '$dt' "
                . " and pass_token_end_date  > '$dt' ";
        
      
        $result = $this->conn->query($sql);
        if(!$result->num_rows):
             $data['msg'] ='<b>Invalid Token</b> '      ;
             return $data;
        endif;
        $row = $result->fetch_assoc();
        $Upsql = "UPDATE `merchants`  SET password ='$password',pass_token='' ,pass_token_start_date='' ,pass_token_end_date=''     WHERE `id` = '".$row['id']."' ";
        $result1 = $this->conn->query($Upsql);

            if($result1){
                $data['status'] = 'SUCCESS'; 
                $data['msg']    = 'password is updated successfully';   
                return $data;
            } else {
                $data['msg'] ='<b>Sql Error:</b> ' . $objapp->conn->error;
                return $data;
            }
    }
    
    public function validLoginDetails(){
        
        if(empty($this->username)) return false;
        if(empty($this->password)) return false;
        
        return true;
    }
     
    public function sendEmailOtp($otp , $email){
       
        $mailData['to'] = $email;
        $mailData['subject'] = "Simplypos OTP";
        $mailData['body'] = "Dear User,<br/><br/>Please user this OTP $otp to change password.<br/><br/><br/>Thank You,<br/>SimplyPos Team.";
        
       return $this->objapp->sendMail( $mailData );
        
    }
    
    public function sendSmsOtp($otp , $phone){
        
        $sms_text = "$otp is your change password OTP. Treat this as confidential. SimplyPos Never call you to verify your OTP. Use this OTP within 30 minuts.";
        
        return $this->objapp->SendSMS($phone, $sms_text);
    }
    
}

?>