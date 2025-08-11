<!-- / fixed menu section -->

<section class="fiexed-menu-section" style="width: 200px">
    
<ul class="sidebar-menu">
       
           <li>
                <a href="#">
                  <i class="fa fa-pie-chart"></i>
                  <span>Account</span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">
                  <li><a href="#"><i class="fa fa-circle-o"></i> Profile</a></li>
                  <li><a href="<?php echo $objapp->baseURL('merchant/index.php');?>"><i class="fa fa-circle-o"></i> Account</a></li>
                </ul>
          </li>
          <li>
                <a href="#">
                  <i class="fa fa-edit"></i> <span>Subscriptions</span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">
                  <li><a href="#"><i class="fa fa-circle-o"></i> Payment History</a></li>
                  <li><a href="#"><i class="fa fa-circle-o"></i> Current Package</a></li>
                  <li><a href="<?php echo $objapp->baseURL('merchant/package-upgrade.php');?>"><i class="fa fa-circle-o"></i>Package Upgrade</a></li>
                </ul>
          </li>
          
         </ul>
</section>
<!-- / fixed menu section end -->