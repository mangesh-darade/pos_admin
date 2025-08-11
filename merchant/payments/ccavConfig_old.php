<?php 
include_once('../../application_main.php'); 
    
$merchant_data  =   '109895';
$working_key    =   'B703BDF3FB2EA315F5A961FDE1CBFCAE';        //Shared by CCAVENUES
$access_code    =   'AVXP67DI17CG52PXGC';                      //Shared by CCAVENUES


 
switch(HOSTNAME) {
    case 'localhost':    
       
        $Checkout_Submit_Url        = "https://www.webkart.xyz/simplypos/merchant/payments/ccavRequestHandler.php";
        $Redirect_Url               = "http://localhost/simplypos.in/merchant/payments/ccavResponseHandler.php" ;
        $Edir_Package_Url           = "http://localhost/simplypos.in/merchant/package-upgrade.php" ;
    break;

    case 'webkart.xyz':
       
        $Checkout_Submit_Url        = "https://www.webkart.xyz/simplypos/merchant/payments/ccavRequestHandler.php";
        $Redirect_Url               = "https://www.webkart.xyz/simplypos/merchant/payments/ccavResponseHandler.php" ;
        $Edir_Package_Url           = "https://www.webkart.xyz/simplypos/merchant/package-upgrade.php" ;
    break;

    case 'simplypos.in':
    	
        $Checkout_Submit_Url        = "https://www.webkart.xyz/simplypos/merchant/payments/ccavRequestHandler.php";
        $Redirect_Url               = 'https://www.simplypos.in/merchant/payments/ccavResponseHandler.php';
        $Edir_Package_Url           = 'https://www.simplypos.in/merchant/package-upgrade.php';
    break; 
}
    

?>
