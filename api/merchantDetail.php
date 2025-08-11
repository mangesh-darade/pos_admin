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
        
        function marchantDetails($merchant, $apikey, $user_phone, $source='') { 
         
            $MsgArr = array();
            $MsgArr['status']='error' ;
            
            if($apikey!=$this->apikey):
                $MsgArr["msg"] = "Invalid API KEY";
                  return $this->json_op($MsgArr);
            endif;
            
            if (!empty(trim($merchant))) {
            
                 $sql = "SELECT `id` ,`name`, `email`, `phone`, `address`, `country`, `country_code`, `state`, `city`, `pincode`, `type`,
                            `pos_name`, `business_name`,"
                        . " `pos_url`, `pos_generate`, `pos_current_version`, `pos_status`,"
                        . " `is_active`, `is_delete`, `sms_balance` "
                       
                        . " FROM `merchants`"
                        . " WHERE `phone` = '$merchant'  LIMIT 1";  
              
                if ($result = mysqli_query($this->conn, $sql)) {
                
                	$num = mysqli_num_rows($result);
                	 
                	if($num) 
                	{
	                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	                     
	                    $MsgArr['status'] = isset($row['id'])?'success':'error'; 
	                    $MsgArr['res'] = isset($row['id'])?$row:''; 
                            if($source){
                                $apiurl = $row['pos_url'] . "api/getuserinfo";
                                $fields = "phone=".$user_phone."&source=".$source;
                                $post = curl_init();
                                curl_setopt($post, CURLOPT_URL, $apiurl);
                                curl_setopt($post, CURLOPT_POST, 1);
                                curl_setopt($post, CURLOPT_POSTFIELDS, $fields);
                                curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
                                $result = curl_exec($post);

                                $MsgArr['user'] = json_decode($result);
                            }
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
    
    $phone  = isset($getParam['phone']) && !empty($getParam['phone'])?$getParam['phone']:''; 
    $apikey = isset($getParam['apikey']) && !empty($getParam['apikey'])?$getParam['apikey']:'';
    $user_phone = isset($getParam['user_phone']) && !empty($getParam['user_phone'])?$getParam['user_phone']:$phone;
    $source = isset($getParam['source']) && !empty($getParam['source']) ? $getParam['source']:'';
    
    $Obj =  new Marchant($conn);
    $res =  $Obj->marchantDetails($phone,$apikey,$user_phone,$source);
    
?>