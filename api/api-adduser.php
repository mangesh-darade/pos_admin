<?php
header('Access-Control-Allow-Origin: *'); 
//Database Connection//
global $conn;
$conn = new mysqli("localhost", "sitadmin_useedur", "TrNQ89BOg~%r", "sitadmin_durgesh");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else { echo "connected"; }
// Check connection

if (!empty($_REQUEST['action'])) {
	if($_REQUEST['action'] == 'addPosuser')
	{
	 $MsgArr = addPosuser($_REQUEST['username'] , $_REQUEST['password']);
	}elseif ($_REQUEST['action'] == 'custEmail')
	 {
		$MsgArr = custEmail();
	 }else { echo "";}
	echo json_encode($MsgArr);
    }
    
    
 //Add User
function addPosuser($username,$password){   
   global $conn;
        $MsgArr = array();
        echo "123";
        $salt = substr(md5(uniqid(rand(), true)), 0, 9);
        echo "INSERT INTO `sma_users` ( 
                                            `username` ,
                                            `password`
											)VALUES ( '".$username."', '".sha1($salt . $password)."')";
        if (!empty($username) && !empty($password)) {
            $sqlInsert = "INSERT INTO  `sitadmin_durgesh`.`sma_users` ( 
                                            `username` ,
                                            `password`
											)VALUES ( '".$username."', '".sha1($salt . $password)."')";

			
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
//Add User
?>