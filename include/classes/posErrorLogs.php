<?php

class posErrorLogs {
    
    private $conn;    
    public $posErrorLog;

    public function __construct($conn) {
        $this->conn = $conn;
         
    }
    
    public function getLogs($merchant_id = ''){
       
        $whereMerchant = '';
        if(is_numeric($merchant_id) &&  $merchant_id > 0) {
            
            $whereMerchant = " AND log.`merchant_id` = '$merchant_id' ";
        }
        
        $sql = "SELECT log.`id` log_id, log.`merchant_id` ,log.`error_message`,log.`error_url`, log.`error_time`, log.`pos_url`, 
            merc.`name` merchant_name, merctyp.`merchant_type`
                FROM ".TABLE_POS_ERROR_LOG." log , ".TABLE_MERCHANTS." merc , ".TABLE_MERCHANT_TYPE." merctyp
                WHERE log.`merchant_id` = merc.id AND merc.type = merctyp.id 
                $whereMerchant 
                order by `error_time` DESC LIMIT 0 , 500";
        
        $result = $this->conn->query($sql);
        
        if($result->num_rows):
            
            while($row = $result->fetch_assoc()) {                 
            
                $this->posErrorLog[] = $row; 
                
            }//end while.
            
        endif;
        
        /* close result set */
        $result->close();
        
        return $this->posErrorLog;
    }
    
    
    
    
    
    
    
    public function __destruct() {
        
        /* close connection */
        $this->conn->close();
        unset($this->posErrorLog);        
    }
    
}

?>