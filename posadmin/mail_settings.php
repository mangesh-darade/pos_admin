<?php
include_once('application_main.php');
include_once('session.php');
include_once('../include/database.php');

 $sqldata = "SELECT * FROM `mail_settings` WHERE id = 1";
 $res = $conn->query($sqldata);
 $row = mysqli_fetch_assoc($res);
   
 $id = $row['id'];
//print_r($_POST); exit;
if(isset($_POST['adddata'])){
   // echo "add data";
    $protocol =                 $_POST['protocol'];
    $mail_path =                $_POST['mail_path'];
    $smtp_host =                $_POST['smtp_host'];
    $smtp_user =                $_POST['smtp_user'];
    $smtp_pass =                $_POST['smtp_pass']; 
    $smtp_port =                $_POST['smtp_port'];
    $smtp_crypto =              $_POST['smtp_crypto'];
    $mail_from =                $_POST['mail_from'];
    $mail_from_name =           $_POST['mail_from_name'];
    $mail_reply =               $_POST['mail_reply'];
    $mail_reply_name =          $_POST['mail_reply_name'];
    $mail_subject =          $_POST['mail_subject'];
    
    $dir_admin =                $_POST['dir_admin'];
    $dir_merchant =             $_POST['dir_merchant'];
    $email_pos =                $_POST['email_pos'];
    $email_sail =               $_POST['email_sail'];
    $email_info =               $_POST['email_info'];
    $email_admin =              $_POST['email_admin'];
    $noreply_email =            $_POST['noreply_email'];
    $noreply_name =             $_POST['noreply_name'];
    $email_to =                 $_POST['email_to'];
    $email_to_name =            $_POST['email_to_name'];
    $smtp_server =            $_POST['smtp_server'];
    
    $timezone =                 $_POST['timezone'];
    $session_merchant_key =     $_POST['session_merchant_key'];
    $merchant_logout_return_page =     $_POST['merchant_logout_return_page'];
    $free_demo_days =                   $_POST['free_demo_days'];
    $service_tax_rate =                 $_POST['service_tax_rate'];
    $default_pos_project_zip =          $_POST['default_pos_project_zip'];
    $default_pos_sql =                  $_POST['default_pos_sql'];
    $pos_project_dir =                  $_POST['pos_project_dir'];
    $sms_prefix =                       $_POST['sms_prefix'];
    $sms_sufix =                        $_POST['sms_sufix'];
    $sms_tpl =                          $_POST['sms_tpl'];
    $sms_api_url =                      $_POST['sms_api_url'];
    $sms_api_user =                     $_POST['sms_api_user'];
    $sms_api_passwd =                   $_POST['sms_api_passwd'];
    
    //$updateId = $_POST['updateId'];
  
   //print_r($row);
   
  // print_r ($res);
//   if(empty($protocol) || empty($mail_path) || empty($smtp_host) || empty($smtp_server) || empty($smtp_user) || empty($smtp_pass) || empty($smtp_port) || 
//       empty($smtp_crypto) || empty($mail_from) || empty($mail_from_name) || empty($mail_reply) || empty($mail_reply_name) || empty($mail_subject) || empty($dir_admin) ||
//       empty($dir_merchant) || empty($email_pos) || empty($email_sail)  || empty($email_info) || empty($email_admin) || empty($noreply_email) || empty($noreply_name)
//       || empty($email_to) || empty($email_to_name) || empty($timezone) || empty($now) ||  empty($session_merchant_key) || 
//       empty($merchant_logout_return_page) || empty($free_demo_days)|| empty($service_tax_rate) || empty($default_pos_project_zip) || empty($default_pos_sql)
//       || empty($pos_project_dir) || empty($sms_prefix) || empty($sms_sufix) || empty($sms_tpl) || empty($sms_api_url) || empty($sms_api_user) || empty($sms_api_passwd) )
//    {
//      // ECHO "FALSE";
//        $err2 = "All fields are required";
//    }
//    else{
        
//     echo $sql1;
//        if ($result = $conn->query($sql1) === TRUE){
//            print_r($result);
//        }
 
   if(isset($_POST['updateId'])){
       $updateQuerry = "update mail_settings set 
                protocol = '".$protocol."', mail_path = '".$mail_path."', smtp_host = '".$smtp_host."',  smtp_user = '".$smtp_user."',  smtp_pass = '".$smtp_pass."',
                smtp_port = '".$smtp_port."' , smtp_crypto = '".$smtp_crypto."', mail_from = '".$mail_from."', mail_from_name = '".$mail_from_name."', 
                mail_reply = '".$mail_reply."' , mail_reply_name = '".$mail_reply_name."', mail_subject = '".$mail_subject."', dir_admin = '".$dir_admin."', dir_merchant ='".$dir_merchant."', email_pos = '".$email_pos."',
                email_sail = '".$email_sail."' , email_info = '".$email_info."', email_admin = '".$email_admin."', noreply_email = '".$noreply_email."',
                noreply_name = '".$noreply_name."' , email_to = '".$email_to."', email_to_name = '".$email_to_name."', smtp_server = '".$smtp_server."' , timezone = '".$timezone."' , session_merchant_key = '".$session_merchant_key."' , merchant_logout_return_page = '".$merchant_logout_return_page."' , free_demo_days = '".$free_demo_days."',
                service_tax_rate = '".$service_tax_rate."', default_pos_project_zip = '".$default_pos_project_zip."', default_pos_sql = '".$default_pos_sql."', pos_project_dir = '".$pos_project_dir."',
                sms_prefix = '".$sms_prefix."' , sms_sufix = '".$sms_sufix."', sms_tpl = '".$sms_tpl."' , sms_api_url = '".$sms_api_url."' ,
                sms_api_user = '".$sms_api_user."' , sms_api_passwd = '".$sms_api_passwd."' where id=$id ";
       //print_r($updateQuerry);
        if ($conn->query($updateQuerry) === TRUE){
             //echo $_SESSION['msg'];
             //echo "<script>alert('Record Updated  successfully')</script>";
           //  unset($_POST);
            // $_SESSION['msg'] = "Record Updated  successfully";
           //  header('location:mail_settings.php');
            
               //echo $successMsg = "Record Updated  successfully";                 
            }
        else{
            echo "failed to update";
        }
        
   }
//   else{
//             $sql = "Insert into mail_settings set 
//                protocol = '".$protocol."', mail_path = '".$mail_path."', smtp_host = '".$smtp_host."',  smtp_user = '".$smtp_user."',  smtp_pass = '".$smtp_pass."',
//                smtp_port = '".$smtp_port."' , smtp_crypto = '".$smtp_crypto."', mail_from = '".$mail_from."', mail_from_name = '".$mail_from_name."', 
//                mail_reply = '".$mail_reply."' , mail_reply_name = '".$mail_reply_name."', mail_subject = '".$mail_subject."', dir_admin = '".$dir_admin."', dir_merchant ='".$dir_merchant."', email_pos = '".$email_pos."',
//                email_sail = '".$email_sail."' , email_info = '".$email_info."', email_admin = '".$email_admin."', noreply_email = '".$noreply_email."',
//                noreply_name = '".$noreply_name."' , email_to = '".$email_to."', email_to_name = '".$email_to_name."', smtp_server = '".$smtp_server."' , timezone = '".$timezone."' , session_merchant_key = '".$session_merchant_key."' , merchant_logout_return_page = '".$merchant_logout_return_page."' , free_demo_days = '".$free_demo_days."',
//                service_tax_rate = '".$service_tax_rate."', default_pos_project_zip = '".$default_pos_project_zip."', default_pos_sql = '".$default_pos_sql."', pos_project_dir = '".$pos_project_dir."',
//                sms_prefix = '".$sms_prefix."' , sms_sufix = '".$sms_sufix."', sms_tpl = '".$sms_tpl."' , sms_api_url = '".$sms_api_url."' ,
//                sms_api_user = '".$sms_api_user."' , sms_api_passwd = '".$sms_api_passwd."' " ;
//           // echo $sql; 
//       
//            if ($conn->query($sql) === TRUE){
//                $successMsg = "New record added successfully";
//            }
//            else{
//                //$errMsg = "queryy erroer";
//            }
//   } 
   // $_SESSION['msg'] = 'Record Updated  successfully';
    //print_r($_SESSION);exit;
   //echo "<script>alert('Record Updated  successfully')</script>";
  // Unset($_SESSION['msg'] );
   header('location:mail_settings.php?success=1');
   //echo $_SESSION['msg'];exit;
  
   
}
else {
    $dberr = "database error";
}
 $successmsg = $_GET['success'];
  if(isset($_GET['success'])){
       $successmsg = "Record Updated  successfully";
   }

