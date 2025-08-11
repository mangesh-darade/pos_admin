<?php
class adminUser  {
    
    private $conn;    
    public $adminUsers;

    public $type;
    public $record_id;
    public $select_fields;
    
    public function __construct($conn) { 
        
         global $objapp;
        
        $this->appCommon = $objapp;
        
        if($conn == '') {
            $this->conn = $this->appCommon->conn();
        } else {
            $this->conn = $conn;
        }
        
        $this->type      = '';
        $this->record_id = '';
        $this->select_fields = '';
    }

    public function getUser() {
        
          $sql = "SELECT `user_id`, `username` ,`display_name`, `is_disrtibuter`, `email_id`, `mobile_no`, `group_id`, `group` , `created_at` , `is_active`, `current_login` 
                FROM ".TABLE_ADMIN."
                WHERE  `is_delete` = '0' AND `is_disrtibuter` = '0' ";
        
        $result = $this->conn->query($sql);
      
        if($result->num_rows):
            
            while($row = $result->fetch_assoc()) {                 
            
                 $this->adminUsers[] = $row; 
                
            }//end while.
            
        endif;
        
        
        return $this->adminUsers;
    }
    
    public function get_record($user_id='', $select='') {
       
        if(is_numeric($user_id)) {
            $this->record_id = $user_id;
        }
        if($select != '') {
            $this->select_fields = $select;
        }
        
        return $this->get_list();      
    }
    
    public function getAdminUsers() {
        
          $sql = "SELECT a.`user_id`, a.`username` ,a.`display_name`, a.`is_disrtibuter`, a.`email_id`, a.`mobile_no`, a.`group_id`, g.`group_key` as group, g.group_name "
                  . "                FROM ".TABLE_ADMIN." as a left join  ".TABLE_ADMIN_USER_GROUP." as g ON a.`group_id` = g.`id`
                WHERE  a.`is_delete` = '0' ";
        
        $result = $this->conn->query($sql);
      
        if($result->num_rows):
            
            while($row = $result->fetch_assoc()) {                 
            
                 $this->adminUsers[] = $row; 
                
            }//end while.
            
        endif;
        
        
        return $this->adminUsers;
    }
    
    public function get_list() {
        
        if(is_numeric($this->record_id)){            
           $where =  " WHERE a.`user_id` IN ( $this->record_id ) ";
           $limit = " LIMIT 1";
        } else {
            $where =  " WHERE  a.`is_delete` = '0'  ";
            $limit = "";
        }
        
        if($this->select_fields == '') {
            $this->select_fields = " a.`user_id` as id, a.`username` ,a.`display_name`, a.`is_disrtibuter`, a.`email_id`, a.`mobile_no`, a.`group_id`, g.`group_key` as `group`, g.group_name  ";
        } 
        
         $query = "SELECT ".$this->select_fields." FROM ".TABLE_ADMIN." as a left join  ".TABLE_ADMIN_USER_GROUP." as g ON a.`group_id` = g.`id` "
                . $where
                . " ORDER BY a.display_name "
                . $limit;
        
         $result = $this->conn->query($query);
         
         if($result->num_rows){ 
            
             if(is_numeric($this->record_id)){
                    $datalist = $result->fetch_assoc();                 
             } else {             
                while($row = $result->fetch_assoc()) {             
                    $datalist[$row['id']] = $row;
                }               
             }
             
              return $datalist;
         }        
    }
    
