<?php
include_once('../../application_main.php');
include_once('../../session.php');
$objUser = new adminUser();
//print_r($_POST).'<BR>';
if(isset($_POST['page'])){
 include_once('../../include/classes/pagination.php');
                $start = !empty($_POST['page'])?$_POST['page']:0; 
                $limit = 20;
               $keywords = trim($_POST['Keywords']);
                switch ($_POST['Calltype']){
                case 'sort_by_pos_marchant':
                     $whereSQL = "WHERE pos_url like '%" . $keywords .  "%' OR merchant_name LIKE '%" . $keywords ."%' order by id desc";
                    break;
                case 'sort_by_username':
                     $whereSQL = "where user_id=$keywords ORDER BY id desc";
                     break;
                case 'sort_by_date':
                    $keyworddate = explode("~", $_POST['Keywords']);
                    $whereSQL = "WHERE activity_at BETWEEN '".date('Y-m-d',strtotime($keyworddate[0]))."' AND '".date('Y-m-d',strtotime($keyworddate[1]))."' order by id desc";
                    break;
               default :
                    $whereSQL= '';
                    break;
            }
        $queryNum = $conn->query("SELECT COUNT(*) as postNum FROM admin_user_log " .$whereSQL);
        //echo  $queryNum ;
        $resultNum = $queryNum->fetch_assoc();
        $rowCount = $resultNum['postNum'];
        $pagConfig = array(
            'currentPage' => $start,
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination =  new Pagination($pagConfig);
        $query = $conn->query("SELECT * FROM admin_user_log $whereSQL LIMIT $start,$limit");
  if($query->num_rows > 0){ ?>
        <div class="posts_list">
        <?php
        $output ='';
        $i=1;
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
        <?php while($row = $query->fetch_assoc()){  ?>
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
<?php echo $pagination->createLinks();} ?>



