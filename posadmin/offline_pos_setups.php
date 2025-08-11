<?php
include_once('application_main.php');
include_once('session.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Simply POS | Offline POS Project List</title>
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
                        Offline POS Project <small>List</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Offline POS Project</a></li>
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
                                    <div class="table-responsive">
                                        <table id="mytable" class="table table-bordred table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Version</th>
                                                    <th>Update Date</th>
                                                    <th>Requirement</th>
                                                    <th>Description</th>
                                                    <th>Download</th>
                                                    <th>Installation</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1.00 Beta</td>
                                                    <td>26-09-2018</td> 
                                                    <td>POS Version 3.01 & Above</td> 
                                                    <td>Setup Ready</td>  	
                                                    <td colspan="2"></td>
                                                </tr>
                                                <tr>
                                                    <td>1.01</td>
                                                    <td>27-09-2018</td> 
                                                    <td>POS Version 3.01 & Above</td>
                                                    <td>Data Synchronization Updated</td>  	
                                                    <td colspan="2"></td>
                                                </tr>
                                                <tr>
                                                    <td>1.02</td>
                                                    <td>22-10-2018</td> 
                                                    <td>POS Version 3.01 & Above</td>
                                                    <td>Installation bug fixed</td>  	
                                                     <td colspan="2"></td>
                                                </tr>
                                                <tr>
                                                    <td>1.03</td>
                                                    <td>03-11-2018</td> 
                                                    <td>POS Version 3.01 & Above</td>
                                                    <td>Pos Data Import Bug Fixed</td>  	
                                                    <td><a href="https://simplypos.in/posadmin/pos_versions/offline_pos/offlinepos_1.03.zip" target="_new">Download</a></td>
                                                    <td><a href="https://simplypos.in/posadmin/pos_versions/offline_pos/Setup.pdf" target="_new">Installation</a></td>
                                                </tr>
                                                <tr>
                                                    <td>1.04</td>
                                                    <td>22-11-2018</td> 
                                                    <td>POS Version 3.01 & Above</td>
                                                    <td>PHP 7.x Session suport issue solve</td>  	
                                                    <td><a href="https://simplypos.in/posadmin/pos_versions/offline_pos/offlinepos_1.04.zip" target="_new">Download</a></td>
                                                    <td><a href="https://simplypos.in/posadmin/pos_versions/offline_pos/Setup.pdf" target="_new">Installation</a></td>
                                                </tr>
                                                <tr>
                                                    <td>1.05</td>
                                                    <td>23-11-2018</td> 
                                                    <td>POS Version 3.02 & Above</td>
                                                    <td>Split Pay, KOT and Receipt No issue solve</td>  	
                                                    <td><a href="https://simplypos.in/posadmin/pos_versions/offline_pos/offlinepos_1.05.zip" target="_new">Download</a></td>
                                                    <td><a href="https://simplypos.in/posadmin/pos_versions/offline_pos/Setup.pdf" target="_new">Installation</a></td>
                                                </tr>
                                                <tr>
                                                    <td>1.06</td>
                                                    <td>30-11-2018</td> 
                                                    <td>POS Version 3.03 & 3.04</td>
                                                    <td>
                                                        <ul>
                                                            <li>Updated Version with restriction synch within 30 days.</li>
                                                            <li>New button added for All data synch on single click. </li>
                                                            <li>Images download option added in synch section.</li>
                                                            <li>Bugs fixed.</li>
                                                        </ul> 
                                                    </td>  	
                                                    <td><a href="https://simplypos.in/posadmin/pos_versions/offline_pos/offlinepos_1.06.zip" target="_new">Download</a></td>
                                                    <td><a href="https://simplypos.in/posadmin/pos_versions/offline_pos/Setup.pdf" target="_new">Installation</a></td>
                                                </tr>
                                                <tr>
                                                    <td>2.00</td>
                                                    <td>20-05-2019</td> 
                                                    <td>POS Version 3.07 & Above</td>
                                                    <td>
                                                        <ul>
                                                            <li>Updated Version with user management & discount masters.</li>
                                                            <li>New option added for synch online users. </li>
                                                            <li>New Pos Theme added</li>
                                                            <li>Auto Synch option added (Duration every 30 minutes)</li>
                                                            <li>Return sales issue fixed</li>
                                                            <li>Bugs fixed.</li>
                                                        </ul> 
                                                    </td>  	
                                                    <td><a href="https://simplypos.in/posadmin/pos_versions/offline_pos/offlinepos_2.00.zip" target="_new">Download</a></td>
                                                    <td><a href="https://simplypos.in/posadmin/pos_versions/offline_pos/Setup.pdf" target="_new">Installation</a></td>
                                                </tr>
                                                <tr>
                                                    <td>4.00</td>
                                                    <td>01-08-2019</td> 
                                                    <td>POS Version 4.00 & Above</td>
                                                    <td>
                                                        <ul>
                                                            <li>New option added for synch add & synch customers online. </li>
                                                            <li>Seals person added on pos screen</li>                                                            
                                                            <li>Bugs fixed.</li>
                                                        </ul> 
                                                    </td>  	
                                                    <td><a href="https://simplypos.in/posadmin/pos_versions/offline_pos/offlinepos_4.00.zip" target="_new">Download</a></td>
                                                    <td><a href="https://simplypos.in/posadmin/pos_versions/offline_pos/Setup.pdf" target="_new">Installation</a></td>
                                                </tr>
                                                <tr>
                                                    <td>4.16 (Beta)</td>
                                                    <td>01-02-2022</td> 
                                                    <td>POS Version 4.16 & Above</td>
                                                    <td>
                                                        <ul>
                                                            <li>Recreate new offline pos compatible for version 4.16</li>
                                                            <li>All updated features available which exists in pos version 4.16</li>                                                            
                                                            <li>Bugs fixed.</li>
                                                        </ul> 
                                                    </td>  	
                                                    <td><a href="https://simplypos.in/posadmin/pos_versions/offline_pos/offlinepos_4.16.zip" target="_new">Download</a></td>
                                                    <td><a href="https://simplypos.in/posadmin/pos_versions/offline_pos/Setup.pdf" target="_new">Installation</a></td>
                                                </tr>
                                                <tr>
                                                    <td>4.20 (Beta)</td>
                                                    <td>07-04-2022</td> 
                                                    <td>POS Version 4.20 & Above</td>
                                                    <td>
                                                        <ul>
                                                            <li>Recreate new offline pos compatible for version 4.20 and above</li>
                                                            <li>All updated features available which exists in pos version 4.20</li>                                                            
                                                            <li>Bugs fixed.</li>
                                                        </ul> 
                                                    </td>  	
                                                    <td><a href="https://simplypos.in/posadmin/pos_versions/offline_pos/offlinepos_4.20.zip" target="_new">Download</a></td>
                                                    <td><a href="https://simplypos.in/posadmin/pos_versions/offline_pos/Setup.pdf" target="_new">Installation</a></td>
                                                </tr>
                                                <tr>
                                                    <td>5.00 (Beta)</td>
                                                    <td>07-06-2022</td> 
                                                    <td>POS Version 5.00 & Above</td>
                                                    <td>
                                                        <ul>
                                                            <li>Recreate new offline pos compatible for version 5.00 and above</li>
                                                            <li>All updated features available which exists in pos version 5.00</li>                                                            
                                                            <li>New : Restaurant Table Management Updates </li>
                                                            <li>New : Sales Auto Synch on/off Setting  </li>
                                                            <li>New : Offline Pos Version Setting  </li>
                                                        </ul> 
                                                    </td>  	
                                                    <td><a href="https://simplypos.in/posadmin/pos_versions/offline_pos/offlinepos_5.00.zip" target="_new">Download</a></td>
                                                    <td><a href="https://simplypos.in/posadmin/pos_versions/offline_pos/Setup.pdf" target="_new">Installation</a></td>
                                                </tr>
                                               <tr>
                                                    <td>5.00.02</td>
                                                    <td>04-08-2022</td> 
                                                    <td>POS Version 5.00 & Above</td>
                                                    <td>
                                                        <ul>
                                                            <li>Recreate new offline pos compatible for version 5.00 and above</li>
                                                            <li>All updated features available which exists in pos version 5.00</li>                                                            
                                                            <li>Bug : Pos Screen Quantity & Discount issue fixed </li>
                                                             
                                                        </ul> 
                                                    </td>  	
                                                    <td><a href="https://simplypos.in/posadmin/pos_versions/offline_pos/offlinepos_5.00.02.zip" target="_new">Download</a></td>
                                                    <td><a href="https://simplypos.in/posadmin/pos_versions/offline_pos/Setup.pdf" target="_new">Installation</a></td>
                                                </tr>
                                            </tbody>
                                        </table>
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


    </body>
</html>
