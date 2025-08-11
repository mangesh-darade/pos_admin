<?php
header('Access-Control-Allow-Origin: *'); 
//Database Connection//
global $conn;
$conn = new mysqli("localhost", "sitadmin_smpsafe", "$!T46@m!nD", "sitadmin_simplysafe");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Check connection
//
// action condition
$test = '';

 if (!empty($_REQUEST['action'])) {
	 //
	 if($_REQUEST['action'] == 'authLogin')
     {
		 $MsgArr = authLogin($_REQUEST['username'] , $_REQUEST['password']);
	 }elseif ($_REQUEST['action'] == 'addCustomer')
	 {
		$MsgArr = addCustomer($_REQUEST['name'] ,$_REQUEST['dueDate'] , $_REQUEST['mobile'],$_REQUEST['address'],$_REQUEST['clientId']);
	 }elseif ($_REQUEST['action'] == 'addPayment')
	 {
		$MsgArr = addPayment($_REQUEST['custId'] , $_REQUEST['monthOfBilling'],$_REQUEST['date'] , $_REQUEST['amount'], $_REQUEST['clientId']);
	 }elseif ($_REQUEST['action'] == 'addPaperdiry')
	 {
		$MsgArr = addPaperdiry($_REQUEST['date_time'] , $_REQUEST['cust_id'],$_REQUEST['cost'], $_REQUEST['quantity'],$_REQUEST['press']);
	 }elseif ($_REQUEST['action'] == 'addPress')
	 {
		$MsgArr = addPress($_REQUEST['name'],$_REQUEST['defaultCost']);
	 }elseif ($_REQUEST['action'] == 'addSetting')
	 {
		$MsgArr = addSetting($_REQUEST['duedate'] , $_REQUEST['cost_default'],$_REQUEST['customer'],$_REQUEST['press']);
	 }elseif ($_REQUEST['action'] == 'updatePress')
	 {
		$MsgArr = updatePress($_REQUEST['id'] , $_REQUEST['name'], $_REQUEST['defaultCost']);
	 }elseif ($_REQUEST['action'] == 'allCustomer')
	 {
		$MsgArr = allCustomer();
	 }elseif ($_REQUEST['action'] == 'updateCustomer')
	 {
		$MsgArr = updateCustomer( $_REQUEST['name'], $_REQUEST['dueDate'], $_REQUEST['mobile'], $_REQUEST['address'],$_REQUEST['clientId'],$_REQUEST['id']);
	 }elseif ($_REQUEST['action'] == 'updatePayment')
	 {
		$MsgArr = updatePayment($_REQUEST['custId'] , $_REQUEST['monthOfBilling'],$_REQUEST['date'] , $_REQUEST['amount'], $_REQUEST['clientId'],$_REQUEST['id']);
	 }elseif ($_REQUEST['action'] == 'updatePdirectory')
	 {
		$MsgArr = updatePdirectory($_REQUEST['id'] , $_REQUEST['cust_id'], $_REQUEST['cost'], $_REQUEST['quantity'], $_REQUEST['press']);
	 }elseif ($_REQUEST['action'] == 'updateSetting')
	 {
		$MsgArr = updateSetting($_REQUEST['id'] , $_REQUEST['duedate'], $_REQUEST['cost_default'], $_REQUEST['customer'], $_REQUEST['press']);
	 }elseif ($_REQUEST['action'] == 'deletePress')
	 {
		$MsgArr = deletePress($_REQUEST['id']);
	 }elseif ($_REQUEST['action'] == 'deleteSetting')
	 {
		$MsgArr = deleteSetting($_REQUEST['id']);
	 }elseif ($_REQUEST['action'] == 'deletePdirectory')
	 {
		$MsgArr = deletePdirectory($_REQUEST['id']);
	 }elseif ($_REQUEST['action'] == 'deletePayment')
	 {
		$MsgArr = deletePayment($_REQUEST['id']);
	 }elseif ($_REQUEST['action'] == 'deleteCustomer')
	 {
		$MsgArr = deleteCustomer($_REQUEST['id']);
	 }elseif ($_REQUEST['action'] == 'allPress')
	 {
		$MsgArr = allPress();
	 }elseif ($_REQUEST['action'] == 'regUser')
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
	 }elseif ($_REQUEST['action'] == 'forgetPass')
	 {
		$MsgArr = forgetPass($_REQUEST['email']);
	 }elseif ($_REQUEST['action'] == 'updateForgetpass')
	 {
		$MsgArr = updateForgetpass($_REQUEST['password'],$_REQUEST['email']);
	 }elseif ($_REQUEST['action'] == 'custEmail')
	 {
		$MsgArr = custEmail();
	 }else { echo "";}
	 echo json_encode($MsgArr);
    }
