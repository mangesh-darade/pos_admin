  <?php
class apiRequests extends  merchant 
{
        public $merchant = '';
        public $apikey = '32468723PWERWE234324SADA';
        
        public function __construct($apiKey ) {
            parent::__construct(); 
            $this->authKey($apiKey);
        }
        
        private function authKey($apiKey) {
	   $return  = array();
	   $return['status'] = 'error' ; 
	   if($this->apikey != $apiKey){
	   	 $return['msg'] = 'Invalid  API KEY' ; 
	   	$this->jsonEncode($return);
	   }
        }
        
        private function authCheck() {  
           
                $sql = "SELECT * FROM `api_auth` WHERE `api_key` = '$this->apikey' and is_active='1' and  is_delete='0'   ";                 
                if ($result = mysqli_query($this->conn, $sql)) {
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    if(!isset($row['id'])):
                     return false;
                    endif; 	
                    return  $row;
                }
            
            return false;
        }
        
        
        
        private function jsonEncode($arr) {
            $arr = is_array($arr) ? $arr : array();
            echo @json_encode($arr);
            exit;
        }
        
        private function jsonDecode($str) {
           return json_decode($str,true);
        }
        
        public function canSendSMS($merchant_mobile) {
           
            if(strlen($merchant_mobile) != 10) return false;
         
             $result =  $this->MerchantDetail($merchant_mobile);
             
          	 if(!isset($result['id'])):
                     return false;
                endif; 	
            return  $result['sms_balance'];
            
        }
       
        
        public function marchantPackageInfo($merchant_mobile) {
            $return  = array();
	    $return['status'] = 'error' ; 
            if(strlen($merchant_mobile) != 10) return false;
        	 $arr = array('name', 'email', 'phone', 'address', 'country', 'state', 'pincode', 'business_name', 'pos_name', 'pos_url', 'sms_balance', 'sms_used', 'customer_balance', 'customer_used', 'registers_balance', 'registers_used', 'products_balance', 'products_used', 'users_balance', 'users_used');
            
             $result =  $this->MerchantDetail($merchant_mobile);
             
          	if(!isset($result['id'])):
                       $return['msg'] = 'Invalid Merchant' ; 
                       $this->jsonEncode($return);
                endif; 	
                $return['status'] = 'success' ; 
                 $return['msg'] = array();
                foreach($result as $result_field=>$result_data){
                	if(in_array($result_field,$arr )):
                	 $return['msg'][$result_field]=$result_data;
                	endif;
                }
            return $this->jsonEncode($return); 
        }
        

	private function MerchantDetail($merchant_mobile) { 
 	    if(strlen($merchant_mobile) != 10) return false;
            if (!empty($merchant_mobile)) {
               $sql = "SELECT * FROM `merchants` WHERE `phone` = '$merchant_mobile' and is_active='1' and  is_delete='0' "; 
                if ($result = mysqli_query($this->conn, $sql)) {
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    if(!isset($row['id'])):
                     return false;
                    endif; 	
                   
                    return  $row;
                }
            }  
            return false;
        }
        
        
	public function updateSmsCounter($merchant_mobile){
		$param = $_POST;
		$sms_credit_used = isset($param['sms_credit_used']) && (int)$param['sms_credit_used'] >0 ?$param['sms_credit_used'] :1;
		$return  = array();
		$return['status'] = 'error' ; 
		$smsPermission = $this->canSendSMS($merchant_mobile);
		if(empty($smsPermission) || $smsPermission < $sms_credit_used):
		   $return['msg'] = 'Insufficient balance to send SMS';
		   $this->jsonEncode($return);
		elseif($smsPermission >= $sms_credit_used):
		   $sql = "update `merchants`   set  `sms_balance`=`sms_balance`-".$sms_credit_used." , `sms_used`=`sms_used`+".$sms_credit_used." where `phone` = '$merchant_mobile' "; 
	           if ($result = mysqli_query($this->conn, $sql)) {
	               $return['status'] = 'success' ; 
	               $return['msg'] = 'SMS counter updated successfully' ; 
	            }
	            $this->jsonEncode($return);
		endif;
	}
        
