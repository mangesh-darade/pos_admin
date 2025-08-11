<?php

class merchant {
    
    protected $conn;    
    public $merchants;    
    public $merchantTypes; 
    public $merchantTypeList; 
    public $merchant_transactions; 
    public $appCommon; 
    public $record_id; 
    
    public $resetcode;    
    public $resetcode_encript; 
    public $packages;
    
    private $conn_pos;
    private $posUsers;    
    private $CP_xmlapi;
    private $CP_validData;

    public function __construct($conn = '') {
        
        global $objapp;
        $this->appCommon = $objapp;
        
        if($conn == '') {
            $this->conn = $this->appCommon->conn();
        } else {
            $this->conn = $conn;
        }
        
        $this->merchantTypes = $this->getMerchantType();

        $this->merchant_transactions = '';
    }
    
    public function set_condition(array $array ) {
        
       $this->record_id = $array['id'];
    }
    
    public function get_record() {
       return $this->get($this->record_id);
    }
    
    public function get($id='') {
        
        if(is_numeric($id)) {
            $whereMerchant = " `id` = '$id' ";
        }
        elseif(is_array($id)) {            
            $ids = join(',' , $id);
            $whereMerchant = " `is_delete` = '0' AND `id` IN ($ids) ";
        } else {
            $whereMerchant = " `is_delete` = '0' ";
        }
        
       $query = "SELECT * FROM ".TABLE_MERCHANTS." 
                 WHERE $whereMerchant order by `id` DESC  ";
        
       $result = $this->conn->query($query);      
        
        if($result->num_rows):
            
            if($result->num_rows > 1){
                
                $this->packages = $this->get_packages();
                
                while($row = $result->fetch_assoc()) 
                {
                    $row['count']               = $result->num_rows;
                    $row['status']              = ($row['is_active']) ? 'Active' : 'Deactive';
                    $row['email_verified']      = ($row['is_email_verified']) ? 'Verified' : 'Not Verified';
                    $row['mobile_verified']     = ($row['is_mobile_verified']) ? 'Verified' : 'Not Verified';
                    $row['package_name']        = $this->packages[($row['package_id']==0)? 1 : $row['package_id']]['package_name'];
                    
                    $this->merchants[$row['id']] = $row;

                }//end while.
                
                return $this->merchants;
                 
            } else {
                
                $this->merchants = $result->fetch_assoc(); 
               
                 return $this->merchants;
            }
        else :
            return false;
        endif;
        
    }
    
