<?php 
include_once('ccavConfig.php');

$posPageName = "checkout";
 
 
 $objapp->authenticateMerchant();

 $objMerchant = new merchant;

 $merchantData =  $objMerchant->get($objapp->authMerchantId); 
 
?>
<?php include_once('../header.php'); ?>

<div class="jumbotron">
	
    <div class="container-fluid">
       
        <?php
       
        
                extract($_POST);
                
                $package_id = $_POST['selected_package_id'];
                $package_name = $_POST['selected_package_name'];
                
                $plane_amount = ($billing_mode==12) ? $annualy_billing_package_price : $monthly_billing_package_price; 
                
                $PriorityPhoneSupport = $_POST['PriorityPhoneSupport'];
                
                $totalPayableAmt = $plane_amount + $addons_amount;
                $totalAdonsCharges = $PriorityPhoneSupportCharges = 0;
                
                if($Adons_PriorityPhoneSupport) { 
                    
                    $PriorityPhoneSupportCharges = $PriorityPhoneSupport * $billing_mode;
                }
                 
                $totalAdonsCharges = $PriorityPhoneSupportCharges;

                $total_package_cost = ($plane_amount + $totalAdonsCharges);
                $service_tax = round($total_package_cost * (SERVICE_TAX_RATE / 100) );
                 
                $totalPayableAmount = $total_package_cost + $service_tax;  

                
$ccAvenuMerchant_Id = $merchant_data ;//This id(also User Id) available at "Generate Working Key" of "Settings & Options" 
$Amount = "1.00";//your script should substitute the amount in the quotes provided here 
        
