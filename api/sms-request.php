<?php  
    define('HOSTNAME', str_replace('www.', '', $_SERVER['SERVER_NAME']));
    include_once('../include/database.php');   
    $posPageName = "login";
   
    Class Sms{
        public $conn = '';
        public $merchant = '';
        private $apikey = '32468723PWERWE234324SADA' ;
        
        public function __construct($conn,$merchant,$apiKey) {
	    $this->authKey($apiKey);
            $this->conn = $conn;
          
            $res = $this->marchantDetails($merchant) ;
            $_phone = isset($res['phone']) && !empty($res['phone'])?$res['phone']:'';
            if(empty($_phone)):
                $arr        = array();
                $arr['status'] =  'error';
                $arr['msg']    =   'Invalid User1';
                $this->json_op($arr);
            endif;
            
            $this->merchant = $res;
            $this->authKey($apiKey);
        }
        
        public function BalanceSms(){
        
            $res    =  $this->merchant;
            $MsgArr = array();
            $MsgArr["status"] = "success";
            $MsgArr["sms_count"] = $res['sms_balance'];
            if($res['sms_balance'] < 1): 
           	$MsgArr["msg"] = 'SMS Balance is Zero' ;
            else:
                $MsgArr["msg"] = 'SMS Balance is '.$res['sms_balance'] ;
            endif;
            $this->json_op($MsgArr);
        }
        
        public function smsLog($mphone, $past=3){
        
            $this->marchant_sms_log($mphone, $past);
        }
        
        public function SmsCron( $mphone){
        
        $allow_cron = isset($_POST['pos_sms_cron'])?(int)$_POST['pos_sms_cron']:0;
        $cron_type = ( $allow_cron==1) && isset($_POST['pos_sms_cron_type']) && $_POST['pos_sms_cron_type'] > 0 ?$_POST['pos_sms_cron_type']:0;
        $fetch_data = isset($_POST['fetch_data'])? $_POST['fetch_data']:'';
        
            $MsgArr = array();
       	    $res    =  $this->merchant;
       	    if(!empty($fetch_data)):
       	    	  $MsgArr["status"] = "success";
               	  $MsgArr["msg"] = "fetched successfully";
               	  $MsgArr["pos_sms_cron"]= $res["pos_sms_cron"];
               	  $MsgArr["pos_sms_cron_type"]= $res["pos_sms_cron_type"];
               	  
               	 $this->json_op($MsgArr);
       	    endif;
       	    
            if (!empty( $res['id'])) {
               $sql = "update `merchants` set pos_sms_cron='$allow_cron',pos_sms_cron_type='$cron_type' WHERE `phone` = '$mphone' and id =".$res['id']; 
              
                if ($result = mysqli_query($this->conn, $sql)) {
                    $res1    =   $this->marchantDetails($mphone) ;
                    $MsgArr["status"] = "success";
                    $MsgArr["msg"] = "updated successfully";
                    $MsgArr["pos_sms_cron"] = $res1["pos_sms_cron"];
                    $MsgArr["pos_sms_cron_type"]= $res1["pos_sms_cron_type"];
                    $this->json_op($MsgArr);
                }
            } else {
                $MsgArr["status"] = "error";
                $MsgArr["msg"] = "All Mandatory Field Are Not Pass";
            }
             $this->json_op($MsgArr);
        }
                
        private function authKey($apiKey) {
	   $return  = array();
	   $return['status'] = 'error' ; 
	   if($this->apikey != $apiKey){
	   	 $return['msg'] = 'Invalid  API KEY' ; 
	   	$this->json_op($return);
	   }
        }
        
        public function marchantDetails($merchant) { 
            $MsgArr = array();
            if (!empty($merchant)) {
               $sql = "SELECT * FROM `merchants` WHERE `phone` = $merchant"; 
              
                if ($result = mysqli_query($this->conn, $sql)) {
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                 
                    $MsgArr = $row;
                    return $MsgArr;
                }
            } else {
                $MsgArr["status"] = "error";
                $MsgArr["msg"] = "All Mandatory Field Are Not Pass";
            }
            return $MsgArr;
        }

        public function SMS($phone,$note){
            $template = isset($_POST['template']) && !empty($_POST['template']) ?$_POST['template']: 'Y';
            $MsgArr = array();
            $MsgArr["status"] = "error";
            $MsgArr["msg"] = '';
            if (empty($phone) || empty($note)):
                if (empty($phone)):
                    $MsgArr["msg"] = $MsgArr["msg"] . "SMS reciver's phone no. is empty ";
                endif;

                if (empty($note)):
                    $MsgArr["msg"] = $MsgArr["msg"] . "SMS note empty";
                endif;
                 $this->json_op($MsgArr);
            endif;
            $res = $this->merchant;
            if(!empty($note)):
                if($template=='Y'):
                 $note =  "Dear Customer, $note Thanks and regards.";
                endif;
            endif;
            $sms_credit_used = ceil(strlen($note)/153);
            $sms_credit_used = $sms_credit_used < 1 ? 1:$sms_credit_used;
            $param['m_phone'] = isset($res['phone']) && !empty($res['phone'])?$res['phone']:'';
            $param['r_phone'] = $phone;
            $param['note']    = $note;
            $resSms = $smsParse = '';
            if($res['sms_balance'] < 1): 
           	   $MsgArr["msg"] = 'Insufficient balance to send SMS';
           	    $this->json_op($MsgArr);
            endif;
            $resSms = $this->SendSMS($phone,$note);
            if(!empty($resSms)):
            	$smsParse  = $this->json_decode($resSms);
            endif;
            $resIsert = '';
            if(!empty($param['m_phone'])  && !empty($smsParse['ErrorCode']) && $smsParse['ErrorCode']=='000' && $smsParse['ErrorMessage']=='Success'):
           	$param['sms_id'] =	$smsParse["MessageData"][0]["MessageParts"][0]["MsgId"];
           	$param['sms_count_used']= $sms_credit_used;
                $resIsert = $this->LogSMS($param);
                $this->CountSMS($res['phone'],$sms_credit_used);
                $MsgArr["status"] = "success";
                $MsgArr["msg"] = 'sms send successfully';
                $this->json_op($MsgArr);
            else:
                $MsgArr["msg"] = !empty($smsParse['ErrorMessage'])?$smsParse['ErrorMessage']:'sms not send successfully';
                $this->json_op($MsgArr);
            endif;
            
        }

        public function CountSMS($phone,$sms_credit_used=NULL){
	     $data = array(
                "action" => "updateSmsCounter",
                "phone" => $phone,
                "apikey" => $this->apikey,
                'sms_credit_used'=>$sms_credit_used,
              );
            $url = 'https://simplypos.in/api/merchantInfo.php';
            $res = $this->PostURL($url, $data); 
            return $res;
        }
        
        public function LogSMS($param){
            
            $m_phone = isset($param['mphone']) && !empty($param['mphone'])?$param['mphone']:'';
            $receiver_phone = isset($param['r_phone']) && !empty($param['r_phone'])?$param['r_phone']:'';
            $note = isset($param['note']) && !empty($param['note'])?$param['note']:'';
            $note =  addslashes($note );
            $sms_id = isset($param['sms_id']) && !empty($param['sms_id'])?$param['sms_id']:'';
            $sms_count_used = isset($param['sms_count_used']) && !empty($param['sms_count_used'])?$param['sms_count_used']:1;
            $t = date("Y-m-d H:i:s");
            
            if (!empty($m_phone)) {
                $sql = "INSERT INTO `merchant_sms_log` (`merchant_phone` ,`receiver_phone` ,`note`,`sms_id` ,`posttime`,`sms_count`) VALUES ( '$m_phone', '$receiver_phone', '$note', '$sms_id', '$t','$sms_count_used')"; 

                if ($result = mysqli_query($this->conn, $sql)) {
                    $MsgArr["status"] = "success";
                    $MsgArr["msg"] = "SMS log has been updated";
                } else {
                    $MsgArr["status"] = "error";
                    $MsgArr["msg"] = "Sql Error: ".mysqli_error($this->conn);
                }
            } else {
                $MsgArr["status"] = "error";
                $MsgArr["msg"] = "Log Merchant not found";
            }
            
            return $MsgArr;            
        }
        
        public function SendSMS($phone,$note) {
            $datasms = array(
                "user" => "simplysafe",
                "password" => "Simplysafe1$$",
                "msisdn" => "+91" .$phone ,
                "sid" => "SIMPLY",
                "msg" =>$note ,
                "fl" => 0,
                "gwid" => 2
            );
            $urlsms = 'http://payonlinerecharge.com/vendorsms/pushsms.aspx';
            $ressms = $this->PostURL($urlsms, $datasms); 
            return $ressms;
        }

        Private function PostURL($url, $data) {
            $fields = '';
            foreach ($data as $key => $value) {
                $fields .= $key . '=' . $value . '&';
            }
            rtrim($fields, '&');
            $post = curl_init();
            curl_setopt($post, CURLOPT_URL, $url);
            curl_setopt($post, CURLOPT_POST, count($data));
            curl_setopt($post, CURLOPT_POSTFIELDS, $fields);
            curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($post);

            return $result;
        } 
        
        Private function json_op($arr) {
            $arr = is_array($arr) ? $arr : array();
            echo @json_encode($arr);
            exit;
        }
        
        Private function json_decode($str) {
           return json_decode($str,true);
        }
        
	Private function marchant_sms_log($merchant, $duration=3) { 
	            $MsgArr = array();
	            $date = date("Y-m-d",mktime(0,0,0,date("m")-$duration,date("d"),date("Y")));	            
	            $offset = isset($_POST["offset"])?(int)$_POST["offset"]:0;
	            $limit  = isset($_POST["limit"])?(int)$_POST["limit"]:30;
	            $limit_clause = '';//" limit $offset,$limit";
            
	            if (!empty($merchant)) {
                        
	               $sql1 = "SELECT count(*) as cnt FROM `merchant_sms_log` WHERE  date(posttime) > '$date' and sms_id!=''   and sms_count > 0 and `merchant_phone` = '$merchant' order by id desc ";   
	
	                if ($result1 = mysqli_query($this->conn, $sql1)):
	                    $row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC);
	                    $rowCount = $row1['cnt'];
	                    $MsgArr["status"]       = "SUCCESS";
	                    $MsgArr["msg"]          = $rowCount." records found";
	                    $MsgArr["total_count"]  = $rowCount ;
	
	                    if($rowCount == 0):
	                        $this->json_op($MsgArr);
	                    endif;
	
	                    $sql2 = "SELECT merchant_phone ,receiver_phone ,note , sms_id ,  ( `posttime` + INTERVAL 330 MINUTE ) AS posttime ,sms_count ,id FROM `merchant_sms_log` WHERE  date(posttime) > '$date' and  sms_id!=''  and sms_count > 0  and `merchant_phone` =  '$merchant' order by id desc ".$limit_clause;   
	                    if ($result2 = mysqli_query($this->conn, $sql2)):
	                        $row_count=mysqli_num_rows($result2);
	                        if($row_count > 0){
	                            $MsgArr["row_count"]  = $row_count ; 
	                            $res  = array();
	                            while ($row = mysqli_fetch_array($result2)) {
	                                $res[] = $row;
	                            }
	                            $MsgArr["result"]  = $res ;  
	                        }
	                    endif;
	                    $this->json_op($MsgArr);
	                else:
	                    $MsgArr["status"] = "Error";
	                    $MsgArr["msg"] = "Unable to fetch data"  ;
	                endif;
	                $this->json_op($MsgArr);
	
	            } else {
	                    $MsgArr["status"] = "error";
	                    $MsgArr["msg"] = "All Mandatory Field Are Not Pass";
	            }
	            $this->json_op($MsgArr);
	    }
	
        public function UpdateBalanceSms( $getParam ) {
            
            if (!empty($getParam["mphone"])) {
               $merchant = $getParam["mphone"];
               $smscount = $getParam["smscount"];
               $sql = "UPDATE `merchants` SET `sms_balance` = (`sms_balance`- '$smscount') , `sms_used` = (`sms_used`+'$smscount') WHERE `phone` = '$merchant'"; 
              
                if ($result = mysqli_query($this->conn, $sql)) {
                    $MsgArr["status"] = "success";
                    $MsgArr["msg"] = "SMS Balance has been updated";
                } else {
                    $MsgArr["status"] = "error";
                    $MsgArr["msg"] = "Sql Error: ".mysqli_error($this->conn);
                }
            } else {
                $MsgArr["status"] = "error";
                $MsgArr["msg"] = "Merchant not found";
            }
            return $MsgArr;
        }
    }
    
    $getParam = $_REQUEST;
    
    $mphone = isset($getParam['mphone']) && !empty($getParam['mphone'])?$getParam['mphone']:'';
    $apikey = isset($getParam['apikey']) && !empty($getParam['apikey'])?$getParam['apikey']:'';
    $action = isset($getParam['action']) && !empty($getParam['action'])?$getParam['action']:'SendSms';
     
    if (!empty($mphone) && !empty($apikey)):
        $smsObj = new Sms($conn, $mphone, $apikey);
        switch ($action) {
            case 'SendSms':
                $phone = isset($getParam['phone']) && !empty($getParam['phone']) ? $getParam['phone'] : '';
                $note = isset($getParam['note']) && !empty($getParam['note']) ? $getParam['note'] : '';
                if (empty($phone) || empty($note)){
                    echo json_encode(array('status' => 'error', 'msg' => 'All mendetory field are not supplied'));
               }
                $res = $smsObj->SMS($phone, $note);
                break;
                
            case 'BalanceSms':          
                $res = $smsObj->BalanceSms();
                break;
                 
            case 'SmsCron':        
                $res = $smsObj->SmsCron( $mphone );
                break;
                 
            case 'smsLog':
                $past = isset($getParam['past']) && !empty($getParam['past']) ? $getParam['past'] : '3';
                $res  = $smsObj->smsLog( $mphone, $past );
                break;    
             
            case 'LogSMS':
               
                $res = $smsObj->LogSMS( $getParam );
                echo json_encode($res);
                break;
            
            case 'UpdateBalanceSms':
                $res = $smsObj->UpdateBalanceSms( $getParam );
                echo json_encode($res);
                break;
                        
            default:
                    echo json_encode(array('status' => 'error', 'msg' => 'All mendetory field are not supplied2'. $action . '@@'));
                break;
        }
    else:
        echo json_encode(array('status' => 'error', 'msg' => 'All mendetory field are not supplied'));
    endif;
?>