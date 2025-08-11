<?php
include_once('application_main.php');
include_once('session.php');
include_once('xmlapi.php');

$objPackage = new packages;
 
 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Simply POS | Package List</title>
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
</head>
<style>
    #setupPOS {
        display: none;
        width: 400px;
        
    }
    
    #setupPOS ul li {
        padding: 10px;
        line-height: 40px;
    }
    
</style>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

	<?php include_once('header.php'); ?>
	<?php include_once('sidebar.php'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Package <small>List</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Package</a></li>
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
                
              
             <?php
             if(isset($_GET['success']))
             {
                 echo '<div class="alert alert-success">Package Update success.</div>';
             }
             ?>
            
            <div class="row">
                <div class="col-sm-12 " >                
                  
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>Id</th>                 
                          <th style="width:200px;">Package Details</th>
                          <th>Price</th>
                          <th>Bundle</th>                          
                          <th>Features </th>
                          <th>Edit</th>
                        </tr>
                        </thead>
                    <tbody>
                    <?php

                    if(is_array($objPackage->packages)):

                        foreach ($objPackage->packages as $package) {
                    ?>
                        <tr>
                          <td><?php echo $package['id'];?></td>
                          <td>
                              <strong><?php echo $package['package_name'];?></strong> <br/>
                              <p><?php echo wordwrap( $package['details'], 50);?> </p>
                          </td>
                          <td>
                              <p>Monthly: <i class="fa fa-inr"></i> <?php echo round($package['monthly_price']);?></p>
                              <p>Annually: <i class="fa fa-inr"></i> <?php echo round($package['annual_price']);?></p>
                          </td>
                          <td>
                              <ul>
                                  <li>Outlet: <?php echo ($package['outlet'] < 0) ? 'Unlimited' : $package['outlet'] ;?></li>
                                  <li>Register: <?php echo ($package['register'] < 0) ? 'Unlimited' : $package['register'] ;?></li>
                                  <li>Users: <?php echo ($package['users'] < 0) ? 'Unlimited' : $package['users'] ;?></li>
                                  <li>Products: <?php echo ($package['products'] < 0) ? 'Unlimited' : $package['products'] ;?></li>
                                  <li>Customers: <?php echo ($package['customers'] < 0) ? 'Unlimited' : $package['customers'] ;?></li>
                              </ul>
                                
                          </td>
                           
                          <td><ul>
                              <?php 
                                $features = explode(',',$package['features']);
                                foreach ($features as $feature) {
                                    echo "<li>$feature</li>";
                                }
                                ?></ul>  
                          </td>
                          <td class="text-center">
                              <a href="package.php?id=<?php echo $package['id'];?>" class="btn btn-primary btn-xs" > edit </a>
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
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
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
      
        
        for(var p = 0; p <= 4 ; p++){
            $('#package_id-'+p).hide();
        }
        
        
        $('.tab-filter').click(function(){
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
            requestMerchantsList(1, 1);
            
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
        
       
  })
 
</script>



</body>
</html>
