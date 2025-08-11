<?php header('Access-Control-Allow-Origin: *'); 
global $conn;
$conn = new mysqli("localhost", "sitadmin_smpsafe", "$!T46@m!nD", "sitadmin_simplysafe");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{ echo "";
} 
// Check connection
 $MsgArr="";
 if (!empty($_REQUEST['action'])) {
	if ($_REQUEST['action'] == 'messageInsert')
	 {
		$MsgArr = messageInsert($_REQUEST['sender'],$_REQUEST['receiver'],$_REQUEST['subject'],$_REQUEST['message'],$_REQUEST);
	 }elseif ($_REQUEST['action'] == 'marchantURL')
	 {
		$MsgArr = marchantURL($_REQUEST['merchant']);
	 }elseif ($_REQUEST['action'] == 'custEmail')
	 {
		$MsgArr = custEmail();
	 }else { echo "";}
	 echo json_encode($MsgArr);
	}

	
//Message Insert
function messageInsert($sender,$receiver,$subject,$message,$request){   
$message = strip_tags($message);
    global $conn;
        $MsgArr = array();
        $req= serialize($request);
        if (!empty($sender) && !empty($receiver) && !empty($subject) && !empty($message)) {
         
            $type_arr = explode(',',$request['type']);
            $_email         = is_array($type_arr) &&  in_array('email',$type_arr)?1:0;
            $_sms           = is_array($type_arr) &&  in_array('sms',$type_arr)?1:0;
            $_push_message  = is_array($type_arr) &&  in_array('push_message',$type_arr)?1:0;
            
        
        	$sqlInsert = "INSERT INTO `vendor_messages` ( 
                                            `sender`,
                                            `receiver`,
                                            `subject`,
                                            `message`,`call_request`,`email`,`sms`,`push_message`
											)VALUES ( '".$sender."', '".$receiver."','".$subject."','".$message."','".$req."','".$_email."','".$_sms."','".$_push_message."')";

			if (mysqli_query($conn, $sqlInsert)) {
				$MsgArr["status"] = "Success";
				$MsgArr["ID"] = mysqli_insert_id($conn); 
				/*
				type (transactional or promotional)
				recipients (comma seperated customer phone numbers)
				merchant_id (optional)
				heading (heading of message)
				message (text message)
				unicode (optional)
				image_url (Url of promotional message, optional)
				*/
				$_MER =  MerchantByURL($request["refrer"]);
				
				$merchent_id = isset($_MER['phone'] ) && !empty($_MER['phone'] )?$_MER['phone'] :Null;
				$data = array(
					"type" => isset($request['msgtype'])?$request['msgtype']:'transactional', 
					"merchant_id" => $merchent_id,
					"recipients" => $receiver,
					"heading" => $subject,
					"message" => $message,
					"image_url" =>  isset($request['attachment'])?$request['attachment']:NULL, 
					"unicode" =>  isset($request['unicode'])?$request['unicode']:true, 
				);
				$surl = "https://simplypos.co.in/api/v1/pos/messages/customer/send";
				if($_push_message==1):
					$res = post_to_url($surl, $data);
					$MsgArr["tpresponse"] = $res;
				endif;	
				$MsgArr["msg"] = 'record inserted';
				return $MsgArr;
		    	} 
			} else {
                $MsgArr["status"] = "error";
                $MsgArr["msg"] = "all mandatory field are not pass";
        }
        return $MsgArr;
}

//Message Insert

//Customer Email list
function custEmail(){   
    global $conn;
        $MsgArr = array();
		$sql = "SELECT * FROM `vendor_messages`";
		$result=mysqli_query($conn,$sql);
		$rowcount=mysqli_num_rows($result);
		$err = array();
		
		if(count($rowcount) > 0){
			while($json = mysqli_fetch_array($result, MYSQLI_ASSOC)){
				$MsgArr[] = $json;
			}
			return $MsgArr;
		}
		$MsgArr['error'] = "No Records";
		return $MsgArr;
}

//Customer Email list
function MerchantByURL($url){   
    global $conn;
        $MsgArr = array();
	$sql = "SELECT phone FROM  `merchants` WHERE  `pos_url` ='$url' limit 1 ";
	$result=mysqli_query($conn,$sql);
	$rowcount=mysqli_num_rows($result);
	$err = array();
	
	if(count($rowcount) > 0){
		$json = mysqli_fetch_array($result, MYSQLI_ASSOC);
		return $json;
	}
	$MsgArr['error'] = "No Records";
	return $MsgArr;
}

//Customer Email list


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