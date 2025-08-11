<?php 
include_once('application_main.php');

$posPageName = "merchant"; 

$objapp->authenticateMerchant();

$objMerchant = new merchant;

$merchantData =  $objMerchant->get($objapp->authMerchantId);
 
$merchant_id = $objapp->authMerchantId;

$objPackages = new packages;

 $upgradePackageId =  4;
 $packageUpgrade1 = $objPackages->packages;

if($merchantData['package_id'] > 1){
	echo "greater than one";
    $expiryDate = $merchantData['subscription_end_at'];
    $package = true;
    
    
    $active_package_id = $merchantData['package_id'];
    $packageInfo = $objPackages->packages[$active_package_id]; 
   
   // $merchantTransaction = $objMerchant->get_merchant_transactions($merchantData['id'] , $merchantData['transaction_id']);
    
    $currentPackageName = $packageInfo['package_name'];
    $currentPackageExpiryDate = $expiryDate;
    $adons = $objPackages->adonsPackage($merchantData['adons_ids']);
    
} else { 
	echo "else part";
    
    $packageInfo = $objPackages->packages[1];
    
    $expiryDate = $merchantData['pos_demo_expiry_at'];
    $package = false;
    $currentPackageName = 'Free Demo';
    $currentPackageExpiryDate = $expiryDate;
    $active_package_id = 1;
    $packageInfo = $objPackages->packages[1];
} 

$expiryDays = $objapp->dateDiff(  date('Y-m-d') , $expiryDate );

$packageStatus = ($expiryDays > 0) ? 'Active' : 'Expired';



?>
<?php include_once('header.php'); ?>
<link rel="stylesheet" href="style/new.css" media="all">
<link href="style/package_style.css" rel="stylesheet" media="screen">
<div class="jumbotron" style="padding-top: 0px;">
	
    <div class="container-fluid">
        <!-- / fixed menu section -->
<!--        <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
             <?php //include_once('left_sidebar.php'); ?>
        </div>-->

        <div class="row">
        <!-- /.middle section 100%-->
            <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-12">
                <h1 class="page-header"> Account </h1>
                
                <div class="package-account">
                    <div class="account-heading">
                        <?php if($expiryDays > 0) { ?>
                            You have <?php echo $expiryDays ?> days left on your current package.
                        <?php } else { ?>
                            <div class="text-danger"> Your package has been expired on <?php echo $objapp->DateTimeFormat($expiryDate);?>.</div> 
                        
                            <p class="center"><a href="package-upgrade.php" class="btn btn-info">Upgrade Package Now</a></p>
                        <?php } ?>
                    </div><!--/.account-heading-->
                </div>
                <!--/.package-account-->
                
                <div class="vd-section" style="padding:0px;">
                   
                    <div class="wrapper">
                         
                         <div class="row">
                             
                             <div class="col-md-6 col-sm-6 col-xs-12 box box-solid bg-light-blue-gradient">
                                 <h6>Renew Package</h6>  
                                 <table class="table detail-section " style="text-align: left;">
                                    <tr>
                                        <th class="no-padd" style=" border-top: 1px solid #989898;">Package Name</th>
                                        <td class="no-padd" style=" border-top: 1px solid #989898;"><?php echo $currentPackageName;?></td>
                                    </tr>
                                    <tr>
                                        <th class="no-padd">Status</th>
                                        <td class="no-padd"><?php echo $packageStatus;?></td>
                                    </tr>
                                    <tr>
                                        <th class="no-padd">Due Date</th>
                                        <td class="no-padd"><?php echo $objapp->DateTimeFormat($currentPackageExpiryDate);?></td>
                                    </tr>
                                <?php
                                if( $package === true) {
                                ?>
                                    <tr>
                                        <th class="no-padd">Active Addon Package</th>
                                        <td class="no-padd"><?php
                                       $adonsPackage = $objPackages->adonsPackage($merchantData['adons_ids']);
                                       
                                        if(is_array($adonsPackage)) {
                                            echo "<ul>";
                                            foreach($adonsPackage as $addons)
                                            {
                                               echo "<li><i class='fa fa-check' style='color:#41af4b'></i>   ". $addons['title'] . "</li>" ; 
                                            }
                                            echo "</ul>";
                                        } else {
                                            echo 'NO';
                                        }
                                        ?>
                                        </td>
                                    </tr>                                    
                                    <tr>
                                        <th>Renewal Amount</th>
                                        <td class="no-padd">
                                            <div class="col-sm-6" style="padding-left:0px;">Monthly :<br/><br/>Annually :</div>
                                            <div class="col-sm-6"><i class='fa fa-inr'></i> <?php echo $packageInfo['monthly_price'];?> / Mo<br/><br/><i class='fa fa-inr'></i> <?php echo $packageInfo['annual_price'];?> / Yr</div>                                             
                                        </td>
                                    </tr> 
                                <?php } ?>
                                    
                                    
                                </table>
                                 <div class="text-center">
                                <?php
                                    if($merchantData['package_id'] < 2){
                                        echo '<a href="package-upgrade.php" class="btn btn-success btn-lg">Choose the best plan for your business.</a>';
                                    } else {
                                        echo '<a href="package-upgrade.php" class="btn btn-success btn-lg">Renew Package</a>';
                                    }
                                ?>
                                </div>
                                 <hr/>
                               <?php
                                    $adonsSMSPackage = $objPackages->adonsPackage[3];
                                ?>
                                 <div class="row" >
                                     <div class="col-sm-6 col-xs-12">
                                         <div class="block--details-inner" style="min-height: 300px;">
                                                <div class="header--blue-block">
                                                    <h4><img src="../img/icon_25_plus.svg" alt="tooltip" class="icon xxsmall--v2">Add SMS Pack</h4>
                                                </div>
                                                <!-- REGISTER PRICE (ANNUALLY) -->
                                                <div class="pricing annually">
                                                    <h5 class="price" style="font-size: 20px; color:#000;"><span class="small_symbol"  style="line-height: 1.3em;"><i class="fa fa-inr"></i></span>250<span class="month">/ 1000 sms</span></h5>
                                                     <h5 class="price" style="font-size: 20px; color:#000;"><span class="small_symbol"  style="line-height: 1.3em;"><i class="fa fa-inr"></i></span>1000<span class="month">/ 5000 sms</span></h5>
                                                    <p>Billed in INR annually</p>
                                                    
                                                </div>