?>       
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SimplyPOS | Mail settings</title>
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
  <style>
 fieldset.scheduler-border {border: 1px solid #DBDEE0 !important;
    padding: 1.4em 1.4em 1.4em !important;
    margin: 0 0 1.5em 0 !important;
    -webkit-box-shadow: 0px 0px 0px 0px #000;
    box-shadow: 0px 0px 0px 0px #000;
    background: #fdfbfb;
 }
 </style>
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
                              Mail Settings
                            </h1>
                            <ol class="breadcrumb">
                              <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                              <li><a href="#">Mail Settings Form</a></li>
                            </ol>
                          </section>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                           
                    <?php if(isset($successmsg)) {?> 
                    <div class="alert alert-success"><i class="fa fa-check" aria-hidden="true"></i> <?php echo $successmsg; ?></div>
                    <?php } else if(isset($err2)){  ?>
                   <div class="alert alert-danger"><i class="fa fa-times" aria-hidden="true"></i> <?php echo $err2; ?></div>
                    <?php }?>
                          

            <form  method="post" role="form">
                <input type="hidden" name="updateId" value="1">
             <div class="col-md-12">
                <fieldset class="scheduler-border">
                  
                   <div class="col-sm-4 col-xs-12">  
                        <div class="form-group">
                           <label class="control-label" for="protocol">EMAIL PROTOCOL</label>
                           <select name="protocol" class="form-control tip" id="protocol" >
                                <option value="PHP Mail Function" <?php if($row['protocol']=="PHP Mail Function") echo 'selected="selected"'; ?>>PHP Mail Function</option>
                                <option value="Send Mail" <?php if($row['protocol']=="Send Mail") echo 'selected="selected"'; ?>>Send Mail</option>
                                <option value="SMTP"  <?php if($row['protocol']=="SMTP") echo 'selected="selected"'; ?>>SMTP</option>
                           </select>
                        </div>
                    </div>
                   <div class="col-sm-4 col-xs-12">     
                        <div class="form-group">
                        <label for="name"><span class="text-red">*</span> EMAIL PATH</label>
                        <input type="text" tabindex="1" name="mail_path" id="mail_path" title="" class="form-control"  value="<?php echo $row['mail_path']; ?>"  /></div>
                   </div>
                    <div class="col-sm-4 col-xs-12">     
                        <div class="form-group"> 
                           
                        <label for="name"><span class="text-red">*</span> SMTP HOST</label>
                        <input type="text" tabindex="1" name="smtp_host" id="smtp_host" title="" class="form-control"  value="<?php echo $row['smtp_host']; ?>"  /></div>
                    </div>
                     <div class="col-sm-4 col-xs-12">     
                                <div class="form-group">
                                <label for="name"><span class="text-red">*</span>SMTP SERVER</label>
                                <input type="text" tabindex="1" name="smtp_server" id="smtp_server" title="" class="form-control"  value="<?php echo $row['smtp_server']; ?>" /></div>
                         </div>
                     <div class="col-sm-4 col-xs-12">     
                        <div class="form-group">
                        <label for="name"><span class="text-red">*</span> SMTP USER</label>
                        <input type="text" tabindex="1" name="smtp_user" id="smtp_user" title="" class="form-control"  value="<?php echo $row['smtp_user']; ?>"  /></div>
                     </div>
                    <div class="col-sm-4 col-xs-12">     
                        <div class="form-group">
                        <label for="name"><span class="text-red">*</span> SMTP PASSWORD</label>
                        <input type="text" tabindex="1" name="smtp_pass" id="smtp_pass" title="" class="form-control"  value="<?php echo $row['smtp_pass']; ?>"  /></div>
                    </div>
                     <div class="col-sm-4 col-xs-12">     
                        <div class="form-group">
                        <label for="name"><span class="text-red">*</span> SMTP PORT</label>
                        <input type="text" tabindex="1" name="smtp_port" id="smtp_port" title="" class="form-control"  value="<?php echo $row['smtp_port']; ?>"  /></div>
                     </div>
                     <div class="col-sm-4 col-xs-12">     
                        <div class="form-group">
                        <label for="name"><span class="text-red">*</span> SMTP CRYPTO</label>
                        <input type="text" tabindex="1" name="smtp_crypto" id="smtp_crypto" title="" class="form-control"  value="<?php echo $row['smtp_crypto'];  ?>"  /></div>
                     </div>
                    <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                            <label for="name"><span class="text-red">*</span> EMAIL POS</label>
                            <input type="text" tabindex="1" name="email_pos" id="email_pos" title="" class="form-control"  value="<?php echo $row['email_pos'];  ?>" /></div>
                        </div>
                            <div class="col-sm-4 col-xs-12">     
                                <div class="form-group">
                                <label for="name"><span class="text-red">*</span> EMAIL SAIL</label>
                                <input type="text" tabindex="1" name="email_sail" id="email_sail" title="" class="form-control"  value="<?php echo $row['email_sail']; ?>" /></div>
                            </div>
                            <div class="col-sm-4 col-xs-12">     
                                <div class="form-group">
                                <label for="name"><span class="text-red">*</span> EMAIL INFO</label>
                                <input type="text" tabindex="1" name="email_info" id="email_info" title="" class="form-control"  value="<?php echo $row['email_info']; ?>" /></div>
                            </div>
                            <div class="col-sm-4 col-xs-12">     
                                <div class="form-group">
                                <label for="name"><span class="text-red">*</span> EMAIL ADMIN</label>
                                <input type="text" tabindex="1" name="email_admin" id="email_admin" title="" class="form-control"  value="<?php echo $row['email_admin']; ?>" /></div>
                            </div>
                            <div class="col-sm-4 col-xs-12">     
                                <div class="form-group">
                                <label for="name"><span class="text-red">*</span> NOREPLY EMAIL</label>
                                <input type="text" tabindex="1" name="noreply_email" id="noreply_email" title="" class="form-control"  value="<?php echo $row['noreply_email']; ?>" /></div>
                            </div>
                            <div class="col-sm-4 col-xs-12">     
                                <div class="form-group">
                                <label for="name"><span class="text-red">*</span> NOREPLY NAME</label>
                                <input type="text" tabindex="1" name="noreply_name" id="noreply_name" title="" class="form-control"  value="<?php echo $row['noreply_name']; ?>" /></div>
                            </div>
                         <div class="col-sm-4 col-xs-12">     
                                <div class="form-group">
                                <label for="name"><span class="text-red">*</span> EMAIL TO</label>
                                <input type="text" tabindex="1" name="email_to" id="email_to" title="" class="form-control"  value="<?php echo $row['email_to']; ?>" /></div>
                            </div>
                         <div class="col-sm-4 col-xs-12">     
                                <div class="form-group">
                                <label for="name"><span class="text-red">*</span>EMAIL TO NAME</label>
                                <input type="text" tabindex="1" name="email_to_name" id="email_to_name" title="" class="form-control"  value="<?php echo $row['email_to_name']; ?>" /></div>
                         </div>
                       
                    <div class="col-sm-4 col-xs-12">
                        <div class="form-group">
                            <label for="name"><span class="text-red">*</span> EMAIL FROM</label>
                            <input type="text" tabindex="1" name="mail_from" id="mail_from" title="" class="form-control"  value="<?php echo $row['mail_from']; ?>" />
                        </div>
                     </div>
                       <div class="col-sm-4 col-xs-12">
                        <div class="form-group">
                         <label for="name"><span class="text-red">*</span> EMAIL FROM NAME</label>
                         <input type="text" tabindex="1" name="mail_from_name" id="mail_from_name"  title="" class="form-control"  value="<?php  echo $row['mail_from_name']; ?>"  />
                        </div>
                     </div>
                     <div class="col-sm-4 col-xs-12">
                        <div class="form-group">
                        <label for="name"><span class="text-red">*</span> EMAIL REPLY</label>
                        <input type="text" tabindex="1" name="mail_reply" id="mail_reply" title="" class="form-control"  value="<?php echo $row['mail_reply']; ?>"  /></div>
                    </div>
                     <div class="col-sm-4 col-xs-12">
                        <div class="form-group">
                        <label for="name"><span class="text-red">*</span> EMAIL REPLY NAME</label>
                         <input type="text" tabindex="1" name= "mail_reply_name" id="mail_reply_name" title="" class="form-control"  value="<?php echo $row['mail_reply_name']; ?>" /></div>
                     </div>
                      <div class="col-sm-4 col-xs-12">     
                         <div class="form-group">
                             <label for="name"><span class="text-red">*</span> EMAIL SUBJECT</label>
                            <input type="text" tabindex="1" name="mail_subject" id="mail_subject" title="" class="form-control"  value="<?php echo $row['mail_subject']; ?>" />
                         </div>
                      </div>
                        <!----NEW FIELD---->
                            
                    </fieldset>
              </div>  
        
            <div class="col-sm-12">
                    <fieldset class="scheduler-border">
                        <div class="col-sm-4 col-xs-12">
                                <div class="form-group">
                                 <label for="name"><span class="text-red">*</span> DIR ADMIN</label>
                                 <input type="text" tabindex="1" name="dir_admin" id="dir_admin"  title="" class="form-control"  value="<?php echo $row['dir_admin']; ?>"  />
                                </div>   
                             </div>
                              <div class="col-sm-4 col-xs-12">
                                <div class="form-group">
                                <label for="name"><span class="text-red">*</span> DIR MERCHANT</label>
                                <input type="text" tabindex="1" name="dir_merchant" id="dir_merchant" title="" class="form-control"  value="<?php echo $row['dir_merchant']; ?>" /></div>
                            </div>
                        <div class="col-sm-4 col-xs-12">     
                                <div class="form-group">
                                <label for="name"><span class="text-red">*</span>TIMEZONE</label>
                                <input type="text" tabindex="1" name="timezone" id="timezone" title="" class="form-control" value="<?php echo $row['timezone']; ?>" /></div>
                            </div>
                       
                        <div class="col-sm-4 col-xs-12">     
                                <div class="form-group">
                                    <label for="name"><span class="text-red">*</span>SESSION MERCHANT KEY</label>
                                <input type="text" tabindex="1" name="session_merchant_key" id="session_merchant_key" title="" class="form-control"  value="<?php echo $row['session_merchant_key']; ?>" /></div>
                            </div>
                        <div class="col-sm-4 col-xs-12">     
                                <div class="form-group">
                                    <label for="name"><span class="text-red">*</span>MERCHANT LOGOUT RETURN PAGE</label>
                                <input type="text" tabindex="1" name="merchant_logout_return_page" id="merchant_logout_return_page" title="" class="form-control" value="<?php echo $row['merchant_logout_return_page']; ?>" /></div>
                            </div>
                        
                         <div class="col-sm-4 col-xs-12">     
                                <div class="form-group">
                                    <label for="name"><span class="text-red">*</span>FREE DEMO DAYS</label>
                                <input type="text" tabindex="1" name="free_demo_days" id="free_demo_days" title="" class="form-control"  value="<?php echo $row['free_demo_days']; ?>" /></div>
                            </div>
                        
                         <div class="col-sm-4 col-xs-12">     
                                <div class="form-group">
                                    <label for="name"><span class="text-red">*</span>SERVICE TAX RATE</label>
                                <input type="text" tabindex="1" name="service_tax_rate" id="service_tax_rate" title="" class="form-control"  value="<?php echo $row['service_tax_rate']; ?>" /></div>
                            </div>
                        <div class="col-sm-4 col-xs-12">     
                                <div class="form-group">
                                    <label for="name"><span class="text-red">*</span>DEFAULT POS PROJECT ZIP</label>
                                <input type="text" tabindex="1" name="default_pos_project_zip" id="default_pos_project_zip" title="" class="form-control"  value="<?php echo $row['default_pos_project_zip']; ?>" /></div>
                            </div>
                         <div class="col-sm-4 col-xs-12">     
                                <div class="form-group">
                                    <label for="name"><span class="text-red">*</span>DEFAULT POS SQL</label>
                                <input type="text" tabindex="1" name="default_pos_sql" id="default_pos_sql" title="" class="form-control"   value="<?php echo $row['default_pos_sql']; ?>" /></div>
                            </div>
                        <div class="col-sm-4 col-xs-12">     
                                <div class="form-group">
                                    <label for="name"><span class="text-red">*</span>POS PROJECT DIR</label>
                                <input type="text" tabindex="1" name="pos_project_dir" id="pos_project_dir" title="" class="form-control"  value="<?php echo $row['pos_project_dir']; ?>" /></div>
                            </div>
                        <div class="col-sm-4 col-xs-12">     
                                <div class="form-group">
                                    <label for="name"><span class="text-red">*</span>SMS PREFIX</label>
                                <input type="text" tabindex="1" name="sms_prefix" id="sms_prefix" title="" class="form-control" value="<?php echo $row['sms_prefix']; ?>" /></div>
                            </div>
                        <div class="col-sm-4 col-xs-12">     
                                <div class="form-group">
                                    <label for="name"><span class="text-red">*</span>SMS SUFIX</label>
                                <input type="text" tabindex="1" name="sms_sufix" id="sms_sufix" title="" class="form-control" value="<?php echo $row['sms_sufix']; ?>" /></div>
                            </div>
                        <div class="col-sm-4 col-xs-12">     
                                <div class="form-group">
                                    <label for="name"><span class="text-red">*</span>SMS TPL</label>
                                <input type="text" tabindex="1" name="sms_tpl" id="sms_tpl" title="" class="form-control" value="<?php echo $row['sms_tpl'];?>" /></div>
                            </div>
                        <div class="col-sm-4 col-xs-12">     
                                <div class="form-group">
                                    <label for="name"><span class="text-red">*</span>SMS API URL</label>
                                <input type="text" tabindex="1" name="sms_api_url" id="sms_api_url" title="" class="form-control"  value="<?php echo  $row['sms_api_url']; ?>" /></div>
                            </div>
                        <div class="col-sm-4 col-xs-12">     
                                <div class="form-group">
                                    <label for="name"><span class="text-red">*</span>SMS API USER</label>
                                <input type="text" tabindex="1" name="sms_api_user" id="sms_api_user" title="" class="form-control" value="<?php echo  $row['sms_api_user']; ?>" /></div>
                            </div>
                        <div class="col-sm-4 col-xs-12">     
                                <div class="form-group">
                                    <label for="name"><span class="text-red">*</span>SMS API PASSWD</label>
                                <input type="text" tabindex="1" name="sms_api_passwd" id="sms_api_passwd" title="" class="form-control" value="<?php echo  $row['sms_api_passwd']; ?>" /></div>
                            </div>
                            
                     </fieldset>
              </div>               
             
              <div class="form-group" style="margin:50px 0;"><button type="submit"  tabindex="11" name="adddata"  class="btn btn-primary center-block">Update Record</button></div>

             </form>
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
    //$('.alert-danger').css('display', 'none');
    setTimeout(function() {
    $('.alert-success,.text-danger').fadeOut('slow');
}, 3000); //    
</script>
</html>
