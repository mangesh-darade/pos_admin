<?php 
include_once('ccavConfig.php');

//$posPageName = "checkout";
 $posPageName = "merchant"; 
 
 $objapp->authenticateMerchant();

 $objMerchant = new merchant;

 $merchantData =  $objMerchant->get($objapp->authMerchantId);
 
    extract($_POST);
    
    $addonsCharges  = 0;
    $package_id     = $_POST['selected_package_id'];
    $package_name   = $_POST['selected_package_name'];
    $billing_mode   = $_POST['selected_billing_mode'];
     

    if($form_action == 'active_addons') {
        $package_amount = 0;
        $billing_mode   = 12;
        $package_id = 0;
        $package_name = 'Addons Pack';
        $onlyAddons = true;
    } else {
        $package_amount = ($billing_mode==12) ? $_POST['package_annually_'.$package_id] : $_POST['package_monthaly_'.$package_id]; 
        $onlyAddons = false;
    }
         
    $adonIds = $adons_ids = '';
    
    if(isset($_POST['chkAdonsPackage_1']))
    {
        $adonIds[] = $_POST['chkAdonsPackage_1'];
        $addonsCharges +=  $_POST['adon_annual_price_1']; 
    }    
     
    if(isset($_POST['chkAdonsPackage_2']))
    {
       $adonIds[] = $_POST['chkAdonsPackage_2'];
       $addonsCharges +=  $_POST['adon_annual_price_2']; 
    }
    
    $AddSMSPackage  =  $SMSPackageCharges = 0;
    if(isset($_POST['chkAdonsPackage_sms']))
    {
       $adonIds[] = $_POST['chkAdonsPackage_sms'];
       
       $smsPack = explode('~', $_POST['adonsSmsPackage']);
       
       $SMSPackageCharges   = $smsPack[1]; 
       $AddSMSPackage       = $smsPack[2]; 
       
       $addonsCharges += $SMSPackageCharges; 
    }      
     
    if($addonsCharges > 0) { 
		
        $totalAdonsCharges = $addonsCharges;
        $adons_ids = join(',' , $adonIds);
    } 
    
    $total_package_cost = $package_amount + $totalAdonsCharges;
     
    $service_tax = round($total_package_cost * (SERVICE_TAX_RATE / 100) );

    $totalPayableAmount = $total_package_cost + $service_tax;  

    $ccAvenuMerchant_Id = $merchant_data; //This id(also User Id) available at "Generate Working Key" of "Settings & Options" 
     $Amount = $totalPayableAmount; //your script should substitute the amount in the quotes provided here 
    //$Amount = 1;   
?>

<?php include_once('../header.php'); ?>
 <link rel="stylesheet" href="../style/new.css" media="all">
