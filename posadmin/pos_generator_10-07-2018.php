<?php

include_once('application_main.php');
include_once('session.php');
include_once('../include/pos_log.php');
include_once 'xmlapi.php';
include_once 'hepers.php';

global $id;
global $projectPath;
global $sorceFile;
global $dbData;

$subDomainName  = $_REQUEST['subdomain'];
$merchant_id    = $_REQUEST['id'];

$objMerchant    = new merchant($conn);

$merchantsData  = $objMerchant->get($merchant_id); 

//Set CPannel Librery Object.
$objMerchant->SetCPObject(); 

$merchantsData['pos_type'] = $objMerchant->merchantTypeList[$merchantsData['type']]['merchant_type_keyword'];
                                       
$setupLog   = '';
$runSetup   = false;
$setup      = '';
$cpanelusr  = CP_USERNAME;
$cpanelpass = CP_PASSWORD;
$hostName   = CP_HOST;
$prefix     = CP_PREFIX;                                  


if($_POST['action'] == "generate_pos")
{     
                                       
    $id = $_POST['id'];
    $setSampleProducts = $_POST['sample_products'];
    //Check Merchant POS Generate Status is Pending or not.
    if($merchantPosData['pos_status'] !== 'pending') {
        $setup  = false;
        $setup_status   = 'pos_assigned';  
        $setupLog[]     = "Merchant POS Is Already Assign."; 
    }//end if.
    
    $subdomain = strtolower($_POST['subdomain']); 
    $setup  = true;
    $isValidPosName = $objapp->isValidPosName( $subdomain );
  
        if( $isValidPosName == false ) {
            $setup          = false;
            $setup_status   = 'invalid_url';
        }
        //Check the POS is exists as same name.
        if( $objMerchant->is_valid_pos($subdomain) )
        {
            //If folder is a valid POS Project Folder. Then terminate the setup. 
            $setup         = false;
            $setup_status  = 'pos_exists';  
            $setupLog[]    = "Valid POS Exists.";             
        } 
        else 
        {
            //=====================================
            //POS Not Exists as the same name.
            //=====================================
            
            //Get pos lavel folder list.
            $ExistRootDirectory = $objapp->getExistRootDirectory();
            //Check pos name folder is exists in the project folder list.
            if(in_array($subdomain, $ExistRootDirectory) )
            {
                $setupLog[] = "The folder name <i><q>$subdomain</q></i> is already exists.";
                //Check Exist folder is pos project folder or not.
                $setupLog[] = "The folder <i><q>$subdomain</q></i> does not belong to any POS project.";
                //Delete the folder is not the POS Project folder.                        
                if( $objMerchant->deletePOSProject('../posmerchants/' . $subdomain))
                {
                    $setupLog[] = "The folder <i><q>$subdomain</q></i> has been Deleted.";
                    //if delete the folder, then set setup status true to continue.
                } else {
                     $setupLog[] = "<span class='text-danger'>The folder <i><q>$subdomain</q></i> dose not deleted.</span>";
                }
            }//end if.

            //Get CP Sub-Domain List.     
            $listSubdomain = $objMerchant->cp_subdomainList();
            //Check the pos name is exists in the subdomain list.
            if(in_array($subdomain, $listSubdomain['list']) )                  
            {
                $setupLog[] = "The subdomain <i><q>".$subdomain.".".CP_HOST."</q></i> is already exists.";
                $setupLog[] = "The subdomain <i><q>".$subdomain.".".CP_HOST."</q></i> does not belong to any POS project.";
                //Delete the subdomain if it exists in list.
                $response = $objMerchant->cp_delsubdomain($subdomain);
                                    
                $setupLog[] = $response['msg'];
                                    
            }//end if.
            
            //Get Merchant POS Setup DB Configuration Details. 
            $dbData = $objMerchant->getDbConfig($subdomain , $id);
                                    
            //If Pos Setup log exists, then check dbname & username is valid or not.
            if(isset($dbData['id']) && $dbData['id'] > 0) 
            {
                $databasename = $dbData['db_name'];
                $databaseuser = $dbData['db_user'];
                $isvalidDb = false;
                
                //Get CP Database List.
                $CP_DBList = $objMerchant->cp_getDBList();
                //Check DB name is exists in Database list.
                if(in_array($databasename, $CP_DBList)) {
                    //Check DB dose belong to any POS Project. 
                    if(!$objMerchant->is_valid_pos_db($databasename)) {               
                       //Delete database if dose not belongs to any POS Project.
                       $response_deldb = $objMerchant->cp_deldb($databasename);
                       $setup  = ($response_deldb['status'] == 'SUCCESS') ? true : false;
                       //Set Delete Message.
                       $setupLog[] = str_replace( $prefix.'_', '', $response_deldb['msg']); 
                    }//else.
                }//end if.
                                    
                //Check DB User Is Exists Or Not.
                if($objMerchant->cp_dbUserExists($databaseuser)) 
                {
                    //Check DB Username dose belongs to any POS Project. 
                    if(!$objMerchant->is_valid_pos_dbuser($databaseuser)){              
                         //Delete db user if dose not belongs to any pos Projects.
                        $result_deldbU = $objMerchant->cp_deleteDbUser($databaseuser); 
                        $setup  = ($result_deldbU['status'] == 'SUCCESS') ? true : false; 
                        //Set Delete message
                        $setupLog[] = str_replace( $prefix.'_', '', $result_deldbU['msg']);
                    }//end else.
                }//end if.
                
                //Reset log database name & username if allready exists & valid.
               $reset =  $objMerchant->cp_resetDbConfig($subdomain , $id);
               if($reset) {
                  $setupLog[] = "Merchant POS Db configuration details has been reset.";
               } else {
                  $setupLog[] = "<span class='text-danger'>Merchant POS Db configuration dose not reset.</div>";
               }
            }//end if. 
           
            if($setup === true) {
                $setupLog[] = "The POS <i><q>$subdomain</q></i> is ready to generate web url.";
            }
            
        }//end else.            
                                    
}
 
