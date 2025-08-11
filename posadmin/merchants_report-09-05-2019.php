<?php
include_once('application_main.php');
include_once('session.php');
require_once('../functions/phpFormFunctions.php');

$objMerchant = new merchant($conn);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Simply POS | Merchants Report</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" />
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous" />
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css" />
        <!-- daterange picker -->
<!--        <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker-bs3.css">-->
        <!-- bootstrap datepicker -->
<!--        <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">-->
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
                <!-- Content Header (Page header) -->
                <section class="content-header">
                  <h1><i class="fa fa-list"></i> Merchants <small>Report</small>  </h1>
                  <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><a href="#">Merchants</a></li>
                    <li class="active">Report</li>
                  </ol>
                </section> 
                <!-- Main content -->
                <section class="content">
                                       
                    <div class="box box-info">                        
                        <!-- /.box-header -->
                        <div class="box-body" style="display: block;">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label>* Report Type</label>
                                    <select name="report_type" id="report_type" required="required" class="form-control">
                                        <option value="all">All POS</option>
                                        <option value="paid">Paid</option>
                                        <option value="demo">Demo</option>                                        
                                        <option value="active">Active</option>
                                        <option value="suspended">Suspended</option>
                                        <option value="going_to_expired">Going to expired</option>
                                    </select>
                                </div>
                                <div class="col-sm-3">
<!--                                    <div class="form-group">
                                        <label>Display in list: </label>
                                        <div class="input-group">
                                            <label><input type="checkbox" name="pos_status" value="suspended" />Suspended</label>
                                            <label><input type="checkbox" name="pos_status" value="active" />Active</label>
                                            <label><input type="checkbox" name="pos_status" value="deleted" />Deleted</label>
                                        </div>                                        
                                    </div> -->
                                </div>
                                <div class="col-sm-3">
                                   <br/> <button id="get_report" class="btn btn-primary" >Generate Report</button>
                                </div>
                                <div class="col-sm-3">
                                    
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <div id="reportsData"></div>
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

        <!-- Generate POS Project Modal -->
        <div class="modal fade " id="posUsers" role="dialog">
            <div class="modal-dialog" style="width: 800px;">    
            <!-- Modal content-->
            <div class="modal-content" id="pos_user_list">
                <h1>Model contains will display here!</h1>
            </div>      
          </div>
        </div>
        <!-- jQuery 2.2.0 -->
        <script src="plugins/jQuery/jQuery-2.2.0.min.js"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <!-- DataTables -->
        <script src="plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
        <!-- date-range-picker -->
<!--        <script src="plugins/daterangepicker/moment.min.js"></script>
        <script src="plugins/daterangepicker/daterangepicker.js"></script>-->
        <!-- bootstrap datepicker -->
<!--        <script src="plugins/datepicker/bootstrap-datepicker.js"></script>-->
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

            $(function () {
                
//                $('#clear_date_range').hide();
//                //Date range picker
//                $('#date_range').daterangepicker();
//                
//                $('#date_range').on('change', function(){
//                    $('#clear_date_range').show();
//                });
//                
//                $('#clear_date_range').on('click', function(){
//                    $('#date_range').val('');
//                    $('#clear_date_range').hide();
//                });
            });
            
            
            $('#get_report').on('click', function(){
                
                var report_type = $('#report_type').val();
                var date_range  = $('#date_range').val();
                var postData = "report_type=" + report_type;
                    postData = postData + "&date_range=" + date_range;
                
                $.ajax({
                    type: "POST",
                    url: "ajax_request/merchants_report.php",
                    data: postData,
                    beforeSend: function(){                    
                        $("#reportsData").html("<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>");                    
                    },
                    success: function(data){			 
                        $("#reportsData").html(data);			 
                    }
                });                
                 
            });

        </script>
    </body>
</html>
