<?php 
include_once('application_main.php');

$posPageName = "merchant"; 

$objapp->authenticateMerchant();

$objMerchant = new merchant();

$merchantData =  $objMerchant->get($objapp->authMerchantId);
 

function getchecksum($MerchantId,$Amount,$OrderId ,$URL,$WorkingKey) 
{ 
    $str ="$MerchantId|$OrderId|$Amount|$URL|$WorkingKey"; 
    $adler = 1;
    $adler = adler32($adler,$str); 
    return $adler; 
}   

function verifychecksum($MerchantId,$OrderId,$Amount,$AuthDesc,$CheckSum,$WorkingKey) 
{ 
    $str = "$MerchantId|$OrderId|$Amount|$AuthDesc|$WorkingKey"; 
    $adler = 1; 
    $adler = adler32($adler,$str);   
    if($adler == $CheckSum) 
        return "true" ; 
    else 
        return "false" ; 
}   


function adler32($adler , $str) 
{ 
    $BASE = 65521 ;   
    $s1 = $adler & 0xffff ; 
    $s2 = ($adler >> 16) & 0xffff; 
    for($i = 0 ; $i < strlen($str) ; $i++) 
    { 
        $s1 = ($s1 + Ord($str[$i])) % $BASE ; 
        $s2 = ($s2 + $s1) % $BASE ; 
    } 
    return leftshift($s2 , 16) + $s1; 
}  



function leftshift($str , $num) 
{   
    $str = DecBin($str);   
    for( $i = 0 ; $i < (64 - strlen($str)) ; $i++) 
        $str = "0".$str ;   
    for($i = 0 ; $i < $num ; $i++) 
        $str = $str."0"; $str = substr($str , 1 ) ;  
    return cdec($str) ; 
}   


function cdec($num) 
{   $dec = '';
    for ($n = 0 ; $n < strlen($num) ; $n++) 
    { 
        $temp = $num[$n] ; 
        $dec = $dec + $temp*pow(2 , strlen($num) - $n - 1); 
    }   
    return $dec; 
} 


$Merchant_Id = "109895" ;//This id(also User Id) available at "Generate Working Key" of "Settings & Options" 
$Amount = 1.00;//your script should substitute the amount in the quotes provided here 
$Order_Id = "101";//your script should substitute the order description in the quotes provided here 
$Redirect_Url = "https://webkart.xyz/simplypos/redirect.php" ;//your redirect URL where your customer will be redirected after authorisation from CCAvenue   
$WorkingKey = "B703BDF3FB2EA315F5A961FDE1CBFCAE" ;//put in the 32 bit alphanumeric key in the quotes provided here.Please note that get this key ,login to your CCAvenue merchant account and visit the "Generate Working Key" section at the "Settings & Options" page. 
$Checksum = getCheckSum($Merchant_Id,$Amount,$Order_Id ,$Redirect_Url,$WorkingKey);   
$billing_cust_name='Sunil Charde'; 
$billing_cust_address='Nagpur'; 
$billing_cust_state='Maharashtra'; 
$billing_cust_country='India';
$billing_cust_tel='88888888888';
$billing_cust_email='sunil.c@greatwebsoft.com'; 
$delivery_cust_name='Sunil Charde';  
$delivery_cust_address='Nagpur'; 
$delivery_cust_state = 'Maharashtra';
$delivery_cust_country = 'India';
$delivery_cust_tel='88888888888';
$delivery_cust_notes='customer Message';  
$billing_city = 'Nagpur'; 
$billing_zip = '440024'; 
$delivery_city = 'Nagpur'; 
$delivery_zip = '440024';
$Merchant_Param = ''; 
?>
<?php include_once '../header.php'; ?>

