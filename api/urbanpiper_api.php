<?php 
	header('Access-Control-Allow-Origin: *');
	global $conn;
	$conn = new mysqli("localhost", "sitadmin_smpsafe", "$!T46@m!nD", "sitadmin_simplysafe");
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} else { //echo "Connected";
	
	}
	$header = apache_request_headers();
	
	switch($header['Type']){
		
		case 'Order': // Add Customer Order
				 $jsonString = file_get_contents("php://input");
			         $phpObject = json_decode($jsonString);
			         header('Content-Type: application/json');
			         $getmarchant_ref_id = $phpObject->order->store->merchant_ref_id;
			         $marchaninfo =  marchantNo($getmarchant_ref_id);	
			         $URL = $marchaninfo['pos_url'].'urban_piper/add_order';
			         
			         
			         $order_log = array(
			         	'merchant_id'=>$marchaninfo['id'],
			         	'phone_no'=>$marchaninfo['phone'],
			         	'pos_url'=>$marchaninfo['pos_url'],
			         	'urbanpiper_order_id'=>$phpObject->order->details->id,
			         	'order_response'=> serialize($phpObject),
			         );
			         
			         $sql = "INSERT INTO urbanpiper_orders_log SET 
			         	merchant_id = '".$marchaninfo['id']."',
			         	phone_no= '".$marchaninfo['phone']."',
			         	pos_url= '".$marchaninfo['pos_url']."',
			         	urbanpiper_order_id = '".$phpObject->order->details->id."',
			         	order_response = '".serialize($phpObject)."'";
			        mysqli_query($conn, $sql);	
			         	   
			       $msg = pass_pos($URL,$jsonString);
			       echo json_encode($msg);
		 	break;
		    
	       case 'Order_Status': // Order Status
	       		$jsonString = file_get_contents("php://input");
			$phpObject = json_decode($jsonString);
			header('Content-Type: application/json');
			$sql = "Select id,pos_url from urbanpiper_orders_log where urbanpiper_order_id = '".$phpObject->order_id."'";
			$get_data = mysqli_query($conn, $sql);
			if(mysqli_num_rows($get_data)>0){
				$marchant_info = mysqli_fetch_assoc($get_data);
				$update_response ="UPDATE urbanpiper_orders_log SET order_status_response = '".serialize($phpObject)."' where id = '".$marchant_info['id']."' ";
				mysqli_query($conn, $update_response);
				$URL = $marchant_info['pos_url'].'urban_piper/orderstatus';
		       	       	$msg = pass_pos($URL,$jsonString);
				echo json_encode($msg);
		        }else{
		         	$response['status']="Error";
	       			echo json_encode($response);
		        }		
	       	
	       	    break;
	       
	       
	       case 'Rider_Status': //Rider Info
	       		$jsonString = file_get_contents("php://input");
			$phpObject = json_decode($jsonString);
			header('Content-Type: application/json');
			$sql = "Select id,pos_url from urbanpiper_orders_log where urbanpiper_order_id = '".$phpObject->order_id."'";
			$get_data = mysqli_query($conn, $sql);
			if(mysqli_num_rows($get_data)>0){
				$marchant_info = mysqli_fetch_assoc($get_data);
				
				$update_response ="UPDATE urbanpiper_orders_log SET rider_status_response= '".serialize($phpObject)."' where id = '".$marchant_info['id']."' ";
				mysqli_query($conn, $update_response);
				$URL = $marchant_info['pos_url'].'urban_piper/orderrider';
				$msg = pass_pos($URL,$jsonString);
				echo json_encode($msg);
	       		}else{
	       			$response['status']="Error";
	       			echo json_encode($response);
	       		}
	       	   break;
	       	    	    
	}
	
	
	function pass_pos($URL,$jsonString){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$URL);
	        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$jsonString);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response  = curl_exec($ch);
		curl_close($ch);
		return $response;
	}
	
	
	//Merchant number
	function marchantNo($merchant) {
	    global $conn;
	
	    $MsgArr = array();
	    if (!empty($merchant)) {
	        $sqlInsert = "SELECT `pos_url`,`id`,`phone` FROM `merchants` WHERE `phone` ='$merchant'";
	        //$result = mysqli_query($conn,$sql);
	        //$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
	        if ($result = mysqli_query($conn, $sqlInsert)) {
	            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	            $MsgArr = $row;
	            return $MsgArr;
	        }
	    } else {
	        $MsgArr["res"] = "error";
	        $MsgArr["msg"] = "All Mandatory Field Are Not Pass";
	    }
	
	    return $MsgArr;
	}
	
?>	
	