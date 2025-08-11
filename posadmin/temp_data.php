<?php

include_once('application_main.php');
include_once('session.php');

include_once 'xmlapi.php';

$objMerchant = new merchant;
                
$objMerchant->SetCPObject();
$POS_PATH = '../';
 
if(isset($_POST['CmdClean'])){
    
    if(count($_POST['chkSelect']) > 0) {
        
        foreach ($_POST['chkSelect'] as $key => $recordStr) {
           
            $recordArr =  explode('~', $recordStr);
          
            if($recordArr[0]==''){
                $pos_url        = $recordArr[1] . '.simplypos.in';
            } else {
                $pos_url        = $recordArr[0] . '.simplypos.in';
            }
            
            $pos_directory  = $recordArr[1];
            
            if(!empty($pos_url)) {
                $result_delssl = $objMerchant->cp_deleteSSL($pos_url);
            }
            
            if(!empty($recordArr[0])) {
                
                $result_sd = $objMerchant->cp_delsubdomain($pos_url);  

                if($result_sd['status'] == 'SUCCESS') {
                    $delSubDomains[] = $pos_url;
                } else {
                     $error[] = '<div class="alert alert-danger">Subdomain '.$pos_url.' could not delete</div>';
                }
            }

            if(!empty($recordArr[2])) {
                $pos_dbname     = $recordArr[2];
                $result_sd = $objMerchant->cp_deldb($pos_dbname);  

                if($result_sd['status'] == 'SUCCESS') {
                    $delDB[] = $pos_dbname;
                } else {
                    $error[] = '<div class="alert alert-danger">Database '.$pos_dbname.' could not delete</div>';
                }
            }
            
            if(!empty($recordArr[3])) {
                $pos_dbusername = $recordArr[3];
                $result_sd = $objMerchant->cp_deluser($pos_dbusername);  

                if($result_sd['status'] == 'ERROR ') {
                    $error[] = '<div class="alert alert-danger">'.$result_sd['msg'].'</div>';
                } else {
                    $delUserDB[] = $pos_dbusername;
                }
            }
            
            if($pos_directory != '') {
                if(file_exists($POS_PATH . $pos_directory)  && is_dir($POS_PATH . $pos_directory)){

                   if( $objMerchant->deletePOSProject($POS_PATH . $pos_directory ) ){
                      $delDir[] = $pos_directory;
                   } else {
                       $error[] = '<div class="alert alert-danger">Project '.$pos_directory.' could not delete</div>';
                   }
                } else {                    
                   $error[] =  '<div class="alert alert-danger">'.$POS_PATH . $pos_directory . ' Project Directory Not Exists. </div>';
                }
            } else {
                 $error[] = '<div class="alert alert-danger">'. $POS_PATH . $pos_directory . ' Project Directory Not Found. </div>';
            }
          
        }//end foreach        
    }//end if  
    else
    {
        $error[] = '<div class="alert alert-danger">You have not selected any records. Please select records.</div>';
    }
}//end if

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Simply POS | POS Temp Data</title>
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
        POS Scraps <small>List</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">POS Scrap Data</a></li>
        <li class="active">List</li>
      </ol>
    </section> 
    <!-- Main content -->
    
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">            
            <!-- /.box-header -->
            
            <div class="box-body"  id="datalist"> 
            <?php 
               
               if(!isset($_POST['CmdClean'])) {
                   
                    include_once 'ajax_request/pos_temp_list.php';
                    
               } else {
                   
                    if(count($delSubDomains) > 0) { 
                        echo  "<div class='alert alert-success'>Subdomains (".join(', ', $delSubDomains).") Deleted Successfully.</div>";                  
                    } 

                    if(count($delDir) > 0) { 
                         echo  "<div class='alert alert-success'>Directory (".join(', ', $delDir).") Deleted Successfully.</div>";                  
                    }

                    if(count($delDB) > 0) { 
                         echo  "<div class='alert alert-success'>Database (".join(', ', $delDB).") Deleted Successfully.</div>";                  
                    }
                    
                    if(count($delUserDB) > 0) { 
                         echo  "<div class='alert alert-success'>Database User (".join(', ', $delUserDB).") Deleted Successfully.</div>";                  
                    }

                    if(count($error) > 0) { 
                         echo  join(' ', $error);                  
                    }
                   
                   echo '<br/><br/><div class="text-center"><a href="temp_data.php" class="btn btn-warning btn-md">Continue..</a></div>';
               }
                ?>
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
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- page script -->
<script>
  $(function () {
     
    $('#datatableScraps').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true
    });
  });
</script>

</body>
</html>
