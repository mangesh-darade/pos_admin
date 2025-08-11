<?php    
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
header('Access-Control-Allow-Credentials: true');

    define('HOSTNAME', str_replace('www.', '', $_SERVER['SERVER_NAME']));
    include_once('../include/database.php');   
    
    Class Marchant{
        public $conn = '';
        public $merchant = '';
        public $apikey = '32468723PWERWE234324SADA';
        
        public function __construct($conn) {
            $this->conn = $conn;
            
        }
        
        function marchantDetails($merchant, $apikey) { 
        
         
            $MsgArr = array();
            $MsgArr['status']='error' ;
            
            if($apikey!=$this->apikey):
                $MsgArr["msg"] = "Invalid API KEY";
                  return $this->json_op($MsgArr);
            endif;
            
            if (!empty(trim($merchant))) {
            
                 $sql = "SELECT `id` ,`name`, `email`, `phone`, `address`, `country`, `country_code`, `state`, `city`, `pincode`, `type`, `pos_name`,
                 `pos_demo_expiry_at`, `business_name`,"
                        . " `pos_url`, `pos_generate`, `pos_current_version`, `pos_status`,  `pos_create_at`, `package_id`, `adons_ids`, "
                        . " `subscription_start_at`, `subscription_end_at`, `subscription_is_active`, `is_active`, `is_delete`, `sms_balance`, "
                        . " `customer_balance`, `message` ,payment_status"
                        . " FROM `merchants`"
                        . " WHERE `phone` = '$merchant'  LIMIT 1";  
              
                if ($result = mysqli_query($this->conn, $sql)) {
                
                	 $num = mysqli_num_rows($result);
                	 
                	if($num) 
                	{
	                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	                     
	                    $MsgArr['status'] = isset($row['id'])?'success':'error'; 
	                    $MsgArr['res'] = isset($row['id'])?$row:''; 
                    
                       } else {
                          $MsgArr["msg"] = "Invalid Merchant Phone Number.";
                       }
                       
                        return $this->json_op($MsgArr);
                }
            } else {
               $MsgArr["status"] = "error";
               $MsgArr["msg"] = "Phone Number Is Mandetory.";
            }
            
             return $this->json_op($MsgArr);
        }

         
        
        private function json_op($arr) {
            $arr = is_array($arr) ? $arr : array();
            echo @json_encode($arr);
            exit;
        }
        
        private function json_decode($str) {
           return json_decode($str,true);
        }
    }
    
    $getParam = $_REQUEST;
    
    $phone = isset($getParam['phone']) && !empty($getParam['phone'])?$getParam['phone']:''; 
    $apikey = isset($getParam['apikey']) && !empty($getParam['apikey'])?$getParam['apikey']:'';
    
    $Obj =  new Marchant($conn);
    $res =  $Obj->marchantDetails($phone,$apikey);
         
    
    
?>