<?php

include_once('application_main.php');
include_once('session.php');

$objMerchant = new merchant($conn);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Simply POS | Developer POS Project Management</title>
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
        POS Project <small>List</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">POS Project</a></li>
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
                    <div class=" col-sm-10 col-sm-offset-1 col-xs-12">
                        <input type="hidden" name="formAction" id="formAction" value="insert" />
                        <input type="hidden" name="update_id" id="update_id" />
                        <div id="action_msg"></div>
                        <div class="form-group">
                          <label for="title" class="col-sm-4 control-label"><span class="text-danger">*</span> Project Group</label>
                          <div class="col-sm-8">
                              <select class="form-control" id="project_group" name="project_group" required="required">
                                  <option value="">--Select One--</option>
                                <?php
                                                                    
                                    $projectsGroup = $objMerchant->projectGroups;

                                    if(is_array($projectsGroup)){

                                       $pselected = '';

                                        foreach($projectsGroup as $pid => $project) 
                                        {
                                            if($project_id == $pid) {
                                                $pselected = ' selected="selected"'; 
                                            }
                                            echo '<option value="'.$pid.'" '. $pselected.'>'.$project.'</option>';
                                        }//end foreach.
                                    }//
                                ?>
                              </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="title" class="col-sm-4 control-label"><span class="text-danger">*</span> POS Project Title</label>
                          <div class="col-sm-8">
                              <input type="text" class="form-control" id="title" name="title" required="required" data-format="requared|alfa-dash" placeholder="Project Title" />
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="project_file" class="col-sm-4 control-label"><span class="text-danger">*</span> Project Zip File Name</label>
                          <div class="col-sm-8">
                              <input type="text" class="form-control" id="project_file" name="project_file" required="required" data-format="requared|alfa-dash" placeholder="Project Zip File Name" />
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="version" class="col-sm-4 control-label"><span class="text-danger">*</span> Project Zip File Version</label>
                          <div class="col-sm-8">
                              <input type="text" class="form-control" id="version" name="version" required="required" data-format="requared|alfa-dash" placeholder="Project Zip File Version" />
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
            <input type="hidden" name="masterTable" id="masterTable" value="<?php echo TABLE_POS_PROJECT;?>" />
            <input type="hidden" name="id_filed" id="id_filed" value="id" />
            <input type="hidden" name="classLibrary" id="classLibrary" value="pos_project_zip" />
            <input type="hidden" name="record_sort_by" id="record_sort_by" value="all" /> 
            <input type="hidden" name="result_type" id="result_type" value="filter" />
            <div class="box-body"  id="datalist"> 
                
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
 
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- page script -->
<script>
    
var classLibrary = $('#classLibrary').val();
    
$(document).ready(function(){
    
    viewDataList(1);
    
    //Action Edit Record
    $('#myModalSubmit').click(function(){         
        
        var formAction      = $('#formAction').val();
        var project_group   = $('#project_group').val();       
        var title           = $('#title').val();       
        var project_file    = $("#project_file").val();
        var version         = $("#version").val();
        var is_validate = true;
        var validate_msg = '';
        
        if(project_group == ''){            
            validate_msg = validate_msg + '<li><i class="fa fa-check" ></i> Project Group is required.</li>';
            is_validate = false;
        }
        if(title == ''){            
            validate_msg = validate_msg + '<li><i class="fa fa-check" ></i> Project Title is required.</li>';
            is_validate = false;
        }
        if(project_file == ''){            
            validate_msg = validate_msg + '<li><i class="fa fa-check" ></i> Project File Name is required.</li>';
            is_validate = false;
        }
        if(version == ''){            
            validate_msg = validate_msg + '<li><i class="fa fa-check" ></i> Project Version is required.</li>';
            is_validate = false;
        } 
        

        if(is_validate == false)
        {
            $('#action_msg').html('<div class="alert alert-danger"><ul style="list-style:none;">'+validate_msg+'</ul></div>');
        }
        else 
        {
            
            if(formAction == 'insert'){
                
                var postData = 'action=insert';            
                    postData = postData + '&library=' + classLibrary;
                    postData = postData + '&project_group=' + project_group;
                    postData = postData + '&title=' + title;
                    postData = postData + '&project_file=' + project_file;
                    postData = postData + '&version=' + version;
                    
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
                                    
                                   $('#action_msg').html('<div class="alert alert-success"><i class="fa fa-check" ></i> Record Insert successfully.</div>'); 
                                   $('#merchant_type').val('');
                                   viewDataList(1);
                                   
                                   setTimeout(function(){  $('#myModal').modal('toggle');  }, 2000);
                                }  
                             
                            setTimeout(function(){
                                 $('#action_msg').hide();                                 
                                 $('#action_msg').html('');                                 
                            }, 5000);
                            
                         }, 2000);
                    }
                });
                
            }
            
            if(formAction == 'edit'){
                
                var postData = 'action=update';            
                    postData = postData + '&library=' + classLibrary;
                    postData = postData + '&id=' + $('#update_id').val();
                    postData = postData + '&project_group=' + project_group;
                    postData = postData + '&title=' + title;
                    postData = postData + '&project_file=' + project_file;
                    postData = postData + '&version=' + version;
                   
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
                                     
                                   viewDataList(1);
                                   
                                   setTimeout(function(){  $('#myModal').modal('toggle');  }, 2000);
                                }
                            
                         }, 1000);
                    }
                });
                
            }
            
        }
        
        
    });
    //End Action Edit Record
    
});


function viewDataList( page ){
    
    var result_type         = $('#result_type').val();
    var per_page_records    = (!$('#per_page_records').val()) ? 10 : $('#per_page_records').val();
    var pageno = page;      
    
    var postData = 'action=dataList';
        postData = postData + '&library=' + classLibrary;
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
