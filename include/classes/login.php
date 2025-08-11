<?php

class login {
   
    private $username;
    private $password;
    
    private $app;
    public $error = false;
    public $success = false;
    public $successMessage = '';
    public $errorMessage = '';

    public function __construct($objapp) {
        
        $this->app = $objapp; 
        
    }
    
    public function set($username , $password) {
        
        $this->username = $username;
        $this->password = $password;
        
       // $this->app->validate([$this->username , "required|alpha", "UserName" ]);
       // $this->app->validate([$this->password , "required", "Password" ]);
        
        if(count($this->app->validation_error)) 
        { 
            $this->errorMessage = $this->app->validation_error;
            $this->error = true; 
            return false;
        }
        else
        {
            $encr_password = $this->app->md5($this->password);
            
            $sql = "SELECT `user_id`, `username`, `display_name`,`group`, `email_id`, `mobile_no`, `last_login`  
                     FROM ".TABLE_ADMIN ." 
                     WHERE `username` = '".$this->username."' AND `password` = '$encr_password' AND `is_delete` = '0' ";
            
            $result = $this->app->conn()->query($sql);
           
            if($result):
                
                $row_cnt = $result->num_rows;

                if($row_cnt){
                    $this->success = true;
                    $this->successMessage = 'Login Successfully.';
                }
                
                 $row = $result->fetch_array(MYSQLI_ASSOC);
                 
                 $_SESSION['session_user_id'] = $row['user_id'];
                 $_SESSION['login']['user_id'] = $row['user_id'];
                 $_SESSION['login']['username'] = $row['username'];
                 $_SESSION['login']['group']    = $row['group'];
                 $_SESSION['login']['display_name'] = $row['display_name'];
                 $_SESSION['login']['email_id']  = $row['email_id'];
                 $_SESSION['login']['mobile_no']  = $row['mobile_no'];
                 $_SESSION['login']['last_login']  = $row['last_login'];
                
                $result->close();
               
           endif;
            
        }
        
    }
    
    public function userlogin($id=''){
        
        if(is_numeric($id)) {
            $whereMerchant = " AND `id` = '$id' ";
        }
        elseif(is_array($id)) {            
            $ids = join(',' , $id);
            $whereMerchant = " AND `id` IN ($ids) ";
        }else {
            $whereMerchant = '';
        }
        
        $sql = "SELECT `id`,`name` ,`email`,`phone`,`address`, `type`, `pos_url`, `username`, `db_name`, `db_username`, `db_password`, `pos_create_at`, 
            `pos_demo_expiry_at`, `created_at`, `updated_at`, `is_active`, `is_varified`
            FROM ".TABLE_MERCHANTS."
            WHERE `is_delete` = '0' $whereMerchant "
                . "order by `created_at`";
        
        $result = $this->conn->query($sql);
        
        if($result->num_rows):
            
            while($row = $result->fetch_assoc()) {
            
                $row['status']     = ($row['is_active']) ? 'Active' : 'Deactive';
                $row['verified']   = ($row['is_varified']) ? 'Verified' : 'Not Verified';
            
                if($result->num_rows > 1)
                $data[] = $row;
                else
                   $data = $row; 
                
            }//end while.
            
        endif;
        
        /* close result set */
        $result->close();
        
        return $data;
    }
    
   public function displayErrors(){
       
        if($this->error === true) :
            if(is_array($this->errorMessage)):
             $errorBox = '<div class="alert alert-danger"><ul>' ;  
                foreach($this->errorMessage as $error):

                    $errorBox .= '<li>'.$error.'</li>';

                endforeach;
            $errorBox .= '</ul></div>';       

            endif;
        endif;
   }
    
    public function __destruct() {
        
        /* close connection */
       // $this->app->conn->close();
    }
    
}

?>