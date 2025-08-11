<?php

include_once('application_main.php');

include_once('session.php');
 
$objMerchant = new merchant;
$objDistributor = new distributors;

 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SimplySafe Admin | Dashboard</title>
   
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
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
        Dashboard
        <small>Version 1.0</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

     <!-- Main content -->
    <section class="content">
      <!-- Info boxes -->
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-signal"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Current Version</span>
              <span class="info-box-number"> <?php $CurrentPOSVersion = $objMerchant->getCurrentPOSVersion();
					if(!empty($CurrentPOSVersion)){
						foreach($CurrentPOSVersion as $CurrentPOSVersionData){
							echo $CurrentPOSVersionData['version'];
						}
					}		
				  ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-rupee"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Paid Merchant</span>
              <span class="info-box-number"><?php
			  $posStatuss = $objMerchant->getPosStatusCounts();
                    foreach ($posStatuss as $keys => $statusArrs) {
						//echo $keys.'<br/>';
						if($keys=='upgrade')
							echo $statusArrs;
                      
                    }
                  ?> </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
		     
        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Unpaid Merchant</span>
              <span class="info-box-number"><?php echo  $objMerchant->countFreePackage(); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Pending Merchant</span>
              <span class="info-box-number"><?php
			  echo $objMerchant->getPendingPOS();
                  ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Monthly Error Log Report</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <div class="btn-group">
                  <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-wrench"></i></button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                  </ul>
                </div>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <p class="text-center">
                    <strong>Merchant Pos</strong>
					<?php
					 $query1 = mysqli_query($conn,"SELECT * FROM merchant_type where merchant_type!='default' LIMIT 0, 12");
					 $ArrayMerchantType = [];
					 $ArrayMerchantTypeLabel = [];
				  while($Row1 = $query1->fetch_assoc()){
					  $ArrayMerchantType[$Row1['id']]=$Row1['id'];
					  $ArrayMerchantTypeLabel[]=$Row1['merchant_type'];
				  }
				//  print_r( $ArrayMerchantTypeLabel);
						//$ArrayMerchantType = array(1=>"Restaurants", 2=>"Electronics", 3=>"StationaryToy", 4=>"Bakery", 5=>"GroceryKirana", 1011=>"Clothing", 1015=>'Jewellery', 9=>"Pharmaceutical");
						// print_r( $ArrayMerchantType);
						$ArrMerchantType = [];
						foreach($ArrayMerchantType as $MerchantKey=>$MerchantValue){
							
							$MerchantsData = $objMerchant->getPosStatusCountsByMerchantTypeId($MerchantKey);
							
							$ArrMerchantType[$MerchantValue]=$MerchantsData;
						}
						//echo '<pre>';
						//print_r($ArrMerchantType);
						$ArrGenerated = [];
						$ArrPending = [];
						$ArrPaid = [];
						//print_r($ArrMerchantType['Restaurants']);
						foreach($ArrMerchantType as $BarMasterKey => $BarMasterValue){
							$ArrGenerated[] = $BarMasterValue['generated'];
							$ArrPending[] = $BarMasterValue['pending'];
							$ArrPaid[] = $BarMasterValue['upgrade'];
						}
						//print_r($ArrGenerated);
						$BarMapData[]=array(
							'label'=>'Generated',
							'fillColor'=> "rgb(210, 214, 222)",
							'strokeColor'=> "rgb(210, 214, 222)",
							'pointColor'=> "rgb(210, 214, 222)",
							'pointStrokeColor'=> "#c1c7d1",
							'pointHighlightFill'=> "#fff",
							'pointHighlightStroke'=> "rgb(220,220,220)",
							'data'=> $ArrGenerated
						);
						$BarMapData[]=array(
							'label'=>'Pending',
							'fillColor'=> "rgba(60,141,188,0.9)",
							'strokeColor'=> "rgba(60,141,188,0.8)",
							'pointColor'=> "#3b8bba",
							'pointStrokeColor'=> "rgba(60,141,188,1)",
							'pointHighlightFill'=> "#fff",
							'pointHighlightStroke'=> "rgba(60,141,188,1)",
							'data'=> $ArrPending
						);
						$BarMapData[]=array(
							'label'=>'Paid',
							'fillColor'=> "rgb(0,128,0)",
							'strokeColor'=> "rgb(0,128,0)",
							'pointColor'=> "#3b8bba",
							'pointStrokeColor'=> "rgb(0,128,0)",
							'pointHighlightFill'=> "#fff",
							'pointHighlightStroke'=> "rgb(0,128,0)",
							'data'=> $ArrPaid
						);
						$JsonBarMapData = json_encode($BarMapData);
						//echo '<pre>';
						//print_r($ArrayMerchantType);
						//exit;
					?>
                  </p>

                  <div class="chart">
                    <!-- Sales Chart Canvas -->
                    <canvas id="barChart" style="height: 180px;"></canvas>
					
                  </div>
                  <!-- /.chart-responsive -->
                </div>
                <!-- /.col -->
               
              </div>
              <!-- /.row -->
            </div>
            <!-- ./box-body -->
            <div class="box-footer">
              <div class="row">
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block border-right">
                    
                    <span class="description-text"><i class="fa fa-square text-light-blue"></i>Pending </span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block border-right">
                   
                    <span class="description-text"><i class="fa fa-square text-green"></i> Paid</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block border-right">
                   
                    <span class="description-text"> <i class="fa fa-square text-gray"></i>Generated </span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <div class="col-md-8">
          
          <!-- /.box -->
          <div class="row">
            <div class="col-md-6">
              <!-- DIRECT CHAT -->
              <div class="box box-warning direct-chat direct-chat-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">Request</h3>
					<?php $ResultRequest = $objDistributor->getDistributorRequest();
						$CountRequest = count($ResultRequest);
					?>
                  <div class="box-tools pull-right">
                    <span data-toggle="tooltip" title="<?php echo $CountRequest; ?> New Messages" class="badge bg-yellow"><?php echo $CountRequest; ?></span>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <!--<button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle">
                      <i class="fa fa-comments"></i></button>-->
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
				
                  <!-- Conversations are loaded here -->
                  <div class="direct-chat-messages">
                    <!-- Message. Default to the left -->
					<?php 
						if(!empty($ResultRequest)){
							$iRequest = 1;
							foreach($ResultRequest as $requestData){
								if( $iRequest==1){
					?>
                    <div class="direct-chat-msg">
                      <div class="direct-chat-info clearfix">
                        <span class="direct-chat-name pull-left"><?php echo $requestData['name']; ?></span>
                        <span class="direct-chat-timestamp pull-right"><?php echo date("d F j h:m A", strtotime($requestData['request_at'])); ?></span>
                      </div>
                      <!-- /.direct-chat-info -->
                      <img class="direct-chat-img" src="dist/img/avatar.jpg" alt="message user image"><!-- /.direct-chat-img -->
                      <div class="direct-chat-text">
                        <?php echo $requestData['distributor_comments']; ?>
                      </div>
                      <!-- /.direct-chat-text -->
                    </div>
                    <!-- /.direct-chat-msg -->
								<?php }else{  ?>
                    <!-- Message to the right -->
                    <div class="direct-chat-msg right">
                      <div class="direct-chat-info clearfix">
                        <span class="direct-chat-name pull-right"><?php echo $requestData['name']; ?></span>
                        <span class="direct-chat-timestamp pull-left"><?php echo date("d F Y h:m A", strtotime($requestData['request_at'])); ?></span>
                      </div>
                      <!-- /.direct-chat-info -->
                      <img class="direct-chat-img" src="dist/img/avatar.jpg" alt="message user image"><!-- /.direct-chat-img -->
                      <div class="direct-chat-text">
                        <?php echo $requestData['distributor_comments']; ?>
                      </div>
                      <!-- /.direct-chat-text -->
                    </div>
                    <!-- /.direct-chat-msg -->
								<?php } $iRequest++; if($iRequest==3) $iRequest=1; } } ?>
                   

                   
                  </div>
                  <!--/.direct-chat-messages-->

                  <!-- Contacts are loaded here -->
                  <div class="direct-chat-contacts">
                    <ul class="contacts-list">
					<?php foreach($ResultRequest as $requestData){ ?>
                      <li>
                        <a href="#">
                          <img class="contacts-list-img" src="dist/img/user1-128x128.jpg" alt="User Image">

                          <div class="contacts-list-info">
                                <span class="contacts-list-name">
                                 <?php echo $requestData['name']; ?>
                                  <small class="contacts-list-date pull-right"><?php echo date("d F Y", strtotime($requestData['request_at'])); ?></small>
                                </span>
                            <span class="contacts-list-msg"><?php echo $requestData['distributor_comments']; ?></span>
                          </div>
                          <!-- /.contacts-list-info -->
                        </a>
                      </li>
					  <?php } ?>
                      <!-- End Contact Item -->
                     
                      
                    </ul>
                    <!-- /.contatcts-list -->
                  </div>
                  <!-- /.direct-chat-pane -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer" style="display:none;">
                  <form action="#" method="post">
                    <div class="input-group">
                      <input type="text" name="message" placeholder="Type Message ..." class="form-control">
                          <span class="input-group-btn">
                            <button type="button" class="btn btn-warning btn-flat">Send</button>
                          </span>
                    </div>
                  </form>
                </div>
                <!-- /.box-footer-->
              </div>
              <!--/.direct-chat -->
            </div>
            <!-- /.col -->

            <div class="col-md-6">
              <!-- USERS LIST -->
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Latest Merchant</h3>

                  <div class="box-tools pull-right">
                    <span class="label label-danger">8 New Merchant</span>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
				 
                  <ul class="users-list clearfix">
				 <?php $LatestMerchant = $objMerchant->getLatestMerchant();
					if(!empty($LatestMerchant)){
						foreach($LatestMerchant as $LatestMerchantData){
							$Date = date("Y-m-d", strtotime($LatestMerchantData['created_at']));
							$CurrentDate = date("Y-m-d");
							$PreviousDate = date('Y-m-d',strtotime("-1 days"));
							$Day = date("d F", strtotime($Date)); //May
							if($Date==$CurrentDate){
								$Day = 'Today';
							}
							if($Date==$PreviousDate){
								$Day = 'Yesterday';
							}
							
				  ?>
                    <li>
                      <img src="dist/img/avatar.jpg" alt="User Image">
                      <h6 class="users-list-name" ><?php echo $LatestMerchantData['name']; ?></h6>
                      <span class="users-list-date"><?php echo $Day; ?></span>
                    </li>
                    <?php } } ?>
                  </ul>
                  <!-- /.users-list -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer text-center">
                  <a href="merchants.php" class="uppercase">View All Users</a>
                </div>
                <!-- /.box-footer -->
              </div>
              <!--/.box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->

          <!-- TABLE: LATEST ORDERS -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">User Log</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr>
					<th>S.No</th>   
					  <th>Activity at</th>                 
					  <th>User</th>
					  <th>Activity</th>
					  <th>Merchant</th>    
                  </tr>
                  </thead>
                  <tbody>
				  <?php 
				  $i=1;
				  $query = mysqli_query($conn,"SELECT * FROM admin_user_log ORDER BY id desc LIMIT 0, 10");
				  while($RowUserLog = $query->fetch_assoc()){
				  ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $objapp->DateTimeFormat($RowUserLog['activity_at'], 'jS F Y g:ia');?></td>
                    <td><span class="label label-success"><?php echo $RowUserLog['user_name'];?></span></td>
                   
					 <td>
                       <?php echo $RowUserLog['user_activity'];?>
                    </td>
					 <td>
                       <?php echo $RowUserLog['merchant_name'];?>
                    </td>
                  </tr>
                  <?php $i++; } ?>
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <!--<a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>-->
              <a href="user_logs.php" class="btn btn-sm btn-default btn-flat pull-right">View All Log</a>
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->

        <div class="col-md-4">
          <!-- Info Boxes Style 2 -->
      
          <!-- /.info-box -->

          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">POS Status Chart</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-8">
                  <div class="chart-responsive">
                    <canvas id="pieChart" height="150"></canvas>
                  </div>
                  <!-- ./chart-responsive -->
                </div>
                <!-- /.col -->
                <div class="col-md-4">
                <?php 
				
                    $posStatus = $objMerchant->getPosStatusCounts();
					//print_r($posStatus);
					// echo '<pre>';
				//  print_r($statusArr['pos_status']);
                    $class = [ 'text-light-blue','text-green', 'text-red', 'text-aqua', 'text-yellow', 'text-gray' ];
                    $colorposStatus = [ '#f56954','#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de' ];
					
					
                ?>
                  <ul class="chart-legend clearfix">
                  <?php
					$ArrposStatus = [];
					$iColor = 0;
                    foreach ($posStatus as $key => $statusArr) {
						$ArrposStatus[]=array(
							'value'=>$statusArr,
							'color'=>$colorposStatus[$iColor],
							'highlight'=>$colorposStatus[$iColor],
							'label'=>$key,
						);
						$iColor++;
						if($iColor==6)
							$iColor = 0;
                        echo '<li><i class="fa fa-circle-o '.$class[$key].'"></i> '.$key.': '.$statusArr.'</li>'; //$statusArr['pos_status']
                    }
					$JsonpieChart = json_encode($ArrposStatus);
                  ?> 
                  </ul>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-body -->
           
            <!-- /.footer -->
          </div>
          <!-- /.box -->

          <!-- PRODUCT LIST -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Recently Version </h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <ul class="products-list product-list-in-box">
			  <?php $LatestPOSVersion = $objMerchant->getLatestPOSVersion();
					if(!empty($LatestPOSVersion)){
						foreach($LatestPOSVersion as $LatestPOSVersionData){
							$Date = date("Y-m-d", strtotime($LatestPOSVersionData['created_at']));
							$Day = date("d F Y", strtotime($Date));
							
				  ?>
                <li class="item">
                  <div class="product-info">
                    <a href="javascript:void(0)" class="product-title"><?php echo 'Version: '.$LatestPOSVersionData['version']; ?>
                      <span class="label label-warning pull-right"><?php echo $Day; ?></span></a>
                        <span class="product-description">
                          <?php echo $LatestPOSVersionData['relese_status']; ?>
                        </span>
                  </div>
                </li>
					<?php } } ?>
                <!-- /.item -->
                
              </ul>
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
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll 1.3.0 -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS 1.0.1 -->
<script src="plugins/chartjs/Chart.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script>
$(document).ready(function() {
  JsonpieChart = <?php echo $JsonpieChart; ?>;
  JsonBarMapData = <?php echo $JsonBarMapData; ?>;
  ArrayMerchantTypeLabel = [];
  <?php foreach($ArrayMerchantTypeLabel as $Keys => $Values){ ?>
	ArrayMerchantTypeLabel.push('<?php echo $Values; ?>');
  <?php } ?>
	console.log(ArrayMerchantTypeLabel);
});
</script>
<script src="dist/js/pages/dashboard2.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script src="merchants_script.js"></script>
</body>
</html>