<link href="../style/package_style.css" rel="stylesheet" media="screen">
<div class="jumbotron" style="padding-top:0px; ">
	
    <div class="container-fluid bg-white">
       
        <div class="row  bg-white">
            
            <div class="col-sm-10 col-sm-offset-1  col-xs-12">
                <div class="row" style="margin:0 10px;">
                      
                    <h1 class="page-header"> Packages </h1>
                     <div class="package-detail">
                            <div class="row">
                                    <div class="col-md-8 col-sm-8 col-xs-12 col-detail">
                                         <table class="table detail-section">
                                            <thead>
                                              <tr>
                                                  <td colspan="2" class="col-md-12 detail-heading"><div class="detail-heading-text text-left">Package Details</div></td>                                                       
                                              </tr>
                                            </thead>
                                              <tr>
                                                  <td class="text-left no-padd">Package:</th>
                                                  <td class="text-right no-padd"><?php echo $package_name;?></th>                         
                                              </tr>
                                              <tr>
                                                <td class="text-left no-padd">Validity</td>
                                                <td class="text-right no-padd"> <?php echo $billing_mode;?> Month</td>                         
                                              </tr>  
                                        <?php if($onlyAddons === false) { ?>      
                                              <tr>
                                                <td class="text-left no-padd">MRP </td>
                                                <td class="text-right no-padd"><i class="fa fa-inr"></i> <?php echo $package_amount;?> /-</td>                         
                                              </tr>                                       
                                              <tr>
                                                <td class="text-left text-success no-padd">Benefits</td>
                                                <td class="text-right text-success no-padd">1 Free User</td>                         
                                              </tr>
                                        <?php } ?>
                                              <?php if(isset($_POST['chkAdonsPackage_2'])){ ?>                             
                                            <tr>
                                                <td colspan="2" class="text-left no-padd">
                                                    <div><?php echo $_POST['adon_title_2'];?> ( for 12 months ):
                                                        <span class="pull-right"><i class="fa fa-inr"></i> <?php echo $adon_annual_price_2; ?> /-<span></div>
                                                    <div><small class="text-info"><?php echo $_POST['adon_title_2'];?> will be charged separately. <i class="fa fa-inr"></i><?php echo $PriorityPhoneSupport;?>/- (INR) per month</small></div>        
                                                </td>
                                            </tr>
                                            <?php } ?>
                                            <?php if(isset($_POST['chkAdonsPackage_1'])){ ?>                             
                                            <tr>
                                                <td colspan="2" class="text-left">
                                                    <div><?php echo $_POST['adon_title_1'];?> ( for 12 months ):
                                                        <span class="pull-right"><i class="fa fa-inr"></i> <?php echo $adon_annual_price_1; ?> /-<span></div>
                                                    <div><small class="text-info"><?php echo $_POST['adon_title_1'];?> will be charged separately. <i class="fa fa-inr"></i><?php echo $AditionalRegistration;?>/- (INR) per month</small></div>        
                                                </td>
                                            </tr>
                                            <?php } ?>
                                            <?php if(isset($_POST['chkAdonsPackage_sms'])){ ?>                             
                                            <tr>
                                                <td colspan="2" class="text-left">
                                                    <div><?php echo $_POST['adon_title_sms'];?> ( <?php echo $AddSMSPackage; ?> SMS):
                                                        <span class="pull-right"><i class="fa fa-inr"></i> <?php echo $SMSPackageCharges; ?> /-<span></div>
                                                    <div><small class="text-info"><?php echo $_POST['adon_title_sms'];?> will be charged separately as per selected package.</div>        
                                                </td>
                                            </tr>
                                            <?php } ?>
                                         </table> 
                   
                                        <table class="table detail-section">
                                            <thead>
                                              <tr>
                                                  <td colspan="2" class="col-md-12 detail-heading"><div class="detail-heading-text text-left">Payment Details</div></td>                                                       
                                              </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td class="text-left no-padd">Total Package Amt:</td>
                                                <td class="text-right no-padd"><i class="fa fa-inr"></i> <?php echo $total_package_cost; ?>/-</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left no-padd">GST (@ <?php echo SERVICE_TAX_RATE;?>%) :</td>
                                                <td class="text-right no-padd"><i class="fa fa-inr"></i> <?php echo $service_tax; ?> /-</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left no-padd">Total Payable Amt. for <?php echo $billing_mode;?> months (INR) :</td>
                                                <td class="text-right no-padd"><span  class="pull-right"> <i class="fa fa-inr"></i> <?php echo $totalPayableAmount;?>/-</span></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                            <div class="detail-button-section">
                                                <form method="POST" name="customerData" action="checkout_set_order.php">
                                                    <input type="hidden" name="currency" value="INR"/>
                                                    <input type="hidden" name="tid" id="tid" value="" />
                                                    <input type="hidden" name="merchant_id" value="<?php echo $ccAvenuMerchant_Id;?>"/>                
                                                    <input type="hidden" name="amount" value="<?php echo $Amount;?>"/>
                                                    
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
                                                    <?php
                                                        if(isset($_POST)){
                                                            foreach ($_POST as $key => $value) {
                                                                echo "<input type='hidden' name='$key' value='$value'/>"; 
                                                            }                                                            
                                                        }
                                                    ?>                                                    
                                                    <input type="hidden" name="customer_id" value="<?php echo $cust_id;?>"/>
                                                    <input type="hidden" name="package_id" value="<?php echo $package_id;?>"/>
                                                    <input type="hidden" name="package_name" value="<?php echo $package_name;?>"/>                
                                                    <input type="hidden" name="adons_ids" value="<?php echo $adons_ids;?>"/>
                                                    <input type="hidden" name="totalAdonsCharges" value="<?php echo $totalAdonsCharges;?>"/>
                                                    <input type="hidden" name="service_tax" value="<?php echo $service_tax;?>"/>
                                                    <input type="hidden" name="totalPayableAmount" value="<?php echo $totalPayableAmount;?>"/>
                                                    <input type="hidden" name="billing_mode" value="<?php echo $billing_mode;?>"/>
                                                    <input type="hidden" name="plane_amount" value="<?php echo $package_amount;?>"/>
                                                    
                                                    <label><input type="checkbox" value="1" required="required" checked="checked" name="accepted_terms" /> Accepted <a href="https://simplypos.in/termsandconditions.php" target="_new">Terms & Conditions.</a></label>
                                                    <div class="col-sm-12"><a href="<?php echo $objapp->baseURL(  ($onlyAddons === true ) ? 'merchant/package-addon-upgrade.php' :'merchant/package-upgrade.php');?>" class="btn btn-info btn-lg" style="width: 80%; margin:20px 0;"><i class="fa fa-pencil-square-o"  style="font-size: 20px;"></i> Edit Package</a></div>
                                                    <div class="col-sm-12"><button type="submit" class="btn btn-success btn-lg" style="width: 80%; margin:20px 0;" > <i class="fa fa-shopping-cart" style="font-size: 20px;"></i> Checkout</button></div>
                                                  </form> 

                                            </div>
                                    </div>
                            </div>
			</div>
                </div><!-- /.row -->
                
                
            </div>
             
        </div>
        <!-- /.row -->
        
        
    
    <!--/.container-fluid-->
</div>
 
<?php include_once('../footer.php'); ?>

    