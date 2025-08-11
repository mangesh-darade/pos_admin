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

                            <input type="hidden" name="form_action" value="active_addons" /> 
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
                                                    <h1 class="small">Choose the addons to get improve results.</h1>
                                                </div>
                                            </div>
                                        </div> 
                                    <!-- Pricing details -->
                                    <div class="pricing-section">

                                            <div class="selected-div">
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
<!--                                                                        <p class="packfir-price"><i class="fa fa-inr"></i>< ?php echo $adonsPackage['annual_price'];?> INR Billed Annually</p>-->
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
                             
                             <hr/>
                             <div class="center"><button id="submit_package" class="btn btn-primary" disabled="disabled">Continue Selection</button></div>
                         

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
   
    var addon_1 = false;
    var addon_2 = false;
    var addon_3 = false;
    
    
    $('#adonsPackage_1').click(function() {
        
       if($('#chkAdonsPackage_1').is(':checked'))
       {
           $(this).addClass('active');
           addon_1 = true;
       } else {
           $(this).removeClass('active');
           addon_1 = false;
       }
        
        if(addon_1 || addon_2 || addon_3){
            $('#submit_package').removeAttr('disabled');
        } else {
             $('#submit_package').attr('disabled', 'disabled');
        }
        
    });
    
    $('#adonsPackage_2').click(function() {
        
       if($('#chkAdonsPackage_2').is(':checked'))
       {
           $(this).addClass('active');
           addon_2 = true;
       } else {
           $(this).removeClass('active');
           addon_2 = false;
       }
       if(addon_1 || addon_2 || addon_3){
            $('#submit_package').removeAttr('disabled');
        } else {
             $('#submit_package').attr('disabled', 'disabled');
        }
    });
    
    $('#adonsPackage_sms').click(function() {
        
       if($('#chkAdonsPackage_sms').is(':checked'))
       {
           $(this).addClass('active');
           $('#adonsSmsPackage').removeAttr('disabled');
           addon_3 = true;
       } else {
           $(this).removeClass('active');
           $('#adonsSmsPackage').attr('disabled', 'disabled');
           addon_3 = false;
       }
       if(addon_1 || addon_2 || addon_3){
            $('#submit_package').removeAttr('disabled');
        } else {
             $('#submit_package').attr('disabled', 'disabled');
        }
    });

});


 
</script>