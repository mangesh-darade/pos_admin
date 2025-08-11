<?php
class distributors  {
    
    private $conn;    
    public $distributors;
    
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
    
    public function get_record($distributor_id='', $select='') {
       
        if(is_numeric($distributor_id)) {
            $this->record_id = $distributor_id;
        }
        if($select != '') {
            $this->select_fields = $select;
        }
        
        return $this->get_list();      
    }
    
    public function get_list() {
        
        if(is_numeric($this->record_id)){            
           $where =  " WHERE `user_id` IN ( $this->record_id ) ";
           $limit = " LIMIT 1";
        } else {
            $where =  " WHERE `group` IN ('employee-sales', 'distributors')  and `is_active`='1' and `is_delete`='0' ";
            $limit = "";
        }
        
        if($this->select_fields == '') {
            $this->select_fields = " `user_id` as id, `display_name` as name, `email_id`, `mobile_no`, `is_disrtibuter`, `group`, `group_id` ";
        } 
        
       $query = "SELECT ".$this->select_fields." FROM " . TABLE_ADMIN   
                . $where
                . " ORDER BY display_name "
                . $limit;
       
         $result = $this->conn->query($query);
         
         if($result) {
            if($result->num_rows){ 

                if(is_numeric($this->record_id)){
                       $datalist = $result->fetch_assoc();                 
                } else {             
                   while($row = $result->fetch_assoc()) {             
                       $datalist[$row[id]] = $row;
                   }               
                }

                 return $datalist;
            }  
         } else {
             echo $this->conn->error;
             exit;
         }
    }
    