// action condition
//

//Addcustomer
function addCustomer($name,$dueDate,$mobile,$address,$clientId){   
    global $conn;
        $MsgArr = array();
	//$dob = date('Y-m-d', strtotime($dob));
	$dueDate = date('Y-m-d', strtotime($dueDate));
        if (!empty($name) && !empty($dueDate) && !empty($mobile) && !empty($address)&& !empty($clientId)) {
            $sqlInsert = "INSERT INTO `customers` ( 
                                            `name` ,
                                            `dueDate`,
                                            `mobile`,
                                            `address`,
											`clientId`
											)VALUES ( '".$name."', '".$dueDate."','".$mobile."','".$address."','".$clientId."')";

			if (mysqli_query($conn, $sqlInsert)) {
				$MsgArr["res"] = "success";
				$MsgArr["ID"] = mysqli_insert_id($conn); 
				return $MsgArr;
			} 
			} else {
                $MsgArr["res"] = "error";
                $MsgArr["msg"] = "all mandatory field are not pass";
        }
        return $MsgArr;
}



//all customer
function allCustomer(){   
    global $conn;
        $MsgArr = array();
		$sql = "SELECT * FROM `customers`";
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
//all customer

//all press
function allPress(){   
    global $conn;
        $MsgArr = array();
		$sql = "SELECT * FROM `press`";
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
//all press


//customer update
function updateCustomer($name,$dueDate,$mobile,$address,$clientId,$id){   
    global $conn;
        $MsgArr = array();
        $dueDate = date('Y-m-d', strtotime($dueDate));
        if (!empty($name) && !empty($dueDate) && !empty($mobile) && !empty($address)&& !empty($clientId)) {
            $sqlupdate = "UPDATE `customers` SET `name`= '".$name."',`dueDate` = '".$dueDate."',`mobile` = '".$mobile."',`address` = '".$address."',`clientId` = '".$clientId."' WHERE `id`= '".$id."' ";
			if (mysqli_query($conn, $sqlupdate)) {
				$MsgArr["res"] = "Update success";
				$MsgArr["ID"] = $id;
				return $MsgArr;
			} 
			} else {
                $MsgArr["res"] = "error";
                $MsgArr["msg"] = "all mandatory field are not pass";
        }
        return $MsgArr;
}
//customer update

//customer Delete
function deleteCustomer($id){   
    global $conn;
        $MsgArr = array();
        if (!empty($id)) {
            $sqldelete = "DELETE FROM `customers`  WHERE `id`= '".$id."' ";
			if (mysqli_query($conn, $sqldelete)) {
				$MsgArr["res"] = "Deleted successfully";
				$MsgArr["ID"] = $id;
				return $MsgArr;
			} 
			} else {
                $MsgArr["res"] = "error";
                $MsgArr["msg"] = "all mandatory field are not pass";
        }
        return $MsgArr;
}
//Payment delete

//Addcustomer


//Payment
function addPayment($custId,$monthOfBilling,$date,$amount,$clientId){   
    global $conn;
        $MsgArr = array();
        if (!empty($custId) && !empty($monthOfBilling) && !empty($date) && !empty($amount) && !empty($clientId)) {
            $sqlInsert = "INSERT INTO `payments` ( 
                                            `custId` ,
                                            `monthOfBilling` , 
                                            `date`,
                                            `amount`,
                                            `clientId`
											)VALUES ( '".$custId."', '".$monthOfBilling."', '".$date."','".$amount."','".$clientId."')";

			if (mysqli_query($conn, $sqlInsert)) {
				$MsgArr["res"] = "success";
				$MsgArr["ID"] = mysqli_insert_id($conn); 
				return $MsgArr;
			} 
			} else {
                $MsgArr["res"] = "error";
                $MsgArr["msg"] = "all mandatory field are not pass";
        }
        return $MsgArr;
}


//Payment update
function updatePayment($custId,$monthOfBilling,$date,$amount,$clientId,$id){   
    global $conn;
        $MsgArr = array();
        if (!empty($custId) && !empty($monthOfBilling) && !empty($date) && !empty($amount) &&!empty($clientId)&& !empty($id)) {
            $sqlupdate = "UPDATE `payments` SET `custId`= '".$custId."',`monthOfBilling` = '".$monthOfBilling."',`date` = '".$date."',`amount` = '".$amount."',`clientId` = '".$clientId."' WHERE `id`= '".$id."' ";
			if (mysqli_query($conn, $sqlupdate)) {
				$MsgArr["res"] = "Update success";
				$MsgArr["ID"] = $id;
				return $MsgArr;
			} 
			} else {
                $MsgArr["res"] = "error";
                $MsgArr["msg"] = "all mandatory field are not pass";
        }
        return $MsgArr;
}
//Payment update

//Payment Delete
function deletePayment($id){   
    global $conn;
		$id    = isset($_REQUEST["id"]) && !empty($_REQUEST["id"])?$_REQUEST["id"]:'';
        $MsgArr = array();
        if (!empty($id)) {
            $sqldelete = "DELETE FROM `payments`  WHERE `id`= '".$id."' ";
			if (mysqli_query($conn, $sqldelete)) {
				$MsgArr["res"] = "Deleted successfully";
				$MsgArr["ID"] = $id;
				return $MsgArr;
			} 
			} else {
                $MsgArr["res"] = "error";
                $MsgArr["msg"] = "all mandatory field are not pass";
        }
        return $MsgArr;
}
//Payment delete

//Payment



//Paper Directory
function addPaperdiry($date_time,$cust_id,$cost,$quantity,$press){   
    global $conn;
        $MsgArr = array();
        if (!empty($cust_id) && !empty($cost) && !empty($quantity) && !empty($press) && !empty($date_time)) {
            $sqlInsert = "INSERT INTO `paper-directory` ( 
                                            `cust_id` ,
                                            `cost` , 
                                            `date_time`,
                                            `quantity`,
                                            `press`
											)VALUES ( '".$cust_id."', '".$cost."', '".$date_time."','".$quantity."','".$press."')";

			if (mysqli_query($conn, $sqlInsert)) {
				$MsgArr["res"] = "success";
				$MsgArr["ID"] = mysqli_insert_id($conn); 
				return $MsgArr;
			} 
			} else {
                $MsgArr["res"] = "error";
                $MsgArr["msg"] = "all mandatory field are not pass";
        }
        return $MsgArr;
}




