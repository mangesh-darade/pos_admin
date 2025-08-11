<?php
include_once('application_main.php');
include_once('session.php');

$objMerchant = new merchant($conn);

$merchantsData =  $objMerchant->get();
 
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
        Add Merchant
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Registration Form</a></li>
       
      </ol>
    </section>
  
    <!-- Main content -->
    <section class="content">
		<?php
		if(isset($_POST['submit'])){
			$name = $_POST['name'];
			$email = $_POST['email'];
			$phone = $_POST['phone'];
			$address = $_POST['address'];
			$username = $_POST['username'];
			$password = $_POST['password'];

			$name    = isset($_POST["name"]) && !empty($_POST["name"])?$_POST["name"]:'';
			$email = isset($_POST["email"]) && !empty($_POST["email"])?$_POST["email"]:'';
			$phone    = isset($_POST["phone"]) && !empty($_POST["phone"])?$_POST["phone"]:'';
			$address = isset($_POST["address"]) && !empty($_POST["address"])?$_POST["address"]:'';
			$username = isset($_POST["username"]) && !empty($_POST["username"])?$_POST["username"]:'';
			$password = isset($_POST["password"]) && !empty($_POST["password"])?$_POST["password"]:'';
			$MsgArr = array();
			if (!empty($name) && !empty($email)&& !empty($phone)&& !empty($address)&& !empty($username)&& !empty($password)) {
				 $sqlInsert = "INSERT INTO `murchants` ( 
												`name`, 
												`email`,
												`phone`,
												`address`,
												`username`,
												`password`
												)VALUES ( '".$name."', '".$email."','".$phone."','".$address."','".$username."','".md5($password)."')";
				if (mysqli_query($conn, $sqlInsert)) {
					 
                                         $validate = 1;
					//$MsgArr["ID"] = mysqli_insert_id($conn); 
					return $MsgArr;
				} 
				} else {
					//$MsgArr["res"] = "error";
                                    $validate = 0;
					$MsgArr = "All Mandatory Field Are Not Pass";
			}

			
		}
		?>
		<style>
                    .admin_form{width: 30%;}
		</style>
		<div class="container">
		<h2>Merchant Registration</h2>
               <?php if( $validate == 0) { ?> <div class="alert alert-danger"><?php echo $MsgArr;?></div> <?php } ?>
               <?php if( $validate == 1) { ?> <div class="alert alert-success">Merchant has been add successfully.</div> <?php } ?>
		<form method="post" action="">
		<input type="hidden" name="token" value="a368aacc3f5a2b808e77000f6f97acc5" style="display:none;">
		<div class="form-group">
		<label for="username">First Name:</label>
		<input type="text" class="form-control admin_form" id="name" name="name" placeholder="Enter First Name">
		</div>
		<div class="form-group">
		<label for="username">Phone:</label>
		<input type="text" class="form-control admin_form" id="phone" name="phone" placeholder="Enter Phone Number">
		</div>
		<div class="form-group">
		<label for="username">Address:</label>
		<input type="text" class="form-control admin_form" id="address" name="address" placeholder="Enter Username">
		</div>
		<div class="form-group">
		<label for="username">Username:</label>
		<input type="text" class="form-control admin_form" id="username" name="username" placeholder="Enter Username">
		</div>
		<div class="form-group">
		<label for="password">Password:</label>
		<input type="password" class="form-control admin_form"  id="password" name="password" placeholder="Enter Password">
		</div>
		<div class="form-group">
		<label for="email">Email:</label>
		<input type="email" class="form-control admin_form" id="email" name="email" placeholder="Enter email">
		</div>
		<input type= "submit" name="submit" class="btn btn-default" value= "Submit" >
		</form>
		</div>
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
$(function(){
	$("#clickgo").click(function(){
	alert('hello');
	var merchant_id = 1;
	var error_url  =  'http://dev.greatwebsoft.co.in/pos3/pos/error';
	var posUrl  =  'http://dev.greatwebsoft.co.in/pos3/pos/';
	var error = 'message';
	var data = "merchant_id="+merchant_id+"&error_url="+error_url+"&posUrl="+posUrl+"&error="+error;
	$.ajax({
	type: "GET",
	data: data,
	url: "https://webkart.xyz/simplysafe/admin/pos_error_log.php?action=setLog&merchant_id = '+merchant_id+'&error_url= '+error_url+' &posUrl='+posUrl+'&error='+error+'",
		success: function(data)
		{ 
		alert(data);
		$('#result').html(data);
		}
	});
	});
});
</script>
</body>
</html>
