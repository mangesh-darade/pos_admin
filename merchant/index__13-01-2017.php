<?php 
include_once('application_main.php');

$posPageName = "merchant"; 

$objapp->authenticateMerchant();

$objMerchant = new merchant();

$merchantData =  $objMerchant->get($objapp->authMerchantId);
 

?>
<?php include_once '../header.php'; ?>

<div class="jumbotron">
	
    <div class="container-fluid">
		<?php include_once('left_sidebar.php'); ?>
                <div class="row">
		<!-- /.new_fixed_links_relative .col-sm-3 -->
		<!-- /.middle section 100%-->
                    <div class="col-sm-10 col-sm-push-2 col-xs-12">
			<h1 class="page-header"> Account </h1>
			<div class="action-bar" role="region">
				<div class="vd-section-wrap" ng-transclude="">
					<div class="flex ">
						Select a plan to get the best out of Simply POS. <a class="" href="<?php echo $objapp->baseURL('package.php');?>" target="_blank">Compare plan details.</a>        
					</div>
				</div>
			</div>
			<div class="vd-section">
				<div class="wrapper">
					<h1 class="vd-hero-headline">You have 10 days left on your free trial</h1>
				<!--	<div class="clear"></div>
					<div class="vd-hero-content">
						<p class="vd-hero-intro"> to explore your example store. </p>
						<p class="vd-hero-intro"> Follow the steps below to set up your own store now. </p>
					</div> -->
				</div>
			</div>
			<div class="acount-pricing">
                            <form method="post" name="choose_package" action="<?php echo $objapp->baseURL('merchant/payment.php');?>" >
				<!--/ pricing section start/-->
				<div class="pricing-table">
					<div class="row">
						<div class="col-sm-12 section-head"> 1. Select a plan <hr class="vd-hr vd-mtxl ng-scope"></div>
						<div class="col-sm-12 col-xs-12">
							<!--/ pricing div 1 section start/-->
                                                        <div class="col-sm-3 col-xs-12 plan1-act free-div" >
                                                            <label for="package_1">
								<div class="price-middle white-bg">
                                                                    <div class="plan-box-heading"><input type="radio" name="package_selected" id="package_1" value="1" /> Free </div>
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
							<!--/ pricing div 1 section end/-->
							<!--/ pricing div 2 section start/-->
							<div class="col-sm-3 col-xs-12 plan2-act">
                                                            <label for="package_2">	
                                                                <div class="price-middle  white-bg">
									<div class="plan-header">
										<h5 class="plan-box-heading"><input type="radio" name="package_selected" id="package_2" value="2" /> BASICS</h5>
										<div class="pricing-unit">
											<span class="account-symbol"><i class="fa fa-inr"></i></span>
											<span class="account-number">199</span>
											<span class="account-frequency">/ MO</span>
											<div class="billing-text">
												INR  billed annually
											</div>
											<div class="alternate-billing-text">
												<i class="fa fa-inr"></i>199 billed monthly
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
										<h5 class="plan-box-heading"><input type="radio" name="package_selected" id="package_3" value="3" /> Advanced</h5>
										<div class="pricing-unit">
											<span class="account-symbol"><i class="fa fa-inr"></i></span>
											<span class="account-number">999</span>
											<span class="account-frequency">/ MO</span>
											<div class="billing-text">
												INR  billed annually
											</div>
											<div class="alternate-billing-text">
												<i class="fa fa-inr"></i> 999 billed monthly
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
                                                                            <label for="checkbox1">
										<div class="addon-header">
                                                                                    <input id="checkbox1" class="inp" type="checkbox" name="Adons_PriorityPhoneSupport" value="1" /> 
											Priority Phone Support
										</div>
										<hr class="vd-hr vd-mbm vd-mtm">
										<div class="addon-body">
											<div class="col-sm-12 col-xs-12">
												<div class="pricing-unit">
													<span class="account-symbol ng-binding"><i class="fa fa-inr"></i></span>
													<span class="account-number ng-binding">99</span>
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
													<span class="account-number ng-binding">79</span>
													<span class="account-frequency">/ MO</span>
												</div>
												<div class="billing-text">
													INR billed annually
												</div>
												<div class="alternate-billing-text">
													<i class="fa fa-inr"></i> 79/-
													INR billed monthly
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
										<h5 class="plan-box-heading"><input type="radio" name="package_selected" id="package_4" value="4" /> Multi-Outlet</h5>
										<div class="pricing-unit">
											<span class="account-symbol">$</span>
											<span class="account-number">69</span>
											<span class="account-frequency">/ MO</span>
											<div class="billing-text">
												USD  billed annually
											</div>
											<div class="alternate-billing-text">
												$69 USD billed monthly
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
													<span class="account-number ng-binding">599</span>
													<span class="account-frequency">/ MO</span>
												</div>
												<div class="billing-text">
													INR billed annually
												</div>
												<div class="alternate-billing-text">
													<i class="fa fa-inr"></i> 599/-
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
				<div class="acount-pricing-biling">
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
                                                                                <div class="section-head">You've selected the Starter plan. </div>
                                                                                <p class="intro-text">How do you want to be billed?</p>
                                                                                <div class="row">
                                                                                    <div class="col-sm-6 col-xs-12 plans-outer select">
                                                                                        <label for="billing_mode_annualy">
                                                                                        <div class="section-head"><input type="radio" name="billing_mode" value="12" id="billing_mode_annualy" />Annual Billing</div>
                                                                                            <hr class="hr">
                                                                                            <div class="row">
                                                                                                    <div class="col-sm-6 col-xs-12">
                                                                                                            <span class="plan-content">Get your bill once a year and receive a <i class="fa fa-inr"></i> 2741/- discount for the year.</span>
                                                                                                    </div>
                                                                                                    <div class="col-sm-6 col-xs-12">
                                                                                                            <div class="pricing-unit">
                                                                                                                    <span class="account-symbol ng-binding"><i class="fa fa-inr"></i></span>
                                                                                                                    <span class="account-number ng-binding">169</span>
                                                                                                                    <span class="account-frequency">/ MO</span>
                                                                                                            </div>
                                                                                                            <div class="billing-text">
                                                                                                                    INR billed annually
                                                                                                            </div>
                                                                                                            <div class="alternate-billing-text">
                                                                                                                <i class="fa fa-inr"></i> 169/- <input type="hidden" name="annualy_billing_package_price" id="annualy_billing_package_price" value="169" />
                                                                                                                    INR billed monthly
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
                                                                                                            <span class="plan-content"> Get your bill once a year.</span>
                                                                                                    </div>
                                                                                                    <div class="col-sm-6 col-xs-12">
                                                                                                            <div class="pricing-unit">
                                                                                                                    <span class="account-symbol ng-binding"><i class="fa fa-inr"></i></span>
                                                                                                                    <span class="account-number ng-binding">395</span>
                                                                                                                    <span class="account-frequency">/ MO</span>
                                                                                                            </div>
                                                                                                            <div class="billing-text">
                                                                                                                    INR billed annually
                                                                                                            </div>
                                                                                                            <div class="alternate-billing-text">
                                                                                                                    <i class="fa fa-inr"></i> 395 <input type="hidden" name="monthly_billing_package_price" id="monthly_billing_package_price" value="395" />
                                                                                                                    INR billed monthly
                                                                                                            </div>
                                                                                                    </div>
                                                                                            </div>
                                                                                        </label>
                                                                                    </div>											
                                                                                </div>

                                                                        <!--	<div class="panel-group accordion" id="accordion" role="tablist" aria-multiselectable="true">
                                                                                        <div class="panel panel-default">
                                                                                                <div class="panel-heading" role="tab" id="headingOne">
                                                                                                        <hr class="hr">
                                                                                                        <h4 class="panel-title">
                                                                                                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                                                                                        I have a referral code <i class="fa fa-chevron-up" aria-hidden="true"></i>

                                                                                                                </a>
                                                                                                        </h4>
                                                                                                </div>
                                                                                                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                                                                                        <div class="panel-body">
                                                                                                                <p class="card-content"> If you were referred by a friend, enter the referral code given - you will both get a one time credit to your subscriptions. </p>
                                                                                                                <div class="discount-code">
                                                                                                                        <div class="label"> Referral code </div>
                                                                                                                        <input class="input-number" >
                                                                                                                </div>
                                                                                                        </div>
                                                                                                </div>
                                                                                        </div>
                                                                                </div> -->
                                                                                <hr class="hr">
                                                                                <button class="btn btn-success btn-lg" type="submit"> Payment </button>

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