//Paper Directory update
function updatePdirectory($id, $cust_id, $cost,$quantity, $press){   
    global $conn;
        $MsgArr = array();
        if (!empty($cust_id) && !empty($cost) && !empty($quantity) && !empty($press)) {
            $sqlupdate = "UPDATE `paper-directory` SET `cust_id`= '".$cust_id."',`cost` = '".$cost."',`quantity` = '".$quantity."',`press` = '".$press."' WHERE `id`= '".$id."' ";
			if (mysqli_query($conn, $sqlupdate)) {
				$MsgArr["res"] = "Update success";
				$MsgArr["ID"] = $id;
				return $MsgArr;
			} 
			} else {
                $MsgArr["res"] = "error";
                $MsgArr["msg"] = "all mandatory field are not pass";
        }
        return $MsgArr;
}
//Paper Directory update


//Paper Directory Delete
function deletePdirectory($id){   
    global $conn;
        $MsgArr = array();
        if (!empty($id)) {
            $sqldelete = "DELETE FROM `paper-directory`  WHERE `id`= '".$id."' ";
			if (mysqli_query($conn, $sqldelete)) {
				$MsgArr["res"] = "Deleted successfully";
				$MsgArr["ID"] = $id;
				return $MsgArr;
			} 
			} else {
                $MsgArr["res"] = "error";
                $MsgArr["msg"] = "all mandatory field are not pass";
        }
        return $MsgArr;
}
//Paper DirectoryDelete

