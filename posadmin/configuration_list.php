<?php
include_once('application_main.php');
include_once('session.php');
 
$objConfigs = new configuration;

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Simply POS | Configuration List</title>
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
        <h1>Configuration <small>List</small></h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Configuration</a></li>
            <li class="active">List</li>
        </ol>
    </section> 
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            
            <!-- /.box-header -->
            <div class="box-body">
            <div id="error_msg"></div> 
            <div id="alert-action-msg" class="alert alert-success alert-action"></div>        
            <div class="row">
                <div class="col-sm-12 " >
                    <table  class="table table-bordered table-striped">
                        <thead>
                            <tr>
                              <th>Id</th>                 
                              <th>Title</th>                           
                              <th>Value</th>
                              <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                    <?php

                    if(is_array($objConfigs->data['user'])):

                        foreach ($objConfigs->data['user'] as $config) {
                    ?>
                        <tr>
                          <td><?php echo ++$i;?></td>
                          <td><?php echo $config['title'];?></td>                          
                          <td>
                              <input type="hidden" id="config_hidden_validation_rule_<?php echo $config['id'];?>" value="<?php echo $config['validation_rule'] ;?>" />
                              <input type="hidden" id="config_hidden_value_<?php echo $config['id'];?>" value="<?php echo $config['value'] ;?>" />
                              <div id="config_value_<?php echo $config['id'];?>"><?php echo $config['value'] ;?></div>
                          </td>
                          <td class="text-center">
                              <button class="btn btn-primary btn-sm edit_config btn_<?php echo $config['id'];?>" name="edit" id="<?php echo $config['id'];?>" ><i class="fa fa-pencil-square-o" ></i> Edit </button>
                          </td>
                        </tr>
                    <?php
                    }//end foreach
                    endif;

                    ?>
                    </tfoot>
                    </table>
                    <!-- DataTables -->
 
                </div>
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
 
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- page script -->
 
<script>

$(document).ready(function(){
    
    $('.edit_config').click(function(){
        
        var id = $(this).attr('id');
        var buttonName = $(this).attr('name');
        var config_hidden_value = $('#config_hidden_value_'+id).val();
        var config_hidden_validation_rule = $('#config_hidden_validation_rule_'+id).val();
        
        if(buttonName == 'edit'){
            
            var inputField = '<input type="text" name="config_input_'+ id +'" id="config_input_'+ id +'" value="'+config_hidden_value+'" class="form-control" maxlength="50" />';
            
            $('#config_value_'+id).html(inputField);
            
            $(this).attr('name', 'update');
            $(this).removeClass('btn-primary');
            $(this).addClass('btn-success');
            $(this).html('<i class="fa fa-pencil-square-o" ></i> Update ');
            
        }
        
        if(buttonName == 'update'){
          
          $('#alert-action-msg').css('display','block');
          $('#alert-action-msg').removeClass('alert-success');
          $('#alert-action-msg').addClass('alert-info');
          $('#alert-action-msg').html('Updating....'); 
          
         var config_new_value = $('#config_input_'+id).val();   
           
           if(config_new_value == config_hidden_value){
               
               setTimeout(function(){
                   $('#alert-action-msg').removeClass('alert-info');
                   $('#alert-action-msg').addClass('alert-warning');
                   $('#alert-action-msg').html('No Changes'); 
                   
               }, 500);
               
               setTimeout(function(){
                   $('#alert-action-msg').removeClass('alert-warning');
                   $('#alert-action-msg').addClass('alert-success');
                                      
                   reset_edit_button(id);
                   
                   $('#config_value_'+id).html(config_hidden_value);
                   
               }, 1000);
               
           } else {
              
              
            var postData = 'action=updateConfig';
                postData = postData + '&id=' + id;
                postData = postData + '&value=' + config_new_value;
                postData = postData + '&rule=' + config_hidden_validation_rule;

                $.ajax({
                    type: "POST",
                    url: "ajax_request/merchant_actions.php",
                    data:postData,

                    success: function(response){ 
                        
                        if(response == 'SUCCESS') {

                            setTimeout(function(){ 
                            
                                $('#alert-action-msg').removeClass('alert-info');
                                 $('#alert-action-msg').addClass('alert-success');
                                 $('#alert-action-msg').html('Update Successfully');
                                 
                            }, 500);

                            setTimeout(function(){

                                  reset_edit_button(id);

                                  $('#config_value_'+id).html(config_new_value + ' <span class="pull-right badge bg-green">Updated</span>');
                                  $('#config_hidden_value_'+id).val(config_new_value);
                                  $('#error_msg').html('');

                            }, 1000);
                         } 
                         else
                         {
                             reset_edit_button(id);
                             $('#error_msg').html('<div class="alert alert-danger">'+response+'</div>');
                             $('#config_value_'+id).html(config_hidden_value + ' <span class="pull-right badge bg-red">Request Failed</span>');

                         }
                    }
                });
              
              
               
           }
           
            
        }
        
    });
    
    
});
 
 

function reset_edit_button(id){
    $('#alert-action-msg').css('display','none'); 
    $('#alert-action-msg').html('');
    
    $('.btn_'+id).attr('name', 'edit');                    
    $('.btn_'+id).removeClass('btn-success');
    $('.btn_'+id).addClass('btn-primary');                     
    $('.btn_'+id).html('<i class="fa fa-pencil-square-o" ></i> Edit ');
}

</script>

</body>
</html>
