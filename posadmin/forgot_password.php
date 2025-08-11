<?php

 include_once('application_main.php');
 
if(isset($_SESSION['session_user_id'])) {
    
    header('location:index.php');    
} 

$sendOtp = false;
$sendOtpMsg = false; 

if(isset($_POST['verifyOtp']))
{
    $sendOtp = true;
    $sendOtpMsg = false;
    $otp        = trim($_POST['otp']);
    $user_id    = trim($_POST['user_id']);
    $username   = trim($_POST['username']);
    
    if(empty($otp) || strlen($otp)!=4 || !is_numeric($otp)) {
         $error = '<i class="fa fa-exclamation-triangle"></i> Please enter valid OTP';
    } else {
        $now = date('Y-m-d H:i:s');
        
        $sql = "SELECT `user_id`, `username`, `display_name`, `email_id`, `mobile_no`, `last_login`, `group`"
                . " FROM `admin`"
                . " WHERE `user_id` = '$user_id' AND `otp` = '$otp' AND `otp_expired_at` > '$now' LIMIT 1";
    
        $result = $conn->query($sql);  
        
        if($result){
                
           $row_cnt = $result->num_rows;
           
           if($row_cnt) {
               
                $row = $result->fetch_array(MYSQLI_ASSOC);
                 
                 $_SESSION['session_user_id']       = $row['user_id'];
                 $_SESSION['session_user_group']    = $row['group'];
                 $_SESSION['login']['user_id']      = $row['user_id'];
                 $_SESSION['login']['username']     = $row['username'];
                 $_SESSION['login']['display_name'] = $row['display_name'];
                 $_SESSION['login']['email_id']     = $row['email_id'];
                 $_SESSION['login']['mobile_no']    = $row['mobile_no'];
                 $_SESSION['login']['last_login']   = $row['last_login'];
                 
                 $dateTime = date('Y-m-d H:i:s');
                 $sqlUpdate = "UPDATE `admin` SET `last_login` = `current_login`, `current_login`='$dateTime' WHERE `user_id` = '".$row['user_id']."' ";
                 
                 $result1 = $conn->query($sqlUpdate); 
                
                header("location:change_password.php");
               
               
           } else {
                $error = '<i class="fa fa-exclamation-triangle"></i> Sorry, OTP is invalid.';
           }
        }
     
    }
    
} 

if(isset($_POST['forgotPasswd'])){    
    
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    
    if(empty($email) && empty($phone)){ 
        $error = '<i class="fa fa-exclamation-triangle"></i> Please enter OTP receive mode.';
    }
    else if(!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)){
        
        $error = '<i class="fa fa-exclamation-triangle"></i> Please enter valid email address.';
        
    }
    elseif(!empty($phone) && (strlen($phone)!== 10 || !is_numeric($phone)) ) {
        
        $error = '<i class="fa fa-exclamation-triangle"></i> Mobile number should be valid 10 disit number.';
         
    
    } else {
       $condition = ''; 
       $condition .= !empty($phone) ? " AND `mobile_no` = '".$phone."' ":'';
       $condition .= !empty($email) ? " AND `email_id` = '".$email."' ":'';
        
        $sql = "SELECT `user_id`, `username` FROM `admin` WHERE `is_delete` = '0' AND `is_active` = '1'  " . $condition . " LIMIT 1";
    
        $result = $conn->query($sql);  
        
        if($result):
                
           $row_cnt = $result->num_rows;

                if($row_cnt==0){
                    $error = "Sorry, Your account details not exists or restricted.";
                    
                } else {
                
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    $user_id   = $row['user_id'];
                    $username  = $row['username'];
                    
                    $otp = rand(1234 , 9876);
                    $dateTime = date('Y-m-d H:i:s');
                    
                    $sqlUpdate = "UPDATE `admin` SET `otp` = '$otp', `otp_expired_at` = DATE_ADD('$dateTime', INTERVAL 30 MINUTE) WHERE `user_id` = '".$row['user_id']."' ";
 
                    $result1 = $conn->query($sqlUpdate); 
                    
                    if($result1){
                        
                        $objAuth = new auth;
                        
                        if(!empty($email))
                        {
                           $sendEmailOtp = $objAuth->sendEmailOtp( $otp , $email );
                        }
                        
                        if(!empty($phone) && strlen($phone)==10)
                        {
                            $sendSmsOtp = $objAuth->sendSmsOtp( $otp, $phone );
                        }
                        
                        $sendOtp = ($sendEmailOtp || $sendSmsOtp) ? true : false;
                        $sendOtpMsg = true;
                    }
                    
                }
                
           endif;    
            
    }
    
}
 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SimplyPOS | Forgot Password</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->  
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous" />
  
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
   
   <?php if($error) { echo "<div class='alert text-danger'>$error</div>"; } ?>
   <?php if($sendOtpMsg) { echo "<div class='alert text-success'>OTP has been send.</div>"; } ?> 
   <?php if($sendOtp) { ?>  
    
    <p class="login-box-msg text-info">Verify OTP To Change Password</p>
    <form name="myform2" method="post" autocomplete="off" >
      <input type="hidden" name="verifyOtp" value="true" />
      <input type="hidden" name="user_id" value="<?php echo $user_id;?>" />
      <div class="form-group has-feedback">
          <label>Username:</label>
          <input type="text" name="username" readonly="readonly" maxlength="50" value="<?php echo $username;?>" class="form-control" placeholder="Username" />
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
          <label>OTP:</label>
          <input type="text" name="otp" maxlength="4" class="form-control" placeholder="Enter OTP" />
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div><hr/>
      <div class="row">
        <!-- /.col -->
        <div class="col-sm-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Verify OTP</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
      <hr/>
      <div class="text-center"><a href="forgot_password.php" class="text-warning">Resend OTP</a></div>
   <?php } else { ?>
     <h3 class="login-box-msg">Forgot Password</h3>
     <p class="login-box-msg text-info">Choose to receive OTP for verification.</p>
     <form name="myform" method="post" autocomplete="off"  >
      <input type="hidden" name="forgotPasswd" value="true" />
      <div class="form-group has-feedback">
          <input type="email" name="email" maxlength="50" value="<?php echo $email;?>" class="form-control" placeholder="Email Id" />
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback text-center">OR</div>
      <div class="form-group has-feedback">
        <input type="text" name="phone" maxlength="10" value="<?php echo $phone;?>" class="form-control" placeholder="Mobile No." />
        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
      </div><hr/>
      <div class="row">
        <!-- /.col -->
        <div class="col-sm-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Send OTP</button>
        </div>
        <!-- /.col -->
      </div>  <hr/>
       <div class="row">
        <!-- /.col -->
        <div class="col-sm-12">
          <a href="login.php" class="text-center text-info"> Back to login</a>
        </div>
        <!-- /.col -->
      </div>  
    </form>
   <?php }//end else ?>
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
