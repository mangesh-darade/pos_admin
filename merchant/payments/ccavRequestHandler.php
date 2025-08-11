<?php include_once('ccavConfig.php'); ?>
<?php include_once('Crypto.php')?>
<html>
<head>
<title> Custom Form Kit </title>
</head>
<body>
<center> 
<?php         
 
	foreach ($_POST as $key => $value) {
	
		$merchant_checkout_data.=$key.'='.urlencode($value).'&';
	}

	 $encrypted_data=encrypt($merchant_checkout_data,$working_key); // Method for encrypting the data.

?>
<form method="post" name="redirect" action="https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction"> 
<?php
    echo "<input type='hidden' name='encRequest' value='$encrypted_data'>";
    echo "<input type='hidden' name='access_code' value='$access_code'>";    
   
?>
</form>
</center>
<?php 
 
 
?>
<script language='javascript'>document.redirect.submit();</script>
</body>
</html>

