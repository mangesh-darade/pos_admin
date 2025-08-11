<?php 
include_once('../../application_main.php'); 
/*// WebKart.xyz  
$merchant_data  =   '109895';
$working_key    =   'B703BDF3FB2EA315F5A961FDE1CBFCAE';        //Shared by CCAVENUES
$access_code    =   'AVXP67DI17CG52PXGC';                      //Shared by CCAVENUES
*/



//Simplypos.in
$merchant_data  =   '122765';
$working_key    =   '4721099688A44228165B661BF3E1C548';        //Shared by CCAVENUES
$access_code    =   'AVQY69EB10AL75YQLA';                      //Shared by CCAVENUES

 
switch(HOSTNAME) {

    case 'localhost':    
       
        $Checkout_Submit_Url        = "https://www.simplypos.in/merchant/payments/ccavRequestHandler.php";
        $Redirect_Url               = "http://localhost/simplypos.in/merchant/payments/ccavResponseHandler.php" ;
        $Edir_Package_Url           = "http://localhost/simplypos.in/merchant/package-upgrade.php";
    break;

    case 'simplypos.in':
    	
        $Checkout_Submit_Url        = "https://www.simplypos.in/merchant/payments/ccavRequestHandler.php";
        $Redirect_Url               = 'https://www.simplypos.in/merchant/payments/ccavResponseHandler.php';
        $Edir_Package_Url           = 'https://www.simplypos.in/merchant/package-upgrade.php';
    break;
   
}
    

?>