         public function updateMerchantUPPackageCounts( $merchant_mobile ){
        
              $orders = $_POST['orders']? $_POST['orders'] : 1;
              
             if($merchant_mobile && $orders) {           

                $sql = "UPDATE `merchants` SET `balance_urbnpiper_order` = (`balance_urbnpiper_order` - $orders), `total_urbanpiper_order` = (`total_urbanpiper_order` + $orders) WHERE `phone` = '$merchant_mobile' ";

                $result = $this->conn->query($sql);

                if($result) {
                    $return['status'] = 'success' ;
                } else {
                    $return['status'] = 'error' ; 
                    $return['msg'] = 'sql Error: '. $this->conn->error; 
                }
             }
             else {
                    $return['status'] = 'error' ; 
                    $return['msg'] = 'Invalid input request'; 
                }
            
            $this->jsonEncode($return);
        }
        
        public  function UpdatePosCustomer($param){
            $return  = array();
            $return['status'] = 'error' ; 
            $authCheck = $this->authCheck();   
            
            $access_token = isset($param['access_token'])&& !empty($param['access_token']) ?$param['access_token']:NULL;
            
            if(empty($access_token)):
                $return['msg'] = 'Access Token is  empty' ; 
                $this->jsonEncode($return);
            endif;
            
            if(empty($authCheck['access_token']) || $authCheck['access_token']!=$access_token):
                $return['msg'] = 'Invalid Access Token '   ; 
                $this->jsonEncode($return);
            endif;
            
            $merchant_phone = isset($param['merchant_phone'])&& !empty($param['merchant_phone']) ?$param['merchant_phone']:NULL;
            if(empty($merchant_phone) || strlen($merchant_phone) != 10):
                $return['msg'] = 'Merchant Phone is empty or  invalid ' ; 
                $this->jsonEncode($return);
            endif;
            
            $customer_phone = isset($param['customer_phone'])&& !empty($param['customer_phone']) ?$param['customer_phone']:NULL;
            if(empty($customer_phone) || strlen($customer_phone) != 10):
                $return['msg'] = 'Customer Phone is empty or  invalid ' ; 
                $this->jsonEncode($return);
            endif;
            
            $MerObj = $this->MerchantDetail($merchant_phone );
            if(!isset($MerObj['phone'])):
                $return['msg'] = 'Merchant Phone invalid ' ; 
                $this->jsonEncode($return);
            endif;
            
            if(empty($MerObj['pos_url'])):
                $return['msg'] = 'POSURL ERROR ' ; 
                $this->jsonEncode($return);
            endif;
            
            $PosApiURL = rtrim($MerObj['pos_url'],'/').'/api/user/?action=update_user_info';
            $requestArr = array();
            $requestArr['phone'] = $customer_phone;
            $requestArr['name'] = isset($param['name'])&& !empty($param['name']) ?$param['name']:NULL;
            $requestArr['email'] = isset($param['email'])&& !empty($param['email']) ?$param['email']:NULL;
            $requestArr['address'] = isset($param['address'])&& !empty($param['address']) ?$param['address']:NULL;
            $requestArr['dob'] = isset($param['dob'])&& !empty($param['dob']) ?$param['dob']:NULL;
            $requestArr['anniversary'] = isset($param['anniversary'])&& !empty($param['anniversary']) ?$param['anniversary']:NULL;
            $requestArr['dob_father'] = isset($param['dob_father'])&& !empty($param['dob_father']) ?$param['dob_father']:NULL;
            $requestArr['dob_mother'] = isset($param['dob_mother'])&& !empty($param['dob_mother']) ?$param['dob_mother']:NULL;
            $requestArr['dob_child1'] = isset($param['dob_child1'])&& !empty($param['dob_child1']) ?$param['dob_child1']:NULL;
            $requestArr['dob_child2'] = isset($param['dob_child2'])&& !empty($param['dob_child2']) ?$param['dob_child2']:NULL;
            try {
                $ApiResponse = $this->postCurl( $PosApiURL, $requestArr );
                if(empty($ApiResponse)):
                    $return['msg'] =  'Unkown error, please try again CODE-1';
                    $this->jsonEncode($return);
                else:
                    $ResObj = json_decode($ApiResponse);
                    if($ResObj->status!='SUCCESS'):
                        $return['msg'] = isset($ResObj->msg) && !empty($ResObj->msg) ? $ResObj->msg: 'Unkown error, please try again CODE-2';;
                        $this->jsonEncode($return);
                    else:
                        $return['status'] = 'success' ; 
                        $return['msg'] = $ResObj->msg;
                         $this->jsonEncode($return);
                    endif;
                endif;
            } catch (Exception $exc) {
                $return['msg'] =  $exc->getMessage();
                $this->jsonEncode($return);
            }
        } 
        
        public function postCurl($url, $data) {
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
            curl_close($post);
            return $result;
	}
	
