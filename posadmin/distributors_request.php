<?php
include_once('application_main.php');
include_once('session.php');

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Simply POS | Distributors Request</title>
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
      <h1> Distributor <small>Requests</small> </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Distributor</a></li>
        <li class="active">Requests</li>
      </ol>
    </section> 
    <!-- Main content -->
<div class="modal fade " id="myModalLoader" role="dialog">
    <div class="modal-dialog">
         <div class="modal-content" id="loder">
            <div class='overlay'><i class='fa fa-refresh fa-spin'></i> Please Wait....</div>
         </div>
    </div>
</div>
<!-- Start Modal -->
<div class="modal fade " id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" id="myModalContent">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <i class="fa fa-close"></i>
                </button>
                <h4 class="modal-title reqval" id="myModalTitle">Request Title Will Display Here</h4>
            </div>
            <div class="modal-body" id="myModalBody">
                <div class="row form-horizontal request_details">
                    <div class="col-sm-10 col-sm-offset-1">
                    <table class="table table-bordered">
                        <tr><th>Request ID</th><td class="id reqval"></td></tr>
                        <tr><th>Request Status</th><td class="request_status reqval"></td></tr>
                        <tr><th>Distributor</th><td class="distributor_name reqval"></td></tr>
                        <tr><th>Merchant</th><td class="business_name reqval"></td></tr>
                        <tr><th>POS Name</th><td class="pos_name reqval"></td></tr>
                        <tr><th>Request At</th><td class="request_at reqval"></td></tr>
                        <tr><th>Request Details</th><td class="distributor_comments reqval"></td></tr>
                        <tr class="hide-reply"><th>Replay At</th><td class="replay_at reqval"></td></tr>                            
                        <tr class="hide-reply"><th>Request Handled By</th><td class="request_handler_name reqval"></td></tr>
                        <tr class="hide-reply"><th>Admin Comment</th><td class="admin_comment reqval"></td></tr>
                    </table>
                    </div>
                </div>
                <div class="row form-horizontal">                  
                    <div class="col-sm-10 col-sm-offset-1 col-xs-12 request_status_update">
                        <input type="hidden" name="formAction" id="formAction" />
                        <input type="hidden" name="update_id" id="update_id" />
                        <div id="action_msg"></div>
                        <div class="form-group">
                          <label for="is_disrtibuter" class="col-sm-4 control-label"><span class="text-danger">*</span> New Status</label>
                          <div class="col-sm-8">
                              <input type="hidden" id="current_request_status" />
                            <select name="request_status" id="request_status" required="required" class="form-control" >
                                <option value="">--Change Request Status--</option>
                                <option value="pending">Pending</option> 
                                <option value="completed">Completed</option>
                                <option value="hold">On Hold</option>
                                <option value="rejected">Rejected</option>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Admin Comment</label>
                          <div class="col-sm-8">
                              <textarea name="admin_comment" class="form-control" id="admin_comment" placeholder="Enter Comments"></textarea>
                          </div>
                        </div>            
                    </div>                     
                    <!-- /.box-body -->
                    <div class="row">
                        <div class="box-footer col-sm-10 col-sm-offset-1 col-xs-12 text-center " id="myModalFooter">
                            <button type="button" id="myModalSubmit" class="btn btn-success request_status_update">Submit</button>
                            <button type="button" id="myModalClose" class="btn btn-danger" data-dismiss="modal">Close</button>
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
            <input type="hidden" name="masterTable" id="masterTable" value="<?php echo TABLE_DISTRIBUTORS_REQUEST;?>" />
            <input type="hidden" name="id_filed" id="id_filed" value="id" />
            <input type="hidden" name="classLibrary" id="classLibrary" value="distributors" />
            <input type="hidden" name="record_sort_by" id="record_sort_by" value="request_status-pending" /> 
            <input type="hidden" name="result_type" id="result_type" value="filter" />
            <div class="box-body" id="requestlist">Please Wait! List will display here!</div>
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
    
    //Action Edit Record
    $('#myModalSubmit').click(function(){         
        
        var formAction      = $('#formAction').val();
        var current_request_status  = $('#current_request_status').val();
        var request_status  = $('#request_status').val();
        var admin_comment   = $('#admin_comment').val();
        var request_id      = $("#update_id").val();
        
        var validate = true;
        var validationMsg = '<ul class="alert alert-danger list">';
        
        if(request_status == '' || request_status == 'pending' || current_request_status == request_status){            
            validationMsg = validationMsg + '<li><i class="fa fa-check" ></i> Please change request status.</li>';
            validate = false;
        }
        
//        if(admin_comment == ''){            
//            validationMsg = validationMsg + '<li><i class="fa fa-check" ></i> Comments is required.</li>';
//            validate = false;
//        }  
        
        if(validate == false){ 
             
            validationMsg = validationMsg + '</ul>';
             
            $('#action_msg').html(validationMsg);
            
        } else {
            
           var suscessMsg = '';
            
           var  postData = 'library=distributors';
                postData = postData + '&request_status='    + request_status;
                postData = postData + '&admin_comment='     + admin_comment;
                postData = postData + '&id='                + request_id; 
            
            if(formAction == 'reply'){                
                postData = postData + '&action=request_update';
                suscessMsg = ' Request updated successfully.';                  
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
                                    $('#action_msg').html('<div class="alert alert-success"><i class="fa fa-check" ></i> '+suscessMsg+'</div>'); 
                                   // $('.form-control').val('');
                                    viewDataList(1);
                                }  
                             
//                            setTimeout(function(){
//                                 $('#action_msg').hide();                                 
//                                 $('#action_msg').html('');                                 
//                            }, 5000);
                            
                         }, 2000);
                    }
                });
                
        }//end else
        
    });
    //End Action Edit Record
    
});

function viewDataList( page ) {
    
    var result_type         = $('#result_type').val();
    var per_page_records    = (!$('#per_page_records').val()) ? 20 : $('#per_page_records').val();
    var pageno              = page;
    
    var postData = 'action=requestList';
        postData = postData + '&library=distributors';
        postData = postData + '&result_type=' + result_type;
        postData = postData + '&perpage=' + per_page_records;
        postData = postData + '&page=' + pageno;       
  
    if(result_type == 'filter') {        
        //var record_filter_by    = $('#record_filter_by').val();      
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
                $('#requestlist').html("<div class='text-center'><img src='images/ajax-loader.gif' alt='loading...' class='center' /></div>");
            },
            success: function(TableData){
               
                $('#requestlist').html(TableData); 
                
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
