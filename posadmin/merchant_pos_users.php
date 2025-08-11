<?php
include_once('application_main.php');
include_once('session.php');

if(!isset($_GET['id'])){
    
   header('location:merchants.php');
} else {
    
   $merchant_id = $_GET['id'];    
}

 
$objMerchant = new merchant($conn);


 
$objMerchant->connect_merchant_pos_db($merchant_id);
            
$merchantUserData = $objMerchant->pos_user_list();


if($_GET['action'] == "resetpasswd"){
   
    $user_id = $_GET['user'];
    
    if( $objMerchant->pos_user_reset_password($user_id) === true ){
     //   echo "<br/>Your new password is : ". $objMerchant->resetcode;
       //$objMerchant->pos_user_reset_password_email_send();
        
       header("location:merchant_pos_users.php?id=$merchant_id&reset=success&code=".$objMerchant->resetcode);
    }
    
}

//Disconnected Merchant POS database connection.
 $objMerchant->desconnect_merchant_pos_db();
 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SimplySafe | Merchant POS Users</title>
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
        Merchant <small> POS User List</small>
      </h1>
      <ol class="breadcrumb">
          <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="merchants.php">Merchant</a></li>
        <li class="active"> POS User List</li>
      </ol>
    </section>
  
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Merchants POS User List</h3>
            </div>
            <?php
            if($_GET['reset']=="success") {
            ?>
              <div class="alert alert-success">User Password Reset Success. [CODE: <?php echo $_GET['code'];?> ]</div>
            <?php   
            }            
            ?>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Id</th>                 
                  <th>User Name</th>                 
                  <th>Login Id</th>
 <th>Email</th>
<th>Phone</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
            <?php
            
            if(is_array($merchantUserData)):
                 
                foreach ($merchantUserData as $posUser) {
            ?>
                <tr>
                  <td><?php echo $posUser['id'] ?></td>
                  <td><?php echo $posUser['first_name'] ?> <?php echo $posUser['last_name'] ?></td>
                  <td><?php echo $posUser['username'] ?></td>
<td><?php echo $posUser['email'] ?></td>
<td><?php echo $posUser['phone'] ?></td>
                  <td><?php echo $posUser['active'] ?></td>                  
                  <td>
                      <div class="dropdown">
                        <span class="dropdown-toggle" type="text" data-toggle="dropdown">Action 
                        <span class="caret"></span></span>
                        <ul class="dropdown-menu">
                            <li><a href="merchant_pos_users.php?id=<?php echo $merchant_id;?>&user=<?php echo $posUser['id'] ?>&action=resetpasswd">Reset Password</a></li>
                        </ul>
                      </div>
                  </td>
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
   
  
</script>
</body>
</html>
