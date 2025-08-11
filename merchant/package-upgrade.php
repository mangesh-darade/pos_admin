<?php 
include_once('application_main.php');

$posPageName = "merchant"; 

$objapp->authenticateMerchant();

$objMerchant = new merchant;

$merchantData =  $objMerchant->get($objapp->authMerchantId);

$cust_id = $merchantData['id'];
$cust_name = $merchantData['name'];
$cust_address = $merchantData['address'];
$cust_city = $merchantData['city'];
$cust_state = $merchantData['state'];
$cust_country = $merchantData['country'];
$cust_zip = $merchantData['pincode'];
$cust_phone = $merchantData['phone'];
$cust_email = $merchantData['email'];
 
$objPackages = new packages;

$merchantData['package_id'] = ($merchantData['package_id'] < 2) ? 1 : $merchantData['package_id'];

if($merchantData['package_id'] > 1){
    $expiryDate = $merchantData['subscription_end_at'];
    $package = true;
} else {
    $expiryDate = $merchantData['pos_demo_expiry_at'];
    $package = false;
}

$expiryDays = $objapp->dateDiff(  date('Y-m-d') , $expiryDate );
$m_class = $a_class = $m_switch_class =$a_switch_class = $sel_div_class = "";
$prod_id = 0;


if(isset($_GET["stat"])){
	$arr = explode("-",$_GET["stat"]);
	if(isset($arr[1]) && isset($arr[0]) && $arr[0] != "" && $arr[1] != ""){
		$prod_id = base64_decode($arr[1]);
                $sel_div_class = "active";
                $form_billing_sty = "style='display:block;'";
		if($arr[0] == "monthly"){
			$a_class="hidden";
			$m_switch_class = "toggled";
			
		}else{
			$a_switch_class = "toggled";
			$m_class ="hidden";
		}			
	}
}else{
	$m_class ="hidden";
	$a_switch_class = "toggled";
        $prod_id = 1;
        $sel_div_class = "hidden";
       $form_billing_sty = "style='display:none;'";
}

?>
<?php include_once('header.php'); ?>
<link rel="stylesheet" href="style/new.css" media="all">
<link href="style/package_style.css" rel="stylesheet" media="screen">
<div class="jumbotron" style="padding-top: 0px;">
	
    <div class="container-fluid">
		<!-- / fixed menu section -->
<!--		<div id="mySidenav" class="sidenav">
                    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                    <?php //include_once('left_sidebar.php'); ?>
		</div>-->
                
            <div class="row"> 
            <!-- /.middle section 100%-->
                <div  class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-12">
                    <h1 class="page-header"> Packages </h1>
                    <form method="post" name="choose_package" action="payments/checkout.php"  >   
                    <div class="acount-pricing" style="padding: 20px 0px;">

                            <input type="hidden" name="form_action" value="package_selection" />
                            <input type="hidden" name="selected_package_id" id="selected_package_id"  />
                            <input type="hidden" name="selected_package_name" id="selected_package_name"  />
                            <input type="hidden" name="selected_billing_mode" id="selected_billing_mode"  />

                            <input type="hidden" name="cust_id" value="<?php echo $cust_id;?>" />
                            <input type="hidden" name="cust_name" value="<?php echo $cust_name;?>" />
                            <input type="hidden" name="cust_address" value="<?php echo $cust_address;?>" />
                            <input type="hidden" name="cust_city" value="<?php echo $cust_city;?>" />
                            <input type="hidden" name="cust_state" value="<?php echo $cust_state;?>" />
                            <input type="hidden" name="cust_country" value="<?php echo $cust_country;?>" />
                            <input type="hidden" name="cust_zip" value="<?php echo $cust_zip;?>" />
                            <input type="hidden" name="cust_phone" value="<?php echo $cust_phone;?>" />
                            <input type="hidden" name="cust_email" value="<?php echo $cust_email;?>" />
                        <!--    <input type="hidden" name="service_tax_rate" value="< ?php echo SERVICE_TAX_RATE;?>" /> -->

                             <!-- PRICING DETAILS SECTION -->
                            <section class="grey-bg pricing_table">
                                    <div class="row">
                                    <!-- HERO BANNER -->
                                            <div class="hero-banner grey-bg">
                                                    <div class="internal">
                                                            <div class="center">
                                                                    <h1 class="small">Choose the best plan for your business.</h1>
                                                            </div>
                                                    </div>
                                            </div>
                                    <!-- Pricing switch (annually/monthly) -->
                                            <div class="switch center mb-70 hidden-xs">
                                                    <div class="switch-button">
                                                            <span class="switch--label switch--label-A <?php echo $m_switch_class; ?>">Monthly</span>
                                                            <input id="cmn-toggle" class="cmn-toggle cmn-toggle-round-flat" checked="checked" type="checkbox">
                                                            <label class="disp-label" for="cmn-toggle" hidden></label>
                                                            <span class="switch--label switch--label-B <?php echo $a_switch_class;?>">Annually</span>
                                                    </div>
                                            </div>

                                    <!-- Pricing switch for mobile (switches between plans) -->
                                    <ul class="nav nav-tabs" style="display:none;">
                                                <li class="active"><a data-toggle="tab" href="#ptab_1">Free</a></li>
                                                <li><a data-toggle="tab" href="#ptab_2">Basic</a></li>
                                                <li><a data-toggle="tab" href="#ptab_3">Advanced</a></li>
                                                <li><a data-toggle="tab" href="#ptab_4">Multi-Outlet</a></li>
                                            </ul>

                                    <!-- Pricing details -->
                                            <div class="pricing-section">
                                                    <div class="pricing-plans">
                                                            <div class="inner-section">
