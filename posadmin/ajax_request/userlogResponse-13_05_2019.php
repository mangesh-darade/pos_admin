<?php
include_once('../../application_main.php');
include_once('../../session.php');

$objUser = new adminUser();


//$table='';
//    $tabel.='<table id="example" class="table table-bordered table-striped"> <thead> <tr>
//                          <th>S.No</th>   
//                          <th>Activity at</th>                 
//                          <th>User</th>
//                          <th>Activity</th>
//                          <th>Merchant</th>                          
//                          <th>POS Url</th>                          
//                          <th>IP Address</th>
//                        </tr>
//                        </thead>
//                  <tbody>';
//    $sr = 1;
//            foreach($userLogs as $row){
//                $tabel.='<tr>';
//                $tabel.='<td>'.$sr.'</td>';
//                $tabel.='<td>'.$row['activity_at'].'</td>';
//                $tabel.='<td>'.$row['user_name'].'</td>';
//                $tabel.='<td>'.$row['user_activity'].'</td>';
//                $tabel.='<td>'.$row['merchant_name'].'</td>';
//                $tabel.='<td>'.$row['pos_url'].'</td>';
//                $tabel.='<td>'.$row['activity_ip'].'</td>';
//                $tabel.='</tr>';
//    
//    $sr++;
//}
//    $tabel.='</tbody>';
//    $tabel.='</table>';
// echo json_encode($tabel );


//print_r($_POST).'<BR>';
//print_r($_GET);
if(isset($_POST['page'])){
    //echo "hello";
    include_once('../../include/classes/pagination.php');
    if(!empty($_POST['keywords']) || !empty($_POST['sortBy']) || !empty($_POST['fstdate']) || !empty($_POST['enddate']) ){
        $start = !empty($_POST['page'])?$_POST['page']:0;
        $limit = 20;
        $whereSQL =''; $orderSQL = '';
        $keywords = trim($_POST['keywords']);
        //$keywords1 = preg_replace('//', '%', $keywords);
        $sortBy = $_POST['sortBy'];
        $fstdate= $_POST['fstdate'];
        $enddate= $_POST['enddate'];

        if(!empty($keywords)){
            $whereSQL = "WHERE pos_url like '%" . $keywords .  "%' OR merchant_name LIKE '%" . $keywords ."%' order by id desc";
            //echo " $whereSQL";
        }
        else if(!empty($sortBy)){
           $whereSQL = "where user_id=$sortBy ORDER BY id desc";
        }
        else if(!empty($fstdate)){
            $whereSQL = "WHERE activity_at BETWEEN '".date('Y-m-d',strtotime($fstdate))."' AND '".date('Y-m-d',strtotime($enddate))."' order by id desc";
            //echo ($whereSQL);
        }
        $queryNum = $conn->query("SELECT COUNT(*) as postNum FROM admin_user_log " .$whereSQL.$orderSQL);
        $resultNum = $queryNum->fetch_assoc();
        $rowCount = $resultNum['postNum'];

        //initialize pagination class
        $pagConfig = array(
            'currentPage' => $start,
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
       // print_r($pagConfig);
        $pagination =  new Pagination($pagConfig);
    
        $query = $conn->query("SELECT * FROM admin_user_log $whereSQL $orderSQL LIMIT $start,$limit");
    }else{
      
        $start = !empty($_POST['page'])?$_POST['page']:0;
        //echo $start;
        $limit = 20;
    
    
    //get number of rows
    $queryNum = $conn->query("SELECT COUNT(*) as postNum FROM admin_user_log");
    $resultNum = $queryNum->fetch_assoc();
    $rowCount = $resultNum['postNum'];
    $pagConfig = array(
        'currentPage' => $start,
        'totalRows' => $rowCount,
        'perPage' => $limit,
        'link_func' => 'searchFilter'
    );
    
     $pagination =  new Pagination($pagConfig);
     $query = $conn->query("SELECT * FROM admin_user_log ORDER BY id DESC LIMIT $start, $limit");
     //print_r( $query);
   
    } 
     if($query->num_rows > 0){ ?>
        <div class="posts_list">
        <?php
        $output ='';
        $i=1;
        $output .='<h3 align="center">Search Results</h3>';
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
                            </thead>';?>
            <?php while($row = $query->fetch_assoc()){ 
        ?>
<!--            <div class="list_item"><a href="javascript:void(0);"><h2><?php echo $row["user_name"]; ?></h2></a></div>-->
                  <?php
    
            $output .='<tr>
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
        <?php } else{echo "<p align='center' class='text-danger'>no records</p>";} ?>
        </div>
<?php echo $pagination->createLinks(); }?>



