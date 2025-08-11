<?php
include_once('application_main.php');
include_once('session.php');
require_once '../functions/phpFormFunctions.php'; 

$objMerchant = new merchant($conn);

// echo "<pre>";
// print_r($objMerchant);
// exit;
$objDistributor = new distributors;
        
$merchantType = $objMerchant->merchantTypes;

//$merchantsData =  $objMerchant->get();

if(isset($_POST['formAction']) ) { 
       
    $name               = $objMerchant->appCommon->prepareInput($_POST['name']);
    $email              = $objMerchant->appCommon->prepareInput($_POST['email']);
    $phone              = $objMerchant->appCommon->prepareInput($_POST['phone']);
    
    $is_testing_merchant     = $_POST['is_testing_merchant'];
    $distributor_id     = $_POST['distributor'];
    $merchant_type_id   = $_POST['merchant_type'];
    $merchant_group_id   = $_POST['merchant_group'];
           
    $address            = $objMerchant->appCommon->prepareInput($_POST['address']);
    $pos_name           = $objMerchant->appCommon->prepareInput($_POST['pos_name']);
    $username           = $objMerchant->appCommon->prepareInput($_POST['username']);
    $password           = $objMerchant->appCommon->prepareInput($_POST['password']);
    $business_name      = $objMerchant->appCommon->prepareInput($_POST['business_name']);
    $countryArr         = explode('~', $_POST['country']); 
        
    $country_name = $objMerchant->appCommon->prepareInput($countryArr[0]);
    $country_code = $objMerchant->appCommon->prepareInput($countryArr[1]);
    $formIsValid = true;
    
    if(empty($distributor_id)){
        $formIsValid = false;
        $validation[] = "Select Distributor";
        $inputError['distributor'] = 1;
    }
    if(empty($name)){
        $formIsValid = false;
        $validation[] = "Name Is Required";
        $inputError['name'] = 1;
    }
    
    if($merchant_type_id == ''){
        $formIsValid = false;
        $validation[] = "Select Merchant Type";
        $inputError['type'] = 1;
    }
    if($merchant_group_id == ''){
        $formIsValid = false;
        $validation[] = "Select Merchant Group";
        $inputError['group'] = 1;
    }
    
     
    if($email != '') {
        if($objMerchant->emailExists($email)){
             $formIsValid = false;
             $validation[] = "Email already exists.";
             $inputError['email'] = 1;
        }
        $fieldEmail = '`email`,';
        $fieldEmailValue = "'$email',";
    } else {
        $fieldEmail = '';
        $fieldEmailValue = "";
    }
    
    if($objMerchant->mobileExists($phone)){
         $formIsValid = false;
         $validation[] = "Mobile number already exists.";
         $inputError['phone'] = 1;
    }
    
    if(!empty($pos_name)) {
        if($objMerchant->posNameExists($pos_name)){
             $formIsValid = false;
             $validation[] = "POS Name is already taken.";
             $inputError['posname'] = 1;
        } 
        $fieldPOSName = '`pos_name`,';
        $fieldPOSNameValue = "'$pos_name',";
    } else {
        $fieldPOSName = '';
        $fieldPOSNameValue = "";
    }
    
    if(empty($business_name)) {
        $formIsValid = false;
        $validation[] = "Business name is required.";
        $inputError['businessname'] = 1;
    }
    
    if($username == ''){
         $formIsValid = false;
         $validation[] = "Username is required.";
        $inputError['username'] = 1;
    }
    
    /*
    if($objMerchant->usernameExists($username)){
         $formIsValid = false;
         $validation[] = "Username is already taken.";
        $inputError['username'] = 1;
    }
    */
    
    if($formIsValid === true)
    { 
    
        $time = time();
        $token = md5($email.$time);
        $now    = date('Y-m-d h:i:s');
    
        switch($_POST['formAction']) :
        
        case 'ADD':
            
         $password_encript = $objMerchant->appCommon->mc_encrypt($password, MASTER_ENCRYPTION_KEY);
            
         $sql = "INSERT INTO ".TABLE_MERCHANTS." ( `name`, $fieldEmail `phone`, `is_testing_merchant`, `distributor_id`, `type`, `message`, $fieldPOSName `address`, `username`, `password_encript` , "
            . " `is_active`, `is_delete`, `is_email_verified`, `verification_code`, `created_at`, `updated_at` , `payment_status`, `package_id`,"
            . " `subscription_is_active`, `is_mobile_verified`, `country`, `country_code`, `business_name`, `merchant_group`) "
            . " VALUES ( '$name',". $fieldEmailValue ." '$phone', '$is_testing_merchant', '$distributor_id', '$merchant_type_id', '$message', ".$fieldPOSNameValue." '$address', '$username', '$password_encript', "
            . "  '1', '0', '0', '$token', '".NOW."' , '".NOW."', 'unpaid', '0', '0', '0', '$country_name', '$country_code', '$business_name', '$merchant_group_id' )";
            
          $result = $conn->query($sql);  
    
  // var_dump($result);
   
if($result):

    $merchant_id = $conn->insert_id;

   $objMerchant->logUserActivity(['merchant_id'=>$merchant_id , 'activity'=>'New merchant added from admin']);
    
   if(isset($_POST['send_email']) && !empty($email)) :
      
    $verificationLink =  $objMerchant->appCommon->baseURL("verification.php?action=verification&id=$merchant_id&email=$email&token=$token");
         
    $mailBody = "<div style='font-family:arial; font-size:14px; text-align:left;'>
                    <h2 style='font-family:arial; font-size:18px; text-align:left;'>Dear Customer</h2><br/>
                    <p style='font-family:arial; font-size:14px; text-align:left;'>Thank you for requesting POS trial of Simply POS.</p>
                     <br/><br/>
                     <p style='font-family:arial; font-size:14px; text-align:left;'>Your cyber safety is the top most priority for us at Simply POS, to verify your email address please click the following link. You can also copy and paste the link into your browser.</p>
                     <br/><br/>
                       <div style='font-family:arial; font-size:14px; text-align:left;'><a href='$verificationLink' target='_blank'>$verificationLink</a></div>
                    <br/><br/>
                    <p style='font-family:arial; font-size:14px; text-align:left;'>Our team will contact you within 24 hours once the verification is completed. </p>
                    <br/><br/><br/>
                    <p style='font-family:arial; font-size:16px; text-align:left;'>Thank you<br/>Simply Safe POS team</p>
                 </div>";
    
    $mailData['to_name']    = $name;
    $mailData['to']         = $email;
    $mailData['from']       = EMAIL_FROM;
    $mailData['from_name']  = EMAIL_FROM_NAME;
    $mailData['reply']      = REPLY_EMAIL;
    $mailData['reply_name'] = REPLY_NAME;
    
    $mailData['subject']    = 'Simply POS Trial Request Sent';
    $mailData['body']       = $mailBody;

  //If Mail send to customer. send mail to POS
    if( $objMerchant->appCommon->sendMail( $mailData )) :
      
        $mailData['from_name']      = EMAIL_FROM_NAME;
        $mailData['from']           = EMAIL_FROM;
        $mailData['to']             = EMAIL_TO;
        $mailData['to_name']        = EMAIL_TO_NAME;
        $mailData['reply']          = REPLY_EMAIL;
        $mailData['reply_name']     = REPLY_NAME;

    $mailBody_2 =   "<div style='font-family:arial; font-size:14px; text-align:left;'>
                        <h2 style='font-family:arial; font-size:18px; text-align:left;'>Hi,</h2>
                        <h5 style='font-family:arial; font-size:16px; text-align:left;'>$name merchant add successfully for ".FREE_DEMO_DAYS." days POS Trial with above details.</h5>
                        <div style='width:600px; text-align:left'>
                            <table width='100%' border='0' cellpadding='10' cellspacing='5' style='font-family:arial; font-size:14px; text-align:left;'>
                                <tr><th>Name</th><th>:</th><td>$name</td></tr>
                                <tr><th>Email</th><th>:</th><td>$email</td></tr>
                                <tr><th>Phone</th><th>:</th><td>$phone</td></tr>
                                <tr><th>Merchant Type</th><th>:</th><td>".$objMerchant->merchantTypes[$merchant_type_id]."</td></tr>
                                <tr><th>Address</th><th>:</th><td>$address</td></tr>
                                <tr><th>Status : </th><th>:</th><td style='color:blue;'>Verification Pending</td></tr>            
                            </table>
                        </div><br/><br/>
                        <h5 style='font-family:arial; font-size:16px; text-align:left;'>Thank you<br/>Simply POS Group</h5>
                    </div>"; 
        
            $mailData['subject']    = "New Merchant add";
            $mailData['body']       = $mailBody_2;
      
            $mailResult =  $objMerchant->appCommon->sendMail( $mailData );
                       
        endif; //Send mail to Merchant
      endif; //Send email is set
      
    header("location:merchant_add.php?action=success");
      
  else:
     echo  $error_msg = $conn->error;
  endif; //Insert Merchant
            
            break;
        
        case 'EDIT':
            
            break;
        
    endswitch;
    
    }//end if.
    
} 
 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SimplyPOS | Add Merchant</title>
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
 
    <section class="content-wrapper">
		 
        <div class="row">
                  
                    <div class="box box-warning">
                        <div class="box-header with-border">
                           <section class="content-header">
                            <h1>
                              Add New Merchant
                            </h1>
                            <ol class="breadcrumb">
                              <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                              <li><a href="#">Registration Form</a></li>
                            </ol>
                          </section>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                             
                            <div class="col-sm-6 col-sm-offset-3" style="margin-top:30px;">
                         
                   <?php if($formIsValid === false) : ?>
                            <ul class="alert alert-danger" style="list-style:none;">
                         <?php 
                         
                        echo ($error_msg) ? "<li>$error_msg</li>" : ''; 
        
                        if(is_array($validation)){
                            foreach($validation as $errormsg) { ?>
                                <li> <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <?php echo $errormsg; ?> </li>
                        <?php }//end foreach
                        }//end if. 
                        ?>
                        </ul>
                    <?php endif; ?> 
                    <?php if($_GET['action'] == "success") : ?> 
                        <div class="alert alert-success"><i class="fa fa-check" aria-hidden="true"></i> Merchant Created Successfully.</div>
                    <?php endif; ?>        

                <form  method="post" role="form">
                <input type="hidden" name="formAction" value="ADD" />
                
              <?php
                if($isDistributors){
                    echo '<input type="hidden" name="distributor" id="distributor" value="'.$_SESSION['session_user_id'].'" />';
                } else {
             ?>
                <div class="row form-group">
                    <div class="col-sm-4 col-xs-12"><label for="merchant_type"><span class="text-red">*</span> Select User:</label><span  class="pull-right"><a class="text-info" href="#" data-toggle="tooltip" title="Select Distributor"><i class="fa fa-question-circle" aria-hidden="true"></i></a></span></div>
                    <div class="col-sm-8 col-xs-12 input-group">
                      <span class="input-group-addon bg-gray"><i class="fa fa-user"></i></span>
                    <select  tabindex="5"  class="<?php echo ($inputError['distributor']) ? 'form-control text-danger border-danger' : 'form-control';?>"  id="distributor" name="distributor" required="required" >
                            <option value="">--Select One--</option>
                            <option value="0">Simplysafe</option>
                        <?php
                        
                            $distributors = $objDistributor->get_list();
        
                            if(is_array($distributors)){

                               $selected = '';

                                foreach($distributors as $id => $distributor) {
                                   if($distributor_id == $id) {
                                      $selected = ' selected="selected"'; 
                                   }
                                   echo '<option value="'.$id.'" '. $selected.'>'.$distributor['name'].'</option>';
                                }//end foreach.
                            }
                        ?>
                        </select> 
                    </div>                  
                  </div>
             <?php
                }
              ?>
                <div class="row form-group">
                    <div class="col-sm-4 col-xs-12"><label for="is_testing_merchant"><span class="text-red">*</span> Is Testing Merchant:</label><span  class="pull-right"><a class="text-info" href="#" data-toggle="tooltip" title="Select Options"><i class="fa fa-question-circle" aria-hidden="true"></i></a></span></div>
                    <div class="col-sm-8 col-xs-12 input-group">
                      <span class="input-group-addon bg-gray"><i class="fa fa-user"></i></span>
                        <select class="form-control"  id="is_testing_merchant" name="is_testing_merchant" required="required" >
                            <option value="">--Select One--</option>
                            <option value="0">No</option>
                            <option value="1">Yes</option>                        
                        </select> 
                    </div>                  
                  </div>
                <div class="row form-group">
                    <div class="col-sm-4 col-xs-12"><label for="merchant_type"><span class="text-red">*</span> Business Type:</label><span  class="pull-right"><a class="text-info" href="#" data-toggle="tooltip" title="If Not found your Type, Please select Other."><i class="fa fa-question-circle" aria-hidden="true"></i></a></span></div>
                    <div class="col-sm-8 col-xs-12 input-group">
                      <span class="input-group-addon bg-gray"><i class="fa fa-fw fa-shopping-cart"></i></span>
                    <select  tabindex="5"  class="<?php echo ($inputError['type']) ? 'form-control text-danger border-danger' : 'form-control';?>"  id="merchant_type" name="merchant_type" required="required" >
                      <option value="">--Select One--</option>
                      <?php
                      echo '<option value="1">Restaurants</option>';
                      $merchants = $objMerchant->getMerchantType('pos_access');
                      
                      if(is_array($merchants)){
                         
                         $selected = '';
                         echo '<option value="1">Restaurants</option>';
                          foreach($merchants as $id => $type) {
                             if($merchant_type_id == $id) {
                                $selected = ' selected="selected"'; 
                             }
                              echo '<option value="'.$id.'" '. $selected.'>'.$type.'</option>';
                          }
                      }
                      ?>
                    </select> 
                    </div>                  
                  </div>
                <div class="row form-group">
                    <div class="col-sm-4 col-xs-12"><label for="merchant_group"><span class="text-red">*</span> Business Group:</label><span  class="pull-right"><a class="text-info" href="#" data-toggle="tooltip" title="Please select merchant group"><i class="fa fa-question-circle" aria-hidden="true"></i></a></span></div>
                    <div class="col-sm-8 col-xs-12 input-group">
                      <span class="input-group-addon bg-gray"><i class="fa fa-fw fa-shopping-cart"></i></span>
                    <select  tabindex="5"  class="<?php echo ($inputError['group']) ? 'form-control text-danger border-danger' : 'form-control';?>"  id="merchant_group" name="merchant_group" required="required" >
                      
                      <?php
                      $merchantsGroup = $objMerchant->getMerchantGroup();
                     
                      if(is_array($merchantsGroup)){
                         
                         $selected = '';
                         echo '<option value="">--Select One--</option>';
                         
                          foreach($merchantsGroup as $id => $group) {
                             if($merchant_group == $id) {
                                $selected = ' selected="selected"'; 
                             }
                              echo '<option value="'.$id.'" '. $selected.'>'.$group.'</option>';
                          }
                          echo '<option value="0">Business Group Not Listed</option>';
                      }
                      
                      ?>
                    </select> 
                      
                    </div>                  
                  </div>
                <div class="row form-group">
                    <div class="col-sm-4 col-xs-12"><label for="business_name"><span class="text-red">*</span> Business Name:</label><span class="pull-right"><a class="text-info" href="#" data-toggle="tooltip" title="Business Name should be should be only in alphabets and numbers & minimum 3 characters."><i class="fa fa-question-circle" aria-hidden="true"></i></a></span></div>
                    <div class="col-sm-8 col-xs-12 input-group">
                      <span class="input-group-addon bg-gray"><i class="fa fa-fw fa-keyboard-o"></i></span>
                      <input type="text"  tabindex="5"  name="business_name" value="<?php echo (!$formIsValid) ? $business_name : $business_name;?>"  data-toggle="tooltip" title="Business Name should be minimum 3 characters." class="<?php echo ($inputError['businessname']) ? 'form-control text-danger border-danger' : 'form-control';?>" id="business_name" required="required" maxlength="30" placeholder="Busness Name"  /></div>
                </div>
               <div class="row form-group">
                   <div class="col-sm-4 col-xs-12"><label for="name"><span class="text-red">*</span> Merchant Name:</label><span class="pull-right"><a class="text-info" href="#" data-toggle="tooltip" title="Merchant Name should be only in alphabets & minimum 3 characters."><i class="fa fa-question-circle" aria-hidden="true"></i></a></span></div>
                    
                   <div class="col-sm-8 col-xs-12 input-group">
                      <span class="input-group-addon bg-gray"><i class="fa fa-fw fa-keyboard-o"></i></span>
                        <input type="name" tabindex="1" name="name"  data-toggle="tooltip" title="Merchant Name should be only in alphabets & minimum 3 characters." class="<?php echo ($inputError['name']) ? 'form-control text-danger border-danger' : 'form-control';?>" id="name" value="<?php echo (!$formIsValid) ? $name : $name;?>"  required="required" maxlength="50" placeholder="Merchant Name" pattern="[A-Za-z ]{3,}" title="Only letter at least 3 charector."/></div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-4 col-xs-12"><label for="email">&nbsp;&nbsp;&nbsp;Email address:</label><span class="pull-right"><a class="text-info" href="#" data-toggle="tooltip" title="Email should be valid. Ex. user@domain.com"><i class="fa fa-question-circle" aria-hidden="true"></i></a></span></div>
                    <div class="col-sm-8 col-xs-12 input-group">
                        <span class="input-group-addon bg-gray"><i class="fa fa-envelope"></i></span>
                        <input type="email" tabindex="2"  data-toggle="tooltip" title="Email should be valid. Ex. user@domain.com" name="email" class="<?php echo ($inputError['email']) ? 'form-control text-danger border-danger' : 'form-control';?>" id="email" value="<?php echo (!$formIsValid) ? $email : $email;?>" maxlength="50" placeholder="Email Address" />
                    </div>
                </div>
                 
                <div class="row form-group">
                    <div class="col-sm-4 col-xs-12"><label for="country"><span class="text-red">*</span> Country Code:</label><span class="pull-right"><a class="text-info" href="#" data-toggle="tooltip" title="Select Country Code"><i class="fa fa-question-circle" aria-hidden="true"></i></a></span></div>
                    <div class="col-sm-8 col-xs-12 input-group">
                        <span class="input-group-addon bg-gray"><i class="fa fa-fw fa-globe"></i></span>
                        <select tabindex="3" data-toggle="tooltip" title="Select Country" name="country" id="country" class="<?php echo ($inputError['countrycode']) ? 'form-control text-danger border-danger' : 'form-control';?>"  required="required">
                        <option value="">-- Select Country Code --</option>
                      <?php 
                        $countries = get_country_data();
                        if(is_array($countries)) {
                            foreach ($countries as $id => $country) {
                                
                                $selected_country = ($country_code == $country['code']) ? ' selected="selected" ' : '';
                                
                               echo '<option value="'.$country['name'].'~'.$country['code'].'" '. $selected_country.'>'.$country['name'].' (+'.$country['code'].')</option>';
                            }
                        }
                      ?>
                    </select>
                  </div>
                  </div>
                <div class="row form-group">
                  <div class="col-sm-4 col-xs-12"><label for="phone"><span class="text-red">*</span> Mobile No:</label><span class="pull-right"><a class="text-info" href="#" data-toggle="tooltip" title="Mobile should be 10 digits number only."><i class="fa fa-question-circle" aria-hidden="true"></i></a></span></div>
                  <div class="col-sm-8 col-xs-12 input-group">
                      <span class="input-group-addon bg-gray"><i class="fa fa-fw fa-mobile"></i></span>
                      <input type="text"  tabindex="4"  data-toggle="tooltip" title="Mobile should be 10 digits number only." name="phone" class="<?php echo ($inputError['phone']) ? 'form-control text-danger border-danger' : 'form-control';?>" id="phone" value="<?php echo (!$formIsValid) ? $phone : $phone;?>" required="required" maxlength="10" placeholder="Phone No." pattern="[0-9]{10,}" title="Only number and minimum 10 digits."/></div>
                </div>
                
                
                <div class="row form-group">
                    <div class="col-sm-4 col-xs-12"><label for="pos_name">&nbsp;&nbsp;&nbsp;POS Web URL:</label><span class="pull-right"> <a class="text-info" href="#" data-toggle="tooltip" title="POS URL should be only in alphabets & minimum 5 characters."><i class="fa fa-question-circle" aria-hidden="true"></i></a></span></div>
                    <div class="col-sm-8 col-xs-12 input-group">
                        <span class="input-group-addon bg-gray"><strong>https://www.</strong></span>
                        <input type="text"  tabindex="6"  name="pos_name" value="<?php echo (!$formIsValid) ? $pos_name : $pos_name;?>"  class="form-control" id="pos_username"  data-toggle="tooltip" title="Choose Your POS URL. URL Name should be only in alphabets between 5 to 20 characters." maxlength="20" placeholder="Web Url" pattern="[A-Za-z0-9]{5,}" />
                        <span class="input-group-addon bg-gray"><strong>.simplypos.in</strong></span>
                    </div>
                </div>                
                <div class="row form-group">
                    <div class="col-sm-4 col-xs-12"><label for="username"><span class="text-red">*</span> Username:</label><span class="pull-right"><a href="#" data-toggle="tooltip" title="Username should minimum 5 characters, only alphabet's & numbers."><i class="fa fa-question-circle" aria-hidden="true"></i></a></span></div>
                    <div class="col-sm-8 col-xs-12 input-group">
                        <span class="input-group-addon bg-gray"><i class="fa fa-fw fa-at"></i></span>
                        <input type="text" tabindex="7" name="username" value="<?php echo (!$formIsValid) ? $username : $username;?>"  data-toggle="tooltip" title="Username should minimum 5 characters, only alphabet's & numbers." class="<?php echo ($inputError['username']) ? 'form-control text-danger border-danger' : 'form-control';?>" id="username" required="required" maxlength="20" placeholder="Username" pattern="[A-Za-z0-9]{5,}" />
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-4 col-xs-12"><label for="password"><span class="text-red">*</span> Password:</label><span class="pull-right"><a href="#" data-toggle="tooltip" title="Password should be minimum 6 characters with combination of Uppercase, Lowercase & Numbers"><i class="fa fa-question-circle" aria-hidden="true"></i></a> </span></div>
                    <div class="col-sm-8 col-xs-12 input-group">
                        <span class="input-group-addon bg-gray"><i class="fa fa-fw fa-shield"></i></span>
                        <input type="password"  tabindex="8"  data-toggle="tooltip" title="Password should be minimum 6 characters with combination of Uppercase, Lowercase & Numbers" name="password" class="<?php echo ($inputError['password']) ? 'form-control text-danger border-danger' : 'form-control';?>" id="password" required="required" maxlength="20" placeholder="Password"  pattern="[A-Za-z0-9@$&#]{6,}" value="" />
                    </div>
                </div>
                
                <div class="row form-group">
                    <div class="col-sm-4 col-xs-12"><label for="message">&nbsp;&nbsp;&nbsp;Business Address:</label></div>
                    <div class="col-sm-8 col-xs-12 input-group">
                        <span class="input-group-addon bg-gray"><i class="fa fa-fw fa-home"></i></span>
                        <input type="text" class="form-control"  tabindex="9"  id="address" name="address" maxlength="255" placeholder="Address" value="<?php echo (!$formIsValid) ? $address : $address;?>" />
                    </div>
                </div>
                <div class="row form-group checkbox">
                    <div class="col-sm-12"><label><input type="checkbox" name="send_email"  tabindex="10"  id="send_email" value="1" /> Send verification email to merchant</label>  <span class="pull-right"><a class="text-info" href="#" data-toggle="tooltip" title="Select if you have to send email on merchant email id."><i class="fa fa-question-circle" aria-hidden="true"></i></a></span> </div>
                </div> 
                <hr/>
                <div class="row form-group " style="margin:50px 0;"><button type="submit"  tabindex="11"  class="btn btn-primary center-block">Add Merchant</button></div>
              </form>
            </div>
                    <!-- /.box-body -->
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

</body>
</html>