//Payment



//Press
function addPress($name,$defaultCost){   
    global $conn;
        $MsgArr = array();
        if (!empty($name) && !empty($defaultCost)) {
            $sqlInsert = "INSERT INTO `press` ( 
                                            `name` ,
                                            `defaultCost`
											)VALUES ( '".$name."', '".$defaultCost."')";

			if (mysqli_query($conn, $sqlInsert)) {
				$MsgArr["res"] = "success";
				$MsgArr["ID"] = mysqli_insert_id($conn); 
				return $MsgArr;
			} 
			} else {
                $MsgArr["res"] = "error";
                $MsgArr["msg"] = "all mandatory field are not pass";
        }
        return $MsgArr;
}

//press update
function updatePress($id, $name, $defaultCost){   
    global $conn;
        $MsgArr = array();
        if (!empty($name) && !empty($defaultCost)&& !empty($id)) {
            $sqlupdate = "UPDATE `press` SET `name`= '".$name."',`defaultCost` = '".$defaultCost."' WHERE `id`= '".$id."' ";
			if (mysqli_query($conn, $sqlupdate)) {
				$MsgArr["res"] = "Update success";
				$MsgArr["ID"] = $id;
				return $MsgArr;
			} 
			} else {
                $MsgArr["res"] = "error";
                $MsgArr["msg"] = "all mandatory field are not pass";
        }
        return $MsgArr;
}
//press update



//press Delete
function deletePress($id){   
    global $conn;
        $MsgArr = array();
        if (!empty($id)) {
            $sqldelete = "DELETE FROM press WHERE `id`= '".$id."' ";
			if (mysqli_query($conn, $sqldelete)) {
				$MsgArr["res"] = "Deleted successfully";
				$MsgArr["ID"] = $id;
				return $MsgArr;
			} 
			} else {
                $MsgArr["res"] = "error";
                $MsgArr["msg"] = "all mandatory field are not pass";
        }
        return $MsgArr;
}
//press Delete



//Press

//Setting
function addSetting($duedate,$cost_default,$customer,$press){   
    global $conn;
        $MsgArr = array();
        if (!empty($cost_default) && !empty($customer) && !empty($duedate) && !empty($press)) {
            $sqlInsert = "INSERT INTO `setting` ( 
                                            `cost_default` ,
                                            `customer` , 
                                            `duedate`,
                                            `press`
											)VALUES ( '".$cost_default."', '".$customer."', '".$duedate."','".$press."')";

			if (mysqli_query($conn, $sqlInsert)) {
				$MsgArr["res"] = "success";
				$MsgArr["ID"] = mysqli_insert_id($conn); 
				return $MsgArr;
			} 
			} else {
                $MsgArr["res"] = "error";
                $MsgArr["msg"] = "all mandatory field are not pass";
        }
        return $MsgArr;
}


