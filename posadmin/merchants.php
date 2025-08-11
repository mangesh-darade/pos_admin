<?php
include_once('application_main.php');
include_once('session.php');
include_once('xmlapi.php');
require_once('../functions/phpFormFunctions.php');

$objMerchant = new merchant($conn);

$objMerchant->get();

$posStatusCount = $objMerchant->getPosStatusCounts();
 

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Simply POS | Merchants</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous" />
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css" />
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <link rel="stylesheet" href="dist/css/Style.css" />
</head>
 
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

	<?php include_once('header.php'); ?>
	<?php include_once('sidebar.php'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1> Merchant <small>List</small>  </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Merchant</a></li>
        <li class="active">List</li>
      </ol>
    </section>
    
  <!-- Generate POS Project Modal -->
  <div class="modal fade " id="posUsers" role="dialog">
      <div class="modal-dialog" style="width: 800px;">    
      <!-- Modal content-->
      <div class="modal-content" id="pos_user_list">
          <h1>Model contains will display here!</h1>
      </div>      
    </div>
  </div>
<input type="hidden" name="UserId" id="UserId" value="<?php echo $_SESSION['login']['user_id'] ?>">
  <!-- // End Generate POS Project Modal -->
  <!-- Start Modal -->
<div class="modal fade " id="myModal" role="dialog">
    <div class="modal-dialog" style="width:90%;">
        <div class="modal-content" id="myModalContent">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <i class="fa fa-close"></i>
                </button>
                <h4 class="modal-title" id="myModalTitle">Merchant Edit Form</h4>
            </div>
            <div class="modal-body" id="myModalBody">
                <div class="row form-horizontal">
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <input type="hidden" name="formAction" id="formAction" value="insert" />
                        <input type="hidden" name="update_id" id="update_id" />
                        
                        <div class="row form-group">
                          <label for="name" class="col-sm-4"><span class="text-danger">*</span> Merchant Name</label>
                          <div class="col-sm-8">
                              <input type="text" class="form-control" id="name" name="name" data-format="requared|alfa-dash" placeholder="Merchant Name" />
                          </div>
                        </div>
                        <div class="row form-group">
                                <label for="email" class="col-sm-4">&nbsp;&nbsp;&nbsp;Merchant Email</label>
                          <div class="col-sm-8">
                                <input type="email" class="form-control" id="email" name="email" data-format="requared|valid_email" placeholder="Merchant Email" />
                          </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-4 col-xs-12"><label for="phone"><span class="text-red">*</span> Mobile No:</label></div>
                            <div class="col-sm-4 col-xs-12">                  
                                <select tabindex="3"  data-toggle="tooltip" title="Select Country" name="country" id="country" class="<?php echo ($inputError['countrycode']) ? 'form-control text-danger border-danger' : 'form-control';?>"  required="required">
                                    <option value="">-- Select Country --</option>
                                    <?php 
                                      $countries = get_country_data();
                                      if(is_array($countries)) {
                                          foreach ($countries as $id => $country) {

                                              $selected_country = ($country_code == $country['code']) ? ' selected="selected" ' : '';

                                             echo '<option value="'.$country['name'].'~'.$country['code'].'" '. $selected_country.'>'.$country['name'].' (+'.$country['code'].')</option>';
                                          }
                                      }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-4 col-xs-12"><input type="text" tabindex="4" readonly="readonly" data-toggle="tooltip" title="Mobile should be 10 digits number only." name="phone" class="form-control" id="phone" value="<?php echo (!$formIsValid) ? $phone : $phone;?>" required="required" maxlength="10" placeholder="Phone No." pattern="[0-9]{10,}" title="Only number and minimum 10 digits."/></div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-4 col-xs-12"><label for="merchant_type"><span class="text-red">*</span> Merchant Type:</label></div>
                            <div class="col-sm-8 col-xs-12">
                                <select  tabindex="5"  class="form-control" id="merchant_type" name="merchant_type" required="required" >
                                    <option value="">--Select One--</option>
                                    <?php
                                        $merchantTypes = $objMerchant->merchantTypes;

                                        if(is_array($merchantTypes)){

                                           $selected = '';

                                            foreach($merchantTypes as $id => $type) {
                                               if($merchant_type_id == $id) {
                                                  $selected = ' selected="selected"'; 
                                               }
                                                echo '<option value="'.$id.'" '. $selected.'>'.$type.'</option>';
                                            }
                                        }
                                    ?>
                                </select> 
                            </div>                  
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-4 col-xs-12"><label for="business_name"><span class="text-red">*</span> Business Name:</label></div>
                            <div class="col-sm-8 col-xs-12"><input type="text"  tabindex="5"  name="business_name" data-toggle="tooltip" title="Business Name should be minimum 3 characters." class="<?php echo ($inputError['businessname']) ? 'form-control text-danger border-danger' : 'form-control';?>" id="business_name" required="required" maxlength="30" placeholder="Busness Name"  /></div>
                        </div>
                        <div class="row form-group " id="pos_web_url">
                            <div class="col-sm-4 col-xs-12"><label for="pos_name">&nbsp;&nbsp;&nbsp;POS Web URL:</label></div>
                            <div class="col-sm-5 col-xs-7">
                                <input type="hidden" name="pos_generate" id="pos_generate" />
                                <input type="hidden" name="pos_status" id="pos_status" />
                                <input type="text" tabindex="6" name="pos_name" class="form-control" id="pos_name" data-toggle="tooltip" title="Choose Your POS URL. URL Name should be only in alphabets between 5 to 20 characters." maxlength="20" placeholder="Web Url" pattern="[A-Za-z0-9]{5,}" /></div>
                            <div class="col-sm-3 col-xs-5" style="padding-left: 0px;"><h4>.simplypos.in</h4></div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-4 col-xs-12"><label for="address-1">&nbsp;&nbsp;&nbsp;Address Line 1:</label></div>
                            <div class="col-sm-8 col-xs-12"><input type="text"  tabindex="5"  name="address" value="<?php echo $address;?>"  class="form-control" id="address"   maxlength="200" placeholder="Address"  /></div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-4 col-xs-12"><label for="address-2">&nbsp;&nbsp;&nbsp;Address Line 2:</label></div>
                            <div class="col-sm-4 col-xs-12"><input type="text"  tabindex="5"  name="state" value="<?php echo $state;?>" class="form-control" id="state" maxlength="60" placeholder="State Name" /></div>
                            <div class="col-sm-4 col-xs-12"><input type="text"  tabindex="5"  name="city" value="<?php echo $city;?>" class="form-control" id="city" maxlength="60" placeholder="City Name" /></div>
                        </div>
                    </div> 
                    <div class="col-md-5 col-sm-5 col-xs-12">
                         
                        <div class="row form-group">
                            <div class="col-sm-6"><label for="merchant_group"><span class="text-red">*</span> Use For Testing:</label></div>
                            <div class="col-sm-6">
                                <select class="form-control" id="is_testing_merchant" name="is_testing_merchant" required="required" >
                                    <option value="">--Select One--</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-6"><label for="restricted_pos_updates"><span class="text-red">*</span> Restricted For Software Updates:</label></div>
                            <div class="col-sm-6">
                                <select class="form-control" id="restricted_pos_updates" name="restricted_pos_updates" required="required" >
                                    <option value="">--Select One--</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                                         
                        <div class="row form-group">
                            <div class="col-sm-6"><label for="merchant_group"><span class="text-red">*</span> Merchant Group:</label></div>
                            <div class="col-sm-6">
                                <select class="form-control" id="merchant_group" name="merchant_group" required="required" >
                                    <option value="">--Select One--</option>
                                    <?php
                                        $merchantsGroups = $objMerchant->merchantGroups;

                                        if(is_array($merchantsGroups)){

                                           $gselected = '';

                                            foreach($merchantsGroups as $gid => $group) {
                                               if($merchant_group == $gid) {
                                                  $gselected = ' selected="selected"'; 
                                               }
                                                echo '<option value="'.$gid.'" '. $gselected.'>'.$group.'</option>';
                                            }
                                        }
                                    ?>
                                </select> 
                            </div>                  
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-6"><label for="project_group"><span class="text-red">*</span> Project Group:</label></div>
                            <div class="col-sm-6">
                                <select class="form-control" id="project_id" name="project_id" required="required" >
                                    <option value="">--Select One--</option>
                                    <?php
                                        $projectsGroup = $objMerchant->projectGroups;

                                        if(is_array($projectsGroup)){

                                           $pselected = '';

                                            foreach($projectsGroup as $pid => $project) 
                                            {
                                                if($project_id == $pid) {
                                                    $pselected = ' selected="selected"'; 
                                                }
                                                echo '<option value="'.$pid.'" '. $pselected.'>'.$project.'</option>';
                                            }//end foreach.
                                        }//
                                    ?>
                                </select> 
                            </div>                  
                        </div>
                        
                         <div class="row form-group">
                            <div class="col-sm-6"><label for="distributor_id"><span class="text-red">*</span> Distributor:</label></div>
                            <div class="col-sm-6">
                                <select class="form-control" id="distributor_id" name="distributor_id" required="required" >
                                    <option value="">--Select One--</option>
                                    <?php
                                        $distributors = $objMerchant->getDistributors();

                                        if(is_array($distributors)){

                                            $dselected = '';

                                            foreach($distributors as $did => $distributor) {
                                                if($distributor_id == $did) {
                                                    $dselected = ' selected="selected"'; 
                                                }
                                                echo '<option value="'.$did.'" '. $dselected.'>'.$distributor['display_name'].'</option>';
                                            }
                                        }
                                    ?>
                                </select> 
                            </div>                  
                        </div>                        
                         <div class="row form-group">
                            <div class="col-sm-6"><label for="client_by"><span class="text-red">*</span> Follow By:</label></div>
                            <div class="col-sm-6">
                                <select class="form-control" id="client_by" name="client_by" required="required" >
                                    <option value="">--Select One--</option>
                                    <?php                                    
                                        $adminUsers = $objMerchant->getAdminUserList();
                                        
                                        if(is_array($adminUsers)){

                                            $cselected = '';

                                            foreach($adminUsers as $uid => $users) {
                                                if($client_by == $uid) {
                                                  $cselected = ' selected="selected"'; 
                                                }
                                                echo '<option value="'.$uid.'" '. $cselected .'>'.$users['display_name'].'</option>';
                                            }
                                        }
                                    ?>
                                </select> 
                            </div>                  
                        </div>
                        <div class="row">
                            <div id="action_msg"></div>
                        </div>
                    </div>
                    
                    <!-- /.box-body -->
                    <div class="row">
                        <div class="box-footer col-sm-10 col-sm-offset-1 col-xs-12 text-center " id="myModalFooter">                            
                            <button type="button" id="myModalClose" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="button" id="myModalSubmit" class="btn btn-primary">Save</button>
                        </div>
                    </div>         
                    <!-- /.box-footer -->
                 </div>
            </div>             
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- // End Modal -->   


    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            
            <!-- /.box-header -->
            <div class="box-body">
            
              <div class="row">
                <div class="col-sm-9 col-xs-12">                     
                    <div class="btn-group">
                       <button class="btn btn-primary">POS :<br/><small class="label label-default"><?php echo $posStatusCount['total'];?></small></button>                    
                       <button type="button" id="is_delete-0~pos_generate-0~pos_status-pending" class="tab-filter btn btn-success">Pending<br/><small class="label label-info"><?php echo $objMerchant->getPendingPOS(); ?></small></button>
                       <button type="button" id="pos_generate-1" class="tab-filter btn btn-default">Generated<br/><small class="label label-info"><?php echo $objMerchant->getGeneratedPOS(); ?></small></button>
                       <button type="button" id="pos_status-upgrade~is_active-1~is_testing_merchant-0" class="tab-filter btn btn-default">Paid<br/><small class="label label-warning"><?php echo $objMerchant->getPaidActivePOS();?></small></button>
                       <button type="button" id="pos_generate-1~is_active-1~package_id-1~is_testing_merchant-0" class="tab-filter btn btn-default">Demos<br/><small class="label label-primary"><?php echo $objMerchant->getFreeActiveDemoPOS();?></small></button>
                       <button type="button" id="pos_status-extended~is_testing_merchant-0" class="tab-filter btn btn-default">Extended<br/><small class="label label-success"><?php echo $objMerchant->getExtendedPOS();?></small></button>
                       <button type="button" id="pos_status-suspended~is_testing_merchant-0" class="tab-filter btn btn-default">Suspended<br/><small class="label label-danger"><?php echo $objMerchant->getSuspendedPOS();?></small></button>
                       <button type="button" id="pos_status-trashed" class="tab-filter btn btn-default">Trashed<br/><small class="label label-danger"><?php echo $objMerchant->getTrashedPOS();?></small></button>
                       <button type="button" id="pos_status-deleted" class="tab-filter btn btn-default">Deleted<br/><small class="label label-danger"><?php echo $objMerchant->getDeletedPOS();?></small></button>
                       <button type="button" id="is_testing_merchant-1" class="tab-filter btn btn-default">Test<br/><small class="label label-primary"><?php echo $objMerchant->getTestingPOS();?></small></button>
                       <button type="button" id="is_merchant_verified-1" class="tab-filter btn btn-default" data-toggle="tooltip" title="Genuine Merchants"><i class="fa fa-handshake-o text-warning text-align-lg-center" aria-hidden="true"></i><br/><small class="label label-warning"><?php echo $posStatusCount['genuine'];?></small></button>
                    </div>
                    <input type="hidden" name="masterTable" id="masterTable" value="<?php echo TABLE_MERCHANTS;?>" />
                    <input type="hidden" name="id_filed" id="id_filed" value="id" />
                    <input type="hidden" name="classLibrary" id="classLibrary" value="merchant" />
            
                    <input type="hidden" name="record_filter_by" id="record_filter_by" value="is_delete-0~pos_generate-0~pos_status-pending" />
                    <input type="hidden" name="record_sort_by" id="record_sort_by" value="all" />                   
                    <input type="hidden" name="record_sort_by_type" id="record_sort_by_type" value="all" />     
                    <input type="hidden" name="result_type" id="result_type" value="filter" />     
                </div>
               
                <div class="col-sm-3 col-xs-12">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary" style="width:80px; text-align: left;">Sort: <span id="show_sort_by"> All </span></button>
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                          <span class="caret"></span>
                          <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu project_sort_by" role="menu">
                          <li id="all"><a>All</a></li>
                          <li id="package_id-0" class="divider"></li>
                          <li id="package_id-1"><a>FREE</a></li>
                          <li id="package_id-2"><a>BASIC</a></li>
                          <li id="package_id-3"><a>ADVANCED</a></li>
                          <li id="package_id-4"><a>MULTI-OUTLET</a></li>
                          <li class="divider"></li>
                          <li id="project_id-1"><a>Simplysafe POS</a></li>
                          <li id="project_id-2"><a>Amstead POS</a></li>
                          <li id="project_id-3"><a>Simplysafe Super Admin</a></li>
                          <li id="project_id-4"><a>Amstead Super Admin</a></li>
                          <li class="divider"></li>                          
                          <li id="is_active-1"><a>ACTIVE</a></li>
                          <li id="is_active-0"><a>DEACTIVE</a></li>                      
                        </ul>
                    </div>
                
                     <div class="btn-group pull-right">
                        <button type="button" class="btn btn-primary" style="width:80px; text-align: left;">Type: <span id="show_sort_by_type"> All</span></button>
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                          <span class="caret"></span>
                          <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu sort_by_type" role="menu">
                          <li id="all"><a>All</a></li>
                          <li class="divider"></li>
                        <?php
                            $merchants = $objMerchant->merchantTypes;

                            if(is_array($merchants)){                         
                                foreach($merchants as $id => $type) {                              
                                    echo '<li id="type-'.$id.'"><a>'.$type.'</a></li>';
                                }
                            }
                        ?>
                          <li class="divider"></li>
                          <li id="type-999"><a>Other</a></li>                                          
                        </ul>
                    </div>
                </div>
                </div>
            
            <hr/> 
            
           <?php if(isset($_GET['deleted'])) {  ?>
            <div class="row">
                <div class="col-sm-12" >
                    <div class="box box-info box-solid" style="margin-bottom:10px; border-bottom: none;">
                        <div class="box-header with-border">
                          <h3 class="box-title">Merchant deleted successfully.</h3>
                          <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                          </div>
                        </div> 
                    </div>
                </div>
            </div>
          <?php } ?>
            
            <div class="row">
                <div class="col-sm-12 " id="display_records">                
                    <div class="text-info"> Please Wait! Records Loading...</div>
                </div>
            </div>
            
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 
	<?php include_once('footer.php'); ?>
  
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.0 -->
<script src="plugins/jQuery/jQuery-2.2.0.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- bootstrap datepicker -->
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- SlimScroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- page script -->
<script src="merchants_script.js"></script> 

<script>
   
  $(function() {
    
     
    $('#example1').DataTable({
        "paging": false,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": true
    });
      
      //Action Edit Record
    $('#myModalSubmit').click(function() {         
         
        var formAction      = $('#formAction').val();
        var name            = $('#name').val();
        var email           = $("#email").val();
        var phone           = $("#phone").val();
        var country         = $("#country").val();
        
        var business_name   = $("#business_name").val();
        var pos_generate    = $("#pos_generate").val();
        var pos_status      = $("#pos_status").val();
        
        if(pos_generate == 0) {
            var pos_name        = $("#pos_name").val();
            var merchant_type   = $("#merchant_type").val();
        }
        
        var address         = $("#address").val();
        var state           = $("#state").val();
        var city            = $("#city").val();
        
        var project_id           = $("#project_id").val();
        var merchant_group       = $("#merchant_group").val();
        var distributor_id       = $("#distributor_id").val();
        var client_by            = $("#client_by").val();
        var is_testing_merchant            = $("#is_testing_merchant").val();
        var restricted_pos_updates         = $("#restricted_pos_updates").val();
         
        var is_validate     = true;
        var validationError = '';
        var format = /[!@#$%^&*()_+\-=\[\]{};':"\\|<>\/?]/;
        var format_address = /[!@#$%^&*_+\=\[\]{};':"\\|<>\/?]/;
                
        if(name === '') {            
            validationError = validationError + '<li>Merchant name is required.</li>';
            is_validate = false;
        }
        
        if(email != '') {
            var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            if (!filter.test(email)) {
                validationError = validationError + '<li>Merchant Email should be in valid format</li>';
                is_validate = false;
            }
        }
        
        if(country === ''){            
            validationError = validationError + '<li>Country is required.</li>';
            is_validate = false;
        }
        
        if(format.test(name)){
            validationError = validationError + '<li>Special charector not allow in Merchant name.</li>';
            is_validate = false;
        }
        
        if(format.test(country)){
            validationError = validationError + '<li>Special charector not allow in country name.</li>';
            is_validate = false;
        }
        
      /*  if(phone == ''){            
            validationError = validationError + '<li>Merchant Mobile is required.</li>';
            is_validate = false;
        } else {
            if(isNaN(phone) || phone.length != 10)
            {
                validationError = validationError + '<li>Mobile number should be 10 digit numeric value.</li>';
                is_validate = false;
            }
        }
         */
        
        if(merchant_type == '' && pos_generate == 0){            
            validationError = validationError + '<li>Merchant Type is required.</li>';
            is_validate = false;
        }
        
        if(business_name == ''){            
            validationError = validationError + '<li>Business Name is required.</li>';
            is_validate = false;
        }
        
        if(format.test(business_name)){
            validationError = validationError + '<li>Special charector not allow in business name.</li>';
            is_validate = false;
        }
        
        if(format_address.test(address)){
            validationError = validationError + '<li>Special charector not allow in address.</li>';
            is_validate = false;
        }
        
        if(format.test(state)){
            validationError = validationError + '<li>Special charector not allow in state name.</li>';
            is_validate = false;
        }
        
        if(format.test(city)){
            validationError = validationError + '<li>Special charector not allow in city name.</li>';
            is_validate = false;
        }
        
        if(merchant_group === '') {            
            validationError = validationError + '<li>Merchant group is required.</li>';
            is_validate = false;
        }
        if(project_id === '') {            
            validationError = validationError + '<li>Project group is required.</li>';
            is_validate = false;
        }
        
        if(distributor_id === '') {            
            validationError = validationError + '<li>Merchant distributor is required.</li>';
            is_validate = false;
        }
        
        if(client_by === '') {            
            validationError = validationError + '<li>Merchant follow by is required.</li>';
            is_validate = false;
        }
        
        if( is_validate == false )
        {
            $('#action_msg').html('<div class="alert alert-danger"><ul>'+validationError+'</ul><div>');
        }
        else
        { 
            
            if(formAction == 'edit'){
               
                var postData = 'action=update';            
                    postData = postData + '&library=merchant';
                    postData = postData + '&id=' + $('#update_id').val();
                    postData = postData + '&name=' + name;
                    postData = postData + '&email=' + email;
                    postData = postData + '&country=' + country;
                    postData = postData + '&phone=' + phone;
                    
                    postData = postData + '&business_name=' + business_name;
                    postData = postData + '&address=' + address;
                    postData = postData + '&state=' + state;
                    postData = postData + '&city=' + city;
                    postData = postData + '&pos_generate=' + pos_generate;
                    postData = postData + '&pos_status=' + pos_status;
                    
                    postData = postData + '&is_testing_merchant=' + is_testing_merchant;
                    postData = postData + '&restricted_pos_updates=' + restricted_pos_updates;
                    postData = postData + '&project_id=' + project_id;
                    postData = postData + '&merchant_group=' + merchant_group;
                    postData = postData + '&distributor_id=' + distributor_id;
                    postData = postData + '&client_by=' + client_by;
                    
                    if(pos_generate == 0 ) {
                        postData = postData + '&pos_name=' + pos_name;
                        postData = postData + '&type=' + merchant_type;
                    } 
                    
                $.ajax({
                    type: "POST",
                    url: "ajax_request/data_actions.php",
                    data: postData,	
                    beforeSend: function() {                    
                        $('#action_msg').html('<div class="alert alert-info"><i class="fa fa-refresh fa-spin" ></i> Please Wait! Data Is Processing...</div>');
                    },
                    success: function(jsonData){ 
                       
                         setTimeout(function(){
                             
                            var obj = $.parseJSON(jsonData);
                            
                                if(obj.status=='ERROR'){ 
                                    $('#action_msg').html('<div class="alert alert-danger"><i class="fa fa-check" ></i>'+ obj.msg +' </div>');                                    
                                } 
                                
                                if(obj.status=='SUCCESS'){ 
                                    
                                   $('#action_msg').html('<div class="alert alert-success"><i class="fa fa-check" ></i> Record updated successfully.</div>'); 
                                     
                                   requestMerchantsList(1);
                                   
                                   setTimeout(function(){  $('#myModal').modal('toggle');  }, 1000);
                                }
                            
                         }, 1000);
                    }
                });
                
            }
            
        }
        
        
    });
    //End Action Edit Record
    
        
    for(var p = 0; p <= 4 ; p++){
        $('#package_id-'+p).hide();
    }
        
        
    $('.tab-filter').click(function()
    {
            $('.tab-filter.btn-success').addClass('btn-default');
            $('.tab-filter.btn-success').removeClass('btn-success');
            $(this).addClass('btn-success');
            $(this).removeClass('btn-default');

            var filterBy = $(this).attr('id');
            $('#record_filter_by').val(filterBy);
            
            //If Filter Select Pending POS Disabled Sort Option by Package.
            if(filterBy == 'pos_generate-0'){                
                for(var p = 0; p <= 4 ; p++){
                    $('#package_id-'+p).hide();
                }
            } else {
                for(var p = 0; p <= 4 ; p++){
                    $('#package_id-'+p).show();
                }
            }
            
            //When select filter Deleted POS Disabled Sort Options.
            if(filterBy == 'is_delete-1'){
                
                $('#show_sort_by').html('all');
                $('#record_sort_by').val('all');
                $('#show_sort_by_type').html('all');
                $('#record_sort_by_type').val('all');
                
                $('#is_active-1').hide();
                $('#is_active-0').hide();
                //disabled
            } else {
                $('#is_active-1').show();
                $('#is_active-0').show();
            }
            
            $('#result_type').val('filter');
            requestMerchantsList(1);
            
        });
        

    $('ul.project_sort_by li').click(function(){

       var sortBySelected = $(this).children('a').html();
       var sortBy = $(this).attr('id');

       $('#show_sort_by').html(sortBySelected);
       $('#record_sort_by').val(sortBy);

       $('#result_type').val('filter');
       requestMerchantsList(1);

    });


    $('ul.sort_by_type li').click(function(){

        var sortByTypeSelected = $(this).children('a').html();
        var sortByType = $(this).attr('id');

        $('#show_sort_by_type').html(sortByTypeSelected);
        $('#record_sort_by_type').val(sortByType);

        $('#result_type').val('filter');            
          requestMerchantsList(1);
     });    

    requestMerchantsList(1);
       
  });
 
</script>

</body>
</html>
