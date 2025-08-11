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
        public $apikey = '324687238787PWERWE234324SADA9834';
        
        public function __construct($conn) {
            $this->conn = $conn;
        }
        
        public function random_password($length = 8) {
        	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	        $password = substr(str_shuffle($chars), 0, $length);
        	return md5($password);
   	}
    
        public function marchantUpdate($merchant, $client,$apikey) { 
            $MsgArr = array();
            $MsgArr['status']='error' ;
            
            if($apikey!=$this->apikey):
                $MsgArr["msg"] = "Invalid API KEY";
                  return $this->json_op($MsgArr);
            endif;
            
            if(empty(trim($merchant))):
                $MsgArr["msg"] = "Merchant phone no is empty";
                  return $this->json_op($MsgArr);
            endif;
            
            
            if(empty(trim($client))):
                $MsgArr["msg"] = "Customer phone no is empty";
                  return $this->json_op($MsgArr);
            endif;
            
            if (!empty(trim($merchant)) && !empty(trim($client))) :           
                 $sql = "SELECT `db_name` ,  `db_username` ,  `db_password`  FROM `merchants` WHERE `phone` = '$merchant'  LIMIT 1";  
                if ($result = mysqli_query($this->conn, $sql)):
                    $num = mysqli_num_rows($result);
                    if($num): 
                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                        $db_name        = $row['db_name'];
                        $db_username    = $row['db_username'];
                        $db_password    = $row['db_password'];
                        if(empty($db_name) ||  empty($db_username) || empty($db_password) ):
                                 $MsgArr["msg"] = "Error Code 200";
                           	 return $this->json_op($MsgArr);
                        endif;
                        try {
                            $conn_new = new mysqli('localhost', $db_username, $db_password, $db_name);
                            if (mysqli_connect_errno()) {
                             	 $MsgArr["msg"] = "Error Code 201";
                           	 return $this->json_op($MsgArr);
                            }
                            $passKey = $this->random_password();
                                if ($result = $conn_new->query("SELECT id,pass_key from  sma_companies where phone='$client' ")) {
                                    $row = $result->fetch_object ();
                                    if(!isset($row->id)){
                                    	  $MsgArr["msg"] = "Error Code 202";
                           		  return $this->json_op($MsgArr);
                                    }
	                            $custId = $row->id;
	                            $sql = "UPDATE sma_companies  SET pass_key='".$passKey."' WHERE id='".$row->id."'";
					if ($conn_new->query($sql) === TRUE) {
					    $MsgArr["msg"] = "Passkey updated successfully";
					    $MsgArr["pass_key"] =  $passKey;
					} else {
					   $MsgArr["msg"] = "Error Code 203";
	                   		   return $this->json_op($MsgArr);
					}

                                }
                               $conn_new->close();
                            
                        } catch (Exception $exc) {
                            echo $exc->getTraceAsString();
                        }                       
                    else:
                          $MsgArr["msg"] = "Invalid Merchant Phone Number.";
                    endif;
                    return $this->json_op($MsgArr);
                else :
                    $MsgArr["status"] = "error";
                    $MsgArr["msg"] = "Phone Number Is Mandetory.";
                endif;
            endif;
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
    $client = isset($getParam['customer_phone']) && !empty($getParam['customer_phone'])?$getParam['customer_phone']:''; 
    $apikey = isset($getParam['apikey']) && !empty($getParam['apikey'])?$getParam['apikey']:'';
    
    $Obj =  new Marchant($conn);
    $res =  $Obj->marchantUpdate($phone, $client,$apikey);
   
?>