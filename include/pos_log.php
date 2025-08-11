<?php
function setPosToMerchant($setupdata){
    
     global $conn;
     
     extract($setupdata);
     
     $createdat = date('Y-m-d h:i:s');
     
    //$expiryDate = get_feature_date( $no_of_feature_day=14 , $no_of_feature_month=0 , $no_of_feature_years=0);
     
    //$expiryDateTime = $expiryDate . " 23:59:59";
        
        
    $pos_name = str_replace([HOSTNAME,'/','http:','https:','.'], '', $pos_url);
    
    $project_directory_path = POS_PROJECT_DIR . $pos_name;
    
    $privateKeyEncryp = setPrivateKeyEncrypt($merchant_id);
        
    $sqlQuery = "UPDATE  ".TABLE_MERCHANTS."  
                SET   
                    `pos_url` =  '$pos_url',
                    `pos_name` = '$pos_name',
                    `project_directory_path` = '$project_directory_path',
                    `db_name` =  '$db_name',
                    `db_username` =  '$db_user',
                    `db_password_encript` =  '$db_password',
                    `pos_create_at` =  '$createdat' ,                     
                    `pos_demo_expiry_at` = DATE_ADD( '$createdat' , INTERVAL ".FREE_DEMO_DAYS." DAY ) ,                    
                    `pos_generate` = '1', 
                    `pos_status` =  'created',
                    `pos_previous_status` = 'pending' ,
                    `package_id` = '1', 
                    `pos_current_version` = '$current_pos_version', 
                    `sql_current_version` = '$current_sql_version', 
                    `subscription_start_at` = '$createdat' , 
                    `subscription_end_at` = DATE_ADD( '$createdat' , INTERVAL ".FREE_DEMO_DAYS." DAY ) , 
                    `subscription_is_active` = '1' ,
                    `private_key` = '$privateKeyEncryp' 
                WHERE 
                    `id` = '$merchant_id' ";
   
        
    $result = $conn->query($sqlQuery);
             
    if($result) {

        return true;
        
     } else {
         echo "<div class='alert alert-danger'>POS Project Could not Apply to merchant.</div>";
         return false;
     }
    
}      


function setPrivateKeyEncrypt($key){
    
    global $objapp;
    
    return $objapp->mc_encrypt(sha1($key.time()));
    
}

function getSetupStatus($merchant_id , $pos_name){
    
    global $conn;
    
  $sql  = " SELECT id, merchant_id, status , step_1 , step_2 ,step_3 ,step_4 ,step_5 ,step_6 ,step_7, pos_url, db_name, db_user, db_password "
            . " FROM ". TABLE_POS_SETUP_LOG
            . " WHERE  `merchant_id` = '$merchant_id' AND `pos_name` = '$pos_name' "
            . " LIMIT 1 "; 
            
    $result = $conn->query($sql);
    
     if($result) {
         
         $row_cnt = $result->num_rows;
         
         if($row_cnt) {
            $row = $result->fetch_array(MYSQLI_ASSOC);        
            $row['num'] = $row_cnt;
           
         } else {
             $row['num'] = 0;
         }
         
         return $row;
     }
}

function cleanMerchantProject($setupdata){
    
    $pos_name = $setupdata['pos_name']; 
    
    $clean = unlink("../".$pos_name); 
    
    if($clean){
        return false;
    }
}
        


