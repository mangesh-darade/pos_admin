<?php
include_once('application_main.php');
include_once('session.php');
include_once('xmlapi.php');
require_once('../functions/phpFormFunctions.php');

$objMerchant = new merchant($conn);
$objMerchant->getmarchants_list('1');


?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Simply POS | Restaurant</title>
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
  <style>
       .loaderclass{position:absolute;left:0;right:0;top:50%;bottom:0;margin:auto;  }
  </style>
</head>
 
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

	<?php include_once('header.php'); ?>
	<?php include_once('sidebar.php'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1> Restaurant <small>List</small>  </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Merchant</a></li>
        <li class="active">Restaurant</li>
      </ol>
    </section>
     <div id="action_msg"></div>
  <!-- Generate POS Project Modal -->
  <div class="modal fade " id="posUsers" role="dialog">
      <div class="modal-dialog" style="width: 800px;">    
      <!-- Modal content-->
      <div class="modal-content" id="pos_user_list">
          <h1>Model contains will display here!</h1>
      </div>      
    </div>
  </div>
  <!-- // End Generate POS Project Modal -->


    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            
            <!-- /.box-header -->
            <div class="box-body">
            
              <div class="text-danger">Note: Pos version should be 4.00 & Above</div> 
            <hr/>
            
            <div class="row">
                <div class="col-sm-12 " id="display_records">                
                    <div class="text-info"> Please Wait! Records Loading...</div>
                </div>
            </div>
            <div class="box-body loaderclass"  id="loader">
                <div class='text-center'><img src='images/ajax-loader.gif' alt='loading...' class='center' /></div>
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


<script>
   $(document).ready(function(){
       get_restaurant_list();
       $('#loader').hide();
   });
   
  //$(function() {
    
     
   
      
    function get_restaurant_list(){
       
       $.ajax({
          type:'ajax',
          dataType:'html',
          url:'ajax_request/restaurant_list.php',
          async:false,
           beforeSend: function() {                    
                $('#display_records').html("<div class='text-center'><img src='images/ajax-loader.gif' alt='loading...' class='center' /></div>");
                
          },
          success:function(result){
            $('#display_records').html(result);
             
          },error:function(){
              console.log('error');
          }
          
       });
        
    }
      
      //Action Edit Record
   
 
</script>



</body>
</html>
