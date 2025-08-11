<?php

class configuration {
    
    protected $conn;
    public $appCommon;       
    public $data; 
    private $edit_id;


    public function __construct() {
        
        global $objapp;
        $this->appCommon = $objapp;
        
        $this->conn = $this->appCommon->conn();
         
        $this->configuration = '';
        $this->edit_id = '';
        
        $this->getConfiguration();          
    }
    
    public function getConfiguration(){        
               
       $sql = "SELECT * 
                FROM ".TABLE_CONFIGURATION." 
                WHERE `is_active` = '1' 
                ORDER BY `type`, `list_order` ASC ";
        
        $result = $this->conn->query($sql);
            
        if($result->num_rows )
        {
            while($row = $result->fetch_assoc()) 
            {
                $row['status'] = ($row['is_active']) ? 'Active' : 'Deactive';

                if($row['developer_only']){
                    $this->data['devloper'][$row['id']] = $row;
                } else {
                    $this->data['user'][$row['id']] = $row;
                }

            }//end while.  
        }
        
        /* close result set */
        $result->close();
         
    } 
    
    public function update(array $postData) {
         $isvalid = true;
        if($postData['rule'] != '') {
            $isvalid = $this->appCommon->validationRule($postData['value'] , $postData['rule'] );
        }
        
        if( $isvalid ) {
            $value = $this->appCommon->prepareInput($postData['value']);
            $this->edit_id =  $postData['id'];       
            $now = date('Y-m-d H:i:s');
            $user_id = $_SESSION['session_user_id'];
            
            $sqlQuery = "UPDATE ".TABLE_CONFIGURATION." SET  `previous_value` = `value` , `value` = '$value' , `updated_at` = '$now' , `updated_by` = '$user_id' "
                      . " WHERE `id` = '".$this->edit_id."'";

             $result = $this->conn->query($sqlQuery);

             if($result) {
                 return true;
             } else {
                 return '<b>MySql Error:</b> '. $result->error;          
             } 
        } else {
            return '<b>Validation Error:</b> Value should be '.str_replace('_', ' ',  $postData['rule']); 
        }
       
            
    } 
    
  
    
    public function __destruct() {
        
        /* close connection */
        $this->conn->close();
         
    }
    
}

?>