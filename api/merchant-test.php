<?php header('Access-Control-Allow-Origin: *');
global $conn;
$conn = new mysqli("localhost", "sitadmin_smpsafe", "$!T46@m!nD", "sitadmin_simplysafe");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{ //echo "Connected";
} 
// Check connection
?>


<?php $MsgArr="";
 if (!empty($_REQUEST['action'])) {
	if ($_REQUEST['action'] == 'marchantRequest')
	 {
		$MsgArr = marchantRequest($_REQUEST['merchant'],$_REQUEST['customerName'],$_REQUEST['customerMobile']);
	 }elseif ($_REQUEST['action'] == 'marchantURL')
	 {
		$MsgArr = marchantURL($_REQUEST['merchant']);
	 }elseif ($_REQUEST['action'] == 'updateStatus')
	 {
		$MsgArr = updateStatus($_REQUEST['merchant'],$_REQUEST['customerMobile'],$_REQUEST['status']);
	 }elseif ($_REQUEST['action'] == 'deleteRequest')
	 {
		$MsgArr = deleteRequest($_REQUEST['merchant'],$_REQUEST['customerMobile']);
	 }elseif ($_REQUEST['action'] == 'sendSms')
	 {
		$MsgArr = sendSms($_REQUEST['msg'],$_REQUEST['mobile']);
	 }else { echo "";}
	 echo json_encode($MsgArr);
	}
	
//	
//Register User
function marchantRequest($merchant,$customerName,$customerMobile){   
    global $conn;
        $MsgArr = array();
       
        //if (!empty($merchant) && !empty($customerName) && !empty($customerMobile)) {
        $sqlInsert = "SELECT `status` FROM `merchant_requests` WHERE `merchant_code` = $merchant AND `customer_code` = $customerMobile";
	$result=mysqli_query($conn,$sqlInsert );
	$rowcount=mysqli_num_rows($result);
	$row1=mysqli_fetch_array($result,MYSQLI_ASSOC);
	//$MsgArr["status"] = $row1;
	if ($rowcount > 0) {
	            $sqlInserts = "SELECT * FROM `merchants` WHERE `phone` = $merchant";
	            $result = mysqli_query($conn, $sqlInserts);
				$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
				//var_dump($row);exit;
				if($row1["status"] == "accepted" ){
				 $status_change = 1;
				}elseif($row1["status"] == "pending" ){
				 $status_change = 0;
				}elseif($row1["status"] == "declined" ){
				 $status_change = -1;
				}else { echo "";}
				$MsgArr["status"] = $status_change;
				//$MsgArr['status'] = $row1["status"];
				$MsgArr["res"] = $row;
				//marchantURL($merchant);
				$url = marchantURL($merchant);
			        $url = $url['pos_url']; 
				//echo $url;
				return $MsgArr;
			} 
	else 
	{
	
		if (!empty($merchant) && !empty($customerName) && !empty($customerMobile)) {
		
			$pending= "Pending";
            $sqlInserts= "INSERT INTO `merchant_requests` ( 
                                            `merchant_code` ,
                                            `customer_code` , 
                                            `customer_name`,
                                            `status`
											)VALUES ( '".$merchant."', '".$customerMobile."', '".$customerName."','".$pending."')";

			//mysqli_query($conn, $sqlInserts);
			
			if (mysqli_query($conn, $sqlInserts)) {
				$Inserts = "SELECT * FROM `merchants` WHERE `phone` = $merchant";
	            $result = mysqli_query($conn, $Inserts);
				$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
				if($row1["status"] == "Accepted" ){
				 $status_change = 1;
				}elseif($row1["status"] == "Pending" ){
				 $status_change = 0;
				}elseif($row1["status"] == "Declined" ){
				 $status_change = -1;
				}else { echo "";}
				$MsgArr["status"] = 0;
				$MsgArr["res"] = $row;
				$url = marchantURL($merchant);
				$url = $url['pos_url']; 
				$MsgArr["res"] = $row;
				$data = array(
				"api_key" => "435DSFSDFDSF743500909809DFSFJKJ234324534",
				"merchant_phone" => $merchant,
				"customer_name" => $customerName,
				"customer_mobile" => $customerMobile,
				"comment" => 'A customer sends a request for Eshop access. Do you want to approve ?',
				"action" => "getpasskey"
				);
				$surl = $url.'api/v2';
				$res = post_to_url($surl, $data);
			        
				//sms//
				$datasms = array(
				"user" => "simplysafe",
				"password" => "Simplysafe1$$",
				"msisdn" => "+91".$merchant,
				"sid" => "SIMPLY",
				"msg" => "Dear Merchant, Customer ".$customerName." send a request to you. Thanks and regards.",
				"fl" => 0,
				"gwid" => 2
				);
				$surlsms = 'http://payonlinerecharge.com/vendorsms/pushsms.aspx';
				$ressms = post_to_url($surlsms, $datasms);
				//sms//
				return $MsgArr;
				
				
				
				
				//return $MsgArr;
			} 
			} else {
		                $MsgArr["res"] = "error";
		                $MsgArr["msg"] = "All Mandatory Field Are Not Pass";
       			 }
	}
        return $MsgArr;
}
//Register User
function marchantURL($merchant){   
    global $conn;

        $MsgArr = array();
        if (!empty($merchant)) {
			$sqlInsert = "SELECT `pos_url` FROM `merchants` WHERE `phone` = $merchant";
			//$result = mysqli_query($conn,$sql);
			//$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
			if ($result = mysqli_query($conn, $sqlInsert)) {
				$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
				$MsgArr = $row;
				return $MsgArr;
			} 
			} else {
                $MsgArr["res"] = "error";
                $MsgArr["msg"] = "All Mandatory Field Are Not Pass";
        }

        return $MsgArr;
}