	 private function MerchantBillerDetail($merchant_mobile,$billerId) { 
 	    if(strlen($merchant_mobile) != 10) return false;
            if (!empty($merchant_mobile)) {
              $sql = "SELECT * FROM `merchants_biller_locations` WHERE `merchant_phone` = '$merchant_mobile' and biller_id='$billerId' and is_active='1' and  is_delete='0'   "; 
                if ($result = mysqli_query($this->conn, $sql)) {
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    if(!isset($row['id'])):
                     return false;
                    endif; 	
                   
                    return  $row;
                }
            }  
            return false;
        }
	
	
    public function UpdateBillerLocation($param) { 
        $return = array();
        $return['status'] = 'error';
        $merchant_mobile = isset($param['phone']) ? $param['phone'] : '';
        $result = $this->MerchantDetail($merchant_mobile); 
        if (!isset($result['id'])):
            $return['msg'] = 'Invalid merchant';
            $this->jsonEncode($return);
        endif;

        $lat = isset($param['lat']) ? $param['lat'] : '';
        $lng = isset($param['lng']) ? $param['lng'] : '';
        $billerId = isset($param['id']) ? $param['id'] : '';

        if ($lat == '' || $lng == '' || $billerId == ''):
            $return['msg'] = 'Required parameter not provided';
            $this->jsonEncode($return);
        endif;
        $lat = isset($param['lat']) ? $param['lat'] : '';
        $lng = isset($param['lng']) ? $param['lng'] : '';
        $billerId = isset($param['id']) ? $param['id'] : '';
        $billerName = isset($param['name']) ? $param['name'] : '';
        $billerCompany = isset($param['company']) ? $param['company'] : '';
        $billerAddress = isset($param['address']) ? $param['address'] : '';
        $billerCity = isset($param['city']) ? $param['city'] : '';
        $billerState = isset($param['state']) ? $param['state'] : '';
        $billerZipcode = isset($param['postal_code']) ? $param['postal_code'] : '';
        $billerPhone = isset($param['b_phone']) ? $param['b_phone'] : '';
        $billerEmail = isset($param['email']) ? $param['email'] : '';
        $billerlogo = isset($param['logo']) ? $param['logo'] : '';

        $resultB = $this->MerchantBillerDetail($merchant_mobile, $billerId);

        $updateAct = isset($resultB['id']) ? 'edit' : 'add';

        switch ($updateAct) {

            case 'edit':
                $upSql = "update `merchants_biller_locations`   set"
                        . "  `latitude`= '$lat' ,"
                        . " `longitude`= '$lng'  ,"
                        . " `biller_name`= '$billerName' ,"
                        . " `biller_company`= '$billerCompany' ,"
                        . " `biller_address`= '$billerAddress' ,"
                        . " `biller_city`= '$billerCity' ,"
                        . " `biller_state`= '$billerState' ,"
                        . " `biller_zipcode`= '$billerZipcode' ,"
                        . " `biller_phone`= '$billerPhone' ,"
                        . " `biller_email`= '$billerEmail' ,"
                        . " `biller_logo`= '$billerlogo' "
                        . "where `merchant_phone` = '$merchant_mobile' and biller_id ='$billerId' ";
                if ($result = mysqli_query($this->conn, $upSql)) {
                    $return['status'] = 'success';
                    $return['msg'] = 'Biller Location updated successfully';
                }
                $this->jsonEncode($return);

                break;

            case 'add':
                $addSql = "INSERT INTO `merchants_biller_locations` "
                        . "(`merchant_phone`, `biller_id`, `latitude`, `longitude`, `biller_name`, `biller_company`, `biller_address`, `biller_city`, `biller_state`, `biller_zipcode`, `biller_phone`, `biller_email`, `biller_logo` )"
                        . " VALUES ( '$merchant_mobile', '$billerId', '$lat', '$lng', '$billerName', '$billerCompany', '$billerAddress', '$billerCity', '$billerState', '$billerZipcode', '$billerPhone', '$billerEmail', '$billerlogo');";
                if ($result = mysqli_query($this->conn, $addSql)) {
                    $return['status'] = 'success';
                    $return['msg'] = 'Biller Location Inserted successfully';
                }
                $this->jsonEncode($return);
                break;

            default:

                break;
        }
         $this->jsonEncode($return);
    }

    
    public function DeleteBillerLocation($param) { 
        $return = array();
        $return['status'] = 'error';
        $merchant_mobile = isset($param['phone']) ? $param['phone'] : '';
        $result = $this->MerchantDetail($merchant_mobile); 
        if (!isset($result['id'])):
            $return['msg'] = 'Invalid merchant';
            $this->jsonEncode($return);
        endif;
            
        $billerId = isset($param['id']) ? $param['id'] : '';

        if ( $billerId == ''):
            $return['msg'] = 'Required parameter not provided';
            $this->jsonEncode($return);
        endif;
            
        $billerId = isset($param['id']) ? $param['id'] : '';           
        $resultB = $this->MerchantBillerDetail($merchant_mobile, $billerId);
        $updateAct = isset($resultB['id']) ? 'edit' : 'add';
        switch ($updateAct) {

            case 'edit':
                $upSql = "update `merchants_biller_locations`   set"
                        . "  `is_delete`= '1'  "  
                        . "where `merchant_phone` = '$merchant_mobile' and biller_id ='$billerId' ";
                if ($result = mysqli_query($this->conn, $upSql)) {
                    $return['status'] = 'success';
                    $return['msg'] = 'Biller Location removed successfully';
                }
                $this->jsonEncode($return);
                break;
                
            default:

                break;
        }
        $this->jsonEncode($return);
    }
    
