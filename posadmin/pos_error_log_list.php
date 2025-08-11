<?php
include_once('application_main.php');
include_once('session.php');

$posLog = new posErrorLogs($conn);

$logs =  $posLog->getLogs();
 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SimplySafe | POS Error LOg</title>
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
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        POS Error <small>Log</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">POS Error Log</a></li>
        <li class="active">List</li>
      </ol>
    </section>
  
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">POS Error Log</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Log Id</th>
                  <th>Merchant & Type</th>                 
                  <th>Error Message</th>                  
                  <th>Error Url</th>
                  <th>Error At</th>                  
                </tr>
                </thead>
                <tbody>
            <?php
            
            if(is_array($logs)):
                 
                foreach ($logs as $log) {
            ?>
                <tr>
                  <td><?php echo $log['log_id'] ?></td>
                  <td><?php echo $log['merchant_name'] ?><br/><?php echo $log['merchant_type'] ?></td>
                  <td><?php echo $log['error_message'] ?></td>
                  <td><?php echo $log['error_url'] ?></td>
                  <td><?php echo $log['error_time'] ?></td>                  
                </tr>
           <?php
            }//end foreach
            endif;

            ?>
                </tfoot>
              </table>
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
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
  
  
  $(function(){
      
      $('.generate_pos').click(function(){
           
          $.ajax({
		type: "POST",
		url: "ajax_request/merchants.php",
                data:'id='+this.id,
		beforeSend: function(){
                   
                    $("#pos_merchant_details").html("<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>");
		},
		success: function(data){
                  
                    $("#pos_merchant_details").html(data);                    
                    $("#btn-generate-pos").css("display","block");                   
		}
            });
          
      });
      
      $('#generate_pos').click(function(){
          
          var subdomain = $('#pos_generate_subdomain').val();
           alert(subdomain);
          $.ajax({
		type: "POST",
		url: "pos_generator/generate_pos.php",
                data:'step=1&subdomain='+subdomain,
		beforeSend: function(){
                   $("#btn-generate-pos").css("display","none");    
                   $("#pos_generate_status").html("<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>");
		},
		success: function(data){
                  alert(data);
                    $("#pos_generate_status").html(data);                    
		}
            });
          
      });
      
  });
  
</script>
</body>
</html>
