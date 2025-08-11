<?php

include_once('application_main.php');
 
if(!isset($_SESSION['session_user_id'])) {
    
    header('location:login.php');    
} 

if($_POST['changePassword']){
    
    $username   = $_POST['username'];
    $passwd     = $_POST['passwd'];    
    $confirm_passwd = $_POST['confirm_passwd'];    
    
    if(empty($username)) {
        $error = "Username is required.";
    }
    elseif($_SESSION['login']['username'] !== $username) {
          $error = "Invalid Username.";
    }
    elseif(empty($passwd)) {
        $error = "Password is required.";
    }
    elseif( $passwd !== $confirm_passwd) {
        $error = "Password not match.";
    }
    else 
    {
        $encr_password = md5($passwd);
            
        $sql = "Update `admin` SET `password` = '$encr_password' "
                . " WHERE `user_id` = '".$_SESSION['session_user_id']."' AND `username` = '$username' ";
    
        $result = $conn->query($sql);  
        
        if($result): 
                
                header("location:change_password.php?action=success");
               
           endif;    
            
    }
    
}

 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SimplyPOS  | Change Password</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>Simply</b>POS</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <?php if($_GET['action'] == "success") { ?>
      
      <p class="login-box-msg text-green">Password Change Successfully.</p>
      <div class="text-center"><a href="logout.php" class="btn btn-success">Login Now</a></div>
    <?php } else { ?>
      
    <h3 class="login-box-msg">Change Password</h3>
    <div class="text-red"><?php echo $error; ?></div><hr/>
    <form name="myform" method="post" autocomplete="off">
      <input type="hidden" name="changePassword" value="true" />
      <div class="form-group has-feedback">
          <label>Username:</label>
          <input type="username" name="username"  maxlength="50" class="form-control" placeholder="Username" value="<?php echo $username;?>" />
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
          <label>New Password:</label>
          <input type="password" autocomplete="new-password" name="passwd" maxlength="25" class="form-control" placeholder="Password" value="<?php echo $passwd;?>" />
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
          <label>Confirm Password:</label>
          <input type="password" autocomplete="new-password" name="confirm_passwd" maxlength="25" class="form-control" placeholder="Confirm Password" value="<?php echo $confirm_passwd;?>" />
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-sm-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Save</button>
        </div>
        <!-- /.col -->
      </div>
       
    </form>
    <?php }//end else. ?>
    
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.0 -->
<script src="plugins/jQuery/jQuery-2.2.0.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
