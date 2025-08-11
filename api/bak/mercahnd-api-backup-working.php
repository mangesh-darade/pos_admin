<?php
header('Access-Control-Allow-Origin: *'); 
global $conn;
$conn = new mysqli("localhost", "sitadmin_smpsafe", "$!T46@m!nD", "sitadmin_simplysafe");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{ //echo "Connected";
}
// Check connection
$MsgArr="";
 if (!empty($_REQUEST['action'])) {
	if ($_REQUEST['action'] == 'marchantRequest')
	 {
		$MsgArr = marchantRequest($_REQUEST['merchant'],$_REQUEST['customerName'],$_REQUEST['customerMobile']);
	 }elseif ($_REQUEST['action'] == 'marchantURL')
	 {
		$MsgArr = marchantURL($_REQUEST['merchant']);
	 }else { echo "";}
	 echo json_encode($MsgArr);
	}
	
	
//Register User
function marchantRequest($merchant,$customerName,$customerMobile){   
    global $conn;
        $MsgArr = array();
        //if (!empty($merchant) && !empty($customerName) && !empty($customerMobile)) {
        $sqlInsert = "SELECT `status` FROM `merchant_requests` WHERE `merchant_code` = $merchant AND `customer_code` = $customerMobile";
	$result=mysqli_query($conn,$sqlInsert );
	$rowcount=mysqli_num_rows($result);
	$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
	if($rowcount == 1){
		$MsgArr['Status'] =$row['status'];
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

			mysqli_query($conn, $sqlInserts);
			$sqlInserts = "SELECT * FROM `merchants` WHERE `phone` = $merchant";
			//$result = mysqli_query($conn,$sqlInsert );
			//$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
			
			if ($result = mysqli_query($conn, $sqlInserts)) {
				$MsgArr["status"] = "Pending";
				$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
				//var_dump($row);exit;
				$MsgArr["res"] = $row;
				$MsgArr["ID"] = mysqli_insert_id($conn); 
				return $MsgArr;
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
				//$MsgArr["status"] = "Pending";
				$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
				//var_dump($row);exit;
				//$row = stripslashes_deep($row);

				$MsgArr = $row;
				//$MsgArr["ID"] = mysqli_insert_id($conn);
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
?>