function stripslashes_deep($value)
{
    $value = is_array($value) ?
                array_map('stripslashes_deep', $value) :
                stripslashes($value);

    return $value;
}
//random password//
function random_password( $length = 8 ) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
    $password = substr( str_shuffle( $chars ), 0, $length );
    return $password;
}
//random password//


//Status update
function updateStatus($merchant,$customerMobile,$status){   
    global $conn;
        $MsgArr = array();
        if (!empty($merchant) && !empty($customerMobile)&& !empty($status)) {
           $pass_key= md5(random_password(8));
           
            $sqlupdate = "UPDATE `merchant_requests` SET `status`= '".$status."' WHERE `merchant_code`= '".$merchant."' AND `customer_code`= '".$customerMobile."'";
			if (mysqli_query($conn, $sqlupdate)) {
				if($status == "accepted" ){
				 $status_change = 1;
				}elseif($status == "pending" ){
				 $status_change = 0;
				}elseif($status == "declined" ){
				 $status_change = -1;
				}else { echo "";}
				$MsgArr["status"] = $status_change;
					$data = array(
					"customer_id" => $customerMobile,
					"merchant_id" =>$merchant,
					"status" => $status_change,
					"password" => $pass_key
					);
					$surl = "http://52.66.101.233/Customer-Backend/public/api/v1/customer/merchant/statusUpdate";
					$res = post_to_url($surl, $data);
				$MsgArr["res"] = $res;
				return $MsgArr;
			} 
			} else {
                $MsgArr["res"] = "error";
                $MsgArr["msg"] = "all mandatory field are not pass";
        }
        return $MsgArr;
}
//Status update


//Delete Request
function deleteRequest($merchant,$customerMobile){   
    global $conn;
        $MsgArr = array();
        if (!empty($merchant) && !empty($customerMobile)) {
             $sqldelete = "DELETE FROM `merchant_requests`  WHERE `merchant_code`= '".$merchant."' AND `customer_code`= '".$customerMobile."' ";
			if (mysqli_query($conn, $sqldelete)) {
				$select = "SELECT * FROM `merchants` WHERE `phone` = '".$merchant."' ";
	            $result = mysqli_query($conn, $select);
				$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
				$url = marchantURL($merchant);
				$url = $url['pos_url'];
				$MsgArr["status"] = "success";
				$MsgArr["CustomerId"] = $customerMobile;
				$datareq = array(
					"merchant" => $merchant,
					"customerMobile" =>$customerMobile,
					"action" => "deleteRequestpos"
					);
					$surlreq = $url.'adduser.php';
					$resreq = post_to_url($surlreq , $datareq );
				$MsgArr["res"] = $resreq ;
				return $MsgArr;
			} 
			} else {
                $MsgArr["res"] = "error";
                $MsgArr["msg"] = "all mandatory field are not pass";
        }
        return $MsgArr;
}
//Delete Request
function sendSms($msg,$mobile){   
    global $conn;
        $MsgArr = array();
        if (!empty($msg) && !empty($mobile)) {
	$datareqs= array(
	        "user" => "simplysafe",
		"password" => "Simplysafe1$$",
		"msisdn" => "+91$mobile",
		"sid" => "SIMPLY",
		"msg" => $msg,
		"fl" => 0,
		"gwid" => 2,
		"action" => "test"
		);
		$surlreqs = "http://payonlinerecharge.com/vendorsms/pushsms.aspx";
		$resreqs = post_to_url($surlreqs , $datareqs);
	$MsgArr["res"] = $resreqs ;
            //$MsgArr["res"] = "success";
			} else {
                $MsgArr["res"] = "error";
                $MsgArr["msg"] = "all mandatory field are not pass";
        }
        return $MsgArr;
}

	function post_to_url($url, $data) {
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
?>