function setp_success($data){
    
    global $conn;
    
    $status = prepareInput($data['status']);
    $merchant_id = $data['merchant_id'];
    $pos_name = prepareInput($data['pos_name']);
    
    $step_1 = $data['step_1'];
    $step_2 = $data['step_2'];
    $step_3 = $data['step_3'];
    $step_4 = $data['step_4'];
    $step_5 = $data['step_5'];
    $step_6 = $data['step_6'];
    $setup_id = $data['setup_id'];
    
    switch($data['step'])
    {
        case 1: 
        
          $prefix = $data['prefix'];
          $pos_url = prepareInput($data['pos_url']);
          
          $time = date('Y-m-d H:i:s');
          
          if($step_1) 
          { 
            $session_user_id = $_SESSION['session_user_id'];
              
            $sql  = "UPDATE ".TABLE_POS_SETUP_LOG." SET "
                    . " `prefix` = '$prefix', `step_1` = '$step_1', `pos_url` = '$pos_url', `status` = '$status', `created_at` = '$time' , `created_by` = '$session_user_id' "
                    . "  WHERE  `merchant_id` = '$merchant_id' ";
           
             $result = $conn->query($sql);
             
             if($result) {                 
                 return true;
             } else {
                 echo "<div class='alert alert-danger'>".$result->error."</div>";
                 return false;
             }
          }  
            break;
        
        case 2:
            
            $sql  = "UPDATE ".TABLE_POS_SETUP_LOG." SET  `step_2` = '$step_2', `status` =  concat(status, '$status') WHERE  `merchant_id` = '$merchant_id' "; 
            
            $result = $conn->query($sql);
             
             if($result) {
                 
                 return true;
             } else {
                 echo "<div class='alert alert-danger'>".$result->error."</div>";
                 return false;
             }
            
            break;
        
        case 3:
            
            $sql = "UPDATE ".TABLE_POS_SETUP_LOG." SET  `step_3` = '$step_3', `status` =  concat(status, '$status') "
                 . " WHERE  `merchant_id` = '$merchant_id' "; 
               
            try {
                    $result = $conn->query($sql);
                } catch (Exception $exc) {
                    echo $exc->getTraceAsString();
                }

            if($result) {        
                return true;
            } else {
                echo "<div class='alert alert-danger'>".$result->error."</div>";
                return false;
            }
            
            break;
        
        case 4:
            
            $sql  = "UPDATE ".TABLE_POS_SETUP_LOG." SET  `step_4` = '$step_4', `status` =  concat(status, '$status') WHERE  `merchant_id` = '$merchant_id' "; 
            
            $result = $conn->query($sql);
             
             if($result) {
        
                 return true;
             } else {
                echo "<div class='alert alert-danger'>".$result->error."</div>";
                return false;
             }
            break;
        
        case 5:
            
        $sql  = "UPDATE ".TABLE_POS_SETUP_LOG." SET  `step_5` = '$step_5', `status` = concat(status, '$status') WHERE  `merchant_id` = '$merchant_id' "; 
          
            $result = $conn->query($sql);
             
             if($result) {
               
                 return true;
             } else {
                echo "<div class='alert alert-danger'>".$result->error."</div>";
                return false;
             }
            break;
        
        case 6:
            
            $sql  = "UPDATE ".TABLE_POS_SETUP_LOG." SET  `step_6` = '$step_6', `status` =  concat(status, '$status') WHERE  `merchant_id` = '$merchant_id' "; 
            
            $result = $conn->query($sql);
             
             if($result) {
                 
                 return true;
             } else {
                echo "<div class='alert alert-danger'>".$result->error."</div>";
                return false;
             }
            break;
        
        case 7:
            
            break;
        
    }
   
}



////
//
//get_future_date(number_of_days,number_of_months,number_of_years);
//below returns a future date (day/month/year)  
//$expire_date = get_future_date(0,3,0);  //a bit of theory
//Return Future date according to send parameter.
//PARA: No_OF_DAY , No_OF_MONTH , No_OF_YEARS
function get_feature_date( $no_of_feature_day=0 , $no_of_feature_month=0 , $no_of_feature_years=0)
{

    $fday = $no_of_feature_day;
    $fmonth = $no_of_feature_month;
    $fyear = $no_of_feature_years;

	$d=date(j)+$fday;
	$m=date(n)+$fmonth;
	$y=date(Y)+$fyear;

	if($d > 31)
	{
            while($d > 31)
            {
                $d-=31;
                $m+=1;
            }
	}
	if($m>12)
	{
            while($m>12)
            {
                $m-=12;
                $y+=1;
            }
	}
	//below sets sequence: day/month/year
	if($d <10) $d='0'.$d;
	
	$r = "$y-$m-$d";
	
	return $r;

}
//
////
    
?>