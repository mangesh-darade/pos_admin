<?php
$txt = json_encode($_REQUEST);
$servername = "localhost";
$username = "sitadmin_smpsafe";
$password = "$!T46@m!nD";
$dbname = "simadmin_simplysafe";
header('Access-Control-Allow-Origin: *'); 
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection


global $conn;
  
 
define('DATABASE_NAME', 'sitadmin_simplysafe');
define('DATABASE_USERNAME', 'sitadmin_smpsafe');
define('DATABASE_PASSWORD', '$!T46@m!nD');
 

$conn = new mysqli("localhost", DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);
 
 


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
if(isset($_REQUEST['data'])){
	$sql = "insert into `test` (data) values('$txt')";
	if ($conn->query($sql) === TRUE) {
		echo "New record created successfully";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
}
elseif(isset($_REQUEST['get'])){
    $merchantId = '';
    $sql="SELECT `phone` FROM merchants where pos_url = '".$_REQUEST['get']."'";
    if ($result=mysqli_query($conn,$sql))
    {
        $row=mysqli_fetch_row($result);
        $merchantId = $row[0];
        mysqli_free_result($result);
    }

    
	$sql="SELECT * FROM test WHERE  `data` LIKE  '%".$merchantId."A%' order by id desc limit 1";
    if ($result=mysqli_query($conn,$sql))
    {
        $row=mysqli_fetch_row($result);
        $tm = strtotime($row[2]);
		$tm1 = $row[2];
		$newtm = $tm - 60;
		$newtm = date('Y-m-d h:i:s',$newtm);
		$sql="SELECT * FROM `test` WHERE `data` LIKE  '%".$merchantId."A%' and `datetime` BETWEEN '$newtm' AND '$tm1' order by id desc ";
		$result=mysqli_query($conn,$sql);
		$tags = array();
		while ($row=mysqli_fetch_row($result))
        {
			$obj = json_decode($row[1]);
			$arr = explode(',',$obj->data);
			$arr = explode(':',$arr[5]);
			$tags[] = $arr[1];
        }
		echo implode(':',$tags);
        mysqli_free_result($result);
    }
}
else{
    $sql="SELECT * FROM test order by id desc limit 10";
    
    if ($result=mysqli_query($conn,$sql))
      {
      // Fetch one and one row
      while ($row=mysqli_fetch_row($result))
        {
        echo '<hr>';    
        var_dump($row);
    	echo '<hr>';
        }
      // Free result set
      mysqli_free_result($result);
    }
}
$conn->close();
?>