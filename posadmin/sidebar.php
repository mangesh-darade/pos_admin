<?php
if(in_array($_SESSION['session_user_group'], ['employee-sales', 'distributors'])) {
    $isDistributors = $_SESSION['login']['is_disrtibuter'];
}
?>
<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="dist/img/avatar5.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $_SESSION['login']['display_name'] ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <li class="active treeview">
          <a href="index.php">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span> </i>
          </a>          
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-industry" aria-hidden="true"></i>
            <span> Merchants </span>
            <span class="label label-primary pull-right"><?php echo $objapp->count_merchant(); ?></span>
          </a>
          <ul class="treeview-menu">
            <li><a href="merchants.php"><i class="fa fa-users"></i> Merchant List</a></li> 
            <li><a href="merchant_add.php"><i class="fa fa-user-plus"></i> Add Merchant</a></li> 
<?php 
        if(in_array($_SESSION['session_user_group'], ['admin-dev', 'superadmin'])) {
    ?>
            <li><a href="restaurant.php"><i class="fa fa-cutlery" aria-hidden="true"></i> Restaurants List</a></li> 
<?php } ?>
          </ul>
        </li>
        
      <?php 
        if(in_array($_SESSION['session_user_group'], ['admin-dev', 'superadmin', 'admin-user'])) {
        ?>     
        <li class="treeview">
          <a href="#">
            <i class="fa fa-database"></i>
            <span>Manage Masters</span>        
          </a>
          <ul class="treeview-menu">
            <li><a href="merchant_type_list.php"><i class="fa fa-circle-o"></i>Merchant Type</a></li>
            <li><a href="package_list.php"><i class="fa fa-circle-o"></i>Packages</a></li>
            <li><a href="package_addon_list.php"><i class="fa fa-circle-o"></i>Addon Package</a></li>
            <li><a href="package_sms_list.php"><i class="fa fa-circle-o"></i>SMS Package</a></li>
            <li><a href="configuration_list.php"><i class="fa fa-cog"></i>Configuration</a></li>
          </ul>
        </li>
    <?php } ?>   
    <?php 
        if(in_array($_SESSION['session_user_group'], ['admin-dev', 'superadmin', 'admin-user'])) {
    ?>    
        <li class="treeview">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>Users & Distributors</span>   
            <span class="label label-primary pull-right"><?php echo $objapp->adminUserCount(); ?></span>           
          </a>
          <ul class="treeview-menu">
	     <?php if($_SESSION['session_user_group'] != 'admin-user') { ?>
<!--            <li><a href="admin_user_list.php"><i class="fa fa-circle-o"></i> User List</a></li> -->
             
	     <?php } ?>
            <li><a href="adminusers_list.php"><i class="fa fa-circle-o"></i> All Users</a></li>
            <li><a href="distributors_list.php"><i class="fa fa-circle-o"></i> Distributors List</a></li>             
          </ul>
        </li>
    <?php } ?> 
         
        <li class="treeview">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>Requests</span>   
            <span class="label label-primary pull-right"><?php echo $objapp->count_pending_request(); ?></span>           
          </a>
          <ul class="treeview-menu">            
            <li><a href="distributors_request.php"><i class="fa fa-circle-o"></i> <?php echo ( $isDistributors )? 'My ':'Distributors ';?> Request </a></li> 
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-list"></i>
            <span>Reports</span>
          </a>
          <ul class="treeview-menu">            
            <li><a href="merchants_report.php"><i class="fa fa-circle-o"></i> Reports </a></li> 
          </ul>
        </li>
        
    <?php 
        if($_SESSION['session_user_group']==='admin-dev') {
    ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-wrench"></i>
            <span>Developer Tools</span>        
          </a>
          <ul class="treeview-menu">
           <!-- <li><a href="dev_configuration.php"><i class="fa fa-circle-o"></i>Configuration</a></li> -->
            <li><a href="dev_pos_project_zip.php"><i class="fa fa-circle-o"></i>POS Project Zip</a></li>            
            <li><a href="dev_pos_project_sql.php"><i class="fa fa-circle-o"></i>POS Project SQL</a></li>            
            <li><a href="dev_pos_versions.php"><i class="fa fa-circle-o"></i>POS Versions</a></li>            
          </ul>
        </li>
        <?php } else { ?> 
        <li class="treeview">
          <a href="#">
            <i class="fa fa-wrench"></i>
            <span>POS Versions</span>        
          </a>
          <ul class="treeview-menu">                     
            <li><a href="dev_pos_versions.php"><i class="fa fa-circle-o"></i>POS Versions</a></li>            
          </ul>
        </li>
        <?php } ?> 
        
    <?php 
        if(in_array($_SESSION['session_user_group'], ['admin-dev', 'superadmin', 'admin-user'])) {
    ?>     
        <li class="treeview">
          <a href="#">
            <i class="fa fa-exclamation-triangle "></i>
            <span>Log</span>   
            <span class="label label-primary pull-right"><?php echo $objapp->errorLogsCount(); ?></span>           
          </a>
          <ul class="treeview-menu">
            <li><a href="pos_error_log_list.php"><i class="fa fa-circle-o"></i> Error Log</a></li>            
            <li><a href="user_logs.php"><i class="fa fa-circle-o"></i> User Log</a></li>            
            <li><a href="temp_data.php"><i class="fa fa-circle-o"></i> Scrap Records</a></li>            
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-exclamation-triangle "></i>
            <span>Offline Setups</span>
          </a>
          <ul class="treeview-menu">
            <li><a href="offline_pos_setups.php"><i class="fa fa-circle-o"></i> Setup List</a></li>      
          </ul>
        </li>

    <?php } ?>
  
        <li><a href="user_change_password.php" class="text-green"><i class="fa fa-shield"></i> Change Password</a></li>
        <li><a href="mail_settings.php"><i class="fa fa-envelope"></i> Mail Settings</a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  