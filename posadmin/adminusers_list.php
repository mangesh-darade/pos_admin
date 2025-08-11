<?php
include_once('application_main.php');
include_once('session.php');

$objAdminUser = new adminUser;

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Simply POS | Admin Users List</title>
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
      <h1> Admin User <small>List</small> </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Admin User</a></li>
        <li class="active">List</li>
      </ol>
    </section> 
    <!-- Main content -->
    
<!-- Start Modal -->
<div class="modal fade " id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" id="myModalContent">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <i class="fa fa-close"></i>
                </button>
                <h4 class="modal-title" id="myModalTitle">Modal Title</h4>
            </div>
            <div class="modal-body" id="myModalBody">
                <div class="row form-horizontal">
                    <div id="action_msg"></div>
                    <div class="col-sm-10 col-sm-offset-1 col-xs-12 model-form">
                        <input type="hidden" name="formAction" id="formAction" value="insert" />
                        <input type="hidden" name="update_id" id="update_id" />
                        <input type="hidden" name="is_disrtibuter" id="is_disrtibuter" value="0" />
                        <input type="hidden" name="group" id="group" value="" />
                        
                        <div class="form-group">
                          <label for="group_id" class="col-sm-4 control-label"><span class="text-danger">*</span> User Type</label>
                          <div class="col-sm-8">
                                <select name="group_id" id="group_id" required="required" class="form-control" >
                                    <option value="" key="">--Select User Type--</option>
                            <?php
                              $userGroups = $objAdminUser->getUserGroups();
                              
                              if(is_array($userGroups)) {
                                  
                                  foreach ($userGroups as $key => $optionsArr) {
                                      if($optionsArr['id'] <= 2) continue;
                                      echo '<option value="'.$optionsArr['id'].'" key="'.$optionsArr['group_key'].'">'.$optionsArr['group_name'].'</option>';
                                  }
                              }
                            ?>                                    
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label"><span class="text-danger">*</span> Full Name</label>
                          <div class="col-sm-8">
                              <input type="text" name="display_name" id="display_name" required="required" maxlength="100"  class="form-control" />
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label"><span class="text-danger">*</span> Email id</label>
                          <div class="col-sm-8">
                              <input type="email" name="email_id" id="email_id" required="required" maxlength="60"  class="form-control" />
                          </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><span class="text-danger">*</span>  Mobile No</label>
                            <div class="col-sm-8">
                                <input type="text" name="mobile_no" id="mobile_no" required="required" maxlength="10"  class="form-control" />
                            </div>
                        </div>
                        <div class="form-group hide-update">
                            <label class="col-sm-4 control-label"><span class="text-danger">*</span> Username</label>
                            <div class="col-sm-8">
                                <input type="text" name="username" id="username" required="required" maxlength="15"  class="form-control" />
                            </div>
                        </div>                         
                    </div>                     
                    <!-- /.box-body -->
                    <div class="row">
                        <div class="box-footer col-sm-10 col-sm-offset-1 col-xs-12 " id="myModalFooter">                            
                            <button type="button" id="myModalClose" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="button" id="myModalSubmit" class="btn btn-primary">Save</button>
                        </div>
                    </div>         
                    <!-- /.box-footer -->
                 </div>
            </div>             
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- // End Modal -->    
    
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">            
            <!-- /.box-header -->
            <input type="hidden" name="masterTable" id="masterTable" value="<?php echo TABLE_ADMIN;?>" />
            <input type="hidden" name="id_filed" id="id_filed" value="user_id" />
            <input type="hidden" name="classLibrary" id="classLibrary" value="adminUser" />
            <input type="hidden" name="record_sort_by" id="record_sort_by" value="all" /> 
            <input type="hidden" name="result_type" id="result_type" value="filter" />
            <div class="box-body" id="datalist"></div>
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
 
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- page script -->
<script>
$(document).ready(function(){
     
    viewDataList(1);
        
    $('#group_id').change(function(){
        
       var group_key = $('option:selected', this).attr('key');
        $('#group').val(group_key);
        if($(this).val() == 5 || $(this).val() == 4) {
             $('#is_disrtibuter').val(1);
        } else {
            $('#is_disrtibuter').val(0);
        }
        
    });
    
    //Action Edit Record
    $('#myModalSubmit').click(function(){         
        
        var formAction      = $('#formAction').val();
        var is_disrtibuter    = $('#is_disrtibuter').val();
        var display_name    = $('#display_name').val();
        var email_id        = $("#email_id").val();
        var mobile_no       = $("#mobile_no").val();
        var username        = $("#username").val();
        var group           = $("#group").val();
        var group_id        = $("#group_id").val();
        
        var validate = true;
        var validationMsg = '<ul class="alert alert-danger list">';
        
        if(group_id == ''){            
            validationMsg = validationMsg + '<li><i class="fa fa-check" ></i> User type is required.</li>';
            validate = false;
        }
        
        if(display_name == ''){            
            validationMsg = validationMsg + '<li><i class="fa fa-check" ></i> Fullname is required.</li>';
            validate = false;
        } else {
            
            if(display_name.length < 3) {
                validationMsg = validationMsg + '<li><i class="fa fa-check" ></i> Fullname should be minimum 3 charectors.</li>';
                validate = false;
            }            
        }
        
        if(email_id == ''){            
            validationMsg = validationMsg + '<li><i class="fa fa-check"></i> Email is required.</li>';
            validate = false;
        } else {
            var isvalid = isValidEmail(email_id);
            if(!isvalid){
                validationMsg = validationMsg + '<li><i class="fa fa-check"></i> Email address should be valid.</li>';
                validate = false;
            }
        }
        
        if(mobile_no == ''){            
            validationMsg = validationMsg + '<li><i class="fa fa-check" ></i> Mobile number is required.</li>';
            validate = false;
        } else {
            
            var mobNum = mobile_no;
            var filter = /^\d*(?:\.\d{1,2})?$/;
            if (!filter.test(mobNum) || mobNum.length!=10) {
                validationMsg = validationMsg + '<li><i class="fa fa-check" ></i> Mobile number should be valid.</li>';
                validate = false;
            }
        } 
        
        if(formAction == 'insert'){ 
            if(username == '' ){            
                validationMsg = validationMsg + '<li><i class="fa fa-check" ></i> Username is required.</li>';
                validate = false;
            } else {            
               var isValid = validUsername(username);
               if(!isValid){
                    validationMsg = validationMsg + '<li><i class="fa fa-check" ></i> Username should only alphabates between 6 to 15 charectors.</li>';
                    validate = false;
               }           
            }
        }
        
        if(validate == false){ 
             
            validationMsg = validationMsg + '</ul>';
             
            $('#action_msg').html(validationMsg);
            
        } else {
            
           var suscessMsg = '';
            
           var  postData = 'library=adminUser';
                postData = postData + '&display_name='   + display_name;
                postData = postData + '&email_id='       + email_id;               
                postData = postData + '&mobile_no='      + mobile_no;
                postData = postData + '&is_disrtibuter=' + is_disrtibuter;            
                postData = postData + '&group_id=' + group_id;            
                postData = postData + '&group=' + group;          
                
               
            if(formAction == 'insert'){  
                postData = postData + '&username='       + username;
                postData =  postData + '&action=insert'; 
               // suscessMsg = ' Record Insert successfully.';                
            }
            
            if(formAction == 'edit'){  
            
                var update_id  = $("#update_id").val();
                
                postData = postData + '&action=update';
                postData = postData + '&update_id='+update_id;
               // suscessMsg = ' Record updated successfully.';                  
            }
                $('#action_msg').show();  
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
                                    $('#action_msg').html('<div class="alert alert-danger"><i class="fa fa-check" ></i>' + obj.msg + '</div>'); 
                                } 
                                
                                if(obj.status=='SUCCESS'){
                                    
                                    $('#action_msg').html('<div class="alert alert-success"><i class="fa fa-check" ></i> '+obj.msg +'</div>'); 
                                    $('.model-form').hide();
                                    $('#myModalSubmit').hide();
                                    
                                    viewDataList(1);
                                    
//                                    setTimeout(function(){
//                                        $('#myModal').modal('hide');
//                                    }, 7000);
                                }
                            
                         }, 2000);
                    }
                });
                
        }//end else
        
    });
    //End Action Edit Record
    
});