?>
    <div class="row "> 
        <div class="col-md-10 col-md-offset-1 col-sm-12 col-xs-12">           
            <div class="row">
            
                <div class="col-sm-4 col-xs-12">
                     <h4>Package Details</h4>    
                    <table class="table">
                    <thead>
                      <tr>
                          <td><p class="text-left">Package Name:</p></th>
                          <td><p class="text-right"><?php echo $package_name;?></p></th>                         
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="text-left">Package Price </td>
                        <td class="text-right"><i class="fa fa-inr"></i> <?php echo $plane_amount;?></td>                         
                      </tr>
                      <tr>
                        <td class="text-left">Subscription For</td>
                        <td class="text-right"> <?php echo $billing_mode;?> Month</td>                         
                      </tr>
                      <tr>
                        <td class="text-left text-success">1 Register included</td>
                        <td class="text-right text-success"> FREE </td>                         
                      </tr>
                   <?php if($billing_mode == 12){ ?>   
                      <tr>
                        <td class="text-left text-success">Annual payment savings</td>
                        <td class="text-right text-success"><i class="fa fa-inr"></i> <?php echo $annual_billing_discount_amount;?></td>                         
                      </tr>
                      <tr>
                          <td class="text-left"><p>Total per year (INR)</p></td>
                          <td class="text-right"><p><i class="fa fa-inr"></i> <?php echo $plane_amount;?></p></td>                         
                      </tr>
                   <?php 
                         } 
                         else
                         {
                   ?>
                      <tr>
                          <td class="text-left"><p>Total per month (INR)</p></td>
                          <td class="text-right"><p><i class="fa fa-inr"></i> <?php echo $plane_amount;?></p></td>                         
                      </tr> 
                    <?php }//end else. ?>
                    </tbody>
                 </table> 
                   
                 
                </div>
                <div class="col-sm-6 col-sm-push-1 col-xs-12">
                     <h4>Payment Details</h4>  
                    <div class="box">
                        <p>Selected Package Amt: <span class="pull-right"><i class="fa fa-inr"></i> <?php echo $plane_amount; ?>/-</span></p>
                        <?php if($Adons_PriorityPhoneSupport) { ?>
                        <div class="text-info ">Priority Phone Support will be charged separately. <i class="fa fa-inr"></i><?php echo $PriorityPhoneSupport;?>/- (INR) per month </div>
                         <?php echo ' <p>Priority Phone Support (for '. $billing_mode .' months):  <span class="pull-right"><i class="fa fa-inr"></i> '. $PriorityPhoneSupportCharges .' /-</span></p>'; ?>
                        <?php } ?>
                            
                        <p>Service Tax (@<?php echo SERVICE_TAX_RATE;?>%) :  <span class="pull-right"><i class="fa fa-inr"></i> <?php echo $service_tax; ?> /-</span></p>
                        
                    </div>
                    
                    <hr/>
                    <h5>Total Payable Amt. for <?php echo $billing_mode;?> months (INR) : <span  class="pull-right"> <i class="fa fa-inr"></i> <?php echo $totalPayableAmount;?>/-</span></h5>
                
                    
                </div>
             
            </div> <hr/>
            <form method="POST" name="customerData" action="checkout_set_order.php">
                <input type="hidden" name="tid" id="tid" value="" />
                <input type="hidden" name="merchant_id" value="<?php echo $ccAvenuMerchant_Id;?>"/>                
                <input type="hidden" name="amount" value="<?php echo $Amount;?>"/>
                <input type="hidden" name="currency" value="INR"/>
                <input type="hidden" name="language" value="EN"/>
                <input type="hidden" name="redirect_url" value="<?php echo $Redirect_Url;?>"/>
                <input type="hidden" name="cancel_url" value="<?php echo $Redirect_Url;?>"/>                
                <input type="hidden" name="billing_name" value="<?php echo $cust_name;?>"/>
                <input type="hidden" name="billing_address" value="India"/>
                <input type="hidden" name="billing_city" value="<?php echo $cust_city;?>"/>
                <input type="hidden" name="billing_state" value="<?php echo $cust_state;?>"/>
                <input type="hidden" name="billing_zip" value="<?php echo $cust_zip;?>"/>
                <input type="hidden" name="billing_country" value="<?php echo $cust_country;?>"/>
                <input type="hidden" name="billing_tel" value="<?php echo $cust_phone;?>"/>
                <input type="hidden" name="billing_email" value="<?php echo $cust_email;?>"/>
                <input type="hidden" name="delivery_name" value="<?php echo $cust_name;?>"/>
                <input type="hidden" name="delivery_address" value="India"/>
                <input type="hidden" name="delivery_city" value="<?php echo $cust_city;?>"/>
                <input type="hidden" name="delivery_state" value="<?php echo $cust_state;?>"/>
                <input type="hidden" name="delivery_zip" value="<?php echo $cust_zip;?>"/>
                <input type="hidden" name="delivery_country" value="<?php echo $cust_country;?>"/>
                <input type="hidden" name="delivery_tel" value="<?php echo $cust_phone;?>"/>
                
                <input type="hidden" name="customer_id" value="<?php echo $cust_id;?>"/>
                <input type="hidden" name="package_id" value="<?php echo $package_id;?>"/>
                <input type="hidden" name="package_name" value="<?php echo $package_name;?>"/>                
                <input type="hidden" name="PriorityPhoneSupport" value="<?php echo $Adons_PriorityPhoneSupport;?>"/>
                <input type="hidden" name="PriorityPhoneSupportCharges" value="<?php echo $PriorityPhoneSupportCharges;?>"/>
                <input type="hidden" name="totalAdonsCharges" value="<?php echo $totalAdonsCharges;?>"/>
                <input type="hidden" name="service_tax" value="<?php echo $service_tax;?>"/>
                <input type="hidden" name="totalPayableAmount" value="<?php echo $totalPayableAmount;?>"/>
                <input type="hidden" name="billing_mode" value="<?php echo $billing_mode;?>"/>
                <input type="hidden" name="plane_amount" value="<?php echo $plane_amount;?>"/>
                
                <a href="<?php echo $Edir_Package_Url;?>" class="btn btn-info btn-lg">Edit Package</a>
		<input type="submit" class="btn btn-success btn-lg" value="Checkout"/>
	      </form>
            </div> 
            
        </div>
    </div>
    <!--/.container-fluid-->
</div>
 
<?php include_once('../footer.php'); ?>
