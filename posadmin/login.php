<?php

include_once('application_main.php');
 
if(isset($_SESSION['session_user_id'])) {
    
    header('location:index.php');    
} 

if($_POST['loginAdmin']){
    
    $username = $_POST['username'];
    $password = $_POST['password'];    
    $token    = $_POST['token'];    
    
    if(empty($username)) {
        $error = "Username is required.";
    }
    if(empty($password)) {
        $error = "Password is required.";
    }
    if(empty($token) || $token !== $_SESSION['CSP']) {         
        header("location:login.php?act=tokenmissmatch");
    }
    
    if( (!empty($username) && !empty($password)) && (!empty($token) && $token == $_SESSION['CSP']) ){
        
        $encr_password = md5($password);
            
        $sql = "SELECT `user_id`, `username`, `display_name`, `email_id`, `mobile_no`, `last_login`, `is_disrtibuter`, `group`, `is_active` "
                . "FROM `admin` "
                . "WHERE `username` = '".$username."' AND `password` = '$encr_password' AND `is_delete` = '0'  ";
    
        $result = $conn->query($sql);  
        
        if($result){
                
            $row_cnt = $result->num_rows;

            if($row_cnt > 0){

                $row = $result->fetch_array(MYSQLI_ASSOC);

                if($row['is_active']==0) {                        
                    header("location:login.php?act=inactive"); 
                } else {                    
                    
                    $success = true;
                    $successMessage = 'Login Successfully.'; 

                    $_SESSION['session_user_id']            = $row['user_id'];
                    $_SESSION['session_user_group']         = $row['group'];
                    $_SESSION['login']['is_disrtibuter']    = $row['is_disrtibuter'];
                    $_SESSION['login']['user_id']           = $row['user_id'];
                    $_SESSION['login']['username']          = $row['username'];
                    $_SESSION['login']['display_name']      = $row['display_name'];
                    $_SESSION['login']['email_id']          = $row['email_id'];
                    $_SESSION['login']['mobile_no']         = $row['mobile_no'];
                    $_SESSION['login']['last_login']        = $row['last_login'];
                    $_SESSION['login']['is_active']         = $row['is_active'];

                    $dateTime = date('Y-m-d H:i:s');
                    
                    $sqlUpdate = "UPDATE `admin` SET `last_login` = `current_login`, `current_login`='$dateTime' WHERE `user_id` = '".$row['user_id']."' ";

                    $result1 = $conn->query($sqlUpdate); 

                    header("location:merchants.php");
                    
                }//end else.

            } else {              

                header("location:login.php?act=invalid");
            }//end else. 
        }    
            
    }
    
}

function getcsp(){
    
    $csp = md5(rand(12345,98765) . time());
    
    $_SESSION['CSP'] = $csp;
    
    return $csp;
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SimplySafe  | Log in</title>
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
    <a href="#"><b>Simply</b>Safe</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>
    <?php echo $objLogin->displayErrors; ?>
    <?php if($_GET['act']=="invalid") echo "<p class='text-red'><i class='fa fa-exclamation-triangle'></i> Invalid Username or Password.</p>"; ?>
    <?php if($_GET['act']=="inactive") echo "<p class='text-red'><i class='fa fa-exclamation-triangle'></i> Account is not activated.</p>"; ?>
    <?php if($_GET['act']=="tokenmissmatch") echo "<p class='text-red'><i class='fa fa-exclamation-triangle'></i> Security token missmatch..</p>"; ?>
    <form name="myform" method="post" autocomplete="off">
      <input type="hidden" name="loginAdmin" value="true" />
      <input type="hidden" name="token" value="<?php echo getcsp()?>" />
      <div class="form-group has-feedback">
            <input type="text" name="username" maxlength="30" class="form-control"  autocomplete="off" placeholder="Username" required="required" />
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
            <input type="password" name="password" maxlength="50" autocomplete="new-password" class="form-control" placeholder="Password" required="required" />
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
                <input type="checkbox" name="remember" value="1" /> Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
      <hr/>
      <div class="row">
          <p class="col-sm-12 text-center"><a href="forgot_password.php">Forgot Password</a></p>
      </div>
    </form>

     

   <!-- <a href="#">I forgot my password</a><br> -->
    

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
