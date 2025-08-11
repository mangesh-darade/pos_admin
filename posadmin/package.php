<?php
include_once('application_main.php');
include_once('session.php');
require_once '../functions/phpFormFunctions.php';
  
$objPackage = new packages;
 
if(isset($_GET['id']) && $_GET['id'] != '' && is_numeric($_GET['id'])) {
   
    $packagesData = $objPackage->packages[$_GET['id']];
     
    if($packagesData)
    {
       extract($packagesData);
    }
    else {
        $objapp->loadPage('package_list.php');
    }
}

if($_POST['formAction'] == "EDIT")
{
    
  if( $objPackage->updatePackage($_POST))
  {
     
    $objapp->loadPage('package_list.php?success');
  }
  else 
  {
      $formIsValid = false;
      
      if($objPackage->inputError){
         $inputError  = $objPackage->inputError;
      }
  } 
  
  extract($_POST);
    
} 


?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Simply POS | Manage Packages</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

	<?php include_once('header.php'); ?>
	<?php include_once('sidebar.php'); ?>

  <!-- Content Wrapper. Contains page content -->
 
    <section class="content-wrapper">
		 
        <div class="row">
                  
                    <div class="box box-warning">
                        <div class="box-header with-border">
                           <section class="content-header">
                            <h1>
                              Package
                            </h1>
                            <ol class="breadcrumb">
                              <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                              <li><a href="#">Package</a></li>
                            </ol>
                          </section>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                             
                        <div class="col-sm-8 col-sm-offset-2">
                         
                   <?php if($formIsValid === false) : ?>
                            <ul class="alert alert-danger" style="list-style:none;">
                         <?php 
                          
                        if(is_array($inputError)){
                            foreach($inputError as $errormsg) { ?>
                                <li> <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <?php echo $errormsg; ?> </li>
                        <?php }//end foreach
                        }//end if. 
                        ?>
                        </ul>
                    <?php endif; ?> 

                <form  method="post" role="form">
                    <input type="hidden" name="formAction" value="EDIT" />
                    <input type="hidden" name="package_id" value="<?php echo $id; ?>" />
                    <div class="row form-group <?php echo ($inputError['package_name']) ? 'has-error' : '';?> ">
                        <div class="col-sm-4 col-xs-12"><label for="package_name"><span class="text-red">*</span> Package Name:</label></div>
                        <div class="col-sm-8 col-xs-12">
                            <input type="text" tabindex="1" name="package_name" id="package_name" value="<?php echo $package_name;?>" 
                            placeholder="Package Name"   maxlength="60"  class="form-control" />
                        </div>
                    </div>
                    <div class="row form-group <?php echo ($inputError['details']) ? 'has-error' : '';?> ">
                        <div class="col-sm-4 col-xs-12"><label for="details"><span class="text-red">*</span> Package Details:</label></div>
                        <div class="col-sm-8 col-xs-12">
                            <input type="text" tabindex="2" name="details" id="details" value="<?php echo $details;?>" 
                            placeholder="Package Details"  maxlength="250"  class="form-control" />
                        </div>
                    </div>
                    <div class="row form-group <?php echo ($inputError['monthly_price']) ? 'has-error' : '';?> ">
                        <div class="col-sm-4 col-xs-12"><label for="monthly_price"><span class="text-red">*</span> Monthly Price:</label></div>
                        <div class="col-sm-8 col-xs-12">
                            <input type="text" tabindex="3" name="monthly_price" id="monthly_price" value="<?php echo round($monthly_price);?>" 
                            placeholder="Amount"  maxlength="10" class="form-control" />
                        </div>
                    </div>
                    <div class="row form-group <?php echo ($inputError['annual_price']) ? 'has-error' : '';?> ">
                        <div class="col-sm-4 col-xs-12"><label for="annual_price"><span class="text-red">*</span> Annual Price:</label></div>
                        <div class="col-sm-8 col-xs-12">
                            <input type="text" tabindex="4" name="annual_price" id="annual_price" value="<?php echo round($annual_price);?>" 
                            placeholder="Amount"  maxlength="10"  class="form-control"  />
                        </div>
                    </div>
                    <div class="row form-group <?php echo ($inputError['outlet']) ? 'has-error' : '';?> ">
                        <div class="col-sm-4 col-xs-12"><label for="outlet"><span class="text-red">*</span> Outlet:</label></div>
                        <div class="col-sm-8 col-xs-12">
                            <input type="text" tabindex="5" name="outlet" id="outlet" value="<?php echo $outlet;?>" 
                            placeholder="Outlet"  maxlength="100" class="form-control"  />
                        </div>
                    </div>
                    <div class="row form-group <?php echo ($inputError['register']) ? 'has-error' : '';?> ">
                        <div class="col-sm-4 col-xs-12"><label for="register"><span class="text-red">*</span> Register:</label></div>
                        <div class="col-sm-8 col-xs-12">
                            <input type="text" tabindex="6" name="register" id="register" value="<?php echo $register;?>"  placeholder="Outlet"  maxlength="100" class="form-control"  />
                        </div>
                    </div>
                    <div class="row form-group <?php echo ($inputError['users']) ? 'has-error' : '';?> ">
                        <div class="col-sm-4 col-xs-12"><label for="users"><span class="text-red">*</span> Users:</label></div>
                        <div class="col-sm-8 col-xs-12">
                            <input type="text" tabindex="7" name="users" id="users" value="<?php echo $users;?>" 
                            placeholder="Users"  maxlength="100" class="form-control"  />
                        </div>
                    </div>
                    <div class="row form-group <?php echo ($inputError['products']) ? 'has-error' : '';?> ">
                        <div class="col-sm-4 col-xs-12"><label for="products"><span class="text-red">*</span> Products:</label></div>
                        <div class="col-sm-8 col-xs-12">
                            <input type="text" tabindex="8" name="products" id="products" value="<?php echo $products;?>" 
                            placeholder="Products"  maxlength="100" class="form-control" />
                        </div>
                    </div>
                    
                    <div class="row form-group <?php echo ($inputError['customers']) ? 'has-error' : '';?> ">
                        <div class="col-sm-4 col-xs-12"><label for="customers"><span class="text-red">*</span> Customers:</label></div>
                        <div class="col-sm-8 col-xs-12">
                            <input type="text" tabindex="10" name="customers" id="customers" value="<?php echo $customers;?>" 
                            placeholder="Customers"  maxlength="100" class="form-control"  />
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-4 col-xs-12"><label for="users">&nbsp;&nbsp;&nbsp;Features:</label></div>
                        <div class="col-sm-8 col-xs-12">
                            <input type="text" tabindex="11" name="features" id="features" value="<?php echo $features;?>" 
                            placeholder="Features"  maxlength="255" class="form-control"  />
                            <p class="text-primary">Can enter multiple features separated by comma (,). </p>
                            <p class="text-danger"><b>Note:</b> For Unlimited Use Negative (-1) Value . </p>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-4 col-sm-push-4 col-xs-10 col-xs-push-2"> 
                            <button type="submit"  tabindex="12"  class="btn btn-primary">&nbsp;&nbsp;&nbsp;Update Package</button>
                            <a  href="package_list.php" class="btn btn-info">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
                    <!-- /.box-body -->
                  </div>  
                       
             </div>
        </div>
    
    </section>
   
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
 
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- page script -->

</body>
</html>
