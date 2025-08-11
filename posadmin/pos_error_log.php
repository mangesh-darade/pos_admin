<?php

include_once('application_main.php');


// Action Condition Start//
$MsgArr = '';

 if (!empty($_REQUEST['action'])) {
	 
	 if($_REQUEST['action'] == 'setLog')
     {
		 $MsgArr = setLog($_REQUEST['merchant_id'] , $_REQUEST['pos_url'], $_REQUEST['error_url'], $_REQUEST['error_message'], $_REQUEST['error_time']);
	 }elseif ($_REQUEST['action'] == 'fetchMerchantid')
	 {
		$MsgArr = fetchMerchantid();
	 }elseif ($_REQUEST['action'] == 'addPayment')
	 {
		$MsgArr = addPayment();
	 }else { echo "";}
	 echo json_encode($MsgArr);
	 
    }
// Action Condition Start//


//Addcustomer
function setLog()
    {
    
    global $conn;
    
        $merchant_id  = 1;
        $pos_url  = isset($_REQUEST["pos_url"]) && !empty($_REQUEST["pos_url"])?$_REQUEST["pos_url"]:'';
        $error_url = isset($_REQUEST["error_url"]) && !empty($_REQUEST["error_url"])?$_REQUEST["error_url"]:'';
        $error_message  = isset($_REQUEST["error_message"]) && !empty($_REQUEST["error_message"])?$_REQUEST["error_message"]:'';
        $MsgArr = array();
        if (!empty($merchant_id) && !empty($pos_url) && !empty($error_url)&& !empty($error_message)) {
            
            $sqlInsert = "INSERT INTO `pos_error_log` ( 
                                            `merchant_id` ,
                                            `pos_url`, 
                                            `error_url`,
                                            `error_message`
			)
                        VALUES ( '$merchant_id', '$pos_url', '$error_url','$error_message')";
                       $result = $conn->query($sqlInsert);
			if ($result) {
				$MsgArr["result"] = "Success";
				$MsgArr["ID"] = mysqli_insert_id($conn); 
				return $MsgArr;
			} 
			} else {
                $MsgArr["res"] = "error";
                $MsgArr["msg"] = "All Mandatory Field Are Not Pass";
        }
        return $MsgArr;
}

//Fetch Merchant Id Start//
function fetchMerchantid(){   
    global $conn;
	$MsgArr = array();
		$sql = "SELECT * FROM `murchants`";
		$result=mysqli_query($conn,$sql);
		$rowcount=mysqli_num_rows($result);
		$err = array();
		
		if(count($rowcount) > 0){
			while($json = mysqli_fetch_array($result, MYSQLI_ASSOC)){
				$MsgArr[] = $json;
			}
			return $MsgArr;
		}else{
		$err['error'] = "Username and Password did not match.";
		return $err;
		}
	
}
//Fetch Merchant Id End//
?>