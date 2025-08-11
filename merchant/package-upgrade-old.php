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

if($merchantData['package_id'] > 1){
    $expiryDate = $merchantData['subscription_end_at'];
    $package = true;
} else {
    $expiryDate = $merchantData['pos_demo_expiry_at'];
    $package = false;
}

$expiryDays = $objapp->dateDiff(  date('Y-m-d') , $expiryDate );


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
                    
		<!-- /.new_fixed_links_relative .col-sm-3 -->
		<!-- /.middle section 100%-->
                    <div class="col-sm-10 col-sm-push-2 col-xs-12">
			<h1 class="page-header"> Packages </h1>
			 
			<div class="acount-pricing">
                            <form method="post" name="choose_package" action="payments/checkout.php"  >
                                <input type="hidden" name="form_action" value="package_selection" />
                                <input type="hidden" name="selected_package_id" id="selected_package_id"  />
                                <input type="hidden" name="selected_package_name" id="selected_package_name"  />
                             
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
                                
				<!--/ pricing section start/-->
				<div class="pricing-table">
					<div class="row">
                                            <div class="col-sm-12 section-head"> 1. Select a plan <hr class="vd-hr vd-mtxl ng-scope"></div>
						<div class="col-sm-12 col-xs-12">
							<!--/ pricing div 1 section start/-->
                                                        <div class="col-sm-3 col-xs-12 plan1-act free-div active" >
                                                            <label for="package_1">
								<div class="price-middle white-bg">
                                                                    <div class="plan-box-heading"><input type="radio" class="package_selected" style="display: none;" name="package_selected" checked="checked" id="package_1" value="1" /> Free </div>
									<ul class="plan-box-details-section">
                                                                            <p class="plan-details-heading"> Single outlet </p>
                                                                            <li class="plan-box-details-text"> 1 register only </li>
                                                                            <input type="hidden" name="package_monthaly_1" value="0" />
                                                                            <input type="hidden" name="package_annually_1" value="0" />
                                                                            <input type="hidden" name="package_name_1" value="Free" />
									</ul>
									<ul class="plan-box-details-section">
                                                                            <li class="plan-box-details-text">1 user only </li>
                                                                            <li class="plan-box-details-text">Up to 10 products only </li>
                                                                            <li class="plan-box-details-text">Up to 1000 customers only </li>
									</ul>
									<ul class="plan-box-details-section no-brd">
										<li class="plan-box-details-text"> Community Support </li>
									</ul>
									<div class="vd-button"> Select Plan </div>
									<div class="plan-hide">
										<div class="plan-box-details-heading">
											<i class="fa fa-check" aria-hidden="true"></i>
										Plan Selected
										</div>
										<div class="downgrade-summary">
											<p class="mbm"><strong class="">You won't get:</strong></p>
											<ul class="plan-box-downgrade">
												<li><i class="fa fa-times" aria-hidden="true"></i>Gift Cards</li>
												<li><i class="fa fa-times" aria-hidden="true"></i>Loyalty</li>
												<li><i class="fa fa-times" aria-hidden="true"></i>Advanced Reporting</li>
												<li><i class="fa fa-times" aria-hidden="true"></i>Ecommerce</li>
												<li><i class="fa fa-times" aria-hidden="true"></i>Priority Phone Support</li>
											</ul>
										</div>
									</div>
								</div>
                                                            </label>
							</div>
							<!--/ pricing div 1 section end/-->
							<!--/ pricing div 2 section start/-->
							<div class="col-sm-3 col-xs-12 plan2-act">
                                                            <label for="package_2">	
                                                                <div class="price-middle  white-bg">
									<div class="plan-header">
                                                                            <h5 class="plan-box-heading"><input type="radio" class="package_selected" name="package_selected" id="package_2" value="2" /> BASICS</h5>
										<div class="pricing-unit">
											<span class="account-symbol"><i class="fa fa-inr"></i></span>
											<span class="account-number">199</span>
											<span class="account-frequency">/ MO</span>
											<div class="billing-text">
												<i class="fa fa-inr"></i>999 INR  billed annually
                                                                                                
											</div>
											<div class="alternate-billing-text">
												<i class="fa fa-inr"></i>199  INR billed monthly
                                                                                                <input type="hidden" name="package_monthaly_2" value="199" />
                                                                                                <input type="hidden" name="package_annually_2" value="999" />
                                                                                                <input type="hidden" name="package_name_2" value="Basic" />
											</div>
										</div>
										<div class="vv-plan-box-divider"></div>
										<div class="description">
											Build your retail dream. The essential features to sell, manage, report and grow.
										</div>
									</div>
									<ul class="plan-box-details-section">
										<p class="plan-details-heading"> Single outlet </p>
										<li class="plan-box-details-text"> 1 register only </li>
									</ul>
									<ul class="plan-box-details-section">
										<li class="plan-box-details-text">1 user only
										</li>
										<li class="plan-box-details-text">Up to 10 products only
										</li>
										<li class="plan-box-details-text">Up to 1000 customers only
										</li>
									</ul>
									<ul class="plan-box-details-section no-brd">
										<li class="plan-box-details-text"> Community Support </li>
									</ul>
									<div class="vd-button"> Select Plan </div>
									<div class="plan-hide">
										<div class="plan-box-details-heading">
											<i class="fa fa-check" aria-hidden="true"></i>
										Plan Selected
										</div>
										<div class="downgrade-summary">
											<p class="mbm"><strong class="">You won't get:</strong></p>
											<ul class="plan-box-downgrade">
												<li><i class="fa fa-times" aria-hidden="true"></i>Gift Cards</li>
												<li><i class="fa fa-times" aria-hidden="true"></i>Loyalty</li>
												<li><i class="fa fa-times" aria-hidden="true"></i>Advanced Reporting</li>
												<li><i class="fa fa-times" aria-hidden="true"></i>Ecommerce</li>
												<li><i class="fa fa-times" aria-hidden="true"></i>Priority Phone Support</li>
											</ul>
										</div>
									</div>
								</div>
                                                            </label>
							</div>
							<!--/ pricing div 2 section end/-->
							<!--/ pricing div 3 section start/-->
							<div class="col-sm-3 col-xs-12 plan3-act shadow-bax">
								<div class="price-middle white-bg">
                                                                    <label for="package_3">
									<div class="plan-header">
										<div class="recommended">Recommended</div>
                                                                                <h5 class="plan-box-heading"><input type="radio" class="package_selected" name="package_selected"  id="package_3" value="3" /> Advanced</h5>
										<div class="pricing-unit">
											<span class="account-symbol"><i class="fa fa-inr"></i></span>
											<span class="account-number">395</span>
											<span class="account-frequency">/ MO</span>
											<div class="billing-text">
												<i class="fa fa-inr"></i> 1999 INR  billed annually
											</div>
											<div class="alternate-billing-text">
												<i class="fa fa-inr"></i> 395 INR billed monthly
                                                                                                <input type="hidden" name="package_monthaly_3" value="395" />
                                                                                                <input type="hidden" name="package_annually_3" value="1999" />
                                                                                                <input type="hidden" name="package_name_3" value="Advanced" />
											</div>
										</div>
										<div class="vv-plan-box-divider"></div>
										<div class="description">
											Build your retail dream. The essential features to sell, manage, report and grow.
										</div>
									</div>
									<ul class="plan-box-details-section">
										<p class="plan-details-heading"> Single outlet </p>
										<li class="plan-box-details-text"> 1 register only </li>
									</ul>
									<ul class="plan-box-details-section">
										<li class="plan-box-details-text">1 user only
										</li>
										<li class="plan-box-details-text">Up to 10 products only
										</li>
										<li class="plan-box-details-text">Up to 1000 customers only
										</li>
									</ul>
									<ul class="plan-box-details-section no-brd">
										<li class="plan-box-details-text"> Community Support </li>
									</ul>
									<div class="vd-button"> Select Plan </div>
									<div class="plan-hide">
										<div class="plan-box-details-heading">
											<i class="fa fa-check" aria-hidden="true"></i>
										Plan Selected
										</div>
									</div>
                                                                    </label>
                                                                </div>
									<div class="vv-plan-addon-plus-icon on-hide">
										<i class="fa fa-plus" aria-hidden="true"></i>
									</div>
									<div class="plan-addon-box Adons_PriorityPhoneSupport on-hide">
                                                                            <label for="Adons_PriorityPhoneSupport">
										<div class="addon-header">
                                                                                    <input id="Adons_PriorityPhoneSupport" class="inp" type="checkbox" name="Adons_PriorityPhoneSupport" value="1" /> 
                                                                                    <input type="hidden" name="PriorityPhoneSupport" value="399" />
                                                                                    <span>Priority Phone Support</span>
										</div>
										<hr class="vd-hr vd-mbm vd-mtm">
										<div class="addon-body">
											<div class="col-sm-12 col-xs-12">
												<div class="pricing-unit">
													<span class="account-symbol ng-binding"><i class="fa fa-inr"></i></span>
													<span class="account-number ng-binding">399</span>
													<span class="account-frequency">/ MO</span>
												</div>
												<div class="billing-text">
													INR billed monthly
												</div>
												<div class="addon-description">Skip to the front of the line with priority phone support. Our dedicated team is here for you&nbsp;24-7.</div>
											</div>
                                                                                </div>
                                                                            </label>
									</div>
									<div class="plan-addon-box on-hide">
										<div class="addon-header">
											Additional registers
										</div>
										<hr class="vd-hr vd-mbm vd-mtm">
										<div class="addon-body">
											<div class="col-sm-12 col-xs-12">
												<div class="pricing-unit">
													<span class="account-symbol ng-binding"><i class="fa fa-inr"></i></span>
													<span class="account-number ng-binding">199</span>
													<span class="account-frequency">/ MO</span>
												</div>
												<div class="billing-text">
													<i class="fa fa-inr"></i> 999/- INR billed annually
												</div>
												<div class="alternate-billing-text">
													<i class="fa fa-inr"></i> 199/- INR billed monthly
												</div>
												<div class="addon-description">To add more registers, go to Setup &gt; Outlets &amp;&nbsp;Registers.</div>
											</div>
										</div>
									</div>
							</div>
							<!--/ pricing div 3 section rnd/-->
							<!--/ pricing div 4 section start/-->
							<div class="col-sm-3 col-xs-12 plan4-act">
								<div class="price-middle white-bg">
                                                                    <label for="package_4" >
									<div class="plan-header">
                                                                            <h5 class="plan-box-heading"><input type="radio" class="package_selected" name="package_selected" id="package_4" value="4" /> Multi-Outlet</h5>
										<div class="pricing-unit">
											<span class="account-symbol"><i class="fa fa-inr"></i></span>
											<span class="account-number">599</span>
											<span class="account-frequency">/ MO</span>
											<div class="billing-text">
												<i class="fa fa-inr"></i> 3999 INR  billed annually
											</div>
											<div class="alternate-billing-text">
												<i class="fa fa-inr"></i> 599 INR billed monthly
                                                                                                <input type="hidden" name="package_monthaly_4" value="599" />
                                                                                                <input type="hidden" name="package_annually_4" value="3999" />
                                                                                                <input type="hidden" name="package_name_4" value="Multi-Outlet" />
											</div>
										</div>
										<div class="vv-plan-box-divider"></div>
										<div class="description">
											Build your retail dream. The essential features to sell, manage, report and grow.
										</div>
									</div>
									<ul class="plan-box-details-section">
										<p class="plan-details-heading"> Single outlet </p>
										<li class="plan-box-details-text"> 1 register only </li>
									</ul>
									<ul class="plan-box-details-section">
										<li class="plan-box-details-text">1 user only
										</li>
										<li class="plan-box-details-text">Up to 10 products only
										</li>
										<li class="plan-box-details-text">Up to 1000 customers only
										</li>
									</ul>
									<ul class="plan-box-details-section no-brd">
										<li class="plan-box-details-text"> Community Support </li>
									</ul>
									<div class="vd-button"> Select Plan </div>
									<div class="plan-hide">
										<div class="plan-box-details-heading">
											<i class="fa fa-check" aria-hidden="true"></i>
										Plan Selected
										</div>
									</div>
                                                                    </label>
                                                                </div>
									<div class="vv-plan-addon-plus-icon on-hide">
										<i class="fa fa-plus" aria-hidden="true"></i>
									</div>
									<div class="plan-addon-box on-hide">
										<div class="addon-header">
											Additional registers
										</div>
										<hr class="vd-hr vd-mbm vd-mtm">
										<div class="addon-body">
											<div class="col-sm-12 col-xs-12">
												<div class="pricing-unit">
													<span class="account-symbol ng-binding"><i class="fa fa-inr"></i></span>
													<span class="account-number ng-binding">199</span>
													<span class="account-frequency">/ MO</span>
												</div>
												<div class="billing-text">
													<i class="fa fa-inr"></i> 999/-INR billed annually
												</div>
												<div class="alternate-billing-text">
													<i class="fa fa-inr"></i> 199/-
													INR billed monthly
												</div>
												<div class="addon-description">To add more registers, go to Setup &gt; Outlets &amp;&nbsp;Registers.</div>
											</div>
										</div>
									</div>
								
							</div>
							<!--/ pricing div 4 section end/-->
						</div>
					</div>
				</div>
				<!--/ pricing section end/-->
				<hr class="vd-hr vd-mtxl ng-scope">
				<!--/ billing section start/-->
                                <div class="acount-pricing-biling" id="billingSection">
					<div class="clear-data">
                                            <div class="row">
                                                <div class="col-sm-3 col-xs-12">
                                                        <div class="section-head"> 2. Billing </div>
                                                </div>
                                                <div class="col-sm-9 col-xs-12 "> 
							<!-- / plans section start / -->
							<div class="row">
                                                            <div class="col-sm-12 col-xs-12">									
                                                                <div class="row plan2">
                                                                        <div class="col-sm-12 col-xs-12">
                                                                            <div class="section-head">You've selected the <span id="selected_plan_name">Free</span> plan.</div>
                                                                                <p class="intro-text">How do you want to be billed?</p>
                                                                                <div class="row">
                                                                                    <div class="col-sm-6 col-xs-12 plans-outer select">
                                                                                        <label for="billing_mode_annualy">
                                                                                            <div class="section-head"><input type="radio" name="billing_mode" checked="checked" value="12" id="billing_mode_annualy" />Annual Billing</div>
                                                                                            <hr class="hr">
                                                                                            <div class="row">
                                                                                                    <div class="col-sm-6 col-xs-12">
                                                                                                        <span class="plan-content">Get your bill once a year and receive
                                                                                                            <h5  style="margin-bottom: 0px; color: #c10841"> <span id="display_annual_billing_discount">0</span>% discount</h5> 
                                                                                                                    for the year.</span>
                                                                                                    </div>
                                                                                                    <div class="col-sm-6 col-xs-12" style="padding-left: 0px; padding-right: 5px;">
                                                                                                            <div class="pricing-unit">
                                                                                                                    <span class="account-symbol ng-binding"><i class="fa fa-inr"></i></span>
                                                                                                                    <span class="account-number ng-binding display_annual_billing_annual_cost">0</span>&nbsp;<span class="account-frequency">/Yr</span>
                                                                                                            </div>
                                                                                                            
                                                                                                            <div class="billing-text">
                                                                                                                <i class="fa fa-inr"></i> <span class="display_annual_billing_monthly_cost">0</span>/-  INR billed monthly  
                                                                                                                   <input type="hidden" name="annualy_billing_package_price" id="annualy_billing_package_price" value="0" />
                                                                                                                   <input type="hidden" name="annual_billing_discount_amount" id="annual_billing_discount_amount" value="0" />
                                                                                                            </div>
                                                                                                    </div>
                                                                                            </div>
                                                                                        </label> 
                                                                                    </div>
                                                                                    <div class="col-sm-6 col-xs-12 plans-outer clearfix">
                                                                                        <label for="billing_mode_monthly">
                                                                                            <div class="section-head"><input type="radio" name="billing_mode" value="1" id="billing_mode_monthly" /> Monthly Billing</div>
                                                                                            <hr class="hr">
                                                                                            <div class="row">
                                                                                                    <div class="col-sm-6 col-xs-12">
                                                                                                            <span class="plan-content"> Active your package for the month.</span>
                                                                                                    </div>
                                                                                                    <div class="col-sm-6 col-xs-12">
                                                                                                        <div class="pricing-unit">
                                                                                                            <span class="account-symbol ng-binding"><i class="fa fa-inr"></i></span>
                                                                                                            <span class="account-number ng-binding display_monthly_billing_cost">0</span>
                                                                                                            <span class="account-frequency">/ MO</span>
                                                                                                        </div>
                                                                                                        <div class="billing-text">
                                                                                                             <i class="fa fa-inr"></i> <span class="display_monthly_billing_annual_cost">0</span> INR billed annually
                                                                                                             <input type="hidden" name="monthly_billing_package_price" id="monthly_billing_package_price" value="0" />
                                                                                                        </div>
                                                                                                        
                                                                                                    </div>
                                                                                            </div>
                                                                                        </label>
                                                                                    </div>											
                                                                                </div>
 
                                                                                <hr class="hr">
                                                                                <button class="btn btn-success btn-lg" type="submit"> Continue Selection </button>
                                                                               
                                                                        </div>
                                                                </div>									 
                                                            </div>
							</div>
							<!-- / plans section end / -->
                                                        
						</div>                                                
                                            </div>
                                        </div>
                                    <!--/ billing section end/-->
                                    <div class="clear"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                        <!-- /.col-sm-10 -->
                </div>
    </div>
    <!--/.container-fluid-->
</div>



<?php include_once('../footer.php'); ?>
 