$projectDataPath = $objMerchant->getPosZipDetails($merchantsData['type']);   

if($_REQUEST['action']=="setup"){
    
   $runSetup    = true;    
   $step        = $_REQUEST['step'];
   $id          = $_REQUEST['id'];
   $subdomain   = $_REQUEST['subdomain'];
   $uploadSampleDataDump   = $_REQUEST['sampledata'];
   
   $setupdata =  getSetupStatus($id , $subdomain);
   
   //Get POS Project ZIP & Database SQL File Name
    if(is_numeric($merchantsData['type'])){     
        $projectDataPath = $objMerchant->getPosZipDetails($merchantsData['type']); 
        
        $setupdata['current_pos_version'] = $projectDataPath['pos_version'];
        $setupdata['current_sql_version'] = $projectDataPath['sql_version'];
    } else {    
        $projectDataPath['pos_project_zip']     = DEFAULT_POS_PROJECT_ZIP;
        $projectDataPath['pos_database_file']   = DEFAULT_POS_SQL;
        $projectDataPath['pos_images_zip_file'] = '';
    }
    
  
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Simply POS | Generator</title>
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
        Merchant <small>POS Generator</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Merchant</a></li>
        <li class="active">POS Generator</li>
      </ol>
    </section>
  
    <!-- Main content -->
    <section class="content">
      <div class="row">
          <div class="col-xs-12">
          <div class="box">
             
            <!-- /.box-header -->
            <div class="box-body" style="min-height:430px;">
                <div id="pos_merchant_details">
                    <!-- Widget: Merchant Details -->
                    <div class="box-widget widget-user-2">
                        <div class="row"> 
                            <div class="col-sm-12 col-xs-12 table-responsive">                                
                                <table class="table table-bordered">
                                    <tr>
                                        <th>#</th>
                                        <th>Merchant Name</th>
                                        <th>Merchant Type</th>
                                        <th>Mobile</th>
                                        <th>Business Name</th>
                                        <th>POS Name</th>
                                        <th>POS Url</th>
                                        <th>POS Status</th>
                                    </tr>
                                    <tr>
                                        <td>#<?php echo $merchantsData['id']?></td>
                                        <td><?php echo $merchantsData['name']?></td>
                                        <td><?php echo $objMerchant->merchantTypes[$merchantsData['type']] ?></td>
                                        <td><?php echo $merchantsData['phone']?></td>
                                        <td><?php echo $merchantsData['business_name']?></td>
                                        <td><?php echo $merchantsData['pos_name']?></td>
                                        <td><?php echo $merchantsData['pos_url']?></td>
                                        <td class="text-center"><span class=" badge <?php echo $STATUS = ($merchantsData['pos_status']=='pending') ? 'bg-primary' : 'bg-success'; ?> "><?php echo $merchantsData['pos_status']?></span></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        
                        <?php if($_REQUEST['action'] != "setup") { ?>
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <?php
                            if($setup == true)
                            {
                                  if(is_array($setupLog)){
                                      $alertmsg = join('<br/>', $setupLog);
                                      echo "<div class='alert alert-info'>$alertmsg</div>";
                                  }
                            ?>
                        <div class="text-center">
                            <a href="<?php echo "pos_generator.php?id=$id"; ?>" class="btn btn-warning btn-lg">Cancel Setup</a>&nbsp;&nbsp;
                            <a href="<?php echo "pos_generator.php?action=setup&id=$id&sampledata=$setSampleProducts&step=1&subdomain=$subdomain"; ?>" class="btn btn-success btn-lg">Run Setup</a>
                        </div>
                           <?php      
                            }
                        ?>
                        <?php 
                            if($setup === false) 
                            {
                                echo ' <div class="alert alert-danger ">'; 
                                
                                   switch ($setup_status) {
                                       
                                       case 'subdomain_exists':

                                           echo "POS url <i><q>$subdomain</q></i> already exists.<br/>";
                                           echo "Please try with another url to generate POS Setup.";

                                           break;

                                       case 'pos_exists':

                                           echo "POS name <i><q>$subdomain</q></i> may already used or reserved.<br/>";
                                           echo "Please try with another POS name to generate POS Weblink.";

                                           break;
                                       
                                        case 'pos_assigned':

                                           echo "POS is already generated for the merchant.<br/>";
                                           echo "POS already generated for the same merchant.";

                                           break;

                                        case 'invalid_url':

                                            echo "Sorry! Invalid POS URL Format.<br/>";
                                            echo "POS URL should be only lowercase letter, number & between 3 to 20 charectors.<br/>";
                                            echo "Space, Special characters or Symbols are not allowed.";
                                           break;

                                   }
                                
                                echo '</div>';                             
                            }//end if.
                          
                        if($setup == '') 
                        {
                            $posurl =  (isset($_REQUEST['subdomain'])) ? $_REQUEST['subdomain'] : str_replace(' ', '' ,strtolower($merchantsData['pos_name']));
                            
                            if($merchantsData['pos_status'] == 'pending') {
                        ?><form method="post" name="generatepos" class=" bg-gray-light">
                            <div class="col-sm-11 col-sm-offset-1 border-radius">
                                <input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>" />
                                <input type="hidden" name="action" value="generate_pos" />
                                <div class="row form-group">
                                    <div class="col-sm-3"><h4 class="pull-right">POS Url: </h4></div>
                                    <div class="input-group col-sm-6">
                                        <span class="input-group-addon bg-gray-light" style="background-color: #ccc;"><h4 style="color: #000;">https://</h4></span>                                        
                                        <input type="text" name="subdomain" class="form-control" id="pos_generate_subdomain" value="<?php echo $posurl; ?>" required="required" maxlength="20" style="font-size:20px !important; height:54px;" placeholder="POS WEB URL" />
                                        <span class="input-group-addon bg-gray-light" style="background-color: #ccc;"><h4 style="color: #000;">.<?php echo $hostName;?></h4></span>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-3"><h4 class="pull-right">Upload Sample Products: </h4></div>
                                    <div class="col-lg-2">
                                        <div class="input-group border-grey">
                                            <label>
                                                <span class="input-group-addon">
                                                    <input type="radio" name="sample_products" required="required" value="1" aria-label="Checkbox for following text input">
                                                </span>
                                                <span class="input-group-addon">Yes</span>       
                                            </label>                                    
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="input-group">
                                            <label>
                                                <span class="input-group-addon">
                                                  <input type="radio" name="sample_products" required="required" value="0" aria-label="Checkbox for following text input">
                                                </span>
                                                <span class="input-group-addon">No</span>
                                            </label>
                                        </div>
                                    </div>                                                                           
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-4 col-sm-offset-4">
                                        <button type="submit" id="generate_pos_btn" class="btn btn-primary" > Generate POS</button>
                                    </div> 
                                </div>
                            </div>
                            </form>
                                    <br/>
                    <?php 
                                }//end if.
                            }//end if.
                    
                        } ?>
                       
                    
                    <?php
                        if($_REQUEST['action']=="setup") :
                            
                           // exit('Testing Unique Url.');
                    ?>
                        <div class="row">
                            
                            <?php if($_REQUEST['step'] != 7){ ?>
                            <div class="col-sm-6">
                               
                                <h2>POS Setup Steps:</h2>
                                <ol>
                                    <li>Create Pos Directory <span class="pull-right" id="progress_step_1"></span></li>
                                    <li>Generate Database <span class="pull-right" id="progress_step_2"></span></li>
                                    <li>Import Sample Data <span class="pull-right" id="progress_step_3"></span></li>
                                    <li>Setup POS Project <span class="pull-right" id="progress_step_4"></span></li>                                    
                                    <li>Setup Configuration <span class="pull-right" id="progress_step_6"></span></li>
                                    <li>Setup Merchant Login <span class="pull-right" id="progress_step_6"></span></li>
                                    <li>Finish Setup <span class="pull-right" id="progress_step_finish"></span></li>
                                </ol>
                               
                            </div>
                            <?php } ?>
                            <div class="col-sm-6" id="pos_result">
                               <?php 
                                 
                                 if(trim($setupdata['status']) != '' && $_REQUEST['step'] < 7) {
                               ?>
                                <div class="alert alert-success">
                                    <ol>
                                        <?php echo htmlspecialchars_decode($setupdata['status']); ?>
                                    </ol>
                                </div>
                                 <?php 
                                 
                                 }//end if 
                                 
                                if($_REQUEST['step'] == 7){
                                        
                                   $ProjectBaseURL = $setupdata['pos_url'];
                                    
                                   $setmerchantPos = setPosToMerchant($setupdata);
                                   
                                   if($setmerchantPos) {
                                       
                                       $merchantsInfo  = $objMerchant->get($_REQUEST['id']);
                                       
                                        extract($merchantsInfo);
                                       
                                        $sms_text = "Your SimplyPOS web link ($pos_url) successfully created. Please login with your credentials.";
                                       
                                        $objapp->SendSMS($merchantsInfo['phone'], $sms_text);
                                       
                                        $mailBody = "<div style='font-family:arial; font-size:14px; text-align:left;'>
                                                        <h2 style='font-family:arial; font-size:18px; text-align:left;'>Dear Customer</h2><br/>
                                                        <p style='font-family:arial; font-size:14px; text-align:left;'>Welcome to Simply POS! Your request for complimentary Simply POS trial has been approved. We appreciate and thank you for your confidence in us, we will make every effort to ensure Simply POS meets your business needs.</p>
                                                         <br/><br/>
                                                        <div style='font-family:arial; font-size:14px; text-align:left;'>Your login credentials will remain the same as filled at the time of registration. </div>
                                                        <br/><br/>
                                                        <p style='font-family:arial; font-size:14px; text-align:left;'>Please find your POS URL below which can be accessed from any device, you can also download the App from the play store which can be installed in any Smartphone or Tablet.</p>
                                                        <br/><br/>
                                                        <table style='border:0; font-family:arial; font-size:14px; text-align:left;' cellspacing='5px' cellpadding='5px' >
                                                            <tr><td>POS WEB URL:</td><td><a href='$pos_url' >$pos_url</a></td></tr>                                                
                                                        </table>
                                                        <br/><br/>
                                                        <p>The entire team looks forward working with you to make this partnership successful.</p>
                                                        <br/><br/><br/>
                                                        <p style='font-family:arial; font-size:16px; text-align:left;'>Thanks/Regards<br/>Simply Safe POS team</p>
                                                    </div>";
                                       
                                        $mailData['to_name']    = $name;
                                        $mailData['to']         = $email;
                                        $mailData['from']       = EMAIL_FROM;
                                        $mailData['from_name']  = EMAIL_FROM_NAME;
                                        $mailData['reply']      = REPLY_EMAIL;
                                        $mailData['reply_name'] = REPLY_NAME;

                                        $mailData['subject']    = 'POS web link generated';
                                        $mailData['body']       = $mailBody;
                                        
                                        if(!empty($email)) {
                                        //If Mail send to customer. send mail to POS
                                            if( $objMerchant->appCommon->sendMail( $mailData )) :

                                                echo '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> POS web link generated successfully. POS link has been sent to merchant.</div>';

                                                echo "<div class='text-center'><a href='$ProjectBaseURL' target='_blank' class='btn btn-danger btn-lg' style='text-decoration:none;'><i class='fa fa-globe'></i> Visit POS </a></div>";

                                            endif;  
                                        } else {
                                            
                                            echo '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> POS web link generated successfully. Link could not sent to merchant.</div>';

                                            echo "<div class='text-center'><a href='".$ProjectBaseURL."login' target='_blank' class='btn btn-danger btn-lg' style='text-decoration:none;'><i class='fa fa-globe'></i> Visit POS </a></div>";

                                        }
                                   }
                                }
                                 
                                if($runSetup === true && $_REQUEST['step'] <= 6 && $merchantsData['pos_status'] == 'pending') {
                                    
                                   
                                   include_once('setup.php');
                                    
                                } 
                                
                            ?>
                                
                            </div>
                             <?php if($_REQUEST['step'] == 7){ ?>
                            <div class="col-sm-6">
                                <table class="table">                                   
                                    <tr>
                                        <td>Web Link</td>  
                                        <td><?php echo $ProjectBaseURL;?></td>  
                                    </tr>
                                    <tr>
                                        <td>POS Status</td>  
                                        <td>Created</td>  
                                    </tr>
                                    <tr>
                                        <td>Active Package</td>  
                                        <td>Free Trial</td>  
                                    </tr>
                                    <tr>
                                        <td>Expiry Date</td>  
                                        <td><?php echo $objapp->DateTimeFormat($pos_demo_expiry_at , 'jS F Y');?></td>  
                                    </tr>
                                </table> 
                                <div class="text-center"><a href="merchants.php" class="btn btn-info"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back To Merchant List</a></div>
                            </div> 
                            <?php } ?>
                        </div>
                            
                <?php endif; ?>
                       </div>
                    </div>
                    <!-- /.Merchant Details  -->
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
  
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.0 -->
<script src="plugins/jQuery/jQuery-2.2.0.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
 
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
    
    $("#btn_next_step_4 a").click(function(){
         $("#btn_next_step_4").html("<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>");
    });
    
    $("#btn_next_step_5 a").click(function(){
         $("#btn_next_step_5").html("<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>");
    });
    
    $("#btn_next_step_6 a").click(function(){
         $("#btn_next_step_6").html("<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>");
    });
    
    $("#btn_next_step_7 a").click(function(){
         $("#btn_next_step_7").html("<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>");
    });
    
}); 

</script>
</body>
</html>
