<?php include_once('ccavConfig.php'); ?>

<?php

 $objapp->authenticateMerchant();

 $objMerchant = new merchant;

 $merchantData =  $objMerchant->get($objapp->authMerchantId); 
 

?>
<?php  include_once('Crypto.php')?>
<html>
<head>
<title> Set checkout Order </title>
</head>
<body>
<center> 
<?php 
       	$merchant_order_id = $objMerchant->set_merchant_order($_POST);
       
     	$_POST['order_id'] = $merchant_order_id; 
     
     	foreach ($_POST as $key => $value) {
	
		$merchant_checkout_data.=$key.'='.urlencode($value).'&';
	} 

	 $encrypted_data = encrypt($merchant_checkout_data,$working_key); // Method for encrypting the data.
       
?>
<!-- <form method="post" name="redirect" action="<?php echo $Checkout_Submit_Url;?>"> -->

<form method="post" name="redirect" action="https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction"> 
<?php
	/*if(is_array($_POST)) {
	    foreach ($_POST as $key => $value){
	         echo "<input type='hidden' name='$key' value='$value' />";
	    }
	}*/
	
	echo "<input type='hidden' name='encRequest' value='$encrypted_data'>";
	echo "<input type='hidden' name='access_code' value='$access_code'>"; 
?>
</form>

</center>
 
 <script language='javascript' type="text/javascript">document.redirect.submit();</script> 
</body>
</html>

