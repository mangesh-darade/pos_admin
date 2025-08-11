<?php 

include_once('ccavConfig.php');  
include_once('Crypto.php');
 
    
$apiRequest = $_REQUEST['apiRequest']; 

$objMerchant = new merchant();
 
switch ($apiRequest) 
{
    case 'getMerchantData':
            
        $merchantData =  $objMerchant->get($_REQUEST['cust_id']);  
        
            echo $data = json_encode($merchantData);
        
        
        break;
    
    case 'setOrder':

           echo  $merchant_order_id = $objMerchant->set_merchant_order($_REQUEST);
        
        break;
    
    case 'setTransaction':


        break;
    
    case 'setOrderStatus':


        break;

    default:
        echo false;
        break;
}
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 ?>
 