    public function filter_data(array $resuestData) {
        
        $whereClause = "";
        
        $itemsPerPage   = $resuestData['perpage'];
        $pageno         = $resuestData['page'];
        
        $this->tableData['itemsPerPage'] = $itemsPerPage; 
        $this->tableData['pageno']       = $pageno; 
        $this->tableData['sort']         = $resuestData['sort'];  
        
        $developerCondition = " AND  a.`group_id` > '1'  ";
        
        
        if($this->select_fields == '') {
            
            $this->select_fields = " a.`user_id` as id, a.`username` ,a.`display_name`, a.`is_disrtibuter`, a.`email_id`, a.`mobile_no`, a.`group_id`, g.`group_key` as `group`, g.group_name, a.is_active, a.is_delete, a.updated_at, a.created_at  ";
        } 

        $selectFields = "SELECT ".$this->select_fields;
        
        $joinTable = " FROM ".TABLE_ADMIN." as a left join  ".TABLE_ADMIN_USER_GROUP." as g ON a.`group_id` = g.`id` ";
                
        $selectTableJoin = $selectFields . $joinTable;
            
        if($resuestData['result_type'] == 'filter') {
            
            if(is_array($resuestData['conditions'])){

                foreach($resuestData['conditions'] as $field=>$value) 
                {
                    if(in_array($field, ['perpage','page'])) continue;
                    $whereData[] = " a.`$field` = '$value' ";
                }
                
                $whereClause = join(' AND ', $whereData);
            }
                    
            $sqlCount = "SELECT count(a.user_id) as num " . $joinTable .  " WHERE " . $whereClause . " " . $developerCondition . " ORDER BY a.`display_name` " ;
            
            $query = $selectTableJoin .
                     " WHERE " . $whereClause . " " . $developerCondition . " ORDER BY a.`display_name`   
                       LIMIT " . ( $pageno - 1 ) * $itemsPerPage . ", " . $itemsPerPage;
            
        }
        
        if($resuestData['result_type'] == 'search') {
            
            $this->tableData['search_key'] = $resuestData['search_key']; 
            
            $search_key = $this->appCommon->prepareInput($resuestData['search_key']);
            
            $sqlCount = " SELECT count(a.user_id) as num " . $joinTable
                        . " WHERE ( a.`display_name` LIKE '%$search_key%' OR a.`mobile_no` LIKE '%$search_key%' OR a.`email_id` LIKE  '%$search_key%' ) "
                        . $developerCondition;
            
           $query = $selectTableJoin
                    . " WHERE ( a.`display_name` LIKE  '%$search_key%' OR a.`mobile_no` LIKE  '%$search_key%' OR a.`email_id` LIKE  '%$search_key%')  
                                    ".$developerCondition . 
                                    " ORDER BY a.`display_name` ASC  
                                    LIMIT ".( $pageno - 1 ) * $itemsPerPage .", " .$itemsPerPage;
        }
         
        if($sqlCount != ''){
            
            $resultCount = $this->conn->query($sqlCount);
           
            if($resultCount) {
                $rec = $resultCount->fetch_assoc();    
                $this->tableData['count'] = $rec['num'];                 
            } else {
                echo '<div class="alert alert-danger">'.$this->conn->error.'</div>';
                exit;
            }
        }
        
        if($query != ''){
            
            $result = $this->conn->query($query);
            
           if($result) { 
            
                if($result->num_rows):

                    $num = ( $pageno - 1 ) * $itemsPerPage;

                    //$posCounts = $this->getPosCounts();

                    while($row = $result->fetch_assoc()) 
                    {                    
                        $num++;
                        $row['index'] = $num; 
                        $this->tableData['rows'][$row['id']] = $row;
                       // $this->tableData['rows'][$row['id']]['pos_count'] = 0 + $posCounts[$row['id']];
                    }//end while.
                  
                    return $this->tableData;

                else :
                    $row['index'] = 0;
               
                    return $this->tableData['rows'] = array();
                endif;
            } 
            else 
            { 
                echo '<div class="alert alert-danger">'.$this->conn->error.'</div>'; 
                exit;
            }
        }
        
        return false;
    } 
    
    public function dataPagignations($tableData) {
       
        $total_records = $tableData['count'];
        $active_pageno = $tableData['pageno'];
        $itemsPerPage  = $tableData['itemsPerPage'];
        $displayPage = 5;
        
        if($total_records <= $itemsPerPage ) return false;
        
        $pagelist = ceil($total_records / $itemsPerPage);
 
        $pagignation = '<ul class="pagination pagination-sm" style="margin-top: 0px; margin-bottom: 0px;">';

        $prePage = $active_pageno - 1;
        $nextPage = $active_pageno + 1;

        if($active_pageno == 1) {
               $pagignation .= '<li class="disabled"><a>&laquo;</a></li>';
        }

        if($active_pageno > 1) {
               $pagignation .= '<li><a onclick="viewDataList('. $prePage .')">&laquo;</a></li>';
        }
       
        $initpage = ($displayPage < $active_pageno && $pagelist > $displayPage ) ? ceil($active_pageno - ($displayPage / 2)) : 1;

        if($initpage > 1) {
            $pagignation .= '<li><a onclick="viewDataList(1)">1</a></li>';
            $pagignation .= '<li class="disabled"><a>...</a></li>';
        }

        for($i=1 ; $i <= $displayPage; $i++){

            $p = $initpage;

            if($p > $pagelist) break;

            $activeClass = ($active_pageno == $p) ? ' class="active" ' : '';

            $pagignation .= '<li '.$activeClass.' ><a onclick="viewDataList('.$p.')">'.$p.'</a></li>';
            $initpage++;
        }

        if($pagelist > $displayPage && $pagelist > $p ){
             $pagignation .= '<li><a>...</a></li>';
             $pagignation .= '<li><a onclick="viewDataList('.$pagelist.')">'.$pagelist.'</a></li>';
        }

        if($active_pageno < $pagelist) {
            $pagignation .= '<li><a  onclick="viewDataList('. $nextPage .')">&raquo;</a></li>';
        }
        if($active_pageno == $pagelist) {
            $pagignation .= '<li class="disabled"><a>&raquo;</a></li>';
        }

        $pagignation .= ' </ul>';
        
        return $pagignation;
    }
    
