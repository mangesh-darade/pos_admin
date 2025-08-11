<?php
    switch ($active_package_id) {
    
    case 2:
        
 ?>        
    <!--/ pricing div 2 section start/-->
    <div class="col-sm-12  plan3-act shadow-bax active">
        <label for="package_2">	
            <div class="price-middle  white-bg">
                    <div class="plan-header">
                        <h5 class="plan-box-heading">BASICS</h5>
                        <div class="recommended"><?php echo $packageStatus;?>  Package</div>
                            <div class="pricing-unit">
                                <span class="account-symbol"><i class="fa fa-inr"></i></span>
                                <span class="account-number">199</span>
                                <span class="account-frequency">/ MO</span>
                                <div class="billing-text">
                                    <i class="fa fa-inr"></i>999 INR  billed annually
                                </div>
                                <div class="alternate-billing-text">
                                    <i class="fa fa-inr"></i>199  INR billed monthly
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
                            <li class="plan-box-details-text">1 user only </li>
                            <li class="plan-box-details-text">Up to 10 products only </li>
                            <li class="plan-box-details-text">Up to 1000 customers only </li>
                    </ul>
                    <ul class="plan-box-details-section no-brd">
                            <li class="plan-box-details-text">  </li>
                    </ul>
                <div><a href="package-upgrade.php" class="vd-button"> Upgrade Package </a></div>
                <br/>
                     
            </div>
        </label>
    </div>
    <!--/ pricing div 2 section end/-->
<?php       
        break;
    
    case 3:
?>        
  <!--/ pricing div 3 section start/-->
    <div class="col-sm-12 plan3-act shadow-bax active">
        <div class="price-middle white-bg">
            <label for="package_3">
                <div class="plan-header">
                        <div class="recommended"><?php echo $packageStatus;?>  Package</div>
                        <h5 class="plan-box-heading"><i class="fa fa-check" aria-hidden="true"></i> Advanced</h5>
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
                        <li class="plan-box-details-text">  </li>
                </ul>
                <div> <a href="package-upgrade.php" class="vd-button">   Upgrade Package </a></div>
                 <br/>
            </label>
        </div> 
</div>
<!--/ pricing div 3 section rnd/-->
<?php        
        
        break;
    
    case 4:
?>        
  <!--/ pricing div 4 section start/-->
<div class="col-sm-12  plan3-act shadow-bax active">
        <div class="price-middle white-bg">
            <label for="package_4" >
                
                <div class="plan-header">
                    <div class="recommended"><?php echo $packageStatus;?>  Package</div>
                    <h5 class="plan-box-heading">Multi-Outlet</h5>
                        <div class="pricing-unit">
                                <span class="account-symbol"><i class="fa fa-inr"></i></span>
                                <span class="account-number">599</span>
                                <span class="account-frequency">/ MO</span>
                                <div class="billing-text">
                                        <i class="fa fa-inr"></i> 3999 INR  billed annually
                                </div>
                                <div class="alternate-billing-text">
                                        <i class="fa fa-inr"></i> 599 INR billed monthly                                        
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
                        <li class="plan-box-details-text">  </li>
                </ul>
                <div> <a href="package-upgrade.php" class="vd-button">   Upgrade Package </a></div>
                <br/>
                 
            </label>
        </div>
                

</div>
<!--/ pricing div 4 section end/-->
<?php
        break;
        
    case 1:
    default:
    ?>
    <div class="col-md-12  plan3-act shadow-bax active">
   							
   
        <div class="price-middle plan3-act shadow-bax white-bg">
             
            <div class="plan-box-heading"> Free Demo </div>
            <div class="recommended"><?php echo $packageStatus;?>  Package</div>
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
                        <li class="plan-box-details-text">  </li>
                </ul>
            <div> <a href="package-upgrade.php" class="vd-button">   Upgrade Package </a></div>
            <br/>
                 
        </div>
     
    </div>
<?php 
        break;
}

?>



 