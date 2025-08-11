<?php
include_once('application_main.php');
include_once('session.php');
 
$objUser = new adminUser();
 

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Simply POS | User Activity Logs</title>
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
      <h1>
        User <small>Log</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">User</a></li>
        <li class="active">Log</li>
      </ol>
    </section> 
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            
            <!-- /.box-header -->
            <div class="box-body"> 
             
            <div class="row">
                <div class="col-sm-12 " >                
                  
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>Activity at</th>                 
                          <th>User</th>
                          <th>Activity</th>
                          <th>Merchant</th>                          
                          <th>POS Url</th>                          
                          <th>IP Address</th>
                        </tr>
                        </thead>
                    <tbody>
                    <?php
                    
                    $userLogs   = $objUser->getUserLog();
                    if(is_array($userLogs)):

                        foreach ($userLogs as $log) {
                    ?>
                        <tr>
                            <td><?php echo $objapp->DateTimeFormat($log['activity_at'], 'jS F Y g:ia');?></td>
                            <td><?php echo $log['user_name'];?></td> 
                            <td><?php echo $log['user_activity'];?></td>                                              
                            <td><?php echo $log['merchant_name'];?></td>                     
                            <td><?php echo $log['pos_url'];?></td>                     
                            <td><?php echo $log['activity_ip'];?></td>                     
                        </tr>
                    <?php
                    }//end foreach
                    endif;

                    ?>
                    </tbody>
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
  
</div>   

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
