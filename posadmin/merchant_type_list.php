<?php
include_once('application_main.php');
include_once('session.php');
 
$objMerchantType = new merchant_type();

$pos_project_list           = $objMerchantType->get_pos_project_list();
$pos_sample_database_list   = $objMerchantType->get_pos_sample_database_list();

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Simply POS | Merchant Type List</title>
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
        Merchant Type <small>List</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Merchant Type</a></li>
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
                          <label for="merchant_type" class="col-sm-4 control-label"><span class="text-danger">*</span> Merchant Type</label>
                          <div class="col-sm-8">
                              <input type="text" class="form-control" id="merchant_type" name="merchant_type" data-format="requared|alfa-dash" placeholder="Merchant Type" />
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">&nbsp;&nbsp;Display On Mobile</label>
                          <div class="col-sm-8">
                              <label class="col-sm-3"> <input type="radio" value="1" name="show_in_mobile" id="show_in_mobile" /> Yes</label>
                              <label class="col-sm-3"> <input type="radio" checked="checked" value="0" name="show_in_mobile" id="hide_in_mobile" /> No</label>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">&nbsp;&nbsp;Display On Website</label>
                          <div class="col-sm-8">
                              <label class="col-sm-3"> <input type="radio" checked="checked" value="1" name="show_in_web" id="show_in_web" /> Yes</label>
                              <label class="col-sm-3"> <input type="radio" value="0" name="show_in_web" id="hide_in_web" /> No</label>
                          </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">&nbsp;&nbsp;POS Generate</label>
                            <div class="col-sm-8">
                                <label class="col-sm-3"> <input type="radio" checked="checked" value="1" name="generate_pos" id="generate_pos" /> Yes</label>
                                <label class="col-sm-3"> <input type="radio" value="0" name="generate_pos" id="not_generate_pos" /> No</label>
                            </div>
                        </div>
                        <div class="form-group" id="form-control-pos-project">
                          <label for="pos_project" class="col-sm-4 control-label"><span class="text-danger">*</span> POS Project</label>
                          <div class="col-sm-8">                              
                              <select class="form-control" name="pos_project" id="pos_project" data-format="requared">                                  
                                  <?php
                                  if(is_array($pos_project_list))
                                  {
                                      $option ='';
                                      foreach ($pos_project_list as $key=>$pos_project) {
                                          $option = $pos_project['title'] . " (Ver: ".$pos_project['version'].")";
                                         echo '<option value="'.$key.'">'.$option.'</option>'; 
                                      }
                                  }
                                  ?>
                              </select>                             
                          </div>
                        </div>
                        <div class="form-group" id="form-control-pos-sample-data">
                          <label for="pos_sample_data" class="col-sm-4 control-label"><span class="text-danger">*</span> POS Sample Data</label>
                          <div class="col-sm-8">
                             
                              <select class="form-control" name="pos_sample_data" id="pos_sample_data" data-format="requared">
                                <?php
                                if(is_array($pos_sample_database_list))
                                {
                                    $option ='';
                                    foreach ($pos_sample_database_list as $key=>$pos_database) {
                                        $option = $pos_database['title'] . " (Ver: ".$pos_database['version'].")";
                                       echo '<option value="'.$key.'">'.$option.'</option>'; 
                                    }
                                }
                                ?>
                              </select>                             
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
            <input type="hidden" name="masterTable" id="masterTable" value="<?php echo TABLE_MERCHANT_TYPE;?>" />
            <input type="hidden" name="id_filed" id="id_filed" value="id" />
            <input type="hidden" name="classLibrary" id="classLibrary" value="merchant_type" />
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
$(document).ready(function(){
    
    viewDataList(1);
    
    $("input[name=generate_pos]").click(function(){       
        
       var posAccess = $(this).val();
       
        if(posAccess == 1) {
            $('#form-control-pos-project').show();
            $('#form-control-pos-sample-data').show();
        } else {
            $('#form-control-pos-project').hide();
            $('#form-control-pos-sample-data').hide();
        }
    });
    
    //Action Edit Record
    $('#myModalSubmit').click(function(){         
        
        var formAction       = $('#formAction').val();
        var merchant_type    = $('#merchant_type').val();
        var show_in_mobile   = $("input[name='show_in_mobile']:checked").val();
        var show_in_web      = $("input[name='show_in_web']:checked").val();
        var generate_pos     = $("input[name='generate_pos']:checked").val();
        var pos_project_id      = $("#pos_project").val();
        var pos_sample_data_id  = $("#pos_sample_data").val();
        
        if(merchant_type == ''){            
            $('#action_msg').html('<div class="alert alert-danger"><i class="fa fa-check" ></i> Merchant Type is required.</div>');
        } else {
            
            if(formAction == 'insert'){
                
                var postData = 'action=insert';            
                    postData = postData + '&library=merchant_type';
                    postData = postData + '&merchant_type=' + merchant_type;
                    postData = postData + '&show_in_mobile=' + show_in_mobile;
                    postData = postData + '&show_in_web=' + show_in_web;
                    postData = postData + '&generate_pos=' + generate_pos;
                    
                    if(generate_pos == 1) {
                        postData = postData + '&pos_project_id=' + pos_project_id;
                        postData = postData + '&pos_sample_data_id=' + pos_sample_data_id;
                    } else {
                        postData = postData + '&pos_project_id=0';
                        postData = postData + '&pos_sample_data_id=0';                    
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
                                   $('#merchant_type').val('');
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
                    postData = postData + '&library=merchant_type';
                    postData = postData + '&id=' + $('#update_id').val();
                    postData = postData + '&merchant_type=' + merchant_type;
                    postData = postData + '&show_in_mobile=' + show_in_mobile;
                    postData = postData + '&show_in_web=' + show_in_web;
                    postData = postData + '&generate_pos=' + generate_pos;
                    
                    if(generate_pos == 1) {
                        postData = postData + '&pos_project_id=' + pos_project_id;
                        postData = postData + '&pos_sample_data_id=' + pos_sample_data_id;
                    } else {
                        postData = postData + '&pos_project_id=0';
                        postData = postData + '&pos_sample_data_id=0';                    
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
        postData = postData + '&library=merchant_type';
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
