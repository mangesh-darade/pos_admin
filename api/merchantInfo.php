<?php   
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
header('Access-Control-Allow-Credentials: true');

if (version_compare(PHP_VERSION, '5.3', '>='))
{
	error_reporting(E_ALL & E_NOTICE & E_DEPRECATED & E_STRICT & E_USER_NOTICE & ~E_USER_DEPRECATED);
}
else
{
	error_reporting(E_ALL & E_NOTICE & E_STRICT & ~E_USER_NOTICE);
}

global $objapp; 
		
include_once('../include/config.php');

include_once "../include/classes/baseClass.php";

$objapp = new baseClass($conn);
 
 
spl_autoload_register(function ($class_name) {
    include_once "../include/classes/".$class_name . '.php';
});
    
    $getParam = $_REQUEST; 
    
    $phone  = isset($getParam['phone']) && !empty($getParam['phone'])?$getParam['phone']:''; 
    $apikey = isset($getParam['apikey']) && !empty($getParam['apikey'])?$getParam['apikey']:'';
    
    $objApi =  new apiRequests( $apikey);
 
    switch ($getParam['action']) 
    {
        case 'merchantInfo':
            
               $res =  $objApi->marchantPackageInfo($phone); 
            
            break;

        case 'updateSmsCounter':
		$res =  $objApi->updateSmsCounter($phone);

            break;
            
         case 'update_pos_customer':
            
             $res =  $objApi->UpdatePosCustomer($getParam);
	   break;
	   
	 case 'saveBillerLocation':        
	
             $res =  $objApi->UpdateBillerLocation($getParam);
	   break;  

 	case 'DeleteBillerLocation':        
	
             $res =  $objApi->DeleteBillerLocation($getParam);
	   break;  
	      
	 case 'MERCHANT_TYPE':        
	
             $res =  $objApi->posType($getParam);
	   break;  

 	case 'MERCHANT_SEARCH':        
	
             $res =  $objApi->getBillerLocation($getParam);
	   break;  
	
       //UrbanPiper Order manage
       case 'updateUPOrders':
		$res =  $objApi->updateMerchantUPPackageCounts($phone);

            break;

        default:
        
            break;
}
    
    
    
         
    
function printArray($arr) {
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
}  
?>