    public function filter_merchants(array $resuestData)
    {
        $whereClause = "";
        
        $itemsPerPage   = $resuestData['perpage'];
        $pageno         = $resuestData['page'];
        
        $this->merchants['itemsPerPage'] = $itemsPerPage; 
        $this->merchants['pageno']       = $pageno; 
        
        $developerCondition = " AND `id` NOT IN (1,2,3,98) ";
        
        if($resuestData['result_type'] == 'filter') {
            if(is_array($resuestData['conditions'])){

                foreach($resuestData['conditions'] as $field=>$value) {
                    if(in_array($field, ['perpage','page'])) continue;
                    $whereData[] = " `$field` = '$value' ";
                }
                
                $whereClause = join(' AND ', $whereData);
            }
        
            $sqlCount = " SELECT count(id) as num FROM ".TABLE_MERCHANTS."  WHERE ". $whereClause ." " .$developerCondition . " ORDER BY `id` DESC ";
            
            $query = " SELECT * FROM ".TABLE_MERCHANTS." 
                WHERE ". $whereClause ." " .$developerCondition . " ORDER BY `id` DESC  
                LIMIT ".( $pageno - 1 ) * $itemsPerPage .", " .$itemsPerPage;
            
        }
        
        if($resuestData['result_type'] == 'search') {
            
            $this->merchants['search_key'] = $resuestData['search_key']; 
            
            $search_key = $this->appCommon->prepareInput($resuestData['search_key']);
            
            $sqlCount = " SELECT count(id) as num FROM ".TABLE_MERCHANTS."  WHERE ( `name` LIKE  '%$search_key%'
                                    OR  `email` LIKE  '%$search_key%'
                                    OR  `phone` LIKE  '%$search_key%'
                                    OR  `address` LIKE  '%$search_key%'
                                    OR  `pincode` LIKE  '$search_key'
                                    OR  `business_name` LIKE  '%$search_key%'
                                    OR  `pos_name` LIKE  '%$search_key%'
                                    OR  `pos_url` LIKE  '%$search_key%' )  
                                     ".$developerCondition;
            
            $query = " SELECT * FROM ".TABLE_MERCHANTS."  WHERE ( `name` LIKE  '%$search_key%'
                                    OR  `email` LIKE  '%$search_key%'
                                    OR  `phone` LIKE  '%$search_key%'
                                    OR  `address` LIKE  '%$search_key%'
                                    OR  `pincode` LIKE  '$search_key'
                                    OR  `business_name` LIKE  '%$search_key%'
                                    OR  `pos_name` LIKE  '%$search_key%'
                                    OR  `pos_url` LIKE  '%$search_key%' )  
                                     ".$developerCondition . 
                                    " ORDER BY `id` DESC  
                                    LIMIT ".( $pageno - 1 ) * $itemsPerPage .", " .$itemsPerPage;
            
        }
        
        if($sqlCount != '') {
            $resultCount = $this->conn->query($sqlCount);
            if($resultCount->error) { echo '<div class="alert alert-danger">'.$result->error.'</div>'; }
           
            if($resultCount) {
                $rec = $resultCount->fetch_assoc();    
                $this->merchants['count'] = $rec['num'];                 
            }
        } 
        
        if($query != ''){
            
            $result = $this->conn->query($query);
            if($result->error) { echo '<div class="alert alert-danger">'.$result->error.'</div>'; }
            if($result->num_rows):
            
                $this->packages = $this->get_packages();

                $num = ( $pageno - 1 ) * $itemsPerPage;

                while($row = $result->fetch_assoc()) 
                {
                    $num++;
                    $row['index'] = $num;

                    $row['status']              = ($row['is_active']) ? 'Active' : 'Deactive';
                    $row['email_verified']      = ($row['is_email_verified']) ? 'Verified' : 'Not Verified';
                    $row['mobile_verified']     = ($row['is_mobile_verified']) ? 'Verified' : 'Not Verified';
                    $row['package_name']        = $this->packages[($row['package_id']==0)? 1 : $row['package_id']]['package_name'];
                    $row['pos_status'] = ($row['is_delete'] == 1) ? 'deleted' : $row['pos_status'];
                    $this->merchants['rows'][$row['id']] = $row;

                }//end while.

                return $this->merchants;

            else :
                return false;
            endif;
            
        }
        
        return false;
    }
        
    public function merchantPagignations($merchantsData) {
        
        $total_records = $merchantsData['count'];
        $active_pageno = $merchantsData['pageno'];
        $itemsPerPage  = $merchantsData['itemsPerPage'];
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
               $pagignation .= '<li><a onclick="requestMerchantsList('. $prePage .')">&laquo;</a></li>';
        }

        $initpage = ($displayPage < $active_pageno && $pagelist > $displayPage ) ? ceil($active_pageno - ($displayPage / 2)) : 1;

        if($initpage > 1) {
            $pagignation .= '<li><a onclick="requestMerchantsList(1)">1</a></li>';
            $pagignation .= '<li class="disabled"><a>...</a></li>';
        }

        for($i=1 ; $i <= $displayPage; $i++){

            $p = $initpage;

            if($p > $pagelist) break;

            $activeClass = ($active_pageno == $p) ? ' class="active" ' : '';

            $pagignation .= '<li '.$activeClass.' ><a onclick="requestMerchantsList('.$p.')">'.$p.'</a></li>';
            $initpage++;
        }

        if($pagelist > $displayPage && $pagelist > $p ){
             $pagignation .= '<li><a>...</a></li>';
             $pagignation .= '<li><a onclick="requestMerchantsList('.$pagelist.')">'.$pagelist.'</a></li>';
        }

        if($active_pageno < $pagelist) {
            $pagignation .= '<li><a  onclick="requestMerchantsList('. $nextPage .')">&raquo;</a></li>';
        }
        if($active_pageno == $pagelist) {
            $pagignation .= '<li class="disabled"><a>&raquo;</a></li>';
        }

        $pagignation .= ' </ul>';
        
        return $pagignation;
    }
    
    public function update($postData) {
        
        $countryArr = explode('~', $postData['country']); 
        
        $postData['country']        = $countryArr[0];
        $postData['country_code']   = $countryArr[1];
        $update_id          = $postData['id'];
        $merchant_mobile    = $postData['phone'];
        $pos_generate       = $postData['pos_generate'];
        
         unset($postData['action']);
         unset($postData['library']);
         unset($postData['id']);
         unset($postData['phone']);
         unset($postData['pos_generate']);
         
         if($postData['email']==''){
            $postData['email']= NULL;
         }
        
         foreach ($postData as $key => $value) {
             
             
             
             $post_data[$key] = $this->appCommon->prepareInput($value);
             $updateFields[] = " `$key` = '".$post_data[$key]."' ";
         }
         
         extract($post_data);
        
        if(isset($email) && $email != NULL) 
        {
            if(!$this->appCommon->validationRule($email , 'valid_email')){
                $data['status'] ='ERROR';
                $data['msg'] = 'Email should be valid.';
                return $data;
            }
            
            if($this->emailExists($email , $update_id)){
                $data['status'] ='ERROR';
                $data['msg'] = 'Email already exist.';
                return $data;
            }
        } 

        if($this->mobileExists($phone , $update_id)){
            $data['status'] ='ERROR';
            $data['msg'] = 'Mobile number already exist.';
            return $data;
        }

        if(!empty($pos_name)) {
            
            if(!$this->appCommon->validationRule($pos_name , 'alpha_numeric'))
            {
                $data['status'] ='ERROR';
                $data['msg'] = 'POS Url containt only letters and numbers.';
                return $data;
            }
            
            if($this->posNameExists($pos_name , $update_id)){
                $data['status'] ='ERROR';
                $data['msg'] = 'POS Url already exist.';
                return $data;
            }
        }
         
        
       if(is_array($updateFields)) 
       {
            $sql = "UPDATE " . TABLE_MERCHANTS . " SET ";
            $sql .= join(',', $updateFields); 
            $sql .= "  WHERE `id` = '$update_id' "; 
            
            $result = $this->conn->query($sql);

            if($result)
            {
                $updatePOS = false;
                
                if($pos_generate == 1) {
                    
                    if($email !=  NULL ) 
                    {
                        $merchantUpdateData = ['email' => $email];
                        $updatePOS = true;
                    }
                    
                    if($updatePOS)
                    {
                        $update = $this->update_pos_merchant_details( $update_id , $merchant_mobile,  $merchantUpdateData);
                        if($update === true){
                            $data['status'] = 'SUCCESS';
                        } else {
                            $data['status'] ='ERROR';
                            $data['msg'] ='<b>Sql Error:</b> ' . $update;
                        }
                    }
                }  
                
                if($updatePOS === false) {
                    $data['status'] = 'SUCCESS'; 
                }
                
            } else {
                $data['status'] ='ERROR';
                $data['msg'] ='<b>Sql Error:</b> ' . $result->error;
            }
           
       } else {
                $data['status'] ='ERROR';
                $data['msg'] ='Request failed.';
            }
       
         return $data;
    }
        
    public function emailVerification(array $requestData ){
        
        $merchant_id = $requestData['id'];
        $vcode = $requestData['vcode'];
        $email = $requestData['email'];
        
        $data['status'] = 'ERROR';
        $data['response'] = '';
        
        if(!is_numeric($merchant_id)){
            $data['msg'] = 'Invalid Request';
            $data['response']['error'] = 'Invalid Merchant Request';
        } else {
        
            $merchantData = $this->get($merchant_id);

            if($merchantData === false){
                $data['msg'] = 'Invalid Request';
                $data['response']['error'] = 'Merchant Not Found';              
            }
            elseif($merchantData['email'] !== $email) {

                $data['msg'] = 'Invalid Request';
                $data['response']['error'] = 'Email Not Match';
            }
            elseif($merchantData['verification_code'] !== $vcode) {
                
                $data['msg'] = 'Invalid Request';
                $data['response']['error'] = 'Token Not Match';
            }
            elseif($merchantData['is_email_verified']){
                
                $data['msg'] = 'Already verified';
                $data['response']['error'] = 'Merchant Already verified';
            }
            else{
                
               if( $this->merchantVerified($merchant_id) ){
                   
                    $data['status'] = 'SUCCESS'; 
                    $data['msg']    = 'Email Successfully Verified';
                    $data['response'] = $merchantData; 
               } else {
                   
                   $data['msg']    = 'Sorry! We could not verify right now.';
                   $data['response']['error'] = 'Error in verification'; 
               }
                
            }
            
        }//end else
        
        return $data;
        
    }
    
    public function merchantVerified($merchant_id) {
        
        return $this->emailVerified($merchant_id);
    }

    public function emailVerified($merchant_id) {
        
        $now = date('Y-m-d H:i:s');
        
        $sql = "UPDATE ".TABLE_MERCHANTS." SET `is_active` = '1' , `is_email_verified` = '1', `updated_at` = '$now' WHERE `id` = '$merchant_id' ";

        $result = $this->conn->query($sql);

        if($result) :
            return true;
        else :
            return false;
        endif;
       
    }
    
    public function mobileVerified($merchant_id) {
        
        $sql = "UPDATE ".TABLE_MERCHANTS." SET  `is_mobile_verified` = '1' WHERE `id` = '$merchant_id' ";

        $result = $this->conn->query($sql);

        if($result) :
            return true;
        else :
            return false;
        endif;
    }    
    
    public function merchantDeactive($merchant_id) {
        
        $sql = "UPDATE ".TABLE_MERCHANTS." SET `is_active` = '0' WHERE `id` = '$merchant_id' ";

        $result = $this->conn->query($sql);

        if($result) :
            return true;
        else :
            return false;
        endif;
       
    }
    
    public function merchantActive($merchant_id) {
        
        $sql = "UPDATE ".TABLE_MERCHANTS." SET `is_active` = '1' WHERE `id` = '$merchant_id' ";

        $result = $this->conn->query($sql);

        if($result) :
            return true;
        else :
            return false;
        endif;
       
    }
    
    public function merchantDelete($merchant_id) {
        
        $sql = "UPDATE ".TABLE_MERCHANTS." SET `is_delete` = '1'  WHERE `id` = '$merchant_id' ";

        $result = $this->conn->query($sql);

        if($result) :
            return true;
        else :
            return false;
        endif;
       
    }
    
    public function activateSubscription($merchant_id) {
        
        $sql = "UPDATE ".TABLE_MERCHANTS." SET `subscription_is_active` = '1' , `subscription_start_at` = '".NOW."' WHERE `id` = '$merchant_id' ";

        $result = $this->conn->query($sql);

        if($result) :
            return true;
        else :
            return false;
        endif;
       
    }
    
    public function deactivateSubscription($merchant_id) {
        
        $sql = "UPDATE ".TABLE_MERCHANTS." SET `subscription_is_active` = '0' WHERE `id` = '$merchant_id' ";

        $result = $this->conn->query($sql);

        if($result) :
            return true;
        else :
            return false;
        endif;
       
    }    
    
    public function merchantType($id){
        
        return $this->merchantTypes[$id];        
    } 
    
    public function merchantTypeList(){
        
        return $this->merchantTypeList;        
    }      
    
    public function getMerchantType($type=''){               
        
        if($type == 'mobile'){
            $where = " WHERE  `show_in_mobile` = 'Yes' ";
        } elseif($type == 'web') {
            $where = " WHERE  `show_in_web` = 'Yes' ";       
        } elseif($type == 'pos_access') {
            $where = " WHERE  `generate_pos` = 'Yes' ";
        } else {
            $where = "";
        }
        
        $sql = "SELECT *  "
                    . " FROM   " . TABLE_VIEW_MERCHANT_TYPE
                    . " $where "
                    . " ORDER BY `merchant_type` ASC";
    
        $result = $this->conn->query($sql);  
        
        if($result):
                
            $row_cnt = $result->num_rows;

            while($row = $result->fetch_array(MYSQLI_ASSOC))
            {
                if($row['id']==999){
                  $other =  $row['merchant_type'];  
                }
                elseif($row['is_active']==1 && $row['is_delete']==0) {
                    $merchants[$row['id']] = $row['merchant_type'];  
                }
                
                $this->merchantTypeList[$row['id']] = $row;                    
            }
                unset($merchants[999]);
                $merchants[999] =  $other; 
            
           /* close result set */
           $merchants = array_unique($merchants);
               
           return  $merchants;
           
            $result->close();
            
        endif;
                 
    }    
    
    public function usernameExists($username, $id=''){
        
        if($id != '' && is_numeric($id)){
            $where = " AND  `id` NOT IN ($id) ";
        } else {
            $where = "";
        }
            
       $is_exists =  $this->appCommon->is_exists( ['table'=> TABLE_MERCHANTS , 'field' => 'username' , 'value' => $username  , 'where' => $where] );
       
       return $is_exists;
    }    
    
    public function posNameExists($pos_name, $id=''){
        
        if($id != '' && is_numeric($id)){
            $where = " AND  `id` NOT IN ($id) ";
        } else {
            $where = "";
        }
        
        //Check POS Name alredy selected by others
       $is_exists =  $this->appCommon->is_exists( ['table'=> TABLE_MERCHANTS , 'field' => 'pos_name' , 'value' => $pos_name  , 'where' => $where] );
       
        if($is_exists === false){
           
            global $ExistsDirectoryArr;
            //Check POS Name is Not same as exists directory name.
            if(in_array( $pos_name , $ExistsDirectoryArr)){
                $is_exists = true;
            }
        }
        
        return $is_exists;
    }    
    
    public function mobileExists($mobile, $id=''){
        
        if($id != '' && is_numeric($id)){
            $where = " AND `id` NOT IN ($id) ";
        } else {
            $where = "";
        }
        
       $is_exists =  $this->appCommon->is_exists( ['table'=> TABLE_MERCHANTS , 'field' => 'phone' , 'value' => $mobile  , 'where' => $where] );
       
       return $is_exists;
    }    
    
    public function emailExists($email, $id=''){
          
        if($id != '' && is_numeric($id)){
            $where = "  AND `id` NOT IN ($id) ";
        } else {
            $where = "";
        }
        
       $is_exists =  $this->appCommon->is_exists( ['table'=> TABLE_MERCHANTS , 'field' => 'email' , 'value' => $email , 'where' => $where] );
       
       return $is_exists;
    }
    
    public function posSetupLogExists( $merchant_id ){
          
        if($id == '' && !is_numeric($merchant_id)){
           return false;
        } 
        
        $is_exists =  $this->appCommon->is_exists( ['table'=> TABLE_POS_SETUP_LOG , 'field' => 'merchant_id' , 'value' => $merchant_id , 'where' => ''] );
       
        return $is_exists;
    }
        
    public function getPosSetupLog( $merchant_id ) {               
        
         $sql = "SELECT   `id` , `merchant_id`, `pos_name`, `db_name` as db_name , `db_user` as db_user, `db_password` as db_passwd, `prefix`, `status`,
                        `step_1`, `step_2`, `step_3`, `step_4`, `step_5`, `step_6`, `step_7`, `username`, `password`, `pos_url`,
                        `created_at`, `created_by`, `deleted_at`, `deleted_by`
                FROM  " . TABLE_POS_SETUP_LOG . "  
                WHERE  `merchant_id` =  '$merchant_id'
                ORDER BY `id` DESC 
                LIMIT 1";
    
        $result = $this->conn->query($sql);  
        
        if($result):
                
            $row_cnt = $result->num_rows;
            if($row_cnt) {
                $row = $result->fetch_array(MYSQLI_ASSOC);
                return  $row;
            } else {
                return false;
            }           
        endif;
        
         return false;
    }
    
    public function resetPosSetup($merchant_id) {
        
        $sql  = "UPDATE ".TABLE_POS_SETUP_LOG." SET `step_1` = '0', `step_2` = '0', `step_3` = '0', `step_4` = '0',  `step_5` = '0', `step_6` = '0', `step_7` = '0',"
                . " `status` = '', `pos_name`='', `pos_url`= '', `db_name`='' , `username`= '', `password`= '' "
                . " WHERE  `merchant_id` = '$merchant_id' "; 
            
        $result = $this->conn->query($sql);  
        
        if($result) {
            return true;
        }
    }
        
    public function getDbConfig($pos_name , $merchant_id)
    {  
        $dbConf = $this->getPosSetupLog( $merchant_id );

        if($dbConf === false)
        { 
             $randkey = $this->appCommon->randomPasswd(15);
             $userKey = $merchant_id . $pos_name . time();

             $dbConf['db_name']     = $db_name        = CP_PREFIX .'_'. substr($pos_name, 0, 8) . $merchant_id;
             $dbConf['db_user']     = $db_user        = CP_PREFIX .'_'. substr($userKey, 0, 7);	
             $dbConf['db_passwd']   = $db_password    = substr($merchant_id . $randkey, 0, 15);

             $sql  = "INSERT INTO ".TABLE_POS_SETUP_LOG." (`merchant_id`, `pos_name`, `db_name`, `db_user`, `db_password` ) "
                     . " VALUES ( '$merchant_id', '$pos_name', '$db_name', '$db_user', '$db_password' ) ";

             $result = $this->conn->query($sql);

             return $dbConf;

        } else {
          return $dbConf;  
        }
    }
    
    public function cp_resetDbConfig($pos_name , $merchant_id)
    {  
        $randkey = $this->appCommon->randomPasswd(15);
        $userKey =  $merchant_id . $pos_name . time();

        $db_name        = CP_PREFIX .'_'. substr($pos_name, 0, 9) . $merchant_id;
        $db_user        = CP_PREFIX .'_'. substr($userKey, 0, 7);		
        $db_password    = substr($merchant_id . $randkey, 0, 15);

        $sql  = " UPDATE ".TABLE_POS_SETUP_LOG." "
                . " SET `pos_name` = '$pos_name', `db_name` = '$db_name', `db_user` = '$db_user', `db_password` = '$db_password' , `status` = '', `pos_url`='' "
                . " WHERE `merchant_id` = '$merchant_id' ";

        $result = $this->conn->query($sql);

        return $result;
    }
        
    public function getPosZipDetails($type='') {               
        
        $sql = "SELECT  `id`, `merchant_type`, `merchant_type_keyword`, `pos_project_zip` , `pos_version` ,  `pos_database_file`, `pos_images_zip_file` , `sql_version`
                FROM  " . TABLE_VIEW_MERCHANT_TYPE . "  
                WHERE  `id` =  '$type'
                LIMIT 1";
    
        $result = $this->conn->query($sql);  
        
        if($result):
                
            $row_cnt = $result->num_rows;
            if($row_cnt) {
                $row = $result->fetch_array(MYSQLI_ASSOC);
                return  $row;
            }           
        endif;  
    }    
    
    public function getResetCode(){
        
        $sql = "SELECT * 
                    FROM  ".TABLE_RESET_CODE."  
                    ORDER BY RAND() 
                    LIMIT 1";
          
        $result = $this->conn->query($sql);
       
        if( $result ) 
        {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            
            $this->resetcode = $row['code'];    
            $this->resetcode_encript = $row['encript'];           
        }
        
        /* close result set */
        $result->close();
    }    
    
    public function pos_user_list() {
        
        $sql = "SELECT  `id` ,  `username` ,  `email` ,  `first_name` ,  `last_name` ,  `company` ,  `phone` ,  `active` ,  `gender` ,  `group_id` 
FROM  `sma_users` ";
        
        $result = $this->conn_pos->query($sql);
        
        if( $result ) 
        {
            while($row = $result->fetch_array(MYSQLI_ASSOC))
            {
                $this->posUsers[$row['id']] = $row;
            }//end while.
        }
        
        
        
        return $this->posUsers;
        
        /* close result set */
        $result->close();
    }
    
    public function pos_directory($pos_url) {
        $pos_subdomain   = str_replace(['http://', 'https://', '/login', '/'], '', $pos_url);
        $urlArr =  explode('.', $pos_subdomain);
        $pos_directory   = $urlArr[0];
        return $pos_directory;
    }
    
    public function pos_user_reset_password($id){
        
        $this->getResetCode();
        
        $resetcode = $this->resetcode;    
        $resetcode_encript = $this->resetcode_encript;
        
        $sql = "UPDATE  `sma_users` SET `password` = '$resetcode_encript' WHERE `id` = '$id' ";
        
        $result = $this->conn_pos->query($sql);
        
        if($result) {            
            return  true;
        } else {            
            return false;
        }
        
    }
        
    public function pos_user_reset_password_email_send($id) {
        
            $mailData['to_name']    = $this->posUsers[$id]['first_name'].' '.$this->posUsers[$id]['last_name'];
            $mailData['to']         = $this->posUsers[$id]['email'];
            $mailData['from']       = 'pos@simplysafe.in';
            $mailData['from_name']  = 'SimplySafe POS';
            $mailData['reply']      = 'noreply@simplysafe.in';
            $mailData['reply_name'] = 'POS Noreply';

            $mailData['subject']    = 'POS login password has been reset.';     
            
           
 $mailData['body'] = "<div style='font-family:arial; font-size:14px; text-align:left;'>
                        <h2 style='font-family:arial; font-size:18px; text-align:left;'>Hello ".$mailData['to_name'].",</h2><br/>
                        <p style='font-family:arial; font-size:14px; text-align:left;'>Your POS login password has been reset by pos administrator. Your new login details as above.</p>
                        <br/><br/>
                        <div style='font-family:arial; font-size:14px; text-align:left;'>
                          Click here to <a href='".$this->merchants['pos_url']."/login' target='_blank'>Login POS</a>.
                        </div>
                        <br/><br/>
                        <p style='font-family:arial; font-size:14px; text-align:left;'>Username: ".$this->posUsers[$id]['username']."</p>
                        <p style='font-family:arial; font-size:14px; text-align:left;'>New Password: ".$this->resetcode."</p>
                            <br/><br/>
                        <p style='font-family:arial; font-size:14px; text-align:left; color:red;'>Note: Do not share your username and password(s) to anybody. Change your password after login.</p>
                            <br/><br/>
                        <p style='font-family:arial; font-size:16px; text-align:left;'>Thank you <br/>Simply POS Group</p>
                    </div>";
            
        if( $this->appCommon->sendMail($mailData) )
        {
            return true;
        } else {
            return false;
        }
    }
        
    public function connect_merchant_pos_db($merchant_id){
        
        $merchants = $this->get($merchant_id);
         
        $pos_db_name     = $merchants['db_name'];
        $pos_db_username = $merchants['db_username'];
        $pos_db_password = $merchants['db_password'];        
        
        $this->conn_pos = new mysqli("localhost", $pos_db_username, $pos_db_password, $pos_db_name);         
        
        // Check connection
        if ($this->conn_pos->connect_error) {
            die("Connection failed: " . $this->conn_pos->connect_error);
        } 
        
    }
        
    public function desconnect_merchant_pos_db() {

        $this->conn_pos->close(); 
        
    }
        
    public function merchant_transactions($id='') {
       return  $this->merchant_transactions[$id];
    }
    
    public function get_merchant_transactions($merchant_id , $transaction_id='') {
        
        $whereTransaction = '';
        if($transaction_id){
            $whereTransaction = " AND id = '$transaction_id' ";
        }
        
        $sql = "SELECT * FROM ".TABLE_MERCHANTS_TRANSACTION." 
                WHERE `merchant_id` = '$merchant_id'  $whereTransaction 
                ORDER BY `transaction_date` DESC ";
        
        $result = $this->conn->query($sql);
        
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()) {

                  $row['status'] = ($row['is_active']) ? 'Active' : 'Deactive';

                  $this->merchant_transactions[$row['id']] = $row;

            }//end while.  
        }
        
        return $this->merchant_transactions;
        
        /* close result set */
        $result->close();
        
        
    }
    
    public function set_merchant_transactions(array $responceData) {
         
            $order_id = $responceData['order_id']; 

            $orderData = $this->get_merchant_order($order_id);

            $package_id        = $orderData['package_id'];
            $merchant_id       = $orderData['merchant_id'];
            $order_at          = $orderData['order_date'];
            $orderDescripttion = json_decode($orderData['order_description'], true); 

            $adons_id            = $orderDescripttion['adons_ids'];
            $adons_price         = $orderDescripttion['totalAdonsCharges'];
            $tax_amount          = $orderDescripttion['service_tax'];  
            $billing_mode        = $orderDescripttion['billing_mode'];    
            $billing_mode_price  = $orderDescripttion['plane_amount']; 
            
            $ObjPackageArr  = $this->get_packages($package_id);
            $ObjPackage     = $ObjPackageArr[$package_id];            
            $ObjMerchant    = $this->getMerchantPackageInfo( $merchant_id );
            
            if($ObjPackage['customers'] < 0 ) {
                //Unlimited Customers Assign with package
                $customer_balance = -1;
            } elseif($orderDescripttion['chkAdonsPackage_2']) { 
                //Add extra 100 Customers in package.
                $customer_balance = 100 + $ObjMerchant['customer_balance'];
            } else {
                //Set When not select addons pack.
                $customer_balance = $ObjMerchant['customer_balance'];
            }
            
            if($ObjPackage['register'] < 0 ) 
            {
                $registers_balance = -1;
            } elseif($orderDescripttion['chkAdonsPackage_1']) {
                $registers_balance  = $ObjMerchant['registers_balance'] + 1;              
            } else {
                $registers_balance = $ObjMerchant['registers_balance'];
            }             
            
            if($orderDescripttion['chkAdonsPackage_sms']) {
               $adonsSmsPackage  = explode('~',  $orderDescripttion['adonsSmsPackage']); 
               $sms_balance = $adonsSmsPackage[2];
            } else {
                if($billing_mode == 12) {
                    //SMS Pack Expired After Year
                    $sms_balance = 0;
                } else {
                    $sms_balance = $ObjMerchant['sms_balance'];
                }
            }
            
            if((int)$ObjPackage['products'] < 0 ){
                $products_balance   = -1;
            } elseif($ObjMerchant['products_used'] == 0) {
                $products_balance   =  $ObjPackage['products'];
            } elseif($ObjPackage['products'] > $ObjMerchant['products_used']) {
                $products_balance   = $ObjPackage['products'] - $ObjMerchant['products_used'];
            } else {
                $products_balance   = $ObjMerchant['products_balance'];
            }
            
            if((int)$ObjPackage['users'] < 0 ){
                $users_balance   = -1;
            } elseif($ObjMerchant['users_used'] == 0) {
                $users_balance   = $ObjPackage['users'];
            } elseif($ObjPackage['products'] > $ObjMerchant['users_used']) {
                $users_balance   = $ObjPackage['users'] - $ObjMerchant['users_used'];
            } else {
                $users_balance   = $ObjMerchant['users_balance'];
            }

            $transaction_mode        = $responceData['payment_mode'];
            $amount                  = $responceData['amount'];
             
            $transaction_date        = $this->appCommon->date_ddmmyy_to_format($responceData['trans_date']);
            
            $transaction_status      = $responceData['order_status'];
            $transaction_tracking_id = $responceData['tracking_id'];
            $bank_ref_no             = $responceData['bank_ref_no'];

            $status_code             = $responceData['status_code'];
            $status_message          = $responceData['status_message'];
            $response_code           = $responceData['response_code'];
            $billing_notes           = $responceData['billing_notes'];
            $currency                = $responceData['currency'];

            $responceLog = array_merge($orderDescripttion, $responceData);

            $transactionLogJson = json_encode($responceLog);            
            
            $sql = "INSERT INTO ".TABLE_MERCHANTS_TRANSACTION." ( `merchant_id`, `order_id`, `package_id`, `adons_ids`, `billing_mode`, `billing_mode_price`, "
                    . " `adons_price`, `tax_amount`, `total_billing_amount`, `subscription_start_date`, `subscription_end_date`, `transaction_mode`, "
                    . " `transaction_amount`, `transaction_date`, `transaction_status`, `transaction_id`, `transaction_log`, `bank_ref_no`, "
                    . " `status_code`, `status_message`, `currency`, `billing_details`, `response_code`) "
                    . " VALUES ( '$merchant_id', '$order_id', '$package_id', '$adons_id', '$billing_mode', '$billing_mode_price', '$adons_price', '$tax_amount', "
                    . " '$amount', '$transaction_date',  DATE_ADD('$transaction_date', INTERVAL ".$billing_mode." MONTH ) , '$transaction_mode', '$amount', '$transaction_date', '$transaction_status',"
                    . " '$transaction_tracking_id', '$transactionLogJson', '$bank_ref_no', '$status_code', '$status_message', '$currency',"
                    . " '$billing_notes', '$response_code' ) ";
             
            $result = $this->conn->query($sql);
        
            if($result) {
         
                $transaction_id = $this->conn->insert_id;

                $tansactionData = [
                                    'merchant_id'=>$merchant_id, 
                                    'package_id'=>$package_id, 
                                    'adons_id'=>$adons_id, 
                                    'transaction_date'=>$transaction_date , 
                                    'transaction_id'=>$transaction_id ,
                                    'billing_mode'=>$billing_mode ,
                                    'sms_balance'=> $sms_balance,
                                    'customer_balance'=> $customer_balance,
                                    'registers_balance'=> $registers_balance ,                     
                                    'products_balance'=> $products_balance ,                     
                                    'users_balance'=> $users_balance ,                     
                                 ];
               
                 
                return $this->set_merchant_subscription( $tansactionData );
                 
            } else {
                echo "<div class='alert alert-danger'>".$this->conn->error."</div>";
            }
    }
    
    public function setAdminMerchantTransaction($transactionData) {
        
        extract($transactionData); 
        
        $adonsSmsPackage  = explode('~',  $transactionData['package']); 
        $pack_id    = $adonsSmsPackage[0];
        $pack_price = $adonsSmsPackage[1];
        $pack_sms   = $adonsSmsPackage[2];
        $taxAmt = round( $pack_price * ( SERVICE_TAX_RATE / 100 )); 
        $total_billing_amount = $pack_price + $taxAmt;
        
        $sql = "INSERT INTO  ".TABLE_MERCHANTS_TRANSACTION 
                . " ( `merchant_id`, `adons_ids`, `billing_mode`, `adons_price`, `tax_amount`, `total_billing_amount`, `transaction_mode`, "
                . " `transaction_amount`, `transaction_date`, `transaction_status`, `transaction_id`, `currency`, `status_message`) "
                . " VALUES ('$id', '3', '12', '$pack_price', '$taxAmt', '$total_billing_amount', '$transaction_mode',"
                . " '$transaction_amount', now(), 'Success', '$transaction_id',  'INR', 'Upgrade By Admin' )";
        
         $result = $this->conn->query($sql);
         $resultData = [];
          if($result) {                
                
                $sql ="UPDATE ".TABLE_MERCHANTS."  SET  `sms_balance` =  '$pack_sms' WHERE `id` = '$id' ";
       
                $result = $this->conn->query($sql);
                
                if($result){
                    $resultData['status'] = "SUCCESS";
                    $resultData['msg'] = 'SMS Pack Activated.';
                } else {
                    $resultData['status'] = "ERROR";
                    $resultData['msg'] = $this->conn->error;
                }
                
          } else {                 
                $resultData['status'] = "ERROR";
                $resultData['msg'] = $this->conn->error;
          } 
          
          return $resultData;
    }
    
    public function set_merchant_order(array $postData) {
        
        
        $order_at = date('Y-m-d H:i:s');
        $amount = $postData['amount'];
        $merchant_id = $postData['customer_id'];
        $package_id = $postData['package_id'];
        
        /*
        $orderData['package_name'] = $postData['package_name'];
        $orderData['priority_phone_support'] = $postData['PriorityPhoneSupport'];
        $orderData['priority_phone_support_charges'] = $postData['PriorityPhoneSupportCharges'];
        $orderData['total_adons_charges'] = $postData['totalAdonsCharges'];
        $orderData['service_tax'] = $postData['service_tax'];
        $orderData['total_payable_amt'] = $postData['totalPayableAmount'];
        $orderData['billing_mode'] = $postData['billing_mode'];
        $orderData['plane_amount'] = $postData['plane_amount'];*/
        
        $order_description =  json_encode($postData);
        
         $sql = "INSERT INTO ".TABLE_PACKAGE_ORDER." (`package_id`, `merchant_id`, `order_date`, `order_status`, `order_amount`, `order_description`)"
                . " VALUES ('$package_id', '$merchant_id', '$order_at', 'Order Send', '$amount', '$order_description' )";
         
        $result = $this->conn->query($sql); 
         
        return  $this->conn->insert_id;
        
    }    
    
    public function get_merchant_order($order_id) {
        
        $sql = "SELECT * FROM ".TABLE_PACKAGE_ORDER." 
                WHERE `id` = '$order_id' LIMIT 1 ";
        
        $result = $this->conn->query($sql);
        $orderData = '';
        if($result->num_rows > 0){
             $orderData = $result->fetch_assoc();
        }
        
         return $orderData;
    }
    
    public function set_order_status(array $statusdata ) {
        
        $sql = "UPDATE ".TABLE_PACKAGE_ORDER."  SET  `order_status` = '".$statusdata['status']."' WHERE `id` = '".$statusdata['id']."' ";
        
         $result = $this->conn->query($sql);
         
         if($result){
             return true;
         } else {
             return false;
         }
    }
    
    public function set_merchant_subscription(array $tansactionData) {      
             
        extract($tansactionData);
        
        if($package_id > 1) {            
            $package_Update = " `package_id` = '$package_id', `subscription_start_at` = '$transaction_date', 
                                `subscription_end_at` = DATE_ADD( '$transaction_date', INTERVAL ".$billing_mode." MONTH ) ,
                                `subscription_is_active` =  '1', `adons_ids` = '$adons_id', `transaction_id` = '$transaction_id', ";            
        } else {
            $package_Update = " `adons_ids` = CONCAT(`adons_ids` , ',$adons_id'), ";             
        }
        
            $sql = "UPDATE ".TABLE_MERCHANTS." 
                    SET 
                           `payment_status`     =  'paid',
                           `pos_status`         =  'upgrade',
                            $package_Update  
                           `sms_balance`        =  '$sms_balance' ,  
                           `customer_balance`   =  '$customer_balance' , 
                           `registers_balance`  =  '$registers_balance' , 
                           `products_balance`   =  '$products_balance' , 
                           `users_balance`      =  '$users_balance' 
                   WHERE  
                           `id` = '$merchant_id' ";
       
        $result = $this->conn->query($sql);
         
         if($result){
             return true;
         } else {
             return false;
         }
    }
        
    public function expired_pos($merchant_id ='') {
        
        if(is_numeric($merchant_id) && $merchant_id > 0 )
        {
            $sql = "UPDATE  ".TABLE_MERCHANTS."  SET  `pos_status` = 'expired' , `subscription_is_active` = '0'   WHERE  `id` = '$merchant_id' ";
         
        } else {
            
            $sql = "UPDATE  ".TABLE_MERCHANTS."  SET  `pos_status` = 'expired' , `subscription_is_active` = '0'  "
                    . " WHERE (`pos_generate` = '1' AND `package_id` < '2' AND `pos_demo_expiry_at` <  NOW() ) OR "
                    . " ( `pos_generate` = '1' AND `package_id` > '0' AND `subscription_end_at` < NOW() ) ";
        }
        
         $result = $this->conn->query($sql);
         
         if($result){
            return true;
         } else {
            return false;
         }
    }
        
    public function suspend_pos($merchant_id ='') {
        
        if(is_numeric($merchant_id) && $merchant_id > 0 )
        {            
            $merchantsData = $this->get($merchant_id);
          
            $pos_generate = $merchantsData['pos_generate'];
            $setSuspend = true;
            
            if($pos_generate) 
            { 
                $setSuspend = false;
                $controlerExists = $viewExists = true;
                
                $pos_directory   =  $merchantsData['project_directory_path']; 
               
                $suspendControlerPath = '../../'.$pos_directory.'/app/controllers/';
                if(!is_file($suspendControlerPath . 'Suspend.php'))
                {
                    if(!is_file('../../include/pos_files/controllers/Suspend.php')) 
                    { 
                        echo '<div class="text-danger">Suspend Controllers Source File not Exists.</div>';                         
                    }
                    else 
                    { 
                        $controlerExists = copy( '../../include/pos_files/controllers/Suspend.php' , $suspendControlerPath . 'Suspend.php');
                    }
                }
                
                $suspendViewPath = '../../'.$pos_directory.'/themes/default/views/';
                if(!is_file($suspendViewPath . 'suspend.php'))
                {
                   if(!is_file('../../include/pos_files/view/suspend.php'))
                   { 
                       echo '<div class="text-danger">View Source File not Exists.</div>'; 
                   } 
                   else
                   {
                        $viewExists = copy( '../../include/pos_files/view/suspend.php' , $suspendViewPath . 'suspend.php');
                   }
                }
                
                if($controlerExists && $viewExists) {                
                    
                    $routes_file_path = '../../'.$pos_directory.'/app/config/routes.php';

                    $findArr = ['auth/login/$1', 'auth/login', 'welcome'];
                    
                    $replaceArr = ['suspend/login/$1', 'suspend/login', 'suspend'];
                     
                    $setSuspend =  $this->appCommon->file_containt_replace($routes_file_path ,  $findArr,  $replaceArr);
                    
                } else {
                     echo '<div class="text-danger">Controler not exists.</div>';
                }
                
            }//end if.
            
            if($setSuspend == true) {
                
               $sql = "UPDATE  ".TABLE_MERCHANTS."  SET  `pos_previous_status` = `pos_status` , `pos_status` = 'suspended'  WHERE  `id` = '$merchant_id' ";

                $result = $this->conn->query($sql);             
                
                if($result){
                    return true;
                }                
            }
        }        
        return false;
    }
        
    public function unsuspend_pos($merchant_id ='') {
        
        if(is_numeric($merchant_id) && $merchant_id > 0 )
        {            
            $merchantsData = $this->get($merchant_id);
          
            $pos_generate = $merchantsData['pos_generate'];
            $setUnsuspend = true;
            if($pos_generate) { 
                $setUnsuspend = false;
                $pos_directory   = $merchantsData['project_directory_path']; 
                $routes_file_path = '../../'.$pos_directory.'/app/config/routes.php';
                
                $findArr = ['suspend/login/$1', 'suspend/login', 'suspend'];
                $replaceArr = ['auth/login/$1', 'auth/login', 'welcome'];
                
               $setUnsuspend =  $this->appCommon->file_containt_replace($routes_file_path ,  $findArr,  $replaceArr);
                
            }//end if.
            
            if($setUnsuspend == true) {
                
                $sql = "UPDATE  ".TABLE_MERCHANTS."  SET  `pos_status` = `pos_previous_status` WHERE  `id` = '$merchant_id' ";

                $result = $this->conn->query($sql);             

                if($result){
                    return true;
                }                
            }
        }
        
        return false;       
         
    }
    
    public function merchant_activeted($merchant_id) {
        
        if(is_numeric($merchant_id))
        {
            $sql = "UPDATE  ".TABLE_MERCHANTS."  SET `is_active` = '1' WHERE  `id` = '$merchant_id' ";
        
            $result = $this->conn->query($sql);

            if($result){
                return true;
            } else {
                return $this->conn->error;
            }
         }
         return 'Invalid merchant id.';
    }
        
    public function merchant_deactiveted($merchant_id) {
        
        if(is_numeric($merchant_id) && $merchant_id > 0 )
        {
            $sql = "UPDATE  ".TABLE_MERCHANTS."  SET `is_active` = '0' WHERE  `id` = '$merchant_id' ";
        
            $result = $this->conn->query($sql);

            if($result){
                return true;
            } else {
                return false;
            }
         }
         return false;
    }
    
    public function merchant_remove($merchant_id) {
        
        if(is_numeric($merchant_id) && $merchant_id > 0 )
        {
            $sql = "DELETE FROM ".TABLE_MERCHANTS." WHERE `id` = '$merchant_id' ";
        
            $result = $this->conn->query($sql);

            if($result){
                $this->setDeleteMerchantLog($merchant_id);
                return true;
            } else {
                return false;
            }
         }
         return false;
    }
    
    public function setDeleteMerchantLog($merchant_id) {
        
        $session_user_id = $_SESSION['session_user_id'];
              
            $sql  = "UPDATE ".TABLE_POS_SETUP_LOG." SET " 
                    . " `deleted_at` = '$time' , `deleted_by` = '$session_user_id' "
                    . " WHERE  `merchant_id` = '$merchant_id' ";
           
            $result = $this->conn->query($sql);        
    }
    
    public function merchant_deleted($merchant_id) {
        
        if(is_numeric($merchant_id) && $merchant_id > 0 )
        {
            $sql = "UPDATE  ".TABLE_MERCHANTS."  SET `is_delete` = '1', `is_active` = '0' WHERE  `id` = '$merchant_id' ";
        
            $result = $this->conn->query($sql);

            if($result){
                return true;
            } else {
                return false;
            }
         }
         return false;
    }
    
    public function merchant_undeleted($merchant_id) {
        
        if(is_numeric($merchant_id) && $merchant_id > 0 )
        {
            $sql = "UPDATE  ".TABLE_MERCHANTS."  SET `is_delete` = '0', `is_active` = '1' WHERE  `id` = '$merchant_id' ";
        
            $result = $this->conn->query($sql);

            if($result){
                return true;
            } else {
                return false;
            }
         }
         return false;
    }
        
    public function get_packages($package_id = '') {
        
        $where = (is_numeric($package_id)) ? " WHERE `id` = '$package_id' " : " WHERE `is_active` = '1' AND `is_delete` ='0' ";
        
        $sql = "SELECT * FROM ".TABLE_PACKAGES. $where;
        
        $result = $this->conn->query($sql);
        
        $packages = [];
        
        if($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc())
            {
                $packages[$row['id']] = $row;
            }
        }
        
        return $packages;
    }
        
    public function pos_password_hash($password) {

        $salt = substr(md5(uniqid(rand(), true)), 0, 10);

        $passcode = $salt . substr(sha1($salt . $password), 0, -10);

        return $passcode;
    }
     
    public function create_pos_user($posconn , array $merchantData) {
        
        $time = time();
        $username = $merchantData['username'];
        $password = $this->pos_password_hash($merchantData['password']);
        $email = $merchantData['email'];
        $name = explode(' ', $merchantData['name']);
        $first_name = $name[0];
        $last_name = $name[1];
        $business_name = $merchantData['business_name'];
        $phone = $merchantData['phone'];
        
       // $this->connect_merchant_pos_db($merchantData['id']);
        
          $sql ="INSERT INTO `sma_users` ( `username`, `password`, `email`,  `created_on`, `active`, `first_name`, `last_name`, `company`, `phone`, "
                . "`group_id`, `view_right`, `edit_right`, `allow_discount`)"
                . " VALUES ('$username', '$password', '$email', '$time', '1', '$first_name', '$last_name', '$business_name', '$phone',"
                . " '1', '1', '1', '0')";
        
              
    
        $result = $posconn->query($sql);
        
        //$this->desconnect_merchant_pos_db();
         
        if($result){
            return true;
          
        } else {
            echo "<div class='alert alert-danger'>".$result->error."</div>";
            return false;
        }
    }
    
    public function update_pos_merchant_details( $merchant_id , $phone_no,  array $merchantUpdateData) {
        
        if( !is_numeric($merchant_id) || !is_numeric($phone_no) || empty($phone_no) ) {
            echo "<div class='alert alert-danger'>Invalid merchant arguments.</div>";
            return false;
        }
        
        $this->connect_merchant_pos_db($merchant_id);
        
        $sql = "UPDATE `sma_users` SET  ";
        
        if(is_array($merchantUpdateData))
        {
            foreach ($merchantUpdateData as $key => $value) {
                $updateArr[] = " $key = '$value' ";
            }
            
            $sql .= join(', ', $updateArr);
        }
        
        $sql .= " WHERE  `phone` = '$phone_no' ";
        
        $result = $this->conn_pos->query($sql);
         
        if($result){
            
            $this->desconnect_merchant_pos_db();
            return true;
          
        } else {
           return  $result->error ;
        }
    }
        
    public function deletePOSProject($pos_path) {
        
        return $this->appCommon->deleteDirectory($pos_path);
    }
        
    public function is_valid_pos($posname) {
        
        $validFolders = ['simplypos', 'simplysafe', 'pos', 'Pos', 'app', 'api', 'posadmin', 'include','functions', 'merchants', 'PHPMailer', 'css', 'js', 'img', 'fonts'];
        
        if(in_array($posname, $validFolders)) return true;
        
        $sql = "SELECT `id`
                FROM  ".TABLE_MERCHANTS."  
                WHERE `pos_name` = '$posname' AND `pos_generate` = '1' ";
        
        $result = $this->conn->query($sql);
        
        if($result->num_rows > 0)
        {
            return true;
        } else {
            return false;
        }
    }
        
    public function is_valid_pos_dbuser($pos_db_username) {
        
        $sql = "SELECT `id`
                FROM  ".TABLE_MERCHANTS."  
                WHERE `db_username` = '$pos_db_username' AND `pos_generate` = '1' ";
        
        $result = $this->conn->query($sql);
        
        if($result->num_rows > 0)
        {
            return true;
        } else {
            return false;
        }
    }
    
    public function is_valid_pos_db($pos_db) {
        
        $sql = "SELECT `id`
                FROM  ".TABLE_MERCHANTS."  
                WHERE `db_name` = '$pos_db' AND `pos_generate` = '1' ";
        
        $result = $this->conn->query($sql);
        
        if($result->num_rows > 0)
        {
            return true;
        } else {
            return false;
        }
    }
    
    public function SetCPObject() {
        
        $cpanelusr  = CP_USERNAME;

        $cpanelpass = CP_PASSWORD;

        $hostName   = CP_HOST;

        $prefix     = CP_PREFIX;
        
        $this->CP_xmlapi =  new xmlapi('127.0.0.1');

        $this->CP_xmlapi->set_port( 2083 );

        $this->CP_xmlapi->password_auth(CP_USERNAME, CP_PASSWORD);

        $this->CP_xmlapi->set_debug(0); //output actions in the error log 1 for true and 0 false 
        
    }
    
    /*
    public function cp_setSSLCrt($subdomain) {
        
        // Generate a self-signed certificate for example.com.
        $generate_new_certificate = (array)$this->CP_xmlapi->api2_query( CP_USERNAME, 'SSL', 'gencrt',
                                                    array(
                                                        'city'            => 'Bhopal',
                                                        'company'         => 'SimplySafe',
                                                        'companydivision' => 'Documentation',
                                                        'country'         => 'IN',
                                                        'email'           => 'info@simplysafe.in',
                                                        'host'            => $subdomain,
                                                        'state'           => 'MP',
                                                    )
                                                );
        return $generate_new_certificate;
    }
    
    public function cp_getSSLCrt() {
        
         $certificate = (array)$this->CP_xmlapi->api2_query( CP_USERNAME, 'SSL', 'listcrts' );
         
         return $certificate;
    }
    
    */
    
    public function cp_deleteSSL($pos_subdomain) 
    {
        if(empty($pos_subdomain)) return FALSE;
        
        // DELETE A SUB-DOMAIN
        $result_obj['deletecrt'] = $this->CP_xmlapi->api1_query( CP_USERNAME, 'SSL', 'deletecrt', array( $pos_subdomain ) );
        $result_obj['deletecsr'] = $this->CP_xmlapi->api1_query( CP_USERNAME, 'SSL', 'deletecsr', array( $pos_subdomain ) );
        $result_obj['deletekey'] = $this->CP_xmlapi->api1_query( CP_USERNAME, 'SSL', 'deletekey', array( $pos_subdomain ) );
        $result_obj['delete'] = $this->CP_xmlapi->api1_query( CP_USERNAME, 'SSL', 'delete', array( $pos_subdomain ) );

        return  $result_obj;  
    }
    
    public function cp_createSubDomain($subDomainName, $hostName, $ProjectDirectory) {
        
        $resultSubdomain = (array)$this->CP_xmlapi->api2_query( CP_USERNAME, 'SubDomain', 'addsubdomain',  array(
                                                        'domain'                => $subDomainName,
                                                        'rootdomain'            => $hostName,
                                                        'dir'                   => $ProjectDirectory,
                                                        'disallowdot'           => '1',
                                                        'canoff'                => '0',
                                                    )
                                                ) ; 
        
        $response = (array)$resultSubdomain['data'];
        
        $result['status'] = ($response['result']) ? 'SUCCESS' : 'ERROR';
        $result['msg'] = $response['reason'] ;
        $result['response'] = $resultSubdomain;
        return $result;
    }
        
    public function cp_subdomainList() {
        
        $listSubdomain = $this->CP_xmlapi->api2_query( CP_USERNAME, 'SubDomain', 'listsubdomains', array() ) ; 
        
        foreach ((array)$listSubdomain as $key => $objSubDOmain) {                          
            if($key != 'data') continue;                                    
            foreach((array)$objSubDOmain as $key => $objSubD) {
                $arrSubD = (array)$objSubD;
                $subArr['data'][] = $arrSubD;
                $subArr['list'][] = $arrSubD['subdomain'];                
            }                                    
        }        
        return $subArr;
    }
    
    //PARA: A valid domain name. Ex. subdomain.example.com 
    public function cp_delsubdomain($pos_subdomain) {
       
        if(empty($pos_subdomain)) return FALSE; 
        
        // DELETE A SUB-DOMAIN
        $result_obj = (array)$this->CP_xmlapi->api2_query( CP_USERNAME, 'SubDomain', 'delsubdomain', array( "domain" => $pos_subdomain ) );

        $response = (array)$result_obj['event']; 
        
        $result['status']       = ($response['result']) ? 'SUCCESS' : 'ERROR';
        $result['msg']          = ($response['result']) ? "The subdomain <i><q>$pos_subdomain</q></i> has been removed." : $response['reason'];
        $result['response']     = $result_obj;
        
        return $result;
    }
    
    public function cp_deluser($pos_db_username) {
        
        if(empty($pos_db_username)) return FALSE;
        // DELETE A USER
        // $result_du = $xmlapi->api1_query( $cpanelusr, 'Mysql', 'deluser', array( "dbuser" => 'hsadmin_74teapo' ) );
        return $result_du = $this->CP_xmlapi->api1_query( CP_USERNAME, 'Mysql', 'deluser', array( '0' => $pos_db_username ) );
    }
     
    //Para: Prefix_DBName
    public function cp_createDB($db_name) {
        // Create the database "example_database"
        $result = (array) $this->CP_xmlapi->api2_query( CP_USERNAME, 'MysqlFE', 'createdb',  array( 'db' => $db_name, ) );
        
        $resultDb = (array)$result['event'];
        
        $response['status'] = ($resultDb['result']) ? 'SUCCESS' : 'ERROR';
        $response['msg']    = $resultDb['reason'];
        $response['response'] = $result;
        
        return  $response;
    }
    
    public function cp_deldb($pos_db_name) {
        
        if(empty($pos_db_name)) return FALSE;
        if(CP_PREFIX . '_simplysafe' == $pos_db_name) return false;
        // DELETE DB
        $dbDelete = (array)$this->CP_xmlapi->api2_query( CP_USERNAME,  'MysqlFE', 'deletedb',  array( 'db' => $pos_db_name, ) ); 
        $response = (array)$dbDelete['event'];

        $result['status']       = ($response['result']) ? 'SUCCESS' : 'ERROR';
        $result['msg']          = ($response['result']) ? "The database <i><q>$pos_db_name </q></i> has been deleted." : $response['reason'];
        $result['response']     = $dbDelete;
        
       return $result;
    }
        
    public function cp_validPosData() {
        
        $sql = "SELECT  `id` ,  `pos_name` ,  `pos_url` ,  `db_name` ,  `db_username` ,  `db_password` 
                FROM  ".TABLE_MERCHANTS."  
                WHERE  `pos_generate` =  '1'
                ORDER BY  `pos_name` ASC ";
        
        $result = $this->conn->query($sql);
        $this->CP_validData = [];
        if($result->num_rows > 0)
        {
            $this->CP_validData = $result->fetch_assoc();
        }     
        
    } 
        
    public function cp_getDBList() {
        
        // Check for a valid .my.cnf file
        $dbList = (array)$this->CP_xmlapi->api2_query( CP_USERNAME, 'MysqlFE', 'listdbs',  array( ) );
        
        foreach($dbList['data'] as $key=>$objDB){
            $arrDB = (array)$objDB;
            $db_list[] = $arrDB['db'];
        }
        
        return $db_list;
              
    }
    
    public function cp_getDBUsersList() {
        
        // Deletes the database user "example_user1"
        $dbUsers = (array)$this->CP_xmlapi->api2_query( CP_USERNAME,  'MysqlFE', 'getdbusers',  array( ) );
        
        return $dbUsers['data'];         
    }
        
    //Para: Prefix_Username
    public function cp_dbUserExists($db_user) {
        
        // Checks whether the database user "example_user1" exists
        $dbUserExists = (array)$this->CP_xmlapi->api2_query( CP_USERNAME, 'MysqlFE', 'dbuserexists', array( 'dbuser' => $db_user, ) );
        
        return $dbUserExists['data'];
    }
    
    //Para 1: Prefix_Username
    //Para 2: Password
    public function cp_addDbUser($db_username, $db_username_passwd) {
        
        // Creates the database user "example_user1"
        $addDbUser = (array)$this->CP_xmlapi->api2_query( CP_USERNAME, 'MysqlFE', 'createdbuser',   array(
                            'dbuser'   => $db_username,
                            'password' => $db_username_passwd,
                        )  
                     );
        
        $response = (array)$addDbUser['event'];
        
        $result['status']       = ($response['result']) ? 'SUCCESS' : 'ERROR';
        $result['msg']          = ($response['result']) ? "The bd user $db_username  Created." : $response['reason'] ;
        $result['response']     = $addDbUser;
        
        return $result;
    }
    
    //Para 1: Prefix_Username
    //Para 2: Prefix_Database_Name
    //Para 3: Privileges
    public function cp_AssignDbUserPrivileges($db_username, $database , $privileges = 'ALL PRIVILEGES' ) {
        
        // Creates the database user "example_user1"
        $setPrivileges = (array)$this->CP_xmlapi->api2_query( CP_USERNAME, 'MysqlFE', 'setdbuserprivileges',   array(
                            'privileges'   => $privileges,
                            'db' => $database,
                            'dbuser' => $db_username,
                        )  
                     );
        
       $response = (array)$setPrivileges['event'];
        
        $result['status']       = ($response['result']) ? 'SUCCESS' : 'ERROR';
        $result['msg']          = ($response['result']) ? "The user assign privileges successfully." : $response['reason'] ;
        $result['response']     = $setPrivileges;
        
        return $result;
    }
    
    //Para: Prefix_Username
    public function cp_deleteDbUser($db_user) {
        
        // Deletes the database user "example_user1"
        $delete_user = (array)$this->CP_xmlapi->api2_query( CP_USERNAME, 'MysqlFE', 'deletedbuser',  array( 'dbuser' => $db_user,  ) );
        
        $response = (array)$delete_user['event'];
        
        $result['status']   = ($response['result']) ? 'SUCCESS' : 'ERROR';
        $result['msg']      = ($response['result']) ? "Db User <i><q>$db_user </q></i> has benn deleted successfully." :  $response['reason'] ;
        $result['response'] = $delete_user;
        return $result;
    }
    
    
    
    public function getMerchantPackageInfo( $merchantId ) {
        
        if(!is_numeric($merchantId)) return false;
                 
        $query ="SELECT `id` , `phone` , `email`, `pos_status` , `payment_status` , `package_id` , `adons_ids` , `subscription_start_at` , 
                        `subscription_end_at` , `subscription_is_active` , `transaction_id` , `sms_balance` , `sms_used` , `customer_balance` , 
                        `customer_used` , `registers_balance` , `registers_used` , `products_balance` , `products_used` , `users_balance` , `users_used`
                FROM ".TABLE_MERCHANTS." 
                WHERE `id` = '$merchantId'
                LIMIT 1";
        
        $result = $this->conn->query($query);      
        
        if($result->num_rows){            
            return $result->fetch_assoc(); 
        }
    }
    
    public function getMerchantSMSDetails( $merchantMobile ) {
        
        if(!is_numeric($merchantMobile)) return false;
                 
        $query ="SELECT `sms_balance` , `sms_used` 
                FROM ".TABLE_MERCHANTS."  
                WHERE `phone` = '$merchantMobile' 
                LIMIT 1";
        
        $result = $this->conn->query($query);      
        
        if($data['num'] = $result->num_rows){
            
            $data['data'] = $result->fetch_assoc();
                        
        }
        
        return $data;
    }
    
    
    public function setPOSExpiryStatus() {
        
        $sql = "UPDATE ".TABLE_MERCHANTS."   SET  `pos_previous_status`= `pos_status`, `pos_status` = 'expired', `subscription_is_active` = '0'"
                . " WHERE `pos_generate` = '1' AND `subscription_end_at` < now() ";
        
        $result = $this->conn->query($sql); 
        
        return $result;
    }
    
    
    public function getGoingToExpiredPosList($day=7) {
        
        $sql ="SELECT *  FROM `view_pos_subscriptions`
                WHERE `validity_balance`
                BETWEEN 0 AND $day ";
        
        $result = $this->conn->query($sql); 
        
        if($data['num'] = $result->num_rows) {           
            while ($row = $result->fetch_assoc()) {
                 $data['data'][] = $row;
            }//end while.         
        }
        
        return $data;
        
    }
    
    
    
    
     
    public function __destruct() {
        
        /* close connection */
        $this->conn->close();
         unset($this->merchants); 
         unset($this->merchantTypes); 
    }
    
}

?>