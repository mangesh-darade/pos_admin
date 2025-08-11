<?php
header('Access-Control-Allow-Origin: *'); 
global $conn;
$conn = new mysqli("localhost", "sitadmin_smpsafe", "$!T46@m!nD", "sitadmin_simplysafe");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Check connection

$MsgArr="";
 if (!empty($_REQUEST['action'])) {
	if ($_REQUEST['action'] == 'regUser')
	 {
		$MsgArr = regUser($_REQUEST['name'],$_REQUEST['email'],$_REQUEST['phone'],$_REQUEST['username'],$_REQUEST['message'],$_REQUEST['type'],$_REQUEST['password'],$_REQUEST['address']);
	 }elseif ($_REQUEST['action'] == 'authLogin')
	 {
		$MsgArr = authLogin($_REQUEST['username'],$_REQUEST['password']);
	 }elseif ($_REQUEST['action'] == 'merchantsType')
	 {
		$MsgArr = merchantsType(1);
	 }elseif ($_REQUEST['action'] == 'merchantsTypes')
	 {
		$MsgArr = merchantsType(0);
	 }elseif ($_REQUEST['action'] == 'custEmail')
	 {
		$MsgArr = custEmail();
	 }else { echo "";}
	 echo json_encode($MsgArr);
	}
	

//Register User
function regUser($name,$email,$phone,$username,$message,$type,$password,$address){   
    global $conn;
        $MsgArr = array();
        if (!empty($name) && !empty($email) && !empty($phone) && !empty($username) && !empty($message)&& !empty($type)&& !empty($password)&& !empty($address)) {
            $sqlInsert = "INSERT INTO `merchants` ( 
                                            `name` ,
                                            `email` , 
                                            `phone`,
                                            `username`,
                                            `message`,
                                            `type`,
											`password`,`address`
											)VALUES ( '".$name."', '".$email."', '".$phone."','".$username."','".$message."','".$type."','".md5($password)."','".$address."')";

			if (mysqli_query($conn, $sqlInsert)) {
				$MsgArr["res"] = "Success";
				$MsgArr["ID"] = mysqli_insert_id($conn); 
				return $MsgArr;
			} 
			} else {
                $MsgArr["res"] = "Error";
                $MsgArr["msg"] = "All Mandatory Field Are Not Pass";
        }
        return $MsgArr;
}
//Register User	


//login Function//
function authLogin($username , $password) {
    global $conn;
    $sql = "SELECT * FROM `merchants`  WHERE `username` = '$username'  AND `password` = '".md5($password)."'";
	$result=mysqli_query($conn,$sql);
	$rowcount=mysqli_num_rows($result);
	$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
	$MsgArr= array();
    if($row){
        return $row;
        //$MsgArr ="Login Successfully";
        //return $MsgArr;
    }else{
        $MsgArr="Username and Password did not match";
	
    }
    return $MsgArr;
}

//login Function//

//Merchant Type Combo Function//
function merchantsType($mobile) {
  global $conn;
        $MsgArr = array();
//		echo $mobile; exit;
		if($mobile == 1){
			$sql = "SELECT `id`,`merchant_type` FROM `mt` Where `show_in_mobile` = '1' and `is_active` = '1'";
		}
		else{
			$sql = "SELECT `id`,`merchant_type` FROM `mt` Where `show_in_mobile` = '0' and `is_active` = '1'";
		}
		$result=mysqli_query($conn,$sql);
		$rowcount=mysqli_num_rows($result);
		$err = array();
		
		if(count($rowcount) > 0){
			while($json = mysqli_fetch_array($result, MYSQLI_ASSOC)){
				$MsgArr[$json['id']] = $json['merchant_type'];
			}
			return $MsgArr;
		}
		$MsgArr['error'] = "No Records";
		return $MsgArr;
}

//Merchant Type Combo Function//

//Customer Email list
function custEmail(){   
    global $conn;
        $MsgArr = array();
		$sql = "SELECT * FROM `sma_custemail`";
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

?>