<?php 
      $prod_class = "";
      if(isset($prod_id) && $prod_id > 1){  
        $prod_class = "";
      }elseif($merchantData['package_id']==1 ){
        $prod_class = "active";
      }?>
                                                                <div id="ptab_1" pid="1" class="pricing-plan col-sm-3 hidden no-plan <?php echo $prod_class;?>">

                                                                    <div class="pric-div " >
                                                                    <?php
                                                                       $defaultPackage = $objPackages->packages[1];
                                                                    ?>
                                                                        <input type="hidden" name="package_monthaly_1" id="package_monthaly_1" value="0" />
                                                                        <input type="hidden" name="package_annually_1" id="package_annually_1" value="0" />
                                                                        <input type="hidden" name="package_name_1" id="package_name_1" value="<?php echo $defaultPackage['package_name'];?>" />
                                                                        <div class="sim-title"><?php echo $defaultPackage['package_name'];?></div>
                                                                        <div class="strip2 text-success"><?php echo $defaultPackage['details'];?></div>
                                                                        <div class="striped-div">
                                                                            <div class="strip1" style="padding: 10px 0;">
                                                                                <p><?php echo $defaultPackage['outlet'];?> Outlet</p>
                                                                                <p><?php echo $defaultPackage['register'];?> Register</p>                                                                                         
                                                                            </div>
                                                                            <div class="strip2" style="padding: 10px 0;">
                                                                                <p><?php echo $defaultPackage['users'];?> Users</p>
                                                                                <p><?php echo $defaultPackage['products'];?> Products</p>
                                                                                <p><?php echo $defaultPackage['customers'];?> Customers</p>
                                                                            </div>
                                                                            <div class="cell trial-button">
                                                                                <a href="#" class="button button-blue-grey-dark"> Select Plan </a>
                                                                                <div class="plan-selected">Plan Selected</div>
                                                                            </div>
                                                                            <div class="strip1" style="display:block">
                                                                                    <p>You won't get :</p>
                                                                                    <p class="ico-cross"><img src="img/cross-icon.png">Gift Cards</p>
                                                                                    <p class="ico-cross"><img src="img/cross-icon.png">Loyalty</p>
                                                                                    <p class="ico-cross"><img src="img/cross-icon.png">Advanced Reporting</p>
                                                                                    <p class="ico-cross"><img src="img/cross-icon.png">Ecommerce</p>
                                                                                    <p class="ico-cross"><img src="img/cross-icon.png">Priority Phone Support</p>
                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                </div>
                                                            <?php
                                                            if(is_array($objPackages->packages))
                                                            foreach($objPackages->packages as $packageInfo) {
                                                                if($packageInfo['id'] < 2) continue;
                                                                    extract($packageInfo);

                                                                    if($prod_id == $id){
								     $activeClass = "active";
                                                                   }else{
                                                                     $activeClass = ($merchantData['package_id'] == $id ) ? ' active' : '';
                                                                    }
                                                            ?>

                                                                <div id="ptab_<?php echo $id;?>" pid="<?php echo $id;?>" class="pricing-plan col-sm-3 hidden act-plan plan-<?php echo $id;?> <?php echo $activeClass; ?>">


                                                                    <input type="hidden" name="package_monthaly_<?php echo $id;?>" id="package_monthaly_<?php echo $id;?>" value="<?php echo $monthly_price;?>" />
                                                                    <input type="hidden" name="package_annually_<?php echo $id;?>" id="package_annually_<?php echo $id;?>" value="<?php echo $annual_price;?>" />
                                                                    <input type="hidden" name="package_name_<?php echo $id;?>" id="package_name_<?php echo $id;?>" value="<?php echo $package_name;?>" />
                                                                    <div class="pric-div">
                                                                        <div class="title center">
                                                                            <h5 class="plan-name bold"><?php echo $package_name;?></h5>
                                                                            <div class="annually <?php echo $a_class; ?>">
                                                                                <h2 class="price">
                                                                                    <span class="small_symbol"><i class="fa fa-inr"></i></span><?php echo round($annual_price);?><span class="month">/YR</span>
                                                                                </h2>
                                                                                <p class="packfir-price"><i class="fa fa-inr"></i><?php echo round($annual_price);?> INR Billed Annually</p>
                                                                                <p class="packsec-price"><i class="fa fa-inr"></i><?php echo round($annual_price / 12);?> INR Monthly Cost</p>
                                                                            </div>

                                                                            <!-- PLAN PRICE (MONTHLY) -->
                                                                            <div class="monthly <?php echo $m_class; ?>">
                                                                                    <h2 class="price">
                                                                                    <span class="small_symbol"><i class="fa fa-inr"></i></span><?php echo round($monthly_price);?><span class="month">/MO</span>
                                                                                    </h2>
                                                                                    <p class="packfir-price"><i class="fa fa-inr"></i><?php echo round($monthly_price * 12);?> INR Billed Annually</p>
                                                                                    <p class="packsec-price"><i class="fa fa-inr"></i><?php echo round($monthly_price);?> INR Monthly Cost</p>
                                                                            </div>
                                                                            <div class="b-content"><?php echo $details;?></div>
                                                                        </div>

                                                                        <!-- PRODUCT DESCRIPTION / BLURB (HARDCODED) -->
                                                                                <div class="strip1">
                                                                                        <p><?php echo ($outlet < 0) ? 'Multiple': $outlet; ?> Outlet</p>
                                                                                        <p><?php echo $register;?> Register </p>
                                                                                </div>
                                                                                <div class="pac strip2">
                                                                                        <p><?php echo ($users < 0) ? 'Unlimited' : $users;?>  Users</p>
                                                                                        <p><?php echo ($products < 0) ? 'Unlimited' : $products;?> Products</p>
                                                                                        <p><?php echo ($customers < 0) ? 'Unlimited' : 'Up to '. $customers;?> customers.</p>
                                                                                </div>
                                                                                <div class="cell trial-button">
                                                                                    <a href="#" class="button button-blue-grey-dark"> Select Plan </a>
                                                                                    <div class="plan-selected">Plan Selected</div>
                                                                                </div>
                                                                        </div>
                                                                </div>

                                                           <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                            <div class="selected-div2 hidden">
                                                <div class="plus-icon"><i class="fa fa-plus" aria-hidden="true"></i></div>
                                                <div class="pack-active">
                                                    <div class="row">
                                                        <div class="col-sm-4 select-pack">

                                                        </div>
                                                        <div class="col-sm-4 select-pack">
                                                            <div class="strip1" style="display:block">
                                                                <p>You won’t get :</p>
                                                                <p class="ico-cross"><img src="img/cross-icon.png">Gift Cards</p>
                                                                <p class="ico-cross"><img src="img/cross-icon.png">Loyalty</p>
                                                                <p class="ico-cross"><img src="img/cross-icon.png">Advanced Reporting</p>
                                                                <p class="ico-cross"><img src="img/cross-icon.png">Ecommerce</p>
                                                                <p class="ico-cross"><img src="img/cross-icon.png">Priority Phone Support</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4 select-pack">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="selected-div <?php echo $sel_div_class; ?>">
                                                    <div class="plus-icon"><i class="fa fa-plus" aria-hidden="true"></i></div>
                                                    <div class="pack-active">
                                                        <div class="row">
                                                        <?php
                                                        for($ap=1; $ap<=2; $ap++) :  
                                                            $adonsPackage = $objPackages->adonsPackage[$ap];

                                                        ?>
                                                            <div class="col-sm-4 select-addon" id="adonsPackage_<?php echo $ap;?>">
                                                                <div class="pack-acin" >
                                                                    <label>
                                                                        <div class="acin-heading">
                                                                            <input type="checkbox" style="display:none;" name="chkAdonsPackage_<?php echo $ap;?>" id="chkAdonsPackage_<?php echo $ap;?>" value="<?php echo $adonsPackage['id'];?>" />
                                                                            <input type="hidden" name="adon_title_<?php echo $ap;?>" value="<?php echo $adonsPackage['title'];?>" />
                                                                            <input type="hidden" name="adon_annual_price_<?php echo $ap;?>" value="<?php echo $adonsPackage['annual_price'];?>" />
                                                                            <?php echo $adonsPackage['title'];?>
                                                                        </div>
                                                                        <div class="annually">
                                                                            <h2 class="price acin-price">
                                                                                <div class="acin-chk"></div>
                                                                                <span class="small_symbol"><i class="fa fa-inr"></i></span> <?php echo $adonsPackage['annual_price'];?><span class="month">/Yr</span>
                                                                            </h2>
<!--                                                                                <p class="packfir-price"><i class="fa fa-inr"></i>< ?php echo $adonsPackage['annual_price'];?> INR Billed Annually</p>-->
                                                                            <p class="packsec-price"><i class="fa fa-inr"></i> <?php echo round($adonsPackage['annual_price'] / 12);?> INR Monthly Cost</p>
                                                                        </div>
                                                                        <p class="acin-normal"><?php echo $adonsPackage['details'];?></p><br/>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                      <?php 
                                                        endfor;

                                                        $adonsSMSPackage = $objPackages->adonsPackage[3];
                                                      ?>

                                                            <div class="col-sm-4 select-addon" id="adonsPackage_sms">
                                                                <div class="pack-acin">
                                                                    <label>
                                                                        <div class="acin-heading">
                                                                            <?php echo $adonsSMSPackage['title'];?></div>
                                                                            <input type="checkbox" style="display:none;" name="chkAdonsPackage_sms" id="chkAdonsPackage_sms" value="3" />
                                                                            <input type="hidden" name="adon_title_sms" value="<?php echo $adonsSMSPackage['title'];?>" /> 
                                                                        <h6 class="price acin-price">
                                                                                <div class="acin-chk"></div>

                                                                                <select disabled="disabled" style="border: 1px solid #989898;" required="required" name="adonsSmsPackage" id="adonsSmsPackage">
                                                                                    <option value="">-- Select SMS Pack --</option>
                                                                                <?php

                                                                                  $smsPackageList = $objPackages->getSmsPackageList(); 
                                                                                  if(is_array($smsPackageList)){
                                                                                      foreach ($smsPackageList as $key => $smspack) {
                                                                                          extract($smspack);
                                                                                          echo "<option value='$id~$price~$quantity'>$title</option>";
                                                                                      }
                                                                                  }
                                                                                ?> 
                                                                                </select>
                                                                        </h6><br/>
                                                                        <p class="packfir-price">Billed in INR per recharge.</p> 
                                                                        <p class="acin-normal"><?php echo $adonsSMSPackage['details'];?><br/><br/></p>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>

                                            </div>
                                    </div>
                            </section>

                        <div id="form_billing" <?php echo $form_billing_sty; ?>>                                    

                                <!--/ billing section start/-->
                               <div class="tophd"><p class="second-title">2. Billing</p></div>
                                <div class="selected-plantext">
                                    <div class="plantext1">You've selected the <span id="billing_display_package_name">Free</span> Package.</div>
                                        <div class="plantext2">Please select the billing type.</div>
                                </div>
                                <section class="grey-bg pricing_table">
                                    <div class="row">
                                        <div class="biling-internal">
                                            <div class="col-sm-6" billing_mode="12">
                                                <div class="biling-selected">
                                                    <div class="bilibg-title">Annual Billing</div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="biling-fir">Get your bill once a year and receive <span class="annualmode_annual_discount">58% discount</span>  for the year.</div>
                                                        </div>
                                                        <div class="col-sm-6 no-padding">
                                                            <h2 class="price acin-price">
                                                                <div class="acin-chk"></div>
                                                                <span class="small_symbol"><i class="fa fa-inr"></i></span><span class="annualmode_annual_cost" >1999</span><span class="month">/YR</span>
                                                            </h2>
                                                            <p class="acin-heigh"><i class="fa fa-inr"></i> <span class="annualmode_month_cost" >169</span>/- INR Monthly Cost</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6" billing_mode="1">
                                                <div class="biling-selected">
                                                    <div class="bilibg-title">Monthly Billing</div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="biling-sec">Active your package for the month.</div>
                                                        </div>
                                                        <div class="col-sm-6 no-padding">
                                                            <h2 class="price acin-price">
                                                                <span class="acin-chk"></span>
                                                                <span class="small_symbol"><i class="fa fa-inr"></i></span><span class="monthlymode_month_cost" >199</span><span class="month">/MO</span>
                                                            </h2>
                                                            <p class="acin-heigh"><i class="fa fa-inr"></i> <span class="monthlymode_annual_cost" >1999</span>/- INR Yearly Cost</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                               <div class="row">
                                   <hr/>
                                   <div class="center"><button id="submit_package" class="btn btn-primary" disabled="disabled">Continue Selection</button></div>
                               </div>
                        </div>

                    </div>
                    </form>
                </div> <!-- /.col-sm-10 -->
            </div><!-- /.row -->
              
    </div>
    <!--/.container-fluid-->
</div>



<?php include_once('../footer.php'); ?>
 <script src="js/jquery-2.js"></script>

<script type="text/javascript" src="js/combined-head-resp.js"></script>


<script src="../js/bootstrap.js"></script>
<script src="js/sidebar-menu.js"></script>


<script>
function smoothScroll(classname) {
document.querySelector('.'+classname).scrollIntoView({ 
behavior: 'smooth' 
});
}
</script>

<script>
$(function(){
    <!-- Required for professional services marketo form -->
    Templates.forms.professionalServices();
    <!-- Required for enterprise services marketo form lightbox -->
    Templates.forms.enterpriseServices();
    <!-- Required for general page functionality -->
    Templates.pricing.pricingV2();
    Templates.global.topBarSuccess();
    Templates.global.headerSuccess();
});

$(window).scroll(function() {    
var scroll = $(window).scrollTop();

if (scroll >= 1) {
$(".header").addClass("firstHeader");
} else {
$(".header").removeClass("firstHeader");
}
});
$(window).scroll(function() {    
var scroll = $(window).scrollTop();

if (scroll >= 1) {
$(".clearHeader").addClass("firstHeader");
} else {
$(".clearHeader").removeClass("firstHeader");
}
});
$(window).scroll(function() {    
var scroll = $(window).scrollTop();

if (scroll >= 1) {
$(".fiexed-menu-section").addClass("fixed1");
} else {
$(".fiexed-menu-section").removeClass("fixed1");
}
});
$(window).scroll(function() {    
var scroll = $(window).scrollTop();

if (scroll >= 1) {
$(".clearHeader2").addClass("firstHeader");
} else {
$(".clearHeader2").removeClass("firstHeader");
}
});

$(document).ready(function(){
   
    $.sidebarMenu($('.sidebar-menu'))

    $('.col-sm-3.col-xs-12').click(function() {
          $(".col-sm-3.col-xs-12.active").removeClass("active");
          $(this).addClass('active');
    });

    $('.plans-outer').click(function() {
          $(".plans-outer.select").removeClass("select");
          $(this).addClass('select');
    });
    
   // $('#form_billing').hide();
    $('#submit_package').hide();
    

        <?php 
    if(isset($prod_id) && $prod_id > 1){  
    ?>
       var selectedPackageId = <?php echo $prod_id; ?>;    

        var package_name    = $('#package_name_'        + selectedPackageId).val();
        var monthlyCost     = $('#package_monthaly_'    + selectedPackageId).val();
        var annualCost      = $('#package_annually_'    + selectedPackageId).val();

        var annual_billing_monthly_cost = parseInt(parseInt(annualCost) / 12);
        var monthly_billing_annual_cost = parseInt(parseInt(monthlyCost) * 12);

        var annual_billing_discount_amount = parseInt(monthly_billing_annual_cost) - parseInt(annualCost);
        var discount = Math.round((annual_billing_discount_amount / (monthly_billing_annual_cost / 100)));

        $('#selected_package_id').val(selectedPackageId);
        $('#selected_package_name').val(package_name);
         
        $('#billing_display_package_name').html(package_name);
         
        $('.monthlymode_month_cost').html(monthlyCost);
        $('.monthlymode_annual_cost').html(monthly_billing_annual_cost);

        $('.annualmode_annual_cost').html(annualCost);
        $('.annualmode_month_cost').html(annual_billing_monthly_cost);

        $('.annualmode_annual_discount').html(discount + '% Discount');

        if(selectedPackageId > 1) {
            $('#form_billing').show();
        } else {
            $('#form_billing').hide();
        }
        
        $('.biling-internal .col-sm-6').siblings().removeClass('active');
        $('#selected_billing_mode').val('');
        $('#submit_package').attr('disabled', 'disabled');
        $('#submit_package').hide();
        
        if($('#chk_additional_registration').is(':checked'))
        {
            $(this).addClass('active');
        }
        if($('#chk_phone_priority').is(':checked'))
        {
            $(this).addClass('active');
        }

    <?php
     }
    ?>

    $('.pricing-plan').on('click', function(){
        
        $(this).siblings().removeClass('active');
        $(this).addClass('active');
        
        var selectedPackageId = $(this).attr('pid');        
    
        var package_name    = $('#package_name_'        + selectedPackageId).val();
        var monthlyCost     = $('#package_monthaly_'    + selectedPackageId).val();
        var annualCost      = $('#package_annually_'    + selectedPackageId).val();

        var annual_billing_monthly_cost = parseInt(parseInt(annualCost) / 12);
        var monthly_billing_annual_cost = parseInt(parseInt(monthlyCost) * 12);

        var annual_billing_discount_amount = parseInt(monthly_billing_annual_cost) - parseInt(annualCost);
        var discount = Math.round((annual_billing_discount_amount / (monthly_billing_annual_cost / 100)));

        $('#selected_package_id').val(selectedPackageId);
        $('#selected_package_name').val(package_name);
         
        $('#billing_display_package_name').html(package_name);
         
        $('.monthlymode_month_cost').html(monthlyCost);
        $('.monthlymode_annual_cost').html(monthly_billing_annual_cost);

        $('.annualmode_annual_cost').html(annualCost);
        $('.annualmode_month_cost').html(annual_billing_monthly_cost);

        $('.annualmode_annual_discount').html(discount + '% Discount');

        if(selectedPackageId > 1) {
            $('#form_billing').show();
        } else {
            $('#form_billing').hide();
        }
        
        $('.biling-internal .col-sm-6').siblings().removeClass('active');
        $('#selected_billing_mode').val('');
        $('#submit_package').attr('disabled', 'disabled');
        $('#submit_package').hide();
        
        if($('#chk_additional_registration').is(':checked'))
        {
            $(this).addClass('active');
        }
        if($('#chk_phone_priority').is(':checked'))
        {
            $(this).addClass('active');
        }
        
    });
    
    $('#adonsPackage_1').click(function() {
        
       if($('#chkAdonsPackage_1').is(':checked'))
       {
           $(this).addClass('active');
       } else {
           $(this).removeClass('active');
       }
       
    });
    
    $('#adonsPackage_2').click(function() {
        
       if($('#chkAdonsPackage_2').is(':checked'))
       {
           $(this).addClass('active');
       } else {
           $(this).removeClass('active');
       }
       
    });
    
    $('#adonsPackage_sms').click(function() {
        
       if($('#chkAdonsPackage_sms').is(':checked'))
       {
           $(this).addClass('active');
           $('#adonsSmsPackage').removeAttr('disabled');
       } else {
           $(this).removeClass('active');
           $('#adonsSmsPackage').attr('disabled', 'disabled');
       }
       
    });
    
    $('.biling-internal .col-sm-6').on('click', function(){
        $(this).siblings().removeClass('active');
        $(this).addClass('active');
        var billingMode = $(this).attr('billing_mode');

       $('#selected_billing_mode').val(billingMode);
       $('#submit_package').show();
       $('#submit_package').removeAttr('disabled');
       
    });
    
    $('.act-plan').on('click', function(){
        $('.selected-div.hidden').removeClass('hidden');
        $('.selected-div').addClass('active');
    });
    $('.no-plan').on('click', function(){
            $('.selected-div').addClass('hidden');
    });
    $('.no-plan2').on('click', function(){
        $('.selected-div2.hidden').removeClass('hidden');
            $('.selected-div2').addClass('active');
    });
    $('.act-plan').on('click', function(){
            $('.selected-div2').addClass('hidden');
    });

});


 
</script>