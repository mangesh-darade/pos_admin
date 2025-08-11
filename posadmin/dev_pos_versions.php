<?php

include_once('application_main.php');
include_once('session.php');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Simply POS | POS Version Management</title>
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
        POS Version <small>List</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">POS Version</a></li>
        <li class="active">List</li>
      </ol>
    </section> 
    <!-- Main content -->
    
<!-- Start Modal -->
<div class="modal fade " id="myModal" role="dialog">
    <div class="modal-dialog" style="width: 900px;">
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
                          <label for="version" class="col-sm-4 control-label"><span class="text-danger">*</span> POS Version</label>
                          <div class="col-sm-8">
                              <input type="text" class="form-control" id="version" name="version" required="required" data-format="requared|alfa-dash" placeholder="POS Version" />
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="project_id" class="col-sm-4 control-label"><span class="text-danger">*</span> Project Group</label>
                          <div class="col-sm-8">
                              <select name="project_id" id="project_id" class="form-control" required="required" >
                                  <option value="">--Select One--</option>
                                <?php
                                $objMerchant = new merchant($conn);
                                
                                $projectGroups = $objMerchant->projectGroups;

                                        if(is_array($projectGroups)){

                                           $gselected = '';

                                            foreach($projectGroups as $gid => $project) {
                                               if($priject_id == $gid) {
                                                  $gselected = ' selected="selected"'; 
                                               }
                                                echo '<option value="'.$gid.'" '. $gselected.'>'.$project.'</option>';
                                            }
                                        }
                                    ?>  
                              </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="relese_status" class="col-sm-4 control-label"><span class="text-danger">*</span> Release Status</label>
                          <div class="col-sm-8">
                              <select name="relese_status" id="relese_status" class="form-control" required="required" >
                                  <option value="">--Select One--</option>
                                  <option value="testing">Testing</option>
                                  <option value="alpha">Alpha</option>
                                  <option value="beta">Beta</option>
                                  <option value="thita">Thita</option>
                                  <option value="gama">Gama</option>
                                  <option value="stable">Stable</option>
                              </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="relese_type" class="col-sm-4 control-label"><span class="text-danger">*</span> Updates Type</label>
                          <div class="col-sm-8">
                              <select name="relese_type" id="relese_type" class="form-control" required="required" >
                                  <option value="minor">minor</option>
                                  <option value="major">major</option>
                              </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="upgread_sql" class="col-sm-4 control-label"><span class="text-danger">*</span> Have Database Changes</label>
                          <div class="col-sm-8">
                              <select name="upgread_sql" id="upgread_sql" class="form-control" required="required" >
                                  <option value="0">No</option>
                                  <option value="1">Yes</option>
                              </select>
                          </div>
                        </div>
                        <div class="form-group sql_file_field">
                          <label for="sql_file_path_up" class="col-sm-4 control-label"><span class="text-danger">*</span>Upgrade Sql File Path</label>
                          <div class="col-sm-8">
                              <input type="text" class="form-control" id="sql_file_path_up" name="sql_file_path_up" maxlength="250" required="required" data-format="requared|alfa-dash" placeholder="Database Upgrade Sql File Path" />
                          </div>
                        </div>
                        <div class="form-group sql_file_field">
                          <label for="sql_file_path_down" class="col-sm-4 control-label"><span class="text-danger">*</span>Rollback Sql File Path</label>
                          <div class="col-sm-8">
                              <input type="text" class="form-control" id="sql_file_path_down" name="sql_file_path_down" maxlength="250" required="required" data-format="requared|alfa-dash" placeholder="Rollback Sql File Path" />
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="project_code_path" class="col-sm-4 control-label"><span class="text-danger">*</span>Project Files Path  </label>
                          <div class="col-sm-8">
                              <input type="text" class="form-control" id="project_code_path" name="project_code_path" maxlength="250" required="required" data-format="requared|alfa-dash" placeholder="Updated Project Path" />
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="update_log_file_path" class="col-sm-4 control-label">Log File Path </label>
                          <div class="col-sm-8">
                              <input type="text" class="form-control" id="update_log_file_path" name="update_log_file_path" maxlength="250"  placeholder="Updated Log File Path" />
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
            <input type="hidden" name="masterTable" id="masterTable" value="<?php echo TABLE_POS_VERSIONS;?>" />
            <input type="hidden" name="id_filed" id="id_filed" value="id" />
            <input type="hidden" name="classLibrary" id="classLibrary" value="pos_versions" />
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
    resetForm();
    
    $('#upgread_sql').click(function(){
        
        if($(this).val() == 1) {
            $("#sql_file_path_up").removeAttr('disabled');
            $("#sql_file_path_down").removeAttr('disabled');
            $('.sql_file_field').show();
        } else {
            $("#sql_file_path_up").attr('disabled', 'disabled');
            $("#sql_file_path_down").attr('disabled', 'disabled');
            $('.sql_file_field').hide();
        }
    });
    
    
    //Action Edit Record
    $('#myModalSubmit').click(function(){         
        
        var formAction      = $('#formAction').val();        
        
        var version                 = $("#version").val();
        var relese_status           = $('#relese_status').val();       
        var relese_type             = $("#relese_type").val();
        var upgread_sql             = $("#upgread_sql").val();
        var project_code_path       = $("#project_code_path").val();
        var update_log_file_path    = $("#update_log_file_path").val();
        var project_id          = $("#project_id").val();
        
        if(upgread_sql == 1) 
        {
            var sql_file_path_up     = $("#sql_file_path_up").val();
            var sql_file_path_down   = $("#sql_file_path_down").val();
        }
        
        var is_validate = true;
        var validate_msg = '';
        
        if(version == ''){            
            validate_msg = validate_msg + '<li>Project Version is required.</li>';
            is_validate = false;
        }
        if(project_id == ''){            
            validate_msg = validate_msg + '<li>Project Group is required.</li>';
            is_validate = false;
        }
        if(relese_status == ''){            
            validate_msg = validate_msg + '<li>Version release status is required.</li>';
            is_validate = false;
        }
        if(relese_type == ''){            
            validate_msg = validate_msg + '<li>Version release type is required.</li>';
            is_validate = false;
        } 
        
        if(upgread_sql == 1) 
        {
            if(sql_file_path_up == ''){            
                validate_msg = validate_msg + '<li>Database upgrade sql file path is required.</li>';
                is_validate = false;
            }
            
            if(sql_file_path_down == ''){            
                validate_msg = validate_msg + '<li>Database rollback sql file path is required.</li>';
                is_validate = false;
            }
        }
                 
        if(project_code_path == ''){            
            validate_msg = validate_msg + '<li>Version updated project files path is required.</li>';
            is_validate = false;
        } 

        if(is_validate == false)
        {
            $('#action_msg').html('<div class="alert alert-danger"><ul>'+validate_msg+'</ul></div>');
        }
        else 
        {
            
            if(formAction == 'insert'){
                
                var postData = 'action=insert';            
                    postData = postData + '&library=' + classLibrary;
                    postData = postData + '&version=' + version;
                    postData = postData + '&project_id=' + project_id;
                    postData = postData + '&relese_status=' + relese_status;
                    postData = postData + '&relese_type=' + relese_type;
                    postData = postData + '&upgread_sql=' + upgread_sql;
                    postData = postData + '&project_code_path=' + project_code_path;
                    postData = postData + '&update_log_file_path=' + update_log_file_path;
                
                 if(upgread_sql == 1) {
                    postData = postData + '&sql_file_path_up=' + sql_file_path_up;
                    postData = postData + '&sql_file_path_down=' + sql_file_path_down;
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
                                    $('#action_msg').html('<div class="alert alert-danger"><i class="fa fa-check" ></i>' + obj.msg + '</div>'); 
                                } 
                                
                                if(obj.status=='SUCCESS'){ 
                                    
                                   $('#action_msg').html('<div class="alert alert-success"><i class="fa fa-check" ></i> Record Insert successfully.</div>'); 
                                   resetForm();
                                   viewDataList(1);
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
                    
                    postData = postData + '&version=' + version;
                    postData = postData + '&project_id=' + project_id;
                    postData = postData + '&relese_status=' + relese_status;
                    postData = postData + '&relese_type=' + relese_type;
                    postData = postData + '&upgread_sql=' + upgread_sql;
                    postData = postData + '&project_code_path=' + project_code_path;
                    postData = postData + '&update_log_file_path=' + update_log_file_path;
                
                 if(upgread_sql == 1) {
                    postData = postData + '&sql_file_path_up=' + sql_file_path_up;
                    postData = postData + '&sql_file_path_down=' + sql_file_path_down;
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
                                     
                                   viewDataList(1);
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

function resetForm(){
    
    $("#version").val('');
    $('#relese_status').val('alpha');       
    $("#relese_type").val('minor');
    $("#upgread_sql").val('0');
    $("#project_code_path").val('');
    $("#sql_file_path_up").val('');
    $("#sql_file_path_down").val('');
    $("#update_log_file_path").val('');
    
    $("#sql_file_path_up").attr('disabled', 'disabled');
    $("#sql_file_path_down").attr('disabled', 'disabled');
    $('.sql_file_field').hide();
}


</script>

</body>
</html>