//Setting update
function updateSetting($id, $duedate, $cost_default,$customer, $press){   
    global $conn;
        $MsgArr = array();
        if (!empty($cost_default) && !empty($customer) && !empty($duedate) && !empty($press)&& !empty($id)) {
            $sqlupdate = "UPDATE `setting` SET `cost_default`= '".$cost_default."',`customer` = '".$customer."',`press` = '".$press."',`duedate` = '".$duedate."' WHERE `id`= '".$id."' ";
			if (mysqli_query($conn, $sqlupdate)) {
				$MsgArr["res"] = "Update success";
				$MsgArr["ID"] = $id;
				return $MsgArr;
			} 
			} else {
                $MsgArr["res"] = "error";
                $MsgArr["msg"] = "all mandatory field are not pass";
        }
        return $MsgArr;
}
//Setting update

//Setting Delete
function deleteSetting($id){   
    global $conn;
        $MsgArr = array();
        if (!empty($id)) {
            $sqldelete = "DELETE FROM `setting`  WHERE `id`= '".$id."' ";
			if (mysqli_query($conn, $sqldelete)) {
				$MsgArr["res"] = "Deleted successfully";
				$MsgArr["ID"] = $id;
				return $MsgArr;
			} 
			} else {
                $MsgArr["res"] = "error";
                $MsgArr["msg"] = "all mandatory field are not pass";
        }
        return $MsgArr;
}
//Setting Delete


//Register User
function regUser($name,$email,$phone,$username,$message,$type,$password,$address){   
    global $conn;
        $MsgArr = array();
        if (!empty($name) && !empty($email) && !empty($phone) && !empty($username) && !empty($type)&& !empty($password)) {
            $sqlInsert = "INSERT INTO `merchants` (`name`,`email`,`phone`,`username`,`type`,`password`)VALUES ( '".$name."', '".$email."', '".$phone."','".$username."','".$type."','".md5($password)."')";
			if (mysqli_query($conn, $sqlInsert)) {
				$MsgArr["res"] = "Success";
				$MsgArr["ID"] = mysqli_insert_id($conn);
				$MsgArr['merchant_code'] = $phone;
				return $MsgArr;
			}
			else{
				$MsgArr["res"] = "Error";
				$MsgArr['msg'] = mysqli_error($conn);
			}
		}
		else {
            $MsgArr["res"] = "Error";
            $MsgArr["msg"] = "All Mandatory Field Are Not Pass";
        }
        return $MsgArr;
}
//Register User	

//login Function//
function authLogin($username , $password) {
    global $conn;
     $MsgArr = array();
    $sql = "SELECT * FROM `merchants`  WHERE `username` = '$username'  AND `password` = '".md5($password)."'";
	$result=mysqli_query($conn,$sql);
	$rowcount=mysqli_num_rows($result);
	$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
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

//Forget Password Function//
function forgetPass($email) {
    global $conn;
     $MsgArr = array();
    $sql = "SELECT * FROM `merchants`  WHERE `email` = '$email'";
	$result=mysqli_query($conn,$sql);
	$rowcount=mysqli_num_rows($result);
	$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
    if($row){
        //return $row;
        $MsgArr ="Thank You";
        return $MsgArr;
    }else{
        $MsgArr="Email did not match";
	
    }
    return $MsgArr;
}

//Forget Password Function//

//updateForgetpass update
function updateForgetpass($password, $email){   
    global $conn;
        $MsgArr = array();
        if (!empty($password && !empty($email))) {
            $sqlupdate = "UPDATE `merchants` SET `password`= '".md5($password)."' WHERE `email`= '".$email."' ";
			if (mysqli_query($conn, $sqlupdate)) {
				$MsgArr["res"] = "Update success";
				$MsgArr["Email"] = $email;
				return $MsgArr;
			} 
			} else {
                $MsgArr["res"] = "error";
                $MsgArr["msg"] = "Something went wrong";
        }
        return $MsgArr;
}
//updateForgetpass update

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