function viewDataList( page ){
    
    var result_type         = $('#result_type').val();
    var per_page_records    = (!$('#per_page_records').val()) ? 10 : $('#per_page_records').val();
    var pageno = page;      
    
    var postData = 'action=dataList';
        postData = postData + '&library=adminUser';
        postData = postData + '&result_type=' + result_type;
        postData = postData + '&perpage=' + per_page_records;
        postData = postData + '&page=' + pageno;       
       
       
    if(result_type == 'filter') {
        
        //var record_filter_by      = $('#record_filter_by').val();      
        var record_sort_by        = $('#record_sort_by').val();

        //postData = postData + '&filter=' + record_filter_by;
        postData = postData + '&sort=' + record_sort_by;       
    }
    
    if(result_type == 'search') {
        
        var searchKey = $('#search_key').val();         
         
        resetSort();
        resetFilter();

        postData = postData + '&search_key=' + searchKey;
    }
        
        
        $.ajax({
            type: "POST",
            url: "ajax_request/data_actions.php",
            data: postData,	
            beforeSend: function() {                    
                $('#datalist').html("<div class='text-center'><img src='images/ajax-loader.gif' alt='loading...' class='center' /></div>");
            },
            success: function(TableData){
                console.log(TableData);
                $('#datalist').html(TableData); 
                
                setTimeout(function(){ 
                      setSortBy(record_sort_by);
                }, 100);  
            }
        });
       
}

function setSortBy(id){
     
    var sortBySelected = $('#'+id).children('a').html();     
    $('#show_sort_by').html(sortBySelected);
}

</script>

</body>
</html>
