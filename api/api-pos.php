<?php
header('Access-Control-Allow-Origin: *'); 
global $conn;
$conn = new mysqli("localhost", "sitadmin_posuser", "^AkxhVrmHG}-", "sitadmin_pos1");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Check connection

$MsgArr="";
 if (!empty($_REQUEST['action'])) {
	if ($_REQUEST['action'] == 'custEmail')
	 {$MsgArr = custEmail();
	 }else { echo "";}
	 echo json_encode($MsgArr);
	}
	


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