    public function IsExistsUser(array $data) {
        
        $sqlStrAnd = '';
         
        foreach ($data as $key => $value) {
            
            if(empty($value)) continue;
           
            if($key == 'except_id') {
                $sqlStrAnd = " AND ( `user_id` NOT IN ('$value')) ";
            } else {
                $select  .= ", $key ";
                $sqlStr[] = " $key = '$value' ";
            }
            
        }
        
        if(is_array( $sqlStr)) {
            $sqlWhere = join( ' OR ', $sqlStr);
        }
        
      $query = "SELECT user_id $select FROM ".TABLE_ADMIN." WHERE ( $sqlWhere ) $sqlStrAnd  LIMIT 1";
        
        $result = $this->conn->query($query);  
          
        if($result->num_rows){
            
            $existData['status'] = 'Exists';            
            $existData['msg'] = 'Information already exists.';            
            $row = $result->fetch_assoc();
            
            if($row['mobile'] == $data['mobile']){
                $existData['msg'] = 'Mobile number already exists.';
            }
            if($row['email_id'] == $data['email_id']){
                $existData['msg'] = 'Email address already exists.';
            }
            if($row['username'] == $data['username'] && !empty($data['username'])){
                $existData['msg'] = 'Username already exists.';
            }
            return $existData;
        } else {
            return false;
        }
        
    }
    
    public function insert($postData) { 
        
        extract($postData);
        
        $display_name   = $this->appCommon->prepareInput($display_name);
        $email_id       = $this->appCommon->prepareInput($email_id);
        $mobile_no      = $this->appCommon->prepareInput($mobile_no);
        $username       = $this->appCommon->prepareInput($username);
        $group_id       = $this->appCommon->prepareInput($group_id);
        $group          = $this->appCommon->prepareInput($group);
        $is_disrtibuter = $this->appCommon->prepareInput($is_disrtibuter);
        
        $exists = $this->IsExistsUser(['mobile_no'=>$mobile_no , 'email_id'=>$email_id, 'username'=>$username]); 
       
        if( $exists['status'] == 'Exists'){
            $data['status'] = 'ERROR';
            $data['msg']    = $exists['msg'];
            return $data;
        }
        
        $otp = rand(1234, 9999);
        $passwd = md5($otp);
        $now = date('Y-m-d H:i:s');
        
        $sql = "INSERT INTO " . TABLE_ADMIN . " ( `username`, `display_name`, `password`, `is_disrtibuter`, `group`, `group_id`, `email_id`, `mobile_no`, `is_active`, `otp`, `otp_expired_at`, `created_at` )
                VALUES ('$username', '$display_name', '$passwd', '$is_disrtibuter', '$group', '$group_id', '$email_id', '$mobile_no', '1', '$otp', '', '$now' )";
        
        $result = $this->conn->query($sql);
        
        if($result){
            $userdata['email']  = $email_id;
            $userdata['name']   = $display_name;
            $userdata['username']   = $username;
            $userdata['vcode']  = $passwd;
            $userdata['id']     = $this->conn->insert_id;
            $data['status'] = 'SUCCESS';
            $data['msg']    = 'Congratulation! User Inserted Successfully.';
            $send = $this->sendSmsOtp($otp ,$username , $mobile_no);
             
            if($send){
                $data['msg'] .= '<br/>Password has been send to registerd mobile no.'; 
            } else {
                $data['msg'] .= '<br/>Sorry! Password could not send.'; 
            }
            //$mailed = $this->sendEmailUserRegistration($userdata);
//            if($mailed){
//                 $data['msg'] .= '<br/>Verification mail send to registered email id.';
//            }
        } else {
            $data['status'] = 'ERROR';
            $data['msg']    = '<b>Sql Error:</b> '. $this->conn->error;
        }  
        return $data;
    }
    
