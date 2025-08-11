<?php 
include_once('ccavConfig.php');

//$posPageName = "checkout";
 $posPageName = "merchant"; 
 
 $objapp->authenticateMerchant();

 $objMerchant = new merchant;

 $merchantData =  $objMerchant->get($objapp->authMerchantId);
 
    extract($_POST);
    
    $addons_amount = 0;
    $package_id     = $_POST['selected_package_id'];
    $package_name   = $_POST['selected_package_name'];
    $billing_mode   = $_POST['selected_billing_mode'];
    $package_name   = $_POST['selected_package_name'];

    $package_amount = ($billing_mode==12) ? $_POST['package_annually_'.$package_id] : $_POST['package_monthaly_'.$package_id]; 

    $PriorityPhoneSupport  = (isset($_POST['chk_phone_priority'])) ? $_POST['chk_phone_priority'] : 0;
    $AditionalRegistration = (isset($_POST['chk_additional_registration'])) ? $_POST['chk_additional_registration'] : 0;

    $addons_amount = $addons_amount + $PriorityPhoneSupport + $AditionalRegistration;
     
   if($addons_amount > 0) { 
		
        $PriorityPhoneSupportCharges = $PriorityPhoneSupport * $billing_mode;
        $AditionalRegistrationCharges = $AditionalRegistration * $billing_mode;
		
        $totalAdonsCharges = $PriorityPhoneSupportCharges + $AditionalRegistrationCharges;
    } 
    
    $total_package_cost = $package_amount + $totalAdonsCharges;
     
    $service_tax = round($total_package_cost * (SERVICE_TAX_RATE / 100) );

    $totalPayableAmount = $total_package_cost + $service_tax;  

    $ccAvenuMerchant_Id = $merchant_data ;//This id(also User Id) available at "Generate Working Key" of "Settings & Options" 
    $Amount = $totalPayableAmount;//your script should substitute the amount in the quotes provided here 
        
?>

<?php include_once('../header.php'); ?>
<style>
    
.table>tbody>tr>td, 
.table>tbody>tr>th, 
.table>tfoot>tr>td, 
.table>tfoot>tr>th, 
.table>thead>tr>td, 
.table>thead>tr>th {
    padding: 8px 10px 8px !important;
    line-height: 1.6;
    vertical-align: middle;
    border-top: 1px solid #e1e1e1;
    
}

hr {
    margin: 0px;
}
</style>
<div class="jumbotron">
	
    <div class="container-fluid bg-white">
       
        <div class="row  bg-white" style="padding: 30px 0;">
            <div class="col-sm-3 xs-hide">
                <!-- / fixed menu section -->
		<div id="mySidenav" class="sidenav">
			<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
			 
			 <?php include_once('../left_sidebar.php'); ?>
		</div>
            </div><!-- /.col-sm-2 .xs-hide -->
            <div class="col-sm-6 col-xs-12">
                <div class="row">
                     
                    <p>Package Details</p><hr style="margin: 0;"/>
                    <div class="col-sm-12">
                         <table class="table">
                            <thead>
                              <tr>
                                  <td class="text-left">Package:</th>
                                  <td class="text-right"><?php echo $package_name;?></th>                         
                              </tr>
                            </thead>
                              <tr>
                                <td class="text-left">MRP </td>
                                <td class="text-right"><i class="fa fa-inr"></i> <?php echo $package_amount;?> /-</td>                         
                              </tr>
                              <tr>
                                <td class="text-left">Validity</td>
                                <td class="text-right"> <?php echo $billing_mode;?> Month</td>                         
                              </tr>
                              <tr>
                                <td class="text-left text-success">Benefits</td>
                                <td class="text-right text-success">1 Free User</td>                         
                              </tr>
                              <?php if(isset($_POST['chk_phone_priority'])){ ?>                             
                            <tr>
                                <td colspan="2" class="text-left">
                                    <div>Priority Phone Support ( for <?php echo $billing_mode; ?> months):
                                        <span class="pull-right"><i class="fa fa-inr"></i> <?php echo $PriorityPhoneSupportCharges; ?> /-<span></div>
                                    <div><small class="text-info">Priority Phone Support will be charged separately. <i class="fa fa-inr"></i><?php echo $PriorityPhoneSupport;?>/- (INR) per month</small></div>        
                                </td>
                            </tr>
                            <?php } ?>
                            <?php if(isset($_POST['chk_additional_registration'])){ ?>                             
                            <tr>
                                <td colspan="2" class="text-left">
                                    <div>Additional Registrations ( for <?php echo $billing_mode; ?> months):
                                        <span class="pull-right"><i class="fa fa-inr"></i> <?php echo $AditionalRegistrationCharges; ?> /-<span></div>
                                    <div><small class="text-info">Additional Registrations will be charged separately. <i class="fa fa-inr"></i><?php echo $AditionalRegistration;?>/- (INR) per month</small></div>        
                                </td>
                            </tr>
                            <?php } ?>
                         </table> 
                   
                    </div><!-- /.col-xs-12 -->
                </div><!-- /.row -->
                
                <div class="row">                     
                    <p>Payment Details</p><hr style="margin: 0;"/>
                    <div class="col-sm-12">
                        <table class="table">
                            <thead>
                            <tr>
                                <td class="text-left">Total Package Amt:</td>
                                <td class="text-right"><i class="fa fa-inr"></i> <?php echo $total_package_cost; ?>/-</td>
                            </tr>
                            </thead>
                            
                            <tr>
                                <td class="text-left">Service Tax (@ <?php echo SERVICE_TAX_RATE;?>%) :</td>
                                <td class="text-right"><i class="fa fa-inr"></i> <?php echo $service_tax; ?> /-</td>
                            </tr>
                        </table>
                     <hr style="margin: 0px;"/>
                    </div><!-- /.col-xs-12 -->
                      
                        <p>Total Payable Amt. for <?php echo $billing_mode;?> months (INR) : <span  class="pull-right"> <i class="fa fa-inr"></i> <?php echo $totalPayableAmount;?>/-</span></p>
                    
                </div><!-- /.row -->
            </div>
            <!-- /.col-sm-10 .col-xs-12 -->
            <div class="col-sm-3 pull-right col-xs-12 ">
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
                
                <div class="col-sm-12"><a href="<?php echo $objapp->baseURL('merchant/package-upgrade.php');?>" class="btn btn-info btn-lg" style="width: 80%; margin:20px 0;"><i class="fa fa-pencil-square-o"  style="font-size: 20px;"></i> Edit Package</a></div>
                <div class="col-sm-12"><button type="submit" class="btn btn-success btn-lg" style="width: 80%; margin:20px 0;" > <i class="fa fa-shopping-cart" style="font-size: 20px;"></i> Checkout</button></div>
	      </form> 
            </div>
        </div>
        <!-- /.row -->
        
        
    
    <!--/.container-fluid-->
</div>
 
<?php include_once('../footer.php'); ?>

    