<div class="line"></div>                                                
                                                <p class="text-center"><a class="btn btn-info btn-lg" href="package-addon-upgrade.php">Active</a></p>
                                        </div>
                                     </div>
                                     <div class="col-sm-6 col-xs-12">
                                         <div class="block--details-inner" style="min-height: 300px;">
                                                <div class="header--blue-block">
                                                    <h4><img src="../img/icon_25_plus.svg" alt="tooltip" class="icon xxsmall--v2">Add 100 Customers </h4>
                                                </div>
                                                <!-- REGISTER PRICE (ANNUALLY) -->
                                                <div class="pricing annually">
                                                    <h2 class="price" style="font-size:40px; color:#000;"><span class="small_symbol"><i class="fa fa-inr"></i></span>499<span class="month">/ yr</span></h2>
                                                    <p>Billed in INR annually</p>                                                    
                                                </div>
                                                <div class="line"></div>
                                                <p class="text-center"><a class="btn btn-info btn-lg" href="package-addon-upgrade.php">Active</a></p>
                                        </div>
                                     </div>
                                 </div> 
                                 
                                
                            </div>
<div class="col-md-6 col-sm-6 col-xs-12">
       <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->

    <div class="carousel-inner">

<?php
foreach($packageUpgrade1 as $packageUpgrade ){
if($packageUpgrade["id"] != 1){
?>
<?php $act_class = ""; 
if($packageUpgrade["id"] == 4){
$act_class = "active"; 
}

?>
<div class="item <?php echo $act_class; ?>">
                             
                                 <h6>Upgrade Package </h6>
                                 <div class="active-pack">
                                    <div class="active-heading">
                                        <h6 style="margin-bottom: 0;">Upgrade Your Package As</h6>                                        
                                    </div>
                                   
                                    <div class="plan-header">
                                         <h4 style="color: #fff;"><?php echo $packageUpgrade['package_name'];?></h4> 
                                         <?php if(round($packageUpgrade['monthly_price'])) {?>  
                                            <div class="pricing-unit">
                                                <span class="account-symbol"><i class="fa fa-inr"></i></span>
                                                <span class="account-number"><?php echo round($packageUpgrade['annual_price']);?></span>
                                                <span class="account-frequency">/ Yr</span>
                                                <div class="billing-text">
                                                    <i class="fa fa-inr"></i><?php echo $packageUpgrade['annual_price'];?> INR  billed annually
                                                </div>
                                                <div class="alternate-billing-text">
                                                    <i class="fa fa-inr"></i><?php echo $packageUpgrade['monthly_price'];?>  INR billed monthly
                                                </div>
                                            </div>
                                         <?php } ?>
                                            <div class="vv-plan-box-divider"></div>
                                            <div class="description"><?php echo $packageUpgrade['details'];?> </div>
                                    </div>
                                
                                    <div class="act-strip2">
                                        <ul>
                                            <li><?php echo ($packageUpgrade['outlet'] < 0) ? 'Multiple': $packageUpgrade['outlet']; ?> Outlet</li>
                                            <li><?php echo $packageUpgrade['register'];?> Register </li>
                                        </ul>
                                    </div>
                                    <div class="act-strip1">
                                        <ul>
                                            <li><?php echo ($packageUpgrade['users'] < 0) ? 'Unlimited' : $packageUpgrade['users'];?>  Users</li>
                                            <li><?php echo ($packageUpgrade['products'] < 0) ? 'Unlimited' : $packageUpgrade['products'];?> Products</li>
                                            <li><?php echo ($packageUpgrade['customers'] < 0) ? 'Unlimited' : 'Up to '. $packageUpgrade['customers'];?> customers.</li>
                                        </ul>
                                    </div>
                                     
                                       <?php
                                        if(trim($packageUpgrade['features']) != '')
                                            $featuresArr = explode(',', $packageUpgrade['features']);
                                            if(is_array($featuresArr) && count($featuresArr) > 0) {
                                        ?>
                                         <div class="act-strip2">
                                         <h6>Features:</h6>
                                            <ul style="list-style: none;">
                                         <?php 
                                            foreach ( $featuresArr as $feature ){
                                                    echo "<li><i class='fa fa-check' style='color:#41af4b' ></i> ".$feature."</li>";
                                                }
                                         ?>
                                             </ul>
                                         </div>       
                                        <?php
                                            }                                       
                                        ?>  
                                     
                                    <div class="change-button">
                                        <a href="package-upgrade.php"><button>Upgrade Package</button></a>
                                    </div>
                            </div>

                             </div>
                            <?php }} ?>
</div></div> </div>
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
 