    public function update($postData) { 
        
        extract($postData);
        
        $update_id      = $this->appCommon->prepareInput($update_id);
        $display_name   = $this->appCommon->prepareInput($display_name);
        $email_id       = $this->appCommon->prepareInput($email_id);
        $mobile_no      = $this->appCommon->prepareInput($mobile_no);
        $group_id       = $this->appCommon->prepareInput($group_id);
        $group          = $this->appCommon->prepareInput($group);
        $is_disrtibuter = $this->appCommon->prepareInput($is_disrtibuter);
        
        $exists = $this->IsExistsUser(['mobile_no'=>$mobile_no , 'email_id'=>$email_id, 'username'=>$username, 'except_id'=>$update_id]); 
       
        if( $exists['status'] == 'Exists'){
            $data['status'] = 'ERROR';
            $data['msg']    = $exists['msg'];
            return $data;
        }
        
        $sql = "UPDATE " . TABLE_ADMIN 
                . " SET `display_name` = '$display_name',
                        `email_id` = '$email_id' ,
                        `mobile_no` = '$mobile_no' ,
                        `is_disrtibuter` = '$is_disrtibuter' ,
                        `group` = '$group' ,
                        `group_id` = '$group_id' 
                    WHERE `user_id` = '$update_id' ";
       
        $result = $this->conn->query($sql);
        
        if($result){             
            $data['status'] = 'SUCCESS';
            $data['msg']    = 'Congratulation! Record Updated Successfully.';             
        } else {
            $data['status'] = 'ERROR';
            $data['msg']    = '<b>Sql Error:</b> '. $this->conn->error;
        }  
        return $data;
    }
    
    public function sendEmailUserRegistration(array $userdata){
        extract($userdata);
        $vid = md5($id);
        $vuid = md5($username);
        $mailData['to'] = $email;
        $mailData['subject'] = "Simplypos distributor account created";
        $message = "Dear $name,<br/><p>Your Simplypos distributors account has been generated successfully.</p><br/>";
        $message .= "<p>Please click the below link to activate your account.</p>";
        $message .= "<p>Please <a href='https://simplypos.in/account_verification.php?vcod=$vcode&vid=$vid&vuid=$vuid'>Click here</a> to activate account.</p>";
        $message .= "<p>After verification complited , you will receive your login password on your registered mobile no.</p>";
        $message .= "<br/><br/><br/>Thank You,<br/>SimplyPos Team.";
         
        $mailData['body'] = $message;
        return $this->appCommon->sendMail( $mailData );
    }
    
    public function sendSmsOtp($otp , $username , $phone){
        
        // $sms_text = "Congratulation! Your Simplypos Distributor Account Created. Use Username: $username and OTP: $otp to login your account. OTP valid only for 30 minuts. Login link: ".BASEURL."posadmin/login.php";
        //$sms_text = "Congratulation! Your Simplypos Distributor Account Created. Use OTP $otp to login your account.";
        $sms_text = "Congratulation! Your Simplypos Account Created Successfully. Login link: ".BASEURL."posadmin/login.php Username:$username and PIN: $otp to login your account.";
        
        $send = $this->appCommon->SendSMS($phone, $sms_text);
        $sendArr = json_decode($send);
        if($sendArr->ErrorMessage=='Success') {
            return true;
        } else {
           return false;
        }
    }
    
    
    public function getUserGroups() {
        
          $sql = "SELECT `id`, `group_key` ,`group_name` 
                FROM ".TABLE_ADMIN_USER_GROUP."
                WHERE  `is_delete` = '0' AND `is_active` = '1' ";
        
        $result = $this->conn->query($sql);
      
        if($result->num_rows):
            
            while($row = $result->fetch_assoc()) {                 
            
                 $this->adminUsers[] = $row; 
                
            }//end while.
            
        endif;
        
        
        return $this->adminUsers;
    }
    
    public function getUserLog($userId='') {
        
        if(!empty($userId)) {
            $where = " WHERE `user_id` = '$userId' ";
        } else {
            $where = "";
        }
        
        $query = "SELECT `user_id`,`user_name`,`user_type`,`merchant_id`,`merchant_name`,`merchant_phone`,`pos_url`,`user_activity`,`activity_at`,`activity_ip` "
                . " FROM ".TABLE_ADMIN_USER_LOG 
                . " $where order by `activity_at` DESC ";
        
        $result = $this->conn->query($query);      
        
        if($result->num_rows):
            
            while($row = $result->fetch_assoc()){
            
                $logData[] = $row;
            }
        
            return $logData;
            
        endif; 
        
    } 
    
    public function getPosCounts() {
        
        $query = "SELECT COUNT( id ) num,  `distributor_id` as id 
                FROM  ".TABLE_MERCHANTS."
                WHERE  `is_delete` =  '0'
                GROUP BY  `distributor_id`";
        
        $result = $this->conn->query($query);
        
        $data[0] = 0;
        
        if($result->num_rows){

            while($row = $result->fetch_assoc()) 
            {
                $data[$row['id']] = $row['num'];
            }//end while.
        }
            
        return $data;
    }
    
    public function set_condition(array $array ) {
        $this->type = $array['type'];
        $this->record_id = $array['id'];
    } 
    
    public function __destruct() {
        
        /* close connection */
        $this->conn->close();
        unset($this->adminUsers);        
    }
    
}

?>