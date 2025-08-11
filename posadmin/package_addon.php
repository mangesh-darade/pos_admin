<?php
include_once('application_main.php');
include_once('session.php');
require_once '../functions/phpFormFunctions.php';
  
$objPackage = new packages;
 
if(isset($_GET['id']) && $_GET['id'] != '' && is_numeric($_GET['id'])) {
   
    $packagesData = $objPackage->adonsPackage[$_GET['id']];
     
    if($packagesData)
    {
       extract($packagesData);
    }
    else {
        $objapp->loadPage('package_addon_list.php');
    }
}

if($_POST['formAction'] == "EDIT")
{
    
  if( $objPackage->updateAdonsPackage($_POST))
  {
     
    $objapp->loadPage('package_addon_list.php?success');
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
                        <div class="col-sm-4 col-xs-12"><label for="title"><span class="text-red">*</span> Addon Package Name:</label></div>
                        <div class="col-sm-8 col-xs-12">
                            <input type="text" tabindex="1" name="title" id="title" value="<?php echo $title;?>" 
                            placeholder="Package Name"   maxlength="60"  class="form-control" />
                        </div>
                    </div>
                    <div class="row form-group <?php echo ($inputError['details']) ? 'has-error' : '';?> ">
                        <div class="col-sm-4 col-xs-12"><label for="details"><span class="text-red">*</span> Package Details:</label></div>
                        <div class="col-sm-8 col-xs-12">
                            <input type="text" tabindex="2" name="details" id="details" value="<?php echo $details;?>" 
                            placeholder="Package Details"   maxlength="250"  class="form-control" />
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
                    

                    <div class="row form-group">
                        <div class="col-sm-4 col-sm-push-4 col-xs-10 col-xs-push-2"> 
                            <button type="submit"  tabindex="12"  class="btn btn-primary">Update Package</button>
                            <a  href="package_addon_list.php" class="btn btn-info">Cancel</a>
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
