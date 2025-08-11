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
    elseif($_SESSION['login']['username'] != $username) {
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
  <title>Simply POS | Merchants</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous" />
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css" />
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
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


    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
            <div class="login-box">
   
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
<!-- bootstrap datepicker -->
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- SlimScroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- page script -->
<script src="merchants_script.js"></script> 

<script>
   
  $(function() {
    
     
    $('#example1').DataTable({
        "paging": false,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": true
    });
      
      //Action Edit Record
    $('#myModalSubmit').click(function() {         
        
        var formAction      = $('#formAction').val();
        var name            = $('#name').val();
        var email           = $("#email").val();
        var phone           = $("#phone").val();
        var country         = $("#country").val();
        
        var business_name   = $("#business_name").val();
        var pos_generate    = $("#pos_generate").val();
        
        if(pos_generate == 0) {
            var pos_name        = $("#pos_name").val();
            var merchant_type   = $("#merchant_type").val();
        }
        
        var address         = $("#address").val();
        var state           = $("#state").val();
        var city            = $("#city").val();
        var is_validate     = true;
        var validationError = '';
        
        if(name === '') {            
            validationError = validationError + '<li>Merchant name is required.</li>';
            is_validate = false;
        }
        
        if(country === ''){            
            validationError = validationError + '<li>Country is required.</li>';
            is_validate = false;
        }
        
      /*  if(phone == ''){            
            validationError = validationError + '<li>Merchant Mobile is required.</li>';
            is_validate = false;
        } else {
            if(isNaN(phone) || phone.length != 10)
            {
                validationError = validationError + '<li>Mobile number should be 10 digit numeric value.</li>';
                is_validate = false;
            }
        }*/
        
        if(merchant_type == '' && pos_generate == 0){            
            validationError = validationError + '<li>Merchant Type is required.</li>';
            is_validate = false;
        }
        
        if(business_name == ''){            
            validationError = validationError + '<li>Business Name is required.</li>';
            is_validate = false;
        } 
        
        if( is_validate == false )
        {
            $('#action_msg').html('<div class="alert alert-danger"><ul>'+validationError+'</ul><div>');
        }
        else
        { 
            
            if(formAction == 'edit'){
               
                var postData = 'action=update';            
                    postData = postData + '&library=merchant';
                    postData = postData + '&id=' + $('#update_id').val();
                    postData = postData + '&name=' + name;
                    postData = postData + '&email=' + email;
                    postData = postData + '&country=' + country;
                    postData = postData + '&phone=' + phone;
                    
                    postData = postData + '&business_name=' + business_name;
                    postData = postData + '&address=' + address;
                    postData = postData + '&state=' + state;
                    postData = postData + '&city=' + city;
                    postData = postData + '&pos_generate=' + pos_generate;
                    
                    if(pos_generate == 0 ) {
                        postData = postData + '&pos_name=' + pos_name;
                        postData = postData + '&type=' + merchant_type;
                    } 
                    
                $.ajax({
                    type: "POST",
                    url: "ajax_request/data_actions.php",
                    data: postData,	
                    beforeSend: function() {                    
                        $('#action_msg').html('<div class="alert alert-info"><i class="fa fa-refresh fa-spin" ></i> Please Wait! Data Is Processing...</div>');
                    },
                    success: function(jsonData){ 
                       
                         setTimeout(function(){
                             
                            var obj = $.parseJSON(jsonData);
                            
                                if(obj.status=='ERROR'){ 
                                    $('#action_msg').html('<div class="alert alert-danger"><i class="fa fa-check" ></i>'+ obj.msg +' </div>'); 
                                } 
                                
                                if(obj.status=='SUCCESS'){ 
                                    
                                   $('#action_msg').html('<div class="alert alert-success"><i class="fa fa-check" ></i> Record updated successfully.</div>'); 
                                     
                                   requestMerchantsList(1);
                                }
                            
                         }, 1000);
                    }
                });
                
            }
            
        }
        
        
    });
    //End Action Edit Record
    
        
    for(var p = 0; p <= 4 ; p++){
        $('#package_id-'+p).hide();
    }
        
        
    $('.tab-filter').click(function()
    {
            $('.tab-filter.btn-success').addClass('btn-default');
            $('.tab-filter.btn-success').removeClass('btn-success');
            $(this).addClass('btn-success');
            $(this).removeClass('btn-default');

            var filterBy = $(this).attr('id');
            $('#record_filter_by').val(filterBy);
            
            //If Filter Select Pending POS Disabled Sort Option by Package.
            if(filterBy == 'pos_generate-0'){                
                for(var p = 0; p <= 4 ; p++){
                    $('#package_id-'+p).hide();
                }
            } else {
                for(var p = 0; p <= 4 ; p++){
                    $('#package_id-'+p).show();
                }
            }
            
            //When select filter Deleted POS Disabled Sort Options.
            if(filterBy == 'is_delete-1'){
                
                $('#show_sort_by').html('all');
                $('#record_sort_by').val('all');
                $('#show_sort_by_type').html('all');
                $('#record_sort_by_type').val('all');
                
                $('#is_active-1').hide();
                $('#is_active-0').hide();
                //disabled
            } else {
                $('#is_active-1').show();
                $('#is_active-0').show();
            }
            
            $('#result_type').val('filter');
            requestMerchantsList(1);
            
        });
        

        $('ul.sort_by li').click(function(){

           var sortBySelected = $(this).children('a').html();
           var sortBy = $(this).attr('id');

           $('#show_sort_by').html(sortBySelected);
           $('#record_sort_by').val(sortBy);
           
           $('#result_type').val('filter');
           requestMerchantsList(1);

        });


        $('ul.sort_by_type li').click(function(){
        
            var sortByTypeSelected = $(this).children('a').html();
            var sortByType = $(this).attr('id');

            $('#show_sort_by_type').html(sortByTypeSelected);
            $('#record_sort_by_type').val(sortByType);
            
            $('#result_type').val('filter');            
              requestMerchantsList(1);
         });    
    
        requestMerchantsList(1);
        
       
       
    
       
  });
 
</script>



</body>
</html>
