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
		$MsgArr = messageInsert($_REQUEST['sender'],$_REQUEST['receiver'],$_REQUEST['subject'],$_REQUEST['message']);
	 }elseif ($_REQUEST['action'] == 'marchantURL')
	 {
		$MsgArr = marchantURL($_REQUEST['merchant']);
	 }else { echo "";}
	 echo json_encode($MsgArr);
	}

	
//Addcustomer
function messageInsert($sender,$receiver,$subject,$message){   
    global $conn;
        $MsgArr = array();
        if (!empty($sender) && !empty($receiver) && !empty($subject) && !empty($message)) {
            $sqlInsert = "INSERT INTO `vendor_messages` ( 
                                            `sender`,
                                            `receiver`,
                                            `subject`,
                                            `message`
											)VALUES ( '".$sender."', '".$receiver."','".$subject."','".$message."')";

			if (mysqli_query($conn, $sqlInsert)) {
				$MsgArr["res"] = "Success";
				$MsgArr["ID"] = mysqli_insert_id($conn); 
				return $MsgArr;
			} 
			} else {
                $MsgArr["res"] = "error";
                $MsgArr["msg"] = "all mandatory field are not pass";
        }
        return $MsgArr;
}

//Add User
?>