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
		$MsgArr = regUser($_REQUEST['name'],$_REQUEST['email'],$_REQUEST['phone'],$_REQUEST['username'],$_REQUEST['message'],$_REQUEST['type'],$_REQUEST['password']);
	 }elseif ($_REQUEST['action'] == 'authLogin')
	 {
		$MsgArr = authLogin($_REQUEST['username'],$_REQUEST['password']);
	 }else { echo "";}
	 echo json_encode($MsgArr);
	}
	
	
//Register User
function regUser($name,$email,$phone,$username,$message,$type,$password){   
    global $conn;
        $MsgArr = array();
        if (!empty($name) && !empty($email) && !empty($phone) && !empty($username) && !empty($message)&& !empty($type)&& !empty($password)) {
            $sqlInsert = "INSERT INTO `merchants` ( 
                                            `name` ,
                                            `email` , 
                                            `phone`,
                                            `username`,
                                            `message`,
                                            `type`,
											`password`
											)VALUES ( '".$name."', '".$email."', '".$phone."','".$username."','".$message."','".$type."','".md5($password)."')";

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
	$err = array();
    if(count($rowcount) > 0){
        //return $row;
        $err['Success'] = "Login Successfully";
        return $err;
    }
		$err['error'] = "Username and Password did not match.";
		return $err;
}

//login Function//

?>