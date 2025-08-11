<?php
include_once('application_main.php');
include_once('session.php');
$objUser = new adminUser();

$userLogs   = $objUser->getUserLog();
$que = mysqli_query($conn,"SELECT * FROM admin_user_log GROUP BY user_id DESC"); 
                  
//$total= count($userLogs);
//
//$start=0;
//$limit = 100;
//
//if(isset($_GET["id"])){ $id  = $_GET["id"];
//
//$start =($id-1) * $limit;
//
//} else { $id=1; };  
//$start = ($id-1) * $limit;   
//$page=ceil($total/$limit);
//$query = mysqli_query($conn,"SELECT * FROM admin_user_log ORDER BY id ASC LIMIT $start, $limit");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Simply POS | User Activity Logs</title>
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
  <style>
    div.pagination {
    padding:20px;
    margin:7px;
}
div.pagination a {
    margin: 2px;
    padding: 0.5em 0.64em 0.43em 0.64em;
    background-color: #ee4e4e;
    text-decoration: none;
    color: #fff;
}
div.pagination a:hover, div.pagination a:active {
    padding: 0.5em 0.64em 0.43em 0.64em;
    margin: 2px;
    background-color: #de1818;
    color: #fff;
}
div.pagination span.current {
    padding: 0.5em 0.64em 0.43em 0.64em;
    margin: 2px;
    background-color: #f6efcc;
    color: #6d643c;
}
div.pagination span.disabled {
    display:none;
}
</style>

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
        User <small>Log</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">User</a></li>
        <li class="active">Log</li>
      </ol>
    </section> 
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            
            <!-- /.box-header -->
            <div class="box-body"> 
      

<!--<div id="result"></div>-->
<div class="row" >
    <div class="col-md-12" style="margin:20px 0;">
                 <div class="col-md-4">
                     <div class="input-group">
                        <input type="text" class="form-control" id="keywords" placeholder="Search record by Merchant's Name or URL"  name="keywords" aria-label="Search" autocomplete="off">
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="button" id="searchbtn" onclick="searchFilter()">Search</button>
                        </span>
                     </div>
                     <span id="err" class="text-danger"></span>
<!--                    <input type="text" class="form-control" id="keywords" placeholder="Type keywords to filter posts"  onkeyup="searchFilter()"/>-->
                 </div>
            <div class="col-md-2">
                <select id="sortBy" class="form-control" onchange="searchFilter()">
                <option value="" selected disabled hidden>Sort By Username</option>
              <?php 
              foreach($que as $user){
                  
                  $user_id= $user['user_id'];
                   ?>
                   <option value="<?php echo $user['user_id']?>"><?php echo $user['user_name']?></option>
              <?php } ?> 
              </select>
            </div>
            <div class="col-md-6">
                <label class="control-label col-md-2">Sort By Date</label> 
              <div class='date col-md-4' id='datetimepicker1'>
                <input type="date" name="fstdate" class="form-control"  id="fstdate">
             </div>
            <div class='date col-md-4' id='datetimepicker1'>
                <input type="date" class="form-control" name="enddate" id="enddate">
            </div>
                <button type="button" class="btn btn-primary" name="searchbtn1" id="searchbtn1" onclick="searchFilter()">GO!</button>
         </div>    
   </div>
</div>


<div class="row">
     <div class="loading-overlay"><div class="overlay-content">Loading.....</div></div>
     <div class="col-md-12" id="posts_content">
    <?php
     include_once('../include/classes/pagination.php');    
    $limit = 20;
    //echo $_POST['page'];
    $start = !empty($_POST['page'])?$_POST['page']:0;
    $limit = 20;
    //get number of rows
    $queryNum = $conn->query("SELECT COUNT(*) as postNum FROM admin_user_log");
    $resultNum = $queryNum->fetch_assoc();
    $rowCount = $resultNum['postNum'];
    $pagConfig = array(
        'totalRows' => $rowCount,
        'perPage' => $limit,
        'link_func' => 'searchFilter'
    );
    
   $pagination =  new Pagination($pagConfig);
   $query = $conn->query("SELECT * FROM admin_user_log ORDER BY id DESC LIMIT $start, $limit");   //print_r( $query);
    $i=1;
    
    if($query->num_rows > 0){ ?>
        <div class="posts_list">
        <?php
//        $output .='<h3 align="center">USER LOG RECORDS</h3>';
        $output .= '<div class="table-responsive">
                    <table  class="table table-bordered table-striped">
                    <thead>
                            <tr>
                              <th>S.No</th>   
                              <th>Activity at</th>                 
                              <th>User</th>
                              <th>Activity</th>
                              <th>Merchant</th>                          
                              <th>POS Url</th>                          
                              <th>IP Address</th>
                            </tr>
                            </thead>';
            while($row = $query->fetch_assoc()){ 
               //print_r($row);
                ?>
            <?php  $output .='<tr>
                        <td>'.($i++).'</td>   
                        <td>'.$row["activity_at"].'</td>
                        <td>'.$row["user_name"].'</td>
                        <td>'.$row["user_activity"].'</td>
                        <td>'.$row["merchant_name"].'</td>
                        <td>'.$row["pos_url"].'</td>
                        <td>'.$row["activity_ip"].'</td>
                       </tr>';
        }
         echo $output; 
         echo "</table>"; 
         echo "</div>";
 ?>

    <?php echo $pagination->createLinks(); } else{echo "<p align='center' class='text-danger'>no records</p>";}?>

    </div>
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
  
</div>   

<!-- jQuery 2.2.0 -->
<script src="plugins/jQuery/jQuery-2.2.0.min.js"></script>

<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- DataTables CSS -->
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>

<script>

 var keywords = ''
$(document).ready(function(){
    
    $('.loading-overlay').hide();
    
});

function searchFilter(page_num) {
//     $('#searchbtn').click(function(){
//         alert('hfghjfd');
//         return false;
//     }
//      document.addEventListener('click', function(e) {
//          if(e.target.id == "searchbtn"){
//              //alert(' please enter merchant name or url');
//              $('#err').html('please enter merchant name or url');
//              setTimeout(function(){ $('#err').html('');  }, 3000);
//            }else{
              page_num = page_num?page_num:0;
            var keywords = $('#keywords').val();
            var sortBy = ($('#sortBy').val())?$('#sortBy').val():'';
            var fstdate = $('#fstdate').val();


             var enddate = $('#enddate').val();
             $.ajax({
                 type: 'POST',
                 url: 'ajax_request/userlogResponse.php',
                 data:'page='+page_num+'&keywords='+keywords+'&sortBy='+sortBy+'&fstdate='+fstdate+'&enddate='+enddate,
                 //alert(data);
         //        beforeSend: function () {
         //            $('.loading-overlay').show();
         //        },

                 success: function (html) {
                     //console.log(html);
                     $('#posts_content').html(html);
                     $('.loading-overlay').fadeOut("slow");

                 }
             });
          
          
        
//   }, false);
    
   
}
 $(function () {
                $('#datetimepicker2').datetimepicker({
                    locale: 'ru'
                });
            });
</script>


  

</body>
</html>


