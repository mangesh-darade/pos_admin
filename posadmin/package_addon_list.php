<?php
include_once('application_main.php');
include_once('session.php');
include_once('xmlapi.php');

$objPackage = new packages;
 
 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Simply POS | Package Addon List</title>
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
  <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<style>
    #setupPOS {
        display: none;
        width: 400px;
        
    }
    
    #setupPOS ul li {
        padding: 10px;
        line-height: 40px;
    }
    
</style>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

	<?php include_once('header.php'); ?>
	<?php include_once('sidebar.php'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Package <small>List</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Package</a></li>
        <li class="active">List</li>
      </ol>
    </section> 
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            
            <!-- /.box-header -->
            <div class="box-body">
                
              
             <?php
             if(isset($_GET['success']))
             {
                 echo '<div class="alert alert-success">Package Update success.</div>';
             }
             ?>
            
            <div class="row">
                <div class="col-sm-12 " >                
                  
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>Id</th>                 
                          <th>Package Details</th>
                          <th>Monthly Price</th>
                          <th>Annually Price</th>                          
                          <th style="width:400px;">Details </th>
                          <th>Edit</th>
                        </tr>
                        </thead>
                    <tbody>
                    <?php

                    if(is_array($objPackage->adonsPackage)):

                        foreach ($objPackage->adonsPackage as $package) {
                    ?>
                        <tr>
                          <td><?php echo $package['id'];?></td>
                          <td><?php echo $package['title'];?></td>
                          <td> <i class="fa fa-inr"></i> <?php echo round($package['monthly_price']);?>/-</td>
                          <td> <i class="fa fa-inr"></i> <?php echo round($package['annual_price']);?>/- </td>
                          <td><?php echo  $package['details'] ;?> </td>
                          <td class="text-center">
                              <a href="package_addon.php?id=<?php echo $package['id'];?>" class="btn btn-primary btn-xs" > edit </a>
                          </td>
                        </tr>
                    <?php
                    }//end foreach
                    endif;

                    ?>
                    </tfoot>
                    </table>
                    <!-- DataTables -->
 
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
 
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- page script -->
 


</body>
</html>