     public function posType() {
        $return = array();
        $return['status'] = 'success'; 
        $res = $this->getMerchantType();
        $return['msg'] = count($res).' data found';
        $return['row_count'] = count($res);  
        foreach ($res as $key => $value) {
            $return['result'][] = array("id"=>$key,"label"=>$value);
        }
       
        $this->jsonEncode($return);
    }
    
    
    private function getPosTypeByKeyword($type) {  	  
        if (!empty($type)) {
             $sql = "SELECT * 
                    FROM  `merchant_type` 
                    WHERE  `is_active` ='1'
                    AND  `is_delete` ='0'
                    AND  `id` =  '$type' "; 
            if ($result = mysqli_query($this->conn, $sql)) {
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                if(!isset($row['id'])):
                 return false;
                endif; 	
                return  $row;
            }
        }  
        return false;
    }
    
    public function getBillerLocation($param) { 
        $return = array();
          $return['status'] = 'success'; 
        $lat        = isset($param['lat']) ? $param['lat'] : '';
        $lng        = isset($param['lng']) ? $param['lng'] : '';
        $distance   = isset($param['distance']) ? $param['distance'] : '';
        if ( $lat == '' ||  $lng == '' || $distance == '' ):
            $return['msg'] = 'Required parameter not provided';
            $this->jsonEncode($return);
        endif;
        
        $type       = isset($param['type']) ? $param['type'] : '';       
        if(!$this->getPosTypeByKeyword($type)):
            $type ='';
        endif;
        $typeCnd = empty($type)?'':" and  MT.id = '$type' ";
        $distanceCnd = empty($distance)?'':" having  distance < '$distance' ";
        $distanceOrder = " order by  distance asc ";
        
          $query = "SELECT  L.`merchant_phone` ,M.pos_url, M.business_name, MT.merchant_type, MT.keyword, L.`latitude` , L.`longitude` , L.`biller_name` , L.`biller_address` , L.`biller_city` , L.`biller_phone` , L.`biller_logo` , ( 3959 * ACOS( COS( RADIANS( $lat ) ) * COS( RADIANS( L.`latitude` ) ) * COS( RADIANS( L.`longitude` ) - RADIANS( $lng ) ) + SIN( RADIANS( $lat ) ) * SIN( RADIANS( L.`latitude` ) ) ) ) AS distance
                FROM  `merchants_biller_locations` L
                INNER JOIN merchants M ON L.`merchant_phone` = M.phone
                LEFT JOIN merchant_type MT ON M.type = MT.id
                WHERE L.is_active =1
                AND L.`is_delete` =0 ".$typeCnd.$distanceCnd.$distanceOrder;    
        $result = $this->conn->query($query);          
        
        if(!$result->num_rows || $result->num_rows==0):
            $return['msg'] = 'No data found';
            $return['row_count'] = '0';
            $this->jsonEncode($return);
        endif;    
         $return['status'] = 'success';     
        if($result->num_rows == 0):
            $return['msg'] = 'No data found';
            $return['row_count'] = '0';
            $this->jsonEncode($return);
        endif;
       
        $return['row_count'] = $result->num_rows;       
        
        while($row = $result->fetch_assoc()) {
            $return['result'][] = $row;
        }//end while.
             $this->jsonEncode($return);
    }
    
}

?>