    public function filter_data(array $resuestData) {
        
        $whereClause = "";
        
        $itemsPerPage   = $resuestData['perpage'];
        $pageno         = $resuestData['page'];
        
        $this->tableData['itemsPerPage'] = $itemsPerPage; 
        $this->tableData['pageno']       = $pageno; 
        $this->tableData['sort']         = $resuestData['sort'];  
        
        $developerCondition = " AND `group` IN ('employee-sales', 'distributors')  ";
        
        if($resuestData['result_type'] == 'filter') {
            
            if(is_array($resuestData['conditions'])){

                foreach($resuestData['conditions'] as $field=>$value) 
                {
                    if(in_array($field, ['perpage','page'])) continue;
                    $whereData[] = " `$field` = '$value' ";
                }
                
                $whereClause = join(' AND ', $whereData);
            }
        
            $sqlCount = "SELECT count(user_id) as num FROM " . TABLE_ADMIN . " WHERE " . $whereClause . " " . $developerCondition ;
            
            $query = "SELECT * FROM " . TABLE_ADMIN . " 
                     WHERE " . $whereClause . " " . $developerCondition . " ORDER BY `display_name`   
                     LIMIT " . ( $pageno - 1 ) * $itemsPerPage . ", " . $itemsPerPage;
            
        }
        
        if($resuestData['result_type'] == 'search') {
            
            $this->tableData['search_key'] = $resuestData['search_key']; 
            
            $search_key = $this->appCommon->prepareInput($resuestData['search_key']);
            
            $sqlCount = " SELECT count(user_id) as num FROM ".TABLE_ADMIN."  WHERE (  `display_name` LIKE  '%$search_key%' OR `mobile_no` LIKE  '%$search_key%' OR `email_id` LIKE  '%$search_key%' )  
                                     ".$developerCondition;
            
            $query = " SELECT * FROM ".TABLE_ADMIN."  WHERE ( `display_name` LIKE  '%$search_key%' OR `mobile_no` LIKE  '%$search_key%' OR `email_id` LIKE  '%$search_key%')  
                                    ".$developerCondition . 
                                    " ORDER BY `display_name` ASC  
                                    LIMIT ".( $pageno - 1 ) * $itemsPerPage .", " .$itemsPerPage;
        }
        
        if($sqlCount != ''){
            $resultCount = $this->conn->query($sqlCount);
            if($resultCount->error) { echo '<div class="alert alert-danger">'.$result->error.'</div>'; }
           
            if($resultCount) {
                $rec = $resultCount->fetch_assoc();    
                $this->tableData['count'] = $rec['num'];                 
            }
        } 
         
        if($query != ''){
            
            $result = $this->conn->query($query);
            if($result->error) { echo '<div class="alert alert-danger">'.$result->error.'</div>'; }
            
            if($result->num_rows):

                $num = ( $pageno - 1 ) * $itemsPerPage;
            
                $posCounts = $this->getPosCounts();
                
                while($row = $result->fetch_assoc()) 
                {
                    $num++;
                    
                    $row['index'] = $num; 
                    $row['id'] = $row['user_id'];
                    $this->tableData['rows'][$row['user_id']] = $row;
                    $this->tableData['rows'][$row['user_id']]['pos_count'] = 0 + $posCounts[$row['id']];
                }//end while.
                
                 
                return $this->tableData;

            else :
                return false;
            endif;
            
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
        
        $exists = $this->IsExistsUser(['mobile_no'=>$mobile_no , 'email_id'=>$email_id, 'username'=>$username]); 
       
        if( $exists['status'] == 'Exists'){
            $data['status'] = 'ERROR';
            $data['msg']    = $exists['msg'];
            return $data;
        }
        
        if($is_disrtibuter) {
            $group = 'disrtibuter';
        } else {
            $group = 'admin-user';            
        }
        
        $otp = rand(1234, 9999);
        $passwd = md5($otp);
        
        $sql = "INSERT INTO " . TABLE_ADMIN . " ( `username`, `display_name`, `password`, `is_disrtibuter`, `group`,  `email_id`, `mobile_no`, `is_active`, `otp`, `otp_expired_at` )
                    VALUES ('$username', '$display_name', '$passwd', '$is_disrtibuter', '$group' , '$email_id', '$mobile_no', '1', '$otp', '' )";
       
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
        
        $exists = $this->IsExistsUser(['mobile_no'=>$mobile_no , 'email_id'=>$email_id, 'username'=>$username, 'except_id'=>$update_id]); 
       
        if( $exists['status'] == 'Exists'){
            $data['status'] = 'ERROR';
            $data['msg']    = $exists['msg'];
            return $data;
        }
        
        $sql = "UPDATE " . TABLE_ADMIN 
                . " SET `display_name` = '$display_name',
                        `email_id` = '$email_id' ,
                        `mobile_no` = '$mobile_no' 
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
    
    public function submitRequest(array $postData) {
       
        if($_SESSION['login']['is_disrtibuter']==0) {
            return false;
        }
        
        $merchant_id    = $postData['id'];
        $type           = $postData['type'];
        $comment        = $postData['comment'];
        $distributor_id = $_SESSION['session_user_id'];
        $now = date('Y-m-d H:i:s');
        
         $sql = "INSERT INTO " . TABLE_DISTRIBUTORS_REQUEST . " ( `merchant_id`, `distributor_id`, `request_type`, `distributor_comments`, `request_at`, `request_status`, `view_status` )
                    VALUES ('$merchant_id', '$distributor_id', '$type', '$comment', '$now' , 'pending', '0'  )";
       
        $res = $this->conn->query($sql); 
         
        if ($res) {
          return $this->conn->insert_id;
        } else {
            echo $this->conn->error;
            return false;
        } 
          
    }
        
    public function updateRequest(array $postData) {
       
        if($_SESSION['login']['is_disrtibuter']==1) {
            return false;
        }
        
        $request_id         = $this->appCommon->prepareInput($postData['id']);
        $request_status     = $this->appCommon->prepareInput($postData['request_status']);
        $admin_comment      = $this->appCommon->prepareInput($postData['admin_comment']);
        $view_status        = 1;
        $request_handled_by = $this->appCommon->prepareInput($_SESSION['session_user_id']);
        $now = date('Y-m-d H:i:s');
        
         $sql = "UPDATE " . TABLE_DISTRIBUTORS_REQUEST  
                . " SET `request_status` = '$request_status', "
                    . "`admin_comment` = '$admin_comment', "
                    . "`view_status` = '$view_status', "
                    . "`request_handled_by` = '$request_handled_by', "
                    . "`replay_at` = '$now' "
                . "WHERE `id` = '$request_id' ";
       
        $res = $this->conn->query($sql); 
         
        if ($res) {
           $data['status']='SUCCESS';
        } else {
            $data['status']='ERROR';
            $data['msg']    = '<b>Sql Error:</b> '. $this->conn->error;
        }
        
        return $data;
    }
    
    public function requestList(array $resuestData)
    {
        $whereClause = "";
        
        $itemsPerPage   = $resuestData['perpage'];
        $pageno         = $resuestData['page'];
        
        $this->tableData['itemsPerPage'] = $itemsPerPage; 
        $this->tableData['pageno']       = $pageno; 
        $this->tableData['sort']         = $resuestData['sort'];  
        
        $developerCondition = " ";
        
        if($_SESSION['login']['is_disrtibuter']==1) {
            $developerCondition = " AND `distributor_id` = '".$_SESSION['session_user_id']."' ";
        }
        
        if($pageno) {
            $limit = " LIMIT " . ( $pageno - 1 ) * $itemsPerPage . ", " . $itemsPerPage;
        }
        
        if($resuestData['result_type'] == 'filter') {
            
            if(is_array($resuestData['conditions'])){

                foreach($resuestData['conditions'] as $field=>$value) 
                {
                    if(in_array($field, ['perpage','page'])) continue;
                    $whereData[] = " `$field` = '$value' ";
                }
                
                $whereClause = join(' AND ', $whereData);
            }
        
            $sqlCount = "SELECT count(id) as num FROM " . TABLE_VIEW_DISTRIBUTORS_REQUEST . " WHERE " . $whereClause . " " . $developerCondition ;
            
           $query = "SELECT * FROM " . TABLE_VIEW_DISTRIBUTORS_REQUEST . " 
                      WHERE " . $whereClause . " " . $developerCondition . " ORDER BY `request_at` DESC  ".$limit;
           
                
        }
        
        if($resuestData['result_type'] == 'search') {
            
            $this->tableData['search_key'] = $resuestData['search_key']; 
            
            $search_key = $this->appCommon->prepareInput($resuestData['search_key']);
            
            $sqlCount = " SELECT count(id) as num FROM ".TABLE_VIEW_DISTRIBUTORS_REQUEST."  "
                        . "WHERE ( `request_type` LIKE '%$search_key%' OR `distributor_comments` LIKE  '%$search_key%' OR  `admin_comment` LIKE  '%$search_key%' ) ".$developerCondition;
            
            $query = " SELECT * FROM ".TABLE_VIEW_DISTRIBUTORS_REQUEST." "
                    . " WHERE ( `request_type` LIKE '%$search_key%' OR `distributor_comments` LIKE  '%$search_key%' OR  `admin_comment` LIKE  '%$search_key%' ) ".$developerCondition . 
                      " ORDER BY `request_at` DESC "
                    . $limit;
        }
         
        if($sqlCount != '') {
            $resultCount = $this->conn->query($sqlCount);
            if($resultCount->error) { echo '<div class="alert alert-danger">'.$result->error.'</div>'; }
           
            if($resultCount) {
                $rec = $resultCount->fetch_assoc();    
                $this->tableData['count'] = $rec['num'];                 
            }
        } 
         
        if($query != ''){
             
            $result = $this->conn->query($query);
            
            if($result->error) { echo '<div class="alert alert-danger">'.$result->error.'</div>'; }
           
            if($result->num_rows):

                $num = ( $pageno - 1 ) * $itemsPerPage;

                while($row = $result->fetch_assoc()) 
                {
                    $num++;
                    
                    $row['index'] = $num;
                    $this->tableData['rows'][$row['id']] = $row;

                }//end while.

                return $this->tableData;

            else :
                return false;
            endif;
            
        }
        
        return false;
    } 
    
    public function get_request($id){
        
        $resuestData['result_type'] = 'filter';
        $resuestData['conditions']['id'] = $id;
         
       $record = $this->requestList( $resuestData );
       
       return $record['rows'][$id];
    }
    
    public function set_condition(array $array ) {
       $this->type = $array['type'];
       $this->record_id = $array['id'];
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
    
    public function isRequestExists($request_type, $merchant_id) {
        
        if(!$request_type || !$merchant_id) return false;
        
        $distributor_id = $_SESSION['session_user_id'];
        
        $query="SELECT id, request_type, request_type_key, distributor_comments, request_at, request_status, view_status, replay_at, request_handler_name, admin_comment 
                FROM  ".TABLE_VIEW_DISTRIBUTORS_REQUEST." 
                WHERE  `distributor_id` =  '$distributor_id' 
                    AND  `request_type_key` =  '$request_type' 
                    AND  `merchant_id`  =  '$merchant_id' 
                    AND  `request_status` IN ( 'pending', 'hold' ) 
                    AND  `is_delete` =  '0' 
                    AND  `is_active` =  '1' LIMIT 1"; 
        
        $result = $this->conn->query($query);
        
        $data['status'] = false;
        
        if($result->num_rows){
            
            $data = $result->fetch_assoc();
            $data['status'] = true;
        }
            
        return $data;
        
    }
    
    public function __destruct() {        
        /* close connection */
        $this->conn->close();
        unset($this->distributors);        
    }
    public function getDistributorRequest(){
		$sql="SELECT m.name, dr.distributor_comments, dr.request_at FROM `distributors_request` dr inner join merchants m on dr.merchant_id=m.id WHERE 1 order by dr.id desc"; 
		$result = $this->conn->query($sql);
		$logData = array();
		while($row = $result->fetch_assoc())
        {
            $logData[] = $row;
        }
		return $logData;
	}
}

?>