<?php 
include_once('application_main.php');

$posPageName = "merchant"; 

$objapp->authenticateMerchant();

$objMerchant = new merchant;

$merchantData =  $objMerchant->get($objapp->authMerchantId);
 
$merchant_id = $objapp->authMerchantId;

if($merchantData['package_id'] > 1){
    $expiryDate = $merchantData['subscription_end_at'];
    $package = true;
    
    $objPackages = new packages;
    
    $packageInfo = $objPackages->packages[$merchantData['package_id']];
    $active_package_id = $merchantData['package_id'];
   // $merchantTransaction = $objMerchant->get_merchant_transactions($merchantData['id'] , $merchantData['transaction_id']);
    
    
    $currentPackageName = $packageInfo['package_name'];
    $currentPackageExpiryDate = $expiryDate;
    $adons = $objPackages->adonsPackage($merchantData['adons_ids']);
    
} else {
    $expiryDate = $merchantData['pos_demo_expiry_at'];
    $package = false;
    $currentPackageName = 'Free Demo';
    $currentPackageExpiryDate = $expiryDate;
    $active_package_id = 1;
} 

$expiryDays = $objapp->dateDiff(  date('Y-m-d') , $expiryDate );

$packageStatus = ($expiryDays > 0) ? 'Active' : 'Expired';

?>
<?php include_once('header.php'); ?>

<div class="jumbotron" style="padding-top: 0px;">
	
    <div class="container-fluid">
        <!-- / fixed menu section -->
        <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

             <?php include_once('left_sidebar.php'); ?>
        </div>

        <div class="row">
        <!-- /.middle section 100%-->
            <div class=" col-lg-10 col-lg-push-2 col-md-10 col-md-push-2 col-sm-12 col-xs-12">
                <h1 class="page-header"> Account </h1>
                 
                <div class="vd-section" style="padding: 20px 0px;">
                    <div class="wrapper">
                        <?php if($expiryDays > 0) { ?>
                            <h1 class="vd-hero-headline" style="color: #41af4b;">You have <?php echo $expiryDays ?> days left on your current package</h1>
                        <?php } else { ?>
                            <h1 class="vd-hero-headline" style="color: #ff0000;">Your package has been expired on <?php echo $objapp->DateTimeFormat($expiryDate);?>.<br/> Please activate now.</h1>
                        
                            <a href="package-upgrade.php" class="vd-button">Upgrade Package</a>
                        <?php } ?>				 
                    </div>
                </div>
                
                 
                <div class="vd-section" style="padding:0px;">
                   
                    <div class="wrapper">
                         <h3>Current Package Details</h3><hr/>
                         <div class="row">
                             <div class="col-md-6 col-sm-6 col-xs-12">
                                   
                                 <table class="table" style="text-align: left;">
                                    <tr>
                                        <th>Package Name</th>
                                        <td><?php echo $currentPackageName;?></td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td><?php echo $packageStatus;?></td>
                                    </tr>
                                    <tr>
                                        <th>Expiry date</th>
                                        <td><?php echo $objapp->DateTimeFormat($currentPackageExpiryDate);?></td>
                                    </tr>
                                <?php
                                if( $package === true) {
                                ?>
                                    <tr>
                                        <th>Adon's Package</th>
                                        <td><?php
                                            foreach($objPackages->adonsPackage($merchantData['adons_ids']) as $addons)
                                            {
                                               $adonTitle[]= $addons['title'] . " :   <i class='fa fa-inr'></i> ".$addons['monthly_price']. '/Mo'; 
                                            }
                                            echo join('<br/>', $adonTitle);
                                        ?></td>
                                    </tr>                                    
                                    <tr>
                                        <th>Renewal Amount</th>
                                        <td>
                                            <table class="table">
                                                <tr>
                                                    <td>Monthly</td>
                                                    <td>Annualy</td>
                                                </tr>
                                                <tr>
                                                    <td> <i class='fa fa-inr'></i> <?php echo $packageInfo['monthly_price'];?></td>
                                                    <td> <i class='fa fa-inr'></i> <?php echo $packageInfo['annual_price'];?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr> 
                                <?php } ?>
                                    
                                    
                                </table>
                               
                            </div>
                             <div class="col-md-6 col-sm-6 col-xs-12">
                             <?php include_once('active_package.php'); ?>
                             </div>
                         </div> 
                         
                       			 
                    </div>
                </div>
            </div>
                <!-- /.col-sm-10 -->
        </div>
    </div>
    <!--/.container-fluid-->
</div>



<?php include_once('../footer.php'); ?>
 