<div class="jumbotron">
	
    <div class="container-fluid">
        <?php include_once('left_sidebar.php'); ?>
        <div class="row">
            <?php
             
                extract($_POST);
                $plane_amount = ($billing_mode==12) ? $annualy_billing_package_price : $monthly_billing_package_price; 
                
                if($billing_mode == 12) 
                {
                    $total_amount = $billing_mode * $annualy_billing_package_price;
                    $anual_saving = ($monthly_billing_package_price * 12) - $anual_amount;                                   
                } else {
                    $total_amount = $billing_mode * $monthly_billing_package_price;
                }
            ?>
            
            <div class="col-sm-10 col-sm-push-2 col-xs-12">
                
                <h3>Selected Package Details</h3>
                <hr/>
                <table class="table">
                    <thead>
                      <tr>
                          <td><p class="text-left">Package:</p></th>
                          <td><p class="text-right">Advanced Plan</p></th>                         
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="text-left">Plan</td>
                        <td class="text-right"><i class="fa fa-inr"></i> <?php echo $plane_amount;?></td>                         
                      </tr>
                      <tr>
                        <td class="text-left">Billing Mode</td>
                        <td class="text-right">For <?php echo $billing_mode;?> Month</td>                         
                      </tr>
                      <tr>
                        <td class="text-left">1 Free Register included</td>
                        <td class="text-right"><i class="fa fa-inr"></i> 0</td>                         
                      </tr>
                   <?php if($billing_mode == 12){ ?>   
                      <tr>
                        <td class="text-left">Annual payment savings</td>
                        <td class="text-right"><i class="fa fa-inr"></i> <?php echo $anual_saving;?></td>                         
                      </tr>
                      <tr>
                          <td class="text-left"><p>Total per year (INR)</p></td>
                          <td class="text-right"><p><i class="fa fa-inr"></i> <?php echo $total_amount;?></p></td>                         
                      </tr>
                   <?php 
                         } 
                         else
                         {
                   ?>
                      <tr>
                          <td class="text-left"><p>Total per month (INR)</p></td>
                          <td class="text-right"><p><i class="fa fa-inr"></i> <?php echo $total_amount;?></p></td>                         
                      </tr> 
                    <?php }//end else. ?>
                    </tbody>
                 </table>
                
                <hr/>
                
                <?php if($Adons_PriorityPhoneSupport) { ?>
                <div class="box">                    
                    <h4>Support Package: Priority Phone Support</h4>
                    <h5>Total per month (INR) : <i class="fa fa-inr"></i> 99/- </h5>
                    <p>Priority Phone Support will be charged separately.</p>
                </div>
                <?php } ?>
                <hr/>
                <div class="row">
                <form name="paymentform" method="post" action="https://world.ccavenue.com/servlet/ccw.CCAvenueController">
                    
                    <a href="index.php" type="button" class="btn btn-primary btn-lg"><p>Edit Package</p></a>
                    <button type="submit" class="btn btn-success btn-lg"><p>Continue Payment</p></button>
                    

<input type="hidden" name="Merchant_Id" value="<?php echo $Merchant_Id; ?>"> 
<input type="hidden" name="Amount" value="<?php echo $Amount; ?>"> 
<input type="hidden" name="Order_Id" value="<?php echo $Order_Id; ?>">
<input type="hidden" name="Redirect_Url" value="<?php echo $Redirect_Url; ?>"> 
<input type="hidden" name="Currency" value="INR">
<input type="hidden" name="TxnType" value="A"> 
<input type="hidden" name="Checksum" value="<?php echo $Checksum; ?>"> 
<input type="hidden" name="billing_cust_name" value="<?php echo $billing_cust_name; ?>"> 
<input type="hidden" name="billing_cust_address" value="<?php echo $billing_cust_address; ?>"> 
<input type="hidden" name="billing_cust_country" value="<?php echo $billing_cust_country; ?>"> 
<input type="hidden" name="billing_cust_state" value="<?php echo $billing_cust_state; ?>"> 
<input type="hidden" name="billing_zip" value="<?php echo $billing_zip; ?>"> 
<input type="hidden" name="billing_cust_tel" value="<?php echo $billing_cust_tel; ?>"> 
<input type="hidden" name="billing_cust_email" value="<?php echo $billing_cust_email; ?>"> 
<input type="hidden" name="delivery_cust_name" value="<?php echo $delivery_cust_name; ?>">
<input type="hidden" name="delivery_cust_address" value="<?php echo $delivery_cust_address; ?>">
<input type="hidden" name="delivery_cust_country" value="<?php echo $delivery_cust_country; ?>">
<input type="hidden" name="delivery_cust_state" value="<?php echo $delivery_cust_state; ?>"> 
<input type="hidden" name="delivery_cust_tel" value="<?php echo $delivery_cust_tel; ?>">
<input type="hidden" name="delivery_cust_notes" value="<?php echo $delivery_cust_notes; ?>"> 
<input type="hidden" name="Merchant_Param" value="<?php echo $Merchant_Param; ?>"> 
<input type="hidden" name="billing_cust_city" value="<?php echo $billing_city; ?>">
<input type="hidden" name="billing_zip_code" value="<?php echo $billing_zip; ?>">
<input type="hidden" name="delivery_cust_city" value="<?php echo $delivery_city; ?>"> 
<input type="hidden" name="delivery_zip_code" value="<?php echo $delivery_zip; ?>"> 
 
</form>
                </div>
            </div>
            
        </div>
    </div>
    <!--/.container-fluid-->
</div>

<?php include_once('../footer.php'); ?>
