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
    private $conn_posinfo; 
    private $posUsers;     
    private $CP_xmlapi; 
    private $CP_validData; 
    private $response;  
            
    public function __construct($conn = '') {
        
        global $objapp;
        
        $this->appCommon = $objapp;
        
        if($conn == '') {
            $this->conn = $this->appCommon->conn();
        } else {
            $this->conn = $conn;
        }
                
        $this->merchantTypes = $this->getMerchantType();
        
        $this->merchant_transactions = $this->response = '';
        
        $this->response = [];
        
    }
    
    public function set_condition(array $array ) {
        
       $this->record_id = $array['id'];
    }
    
    public function get_record() {
       return $this->get($this->record_id);
    }
    
    public function get($id='', $select = '') {
        
        $developerCondition = $this->getMerchantDeveloperCondition();
        
        if(is_numeric($id)) {
            $whereMerchant = " `id` = '$id' ";
        }
        
        elseif(is_array($id)) {            
            $ids = join(',' , $id);
            $whereMerchant = " `is_delete` = '0' AND `id` IN ($ids) ";
        } else {
            $whereMerchant = " `is_delete` = '0' ";
        }
        
        $fields = ($select=='') ? ' * ' : $select;
        
       $query = "SELECT $fields FROM ".TABLE_MERCHANTS." 
                 WHERE $whereMerchant $developerCondition order by `id` DESC ";
        
       $result = $this->conn->query($query);      
        
        if($result->num_rows):
            
            if($result->num_rows > 1){
                
                $this->packages = $this->get_packages();
                
                while($row = $result->fetch_assoc()) 
                {
                   if($select=='') {                    
                        $row['count']               = $result->num_rows;
                        $row['status']              = ($row['is_active']) ? 'Active' : 'Deactive';
                        $row['email_verified']      = ($row['is_email_verified']) ? 'Verified' : 'Not Verified';
                        $row['mobile_verified']     = ($row['is_mobile_verified']) ? 'Verified' : 'Not Verified';
                        $row['package_name']        = $this->packages[($row['package_id']==0)? 1 : $row['package_id']]['package_name'];

                        $this->merchants[$row['id']] = $row;
                   } else {
                        $this->merchants[] = $row;
                   }
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
    
    public function merchants_report($post) {
        
        switch($post['report_type']) {
            
            case 'all':
                $whereMerchant = " AND  M.`pos_status` NOT IN ( 'suspended', 'deleted', 'expired', 'pending' ) ";
                break;
            case 'paid':
                $whereMerchant = " AND  M.`package_id` > '1' ";
                break;
            case 'demo':
                $whereMerchant = " AND  M.`package_id` = '1' AND M.`pos_status` NOT IN ( 'suspended', 'deleted', 'expired', 'pending' ) ";
                break;
            case 'suspended':
                $whereMerchant = " AND  M.`pos_status` = 'suspended' ";
                break;
            case 'active':
                $whereMerchant = " AND  M.`pos_status` NOT IN ( 'suspended','deleted','expired','pending' ) ";
                break;
            case 'going_to_expired':
                $whereMerchant = " AND S.`validity_balance` BETWEEN 0 AND 30 ";
                break;
            
        }//end switch
        
        //Condition to hide development pos.
        $developerCondition = " AND M.`id` NOT IN ('"._HIDE_POS_."') ";
        
        $query = "SELECT M.`id`, M.`name`, M.`email`, M.`phone`, M.`type`, M.`distributor_id`, M.`business_name`, M.`pos_name`, M.`pos_url`, M.`pos_current_version`,
            M.`pos_status`, M.`pos_create_at`, M.`package_id` , M.`subscription_start_at`, DATE(M.`subscription_end_at`) subscription_end_at , M.`subscription_is_active`, 
            M.`is_active`, M.`is_delete` , MT.`merchant_type` , MT.`keyword` as merchant_type_keyword , D.`display_name` AS distributor_name , 
            P.`package_name` , S.`validity_balance` 
            
        FROM `merchants` M 
                LEFT JOIN `merchant_type` AS MT ON M.`type` = MT.`id` 
                LEFT JOIN `admin` AS D ON M.`distributor_id` = D.`user_id` 
                LEFT JOIN `packages` AS P ON M.`package_id` = P.`id` 
                LEFT JOIN `view_pos_subscriptions` AS S ON M.`id` = S.`merchant_id` 
        WHERE M.`is_delete` = '0' $whereMerchant $developerCondition order by S.`validity_balance` ";
        
        $result = $this->conn->query($query);      
        
        if($result->num_rows): 
             
            while($row = $result->fetch_assoc()) 
            { 
               $this->merchants[] = $row;            
            }//end while.

            return $this->merchants;
        else :
            return false;
        endif;    
    }
    
    public function getPosStatusCounts() {
        
        $developerCondition = $this->getMerchantDeveloperCondition();
        
        $sql = "SELECT COUNT( `id` ) count,  `pos_status`, `is_delete`  FROM  `merchants` WHERE `pos_status`!= '' $developerCondition  GROUP BY `pos_status` ";
        
        $result = $this->conn->query($sql);
        
        $data['pending'] = $data['created'] = $data['expired'] = $data['extended']= $data['upgrade']= $data['deleted']= $data['suspended'] =$data['genuine'] =$data['generated'] = 0;
        
        while($row = $result->fetch_array(MYSQLI_ASSOC)){
            $data[$row['pos_status']] = $row['count'];
            $data['total'] += $row['count']; 
            
            if($row['pos_status'] =='pending' || $row['is_delete']==1) continue;
            $data['generated'] += $row['count']; 
        } 
        
        $data['genuine'] = $this->getGenuineMerchantCounts();
        
        return  $data;
    }
    
    public function getPosDeleteCounts() {
        
        $developerCondition = $this->getMerchantDeveloperCondition();
        
        $sql = "SELECT COUNT( `id` ) count FROM `merchants`  WHERE `is_delete` = '1' $developerCondition ";
        
        $result = $this->conn->query($sql);
        
        $row = $result->fetch_array(MYSQLI_ASSOC);
            
        return  $row['count'];
    }
    
    public function getGenuineMerchantCounts() {
        
        $developerCondition  = $this->getGenuineCondition(); 
        
        $developerCondition .= $this->getMerchantDeveloperCondition(); 
        
        $sql = "SELECT COUNT( `id` ) count FROM `merchants` WHERE  $developerCondition ";
        
        $result = $this->conn->query($sql);
        
        $row = $result->fetch_array(MYSQLI_ASSOC);
            
        return  $row['count'];
    }
    
    public function getGenuineCondition() { 
        
       // return " `is_merchant_verified` = '1' AND `pos_status` NOT IN ('deleted', 'pending', 'suspended') AND `pos_generate` = '1' ";   
        return " `is_merchant_verified` = '1'  ";   
    }
                
    public function getMerchantDeveloperCondition() {
        
        //Condition to hide development pos.
        $developerCondition = " AND `id` NOT IN ("._HIDE_POS_.") ";
        
        //Condition to get distributors pos
        if($_SESSION['login']['is_disrtibuter']) {
            $developerCondition .= " AND `distributor_id` = '".$_SESSION['session_user_id']."' ";
        }
        
        return $developerCondition;
    }
    
    public function filter_merchants(array $resuestData) {
        
        $whereClause = "";
        
        $itemsPerPage   = $resuestData['perpage'];
        $pageno         = $resuestData['page'];
        
        $this->merchants['itemsPerPage'] = $itemsPerPage; 
        $this->merchants['pageno']       = $pageno; 
        
        $developerCondition = $this->getMerchantDeveloperCondition();
        
        if($resuestData['result_type'] == 'filter') {
            
            if(is_array($resuestData['conditions'])) {
                
                foreach($resuestData['conditions'] as $field=>$value) {
                    
                    if(in_array($field, ['perpage','page'])) continue;
                    
                    if($field == 'is_merchant_verified') {
                        $whereClause = $this->getGenuineCondition();
                        break;
                    } else {                    
                        $whereData[] = " `$field` = '$value' ";
                    }
                }
                
                if(empty($whereClause)) {
                    $whereClause = join(' AND ', $whereData);
                }
            }
        
            $sqlCount = " SELECT count(id) as num FROM ".TABLE_MERCHANTS."  WHERE ". $whereClause ." " .$developerCondition . " ORDER BY `id` DESC ";
            
            $query = "  SELECT * FROM ".TABLE_MERCHANTS." 
                        WHERE ". $whereClause ." " .$developerCondition . " ORDER BY `id` DESC  
                        LIMIT ".( $pageno - 1 ) * $itemsPerPage .", " .$itemsPerPage;
            
        }
        
        if($resuestData['result_type'] == 'search') {
            
            $this->merchants['search_key'] = $resuestData['search_key']; 
            
            $search_key = $this->appCommon->prepareInput($resuestData['search_key']);
            
            $sqlCount = " SELECT count(id) as num FROM ".TABLE_MERCHANTS."  WHERE ( `name` LIKE  '%$search_key%'
                                    OR  `email` LIKE  '%$search_key%'
                                    OR  `phone` LIKE  '%$search_key%'
                                    OR  `address` LIKE '%$search_key%'
                                    OR  `pincode` LIKE '$search_key'
                                    OR  `business_name` LIKE  '%$search_key%'
                                    OR  `pos_name` LIKE  '%$search_key%'
                                    OR  `pos_current_version` LIKE '$search_key' 
                                    OR  `pos_url` LIKE  '%$search_key%' )  
                                     ".$developerCondition;
            
            $query = " SELECT * FROM ".TABLE_MERCHANTS."  WHERE ( `name` LIKE  '%$search_key%'
                                    OR  `email` LIKE  '%$search_key%'
                                    OR  `phone` LIKE  '%$search_key%'
                                    OR  `address` LIKE '%$search_key%'
                                    OR  `pincode` LIKE '$search_key'
                                    OR  `business_name` LIKE  '%$search_key%'
                                    OR  `pos_name` LIKE  '%$search_key%'
                                    OR  `pos_current_version` LIKE '$search_key' 
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
                    $row['pos_status']          = ($row['is_delete'] == 1) ? 'deleted' : $row['pos_status'];
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
             $updateFields[] = " $key = '".$post_data[$key]."' ";
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
            $sql .= "  WHERE id = '$update_id' ";  
            
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
                    $this->logUserActivity(['merchant_id'=>$update_id , 'activity'=>'Merchant information updated.']);              
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
    
    public function updateDistributor($merchant_id, $distributor_id) {
        
        if($distributor_id =='' || !$merchant_id) return false;
        
        $sql = "UPDATE ".TABLE_MERCHANTS." SET `distributor_id` = '$distributor_id' WHERE `id` = '$merchant_id' ";

        $result = $this->conn->query($sql);

        if($result) :            
            return true;
        else :
            return false;
        endif;
       
    }
    
    public function setToggleMerchantGenuineStatus($merchant_id) {
        
        $sql = "UPDATE ".TABLE_MERCHANTS." SET `is_merchant_verified` = IF(`is_merchant_verified` = '0' , '1' , '0') WHERE `id` = '$merchant_id' ";

        $result = $this->conn->query($sql);
        
        $merchantData = $this->get($merchant_id, 'is_merchant_verified');
        
        $data['genuine_status'] = $merchantData['is_merchant_verified'];
        
        if($result) :
            $data['status'] = 'SUCCESS';
        
            if($data['genuine_status']==1) {
                $this->logUserActivity(['merchant_id'=>$merchant_id , 'activity'=>'Genuine Status Set']);
            } else {
                $this->logUserActivity(['merchant_id'=>$merchant_id , 'activity'=>'Genuine Status Remove']);
            }
        else :
            $data['status'] = 'ERROR';
            $data['msg'] = $result->error;
        endif;
        
       return $data;
    }
    
    //Soft Delete Merchant
    public function merchantDelete($merchant_id) {
        
       return $this->merchant_deleted($merchant_id);    
       
    }
    //Alias Soft Delete Merchant
    public function merchant_deleted($merchant_id) {
        
        if(is_numeric($merchant_id) && $merchant_id > 0 )
        {
            $sql = "UPDATE  ".TABLE_MERCHANTS."  "
                    . " SET  `pos_previous_status` = `pos_status`, `pos_status` = 'deleted', `is_delete` = '1', `is_active` = '0' "
                    . " WHERE  `id` = '$merchant_id' ";
        
            $result = $this->conn->query($sql);

            if($result){
                $this->logUserActivity(['merchant_id'=>$merchant_id , 'activity'=>'Merchant soft deleted.']);
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
            $sql = "UPDATE  ".TABLE_MERCHANTS." "
                    . " SET `pos_status` = if(`pos_previous_status`='',  if(`pos_generate` = '1' , 'created', 'pending') , `pos_previous_status` ), `is_delete` = '0', `is_active` = '1' "
                    . " WHERE  `id` = '$merchant_id' ";
        
            $result = $this->conn->query($sql);

            if($result){
                $this->logUserActivity(['merchant_id'=>$merchant_id , 'activity'=>'Merchant soft delete remove.']);
                return true;
            } else {
                return false;
            }
         }
         return false;
    }
    
    public function activateSubscription($merchant_id) {
        
        $sql = "UPDATE ".TABLE_MERCHANTS." SET `subscription_is_active` = '1' , `subscription_start_at` = '".NOW."' WHERE `id` = '$merchant_id' ";

        $result = $this->conn->query($sql);

        if($result) :
            $this->logUserActivity(['merchant_id'=>$merchant_id , 'activity'=>'Subscription activated.']);
            return true;
        else :
            return false;
        endif;
       
    }
    
    public function deactivateSubscription($merchant_id) {
        
        $sql = "UPDATE ".TABLE_MERCHANTS." SET `subscription_is_active` = '0' WHERE `id` = '$merchant_id' ";

        $result = $this->conn->query($sql);

        if($result) :
            $this->logUserActivity(['merchant_id'=>$merchant_id , 'activity'=>'Subscription deactivated.']);
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
        
    public function getPosSetupLog( $merchant_id  ) {               
        
         $sql = "SELECT `id` , `merchant_id`, `pos_name`, `db_name` as db_name , `db_user` as db_user, `db_password` as db_passwd, `prefix`, `status`,
                        `step_1`, `step_2`, `step_3`, `step_4`, `step_5`, `step_6`, `step_7`, `username`, `password`, `pos_url`,
                        `created_at`, `created_by`, `deleted_at`, `deleted_by`
                FROM  " . TABLE_POS_SETUP_LOG . "  
                WHERE  `merchant_id` =  '$merchant_id'  
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
        
    public function getDbConfig($pos_name , $merchant_id) {  
        
        $dbConf = $this->getPosSetupLog( $merchant_id  );

        if($dbConf === false)
        { 
            $pos_name = trim($pos_name); 
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
    
    public function cp_resetDbConfig($pos_name , $merchant_id) {
        
        $pos_name = trim($pos_name);
        
        $rand1 = rand(0, 9);
        $rand2 = rand(0, 99);
        $rand3 = rand(0, 999);
        
        $randkey = $this->appCommon->randomPasswd(15);
        $userKey = $merchant_id. $rand1 . $pos_name . time();
        
        $dbConf['db_name']     = $db_name        = CP_PREFIX .'_'. substr($pos_name, 0, 8). $rand2 . $merchant_id;
        $dbConf['db_user']     = $db_user        = CP_PREFIX .'_'. substr($userKey, 0, 7);	
        $dbConf['db_passwd']   = $db_password    = substr($merchant_id. $rand3 . $randkey, 0, 16);

        $sql  = " UPDATE ".TABLE_POS_SETUP_LOG." "
            . " SET `pos_name` = '$pos_name', `db_name` = '$db_name', `db_user` = '$db_user', `db_password` = '$db_password' ,"
            . " `status` = '', `pos_url`='', `sql_version` = '0.0', `pos_version` = '0.0', `created_at`='000-00-00', "
            . " `step_1` = '0', `step_2`='0', `step_3`='0', `step_4`='0', `step_5` = '0', `step_6`='0', `step_7` = '0' "
            . " WHERE `merchant_id` = '$merchant_id' ";

        $result = $this->conn->query($sql);

        return $result;
    }
        
    public function getPosZipDetails($type='') {               
        
        $sql = "SELECT  `id`, `merchant_type`, `merchant_type_keyword`, `pos_project_zip` ,  `pos_sample_data_file`,  `pos_database_file`, `pos_images_zip_file` ,`pos_version` ,`sql_version`
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
     
    public function getMerchantPosData($merchant_id, $select='') {
        
        if(empty($select)) {
            $select = " `id`, `name`, `business_name` , `pos_name`, `phone` , `pos_url` , `db_name` , `db_username` , `db_password` , `pos_current_version` , `sql_current_version`, `project_directory_path`, `pos_status` ";
        } 
        $sql = "SELECT ".$select ." FROM  ".TABLE_MERCHANTS." 
                WHERE `id` = '$merchant_id'
                LIMIT 1 "; 
            
        $result = $this->conn->query($sql);      
        
        if($result->num_rows):
            
            $row = $result->fetch_assoc();
            
            return $row;
            
        endif;
        
        return false;
    }
        
    public function connect_merchant_pos_db($merchant_id){
        
        $this->conn_posinfo = $this->getMerchantPosData($merchant_id);
            
        if($merchants === false ) { $this->conn_pos = false; }
                
        $pos_db_name     = $this->conn_posinfo['db_name'];
        $pos_db_username = $this->conn_posinfo['db_username'];
        $pos_db_password = $this->conn_posinfo['db_password'];        
        
        $this->conn_pos = new mysqli("localhost", $pos_db_username, $pos_db_password, $pos_db_name);         
        
        //Check connection
        if($this->conn_pos->connect_error) {
            die("Connection failed: " . $this->conn_pos->connect_error);
        } 
        
    }
        
    public function desconnect_merchant_pos_db() {

        $this->conn_pos->close(); 
        unset($this->conn_pos);
        unset($this->conn_posinfo);
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
        
        $adonsSmsPackage  = explode('~', $transactionData['package']); 
        $pack_id    = $adonsSmsPackage[0];
        $pack_price = $adonsSmsPackage[1];
        $pack_sms   = $adonsSmsPackage[2];
        $taxAmt     = round( $pack_price * ( SERVICE_TAX_RATE / 100 )); 
        $total_billing_amount = $pack_price + $taxAmt;
        
        $sql = "INSERT INTO  ".TABLE_MERCHANTS_TRANSACTION 
                . " ( `merchant_id`, `adons_ids`, `billing_mode`, `adons_price`, `tax_amount`, `total_billing_amount`, `transaction_mode`, "
                . " `transaction_amount`, `transaction_date`, `transaction_status`, `transaction_id`, `currency`, `status_message`) "
                . " VALUES ('$id', '3', '12', '$pack_price', '$taxAmt', '$total_billing_amount', '$transaction_mode',"
                . " '$transaction_amount', now(), 'Success', '$transaction_id',  'INR', 'Upgrade By Admin' )";
        
         $result = $this->conn->query($sql);
         $resultData = [];
          if($result) {                
                
                $sql ="UPDATE ".TABLE_MERCHANTS."  SET  `sms_balance` = `sms_balance` + '$pack_sms' WHERE `id` = '$id' ";
       
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
                
        $order_at       = date('Y-m-d H:i:s');
        $amount         = $postData['amount'];
        $merchant_id    = $postData['customer_id'];
        $package_id     = $postData['package_id']; 
        
        $order_description =  json_encode($postData);
        
        $sql = "INSERT INTO ".TABLE_PACKAGE_ORDER." (`package_id`, `merchant_id`, `order_date`, `order_status`, `order_amount`, `order_description`)"
                . " VALUES ('$package_id', '$merchant_id', '$order_at', 'Order Send', '$amount', '$order_description' )";
         
        $result = $this->conn->query($sql); 
        
        if( $result ) {
            return  $this->conn->insert_id;
        }
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
            
            $days = ($billing_mode == 12) ? 365 : 30;
            
            $package_Update = " `package_id` = '$package_id', `subscription_start_at` = '$transaction_date', 
                                `subscription_end_at` = DATE_ADD( '$transaction_date', INTERVAL ".$days." DAY ) ,
                                `subscription_is_active` = '1', `adons_ids` = '$adons_id', `transaction_id` = '$transaction_id', ";            
        } else {
            $package_Update = " `adons_ids` = CONCAT(`adons_ids` , ',$adons_id'), ";             
        }
            $payment_status = (!isset($tansactionData['payment_status']) || empty($tansactionData['payment_status'])) ? 'paid' : $tansactionData['payment_status'];
        
            $sql = "UPDATE ".TABLE_MERCHANTS." 
                    SET 
                           `payment_status`      =  $payment_status,
                           `pos_previous_status` =  `pos_status`,
                           `pos_status`          =  'upgrade',                           
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
    
    public function adminActivatePackage( array $orderData ){
        
       $order_id =  $this->set_merchant_order($orderData);
       
       if(!$order_id) {
           $data['status'] = 'ERROR';
           $data['msg'] = 'Order Could Not Generate.';
           return $data;
       }
       
       if($orderData['inclusive_tax']) {
           $tax_amount = $orderData['amount'] * SERVICE_TAX_RATE / (100 + SERVICE_TAX_RATE);
       } else {
           $tax_amount = 0.0;
       }
       
       $activate_at = (!isset($orderData['activate_at']) || $orderData['activate_at'] == '' || !strtotime($orderData['activate_at'])) ? date('Y-m-d H:i:s') : $orderData['activate_at']; 
       
       $transactionData = [
                        'order_id' => $order_id,
                        'merchant_id' => $orderData['customer_id'],
                        'package_type' => 'basepack',
                        'package_id' => $orderData['package_id'],
                        'adons_ids' => '',
                        'billing_mode' => $orderData['duration'],
                        'billing_mode_price' => '0.0',
                        'adons_price' => '0.0',
                        'tax_amount' => $tax_amount,
                        'total_billing_amount'  => $orderData['amount'],
                        'transaction_amount'    => $orderData['amount'],
                        'bank_ref_no'           => in_array($orderData['payment_mode'], ['bank_deposit','cheque'])         ? $orderData['tid'] :'',
                        'transaction_id'        => in_array($orderData['payment_mode'], ['net_banking','card','wallet'])   ? $orderData['tid'] :'',
                        'transaction_mode'      => $orderData['payment_mode'],
                        'transaction_status'    => $orderData['payment_status'],
                        'transaction_date'      => $orderData['transaction_date'],
                        'activate_at'           => $activate_at,
                    ];
       
       $ObjPackage = $this->get_packages($package_id);
       
       $orderData['transaction_id'] = $this->_set_package_transaction($transactionData );
       $orderData['activate_at'] = $activate_at;
       $orderData['order_id'] = $order_id;
       
       if(!$orderData['transaction_id']) {
           $data['status'] = 'ERROR';
           $data['msg'] = 'Transaction Could Not Saved.';
           return $data;
       }
       
       return $this->_package_activate($orderData, $ObjPackage); 
       
    }
        
    //SMS Adon Transaction
    private function _set_package_transaction( array $transactionData ) {
        
        extract($transactionData);
         
        $days = ($billing_mode == 12) ? 365 : 30;
        $transactionDate = $this->appCommon->date_mmddyy_to_format($transaction_date , 'Y-m-d');
        
        $sql = "INSERT INTO  ".TABLE_MERCHANTS_TRANSACTION 
                . " ( `order_id`, `merchant_id`, `package_id`, `adons_ids`, `billing_mode`, `adons_price`, `tax_amount`, `total_billing_amount`, `transaction_mode`, "
                . " `transaction_amount`, `transaction_date`, `transaction_status`, `transaction_id`, `currency`, `status_message`, `subscription_start_date`, `subscription_end_date` ) "
                . " VALUES ( '$order_id', '$merchant_id', '$package_id', '$adons_ids', '$billing_mode', '$adons_price', '$tax_amount', '$total_billing_amount', '$transaction_mode',"
                . " '$transaction_amount', '$transactionDate', '$transaction_status', '$transaction_id',  'INR', 'Activated By Admin', '$activate_at', DATE_ADD( '$activate_at', INTERVAL ".$days." DAY ) )";
        
        $result = $this->conn->query($sql);
        
        if( $result ) {
            return  $this->conn->insert_id;
        }
    }
        
    private function _package_activate(array $packageData , array $ObjPackage) {
        
        $merchant_id = $packageData['customer_id'];
        $package_id  = $packageData['package_id'];
        $validity    = $packageData['duration'];
        $activate_at = $packageData['activate_at'];
        $transaction_id = $packageData['transaction_id'];
        $payment_status = $packageData['payment_status'];
        
        if(is_numeric($merchant_id) && $merchant_id > 0 )
        {
            $days = ($validity == 12) ? 365 : 30;
            
           $package = $ObjPackage[$package_id];
           
            $time = date('H:i:s');
            $sql = "UPDATE  ".TABLE_MERCHANTS." SET "
                    . " `pos_previous_status` = `pos_status`,"
                    . " `pos_status` = 'upgrade',"
                    . " `payment_status` = '$payment_status',"
                    . " `subscription_is_active` = '1',"
                    . " `subscription_end_at` = DATE_ADD( '$activate_at', INTERVAL ".$days." DAY ) ,"
                    . " `subscription_start_at` = '$activate_at',"
                    . " `package_id` = '$package_id', "
                    . " `adons_ids` = '$adons_ids', "
                    . " `transaction_id` = '$transaction_id', "
                    . " `users_balance`     = if( `users_used` >= ".$package['users']." , 0 , ".$package['users']." - `users_used` ), "
                    . " `products_balance`  = if( `products_used` >= ".$package['products']." , 0 , ".$package['products']." - `products_used` ), " 
                    . " `registers_balance` = if( `registers_used` >= ".$package['register']." , 0 , ".$package['register']." - `registers_used` ), " 
                    . " `customer_balance`  = if( `customer_used` >= ".$package['customers']." , 0 , ".$package['customers']." - `customer_used` ) " 
                    . " WHERE `id` = '$merchant_id' ";
            
            $result = $this->conn->query($sql);
            
            if($result) {
              $this->set_order_status(['status'=>'Success', 'id'=>$packageData['order_id']] );
              $this->logUserActivity(['merchant_id'=>$merchant_id , 'activity'=>'Package Activate From Admin. Transaction id: '.$transaction_id]);
              $data['status'] = 'SUCCESS';
              $data['msg'] = 'Package Activated.';
              
              $this->logUserActivity(['merchant_id'=>$merchant_id , 'activity'=>'Package activated package id is $package_id.']);
            } else {
              $data['status'] = 'ERROR';
              $data['msg'] = $this->conn->error;
            }
            
        } else {
            $data['status'] = 'ERROR';
            $data['msg'] = 'Invalid Merchant Id.';
        }
        
        return $data;
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
    
    public function expired_pos($merchant_id ='') {
        
        if(is_numeric($merchant_id) && $merchant_id > 0 )
        {
            $sql = "UPDATE  ".TABLE_MERCHANTS."  SET  `pos_previous_status` = `pos_status`, `pos_status` = 'expired', `subscription_is_active` = '0'"
                    . " WHERE  `id` = '$merchant_id'  AND `is_delete` = '0' ";
         
        } else {
            
            $sql = "UPDATE  ".TABLE_MERCHANTS." SET `pos_previous_status` = `pos_status`, `pos_status` = 'expired' , `subscription_is_active` = '0'  "
                    . " WHERE `pos_generate` = '1' AND `is_delete` = '0' AND `pos_status` NOT IN ('suspended', 'deleted') "
                    . " AND (`package_id` < '2' AND `pos_demo_expiry_at` <  NOW() ) OR ( `package_id` > '1' AND `subscription_end_at` < NOW()) ";
        }
        
         $result = $this->conn->query($sql);
         
         if($result){
            return true;
         } else {
            return false;
         }
    }
        
    public function update_pos_expry_date($merchant_id , $new_expiry_date) {
        
        $newDate = $this->appCommon->DateTimeFormat($new_expiry_date , 'Y-m-d');
        
        if(is_numeric($merchant_id) && $merchant_id > 0 )
        {
            $sql = "UPDATE  ".TABLE_MERCHANTS."  SET  `pos_previous_status` = `pos_status`, `pos_status` = 'extended', `subscription_is_active` = '1', `subscription_end_at` = '$newDate', "
                    . " `pos_demo_expiry_at` = if( `package_id` < 2 ,  '$newDate' , `pos_demo_expiry_at` ) "
                    . " WHERE `id` = '$merchant_id' ";
            
            $result = $this->conn->query($sql);
            
            if($result) {
              $data['status'] = 'SUCCESS';
              $this->logUserActivity(['merchant_id'=>$merchant_id , 'activity'=>'Pos expiry date extended.']);
            } else {
              $data['status'] = 'ERROR';
              $data['msg'] = $this->conn->error;
            }
            
        } else {
             $data['status'] = 'ERROR';
             $data['msg'] = 'Invalid Merchant Id.';
        }
        
        return $data;
    }
        
    public function suspend_pos($merchant_id ='', $action='') {
        
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
               
                $outer_path = empty($action) ? '../../' : '../';
                
                $suspendControlerPath = $outer_path.$pos_directory.'/app/controllers/';
                if(!is_file($suspendControlerPath . 'Suspend.php'))
                {
                    if(!is_file($outer_path.'include/pos_files/controllers/Suspend.php')) 
                    { 
                        echo '<div class="text-danger">Suspend Controllers Source File not Exists.</div>';                         
                    }
                    else 
                    { 
                        $controlerExists = copy( $outer_path.'include/pos_files/controllers/Suspend.php' , $suspendControlerPath . 'Suspend.php');
                    }
                }
                
                $suspendViewPath = $outer_path.$pos_directory.'/themes/default/views/';
                if(!is_file($suspendViewPath . 'suspend.php'))
                {
                   if(!is_file($outer_path.'include/pos_files/view/suspend.php'))
                   { 
                       echo '<div class="text-danger">View Source File not Exists.</div>'; 
                   } 
                   else
                   {
                        $viewExists = copy( $outer_path.'include/pos_files/view/suspend.php' , $suspendViewPath . 'suspend.php');
                   }
                }
                
                if($controlerExists && $viewExists) {                
                    
                    $routes_file_path = $outer_path.$pos_directory.'/app/config/routes.php';

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
                    $this->logUserActivity(['merchant_id'=>$merchant_id , 'activity'=>'Pos suspended.', 'action'=>'auto']);
                    return true;
                } else {
                    return false;
                }               
            }
        }        
        return false;
    }
    
    public function auto_suspeds_expiry_pos() {
       
        $merchants = $this->getmerchants('', 'id', " AND `pos_status` = 'expired' ");
            
        if($merchants['count'] > 0) {
           
            foreach($merchants['data'] as $key=>$merchant){
               
               $this->suspend_pos($merchant['id'], 'AUTO');
            }
        }
    }
    
    public function getmerchants($id='', $select = '', $condition='') {
        
        $developerCondition = $this->getMerchantDeveloperCondition();
        
        if(is_numeric($id)) {
            $whereMerchant = " `id` = '$id' ";
        }
        elseif(is_array($id)) {            
            $ids = join(',' , $id);
            $whereMerchant = " `is_delete` = '0' AND `id` IN ($ids) ";
        } else {
            $whereMerchant = " `is_delete` = '0' ";
        }
        
        $fields = ($select=='') ? ' * ' : $select;
        
       $query = "SELECT $fields FROM ".TABLE_MERCHANTS." 
                 WHERE $whereMerchant $developerCondition $condition order by `id` DESC ";
        
        $result = $this->conn->query($query);
       
        $merchants['count'] = $result->num_rows;
        
        if($result->num_rows > 0){

            while($row = $result->fetch_assoc()) 
            {
                $merchants['data'][] = $row;
            }//end while.
        }
        
        return $merchants;
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
                
                $sql = "UPDATE  ".TABLE_MERCHANTS." SET `pos_status` = if(`pos_previous_status`='' , 'created', `pos_previous_status` ) WHERE  `id` = '$merchant_id' ";

                $result = $this->conn->query($sql);             

                if($result){
                    $this->logUserActivity(['merchant_id'=>$merchant_id , 'activity'=>'Pos unsuspended.']);
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
                $this->logUserActivity(['merchant_id'=>$merchant_id , 'activity'=>'Merchant activated']);
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
                $this->logUserActivity(['merchant_id'=>$merchant_id , 'activity'=>'Merchant deactivated']);
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
            $this->logUserActivity(['merchant_id'=>$merchant_id , 'activity'=>'Merchant remove permanently.']);
            
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
        
    public function setVersionToPosSettings($posconn , array $projectDataPath) {
         
        $versionData['version']     =  $projectDataPath['pos_version'];
        $versionData['sql']         =  $projectDataPath['sql_version'];
        $versionData['type']        =  $projectDataPath['merchant_type'];
        $merchant_type_keyword      =  $projectDataPath['merchant_type_keyword'];
        $versionData['type_id']     =  $projectDataPath['id'];
        
        $jsonFormatVersionData = json_encode($versionData);
        
        $sql = "UPDATE `sma_settings` SET `pos_version` = '$jsonFormatVersionData', `pos_type` = '$merchant_type_keyword' WHERE `setting_id` = '1' ";
        
        $result = $posconn->query($sql);
         
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
        
        $sql = "UPDATE `sma_users` SET ";
        
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
    
    public function getScrapFolderList($dir_path) {
        
        $rootFolders = $this->appCommon->getSubFolderList( $dir_path  );
        $scrapsDir = [];
        if(is_array($rootFolders)) {
            
            foreach ($rootFolders as $key => $dir) {
                
                if($this->is_valid_pos($dir) === false){
                    $scrapsDir[] = $dir;
                }
            }
        }
        
        return $scrapsDir;
    }
    
    public function is_valid_pos($posname) {
        
        $validFolders = ['.', '..', 'simplypos', 'simplystatic', 'simplysafe', 'devpos', 'pos', 'Pos', 'app','paynear', 'api', 'posadmin', 'include','functions','merchant', 'merchants', 'posmerchants', 'PHPMailer', 'sass', 'css', 'js', 'style', 'img', 'fonts', 'pos_backups', 'poscron', 'paynearpos'];
        
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
    
    
    /*
     * @Para: Subdomain without https and www (Ex. xyz.mydomain.com )
     */
    public function cp_deleteSSL($pos_subdomain)  {
        
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
                
   /*
    * @Para: String , Subdomain without https and www (Ex. xyz.mydomain.com )
    * @return Array
    */
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
    
     //Para: Prefix_Username
    public function cp_setCorn($filepath , $minute='*', $hour='*',  $day='*', $month='*', $weekday='*' ) {
        
        // Deletes the database user "example_user1"
        $delete_user = (array)$this->CP_xmlapi->api2_query( CP_USERNAME, 'Cron', 'add_line',  array(
                                    'command'        => '/usr/bin/php/home/sitadmin/public_html/'.$filepath,
                                    'day'            => $day,
                                    'hour'           => $hour,
                                    'minute'         => $minute,
                                    'month'          => $month,
                                    'weekday'        => $weekday,
                                ) );
        
        $response = (array)$delete_user['event'];
        
        return $response; 
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
        
        $sql ="SELECT *  FROM ".TABLE_POS_SUBSCRIPTIONS."
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
    
    public function getPosLatestVersion($after_version='') {
        
        $sqlwhere = '';
        if($after_version != ''){            
            $sqlwhere = " AND  `version` > '$after_version' ";
        } 
        
        $sql = "SELECT `id`, `version`, `relese_status`, `relese_type` , `relese_date`, `upgread_sql`, `sql_file_path_up`, `project_code_path`"
                . " FROM  ".TABLE_POS_VERSIONS." 
                WHERE  `version`  
                            IN (
                                SELECT MAX( version )  FROM  ".TABLE_POS_VERSIONS." 
                                WHERE  `is_active` =  '1'  AND  `is_delete` =  '0' $sqlwhere 
                                GROUP BY  `relese_status` 
                            ) 
                ORDER BY `version` DESC ";
        
        $result = $this->conn->query($sql); 
        
        if($data['num'] = $result->num_rows) {           
            while ($row = $result->fetch_assoc()) {
                 $data['data'][$row['id']] = $row;
                 $data['versions'][$row['id']] = $row['version'];
            }//end while.         
        }
            
        return $data;
        
    }
    
    public function getMerchantPosBackups($merchant_id , $limit='') {
        
        $sqlwhere = '';
        if($limit != ''){            
            $sqlwhere = " LIMIT $limit ";
        } 
        
        $sql = "SELECT * FROM  ".TABLE_MERCHANT_POS_BACKUPS_LOG." 
                WHERE `merchant_id` = '$merchant_id'   
                GROUP BY version , type 
                ORDER BY `backup_time` DESC ";
        
        $result = $this->conn->query($sql); 
        
        if($data['num'] = $result->num_rows) {           
            while ($row = $result->fetch_assoc()) {
                 $data['data'][$row['id']] = $row;
            
            }//end while.         
        }
            
        return $data;
        
    }
    
    public function getVersionInfo($version_id) {
        
        $sql = "SELECT `id`, `version`, `relese_status`, `relese_type` , `relese_date`, `upgread_sql`, `sql_file_path_up`, `project_code_path`"
                . " FROM  ".TABLE_POS_VERSIONS 
                . " WHERE `id` = '$version_id' LIMIT 1 ";
        
        $result = $this->conn->query($sql); 
        
        if( $result->num_rows) {           
             return $result->fetch_assoc(); 
        }
    }
    
    public function getPosUpgradeVersion($pos_version) {
        
        $sql = "SELECT * FROM  ".TABLE_POS_VERSIONS." 
                WHERE `version` > '$pos_version'                              
                ORDER BY `version` DESC  LIMIT 3";
        
        $result = $this->conn->query($sql); 
        
        if($data['num'] = $result->num_rows) {           
            while ($row = $result->fetch_assoc()) {
                $data['data'][] = $row;
            }//end while.         
        }
        
        return $data;
        
    }
    
    public function getMerchantPosVersion($merchant_id) {
        
        $this->connect_merchant_pos_db($merchant_id);
        
        $sql = "SELECT `pos_version` FROM `sma_settings` WHERE `setting_id` = '1' ";
       
        $result = $this->conn_pos->query($sql);
        
        if($result){
            
            $row = $result->fetch_assoc();
           
            $this->desconnect_merchant_pos_db();
            
            return $this->appCommon->isJson($row['pos_version'], true);  
             
        } else {
           return  $result->error ;
        }
    }
    
    public function setMerchantPosVersion( $merchant_id ,  $posVersion)  { 
        $pos_version = $posVersion['version'];
        $sql_version = $posVersion['sql'];  
        
        $sql=" UPDATE  ".TABLE_MERCHANTS."  
                     SET   
                            `sql_current_version` = '$sql_version',
                            `pos_current_version` = '$pos_version'
                     WHERE 
                            `id` = '$merchant_id' ";
         
         $result = $this->conn->query($sql);
         
        if($result){
            $this->logUserActivity(['merchant_id'=>$merchant_id , 'activity'=>'Set pos version.']);
            return true;
        } else {
            return false;
        }
    }    
    
    public function getMerchantPosCurrentVersion( $merchant_id )  { 
        
        $sql=" SELECT `pos_current_version` FROM ".TABLE_MERCHANTS."  WHERE  `id` = '$merchant_id' ";
         
         $result = $this->conn->query($sql);
         
        if($result){
            $row = $result->fetch_assoc();
             
            return $row['pos_current_version'];
        } else {
            return  $result->error ;
        }
    }    
    
    public function checkMerchantPosVersion($merchant_id) {
        
       $posVersion = (array)$this->getMerchantPosVersion($merchant_id);
        
       $isset = $this->setMerchantPosVersion($merchant_id , $posVersion);
       
       if($isset) {
           $data['status'] = "SUCCESS";
           $data['version'] = $posVersion['version'];
       } else {
           $data['status'] = "ERROR";
           $data['version'] = 'Not Found';
       }
       
       return $data;
    }
        
    public function pos_update_setup($merchant_id , $steps=0 , $extra=[]) {
        
        $data = [];
        switch ($steps) {
            case 1:
                
              $data =  $this->__pos_update_step1($merchant_id);
              $data['next_step'] = 2;  
              $data['next_msg'] = 'Next Step 2: Take POS Code Backups.';
              $data['msg'] = 'Step 1 Succeeded: Database backups completed.';
              
                break;
            
            case 2:
                
              $data =  $this->__pos_update_step2($merchant_id);
                
                if($data['status'] == 'SUCCESS') {
                  $data['next_step'] = 3;  
                  $data['next_msg'] = 'Next Step 3: Update POS Latest Version.';
                  $data['msg'] = 'Step 2 Succeeded: POS backups completed.';
                } 
                
                break;
            
            case 3:
                
                $version_id = $extra['update_version_id'];
                
                $data =  $this->__pos_update_step3($merchant_id , $version_id);
                
                if($data['status'] == 'SUCCESS') {
                  $data['next_step'] = 4;  
                  $data['next_msg'] = 'Congratulations! POS Successfully Updated.';
                  $data['msg'] = 'POS Updates Completed';
                  $this->logUserActivity(['merchant_id'=>$merchant_id , 'activity'=>'POS version updated.']);
                }
                
                if($data['status'] == 'ERROR') {
                  $data['next_step'] = 3;  
                  $data['next_msg'] = '<ul>'.$this->response . '</ul>';
                  $data['msg'] = 'POS Updates Failed';
                }
                
                $data['response_log'] = $this->response;
                
                break;
                
            default:
                
                $data['status'] = 'SUCCESS';
                $data['next_step'] = 1;
                $data['next_msg'] = 'Step 1: Take Database Backups.';                
                $data['msg'] = 'Run POS Updates';
                break;
        }
        
        return $data;        
    }
    
    private function __pos_update_step1($merchant_id) {
        //POS Database Connection
        $this->connect_merchant_pos_db($merchant_id);
        
        $data = $this->appCommon->export_database($this->conn_pos, $this->conn_posinfo['db_name'] , $this->conn_posinfo['pos_current_version'] ,  _DIR_POS_BACKUPS_SQL );
                
        if($data['status'] == 'SUCCESS') {
            
            $backupSql = str_replace('../', '', $data['backup']);
            $setlog = $this->__set_pos_backup_log($backupSql, $merchant_id , $type='sql', $this->conn_posinfo['pos_current_version']);
            
             //POS Database Connection Closed
            $this->desconnect_merchant_pos_db();
            
            if($setlog) {                
                return $data;
            }
        }
        
    }
    
    private function __pos_update_step2($merchant_id) {
        
        $posinfo = $this->getMerchantPosData($merchant_id);
        
        $data = $this->__get_pos_backup( $posinfo['project_directory_path'] );
        
        if($data['status'] == 'SUCCESS') {
            
            $backupPos =  $data['response']['backup_copy'];
            $setlog = $this->__set_pos_backup_log($backupPos, $merchant_id , $type='code', $posinfo['pos_current_version'] );
            
            if($setlog) {                
                $data['setlog']=$setlog;
            }
        }
        return $data;    
    }
    
    private function __pos_update_step3($merchant_id , $version_id){
        
        $posinfo = $this->getMerchantPosData($merchant_id);
        
        $versionInfo = $this->getVersionInfo($version_id);
        
        //POS Database Connection
        $this->connect_merchant_pos_db($merchant_id);
        
        $data = $this->__copy_version_files_to_pos($posinfo , $versionInfo);
            
        if($data['sql'][$versionInfo['version']]['version_update'] == true) 
        {
            $data['status']= "SUCCESS";  
        } else {
            $data['status']= "ERROR";  
        } 
        
        //POS Database Connection Closed
        $this->desconnect_merchant_pos_db();
        
       return $data;
    }
    
    private function __copy_version_files_to_pos( $posinfo , $versionInfo){            
        
        $zip = new ZipArchive();
          
        $versionPath = '../' . $versionInfo['project_code_path'];  
       
        $data['status']= "SUCCESS"; 
        
        if(is_file($versionPath .'/index.php')) {
            $this->response .= "<li>Projest Directory is available : $versionPath </li>";
        } else {
            $data['status']= "ERROR"; 
            $this->response .= "<li class='text-danger'>Projest Directory not found : $versionPath </li>";            
            return $data;
        }
        $createzip = false;
        if(file_exists($versionPath.'/' . _VERSION_UPGRADE_ZIP) === false)
        {
            $createzip = true;
            $this->response .= '<li>Version Upgrade ZIP not exists : '._VERSION_UPGRADE_ZIP.'</li>';
            
            $avoideFiles = [
               //$versionInfo['project_code_path'] . '/app/config/config.php',
               $versionInfo['project_code_path'] . '/app/config/database.php',
               $versionInfo['project_code_path'] . '/app/config/payment_gateways.php',
            ];

            $avoideFolders = [
                '/assets/uploads',
                '/files',
                '/system',
                '/app/migrations',
                '.zip',
            ];

            $files = $this->appCommon->getFilesAndSubfoldersList('../'.$versionInfo['project_code_path']);
          
            $objopen = $zip->open( $versionPath.'/'._VERSION_UPGRADE_ZIP , ZipArchive::CREATE);  
            
            if(!$objopen) {
                $this->response .= '<li class="test-danger">Unabled to open zip  : '.$versionPath.'/'._VERSION_UPGRADE_ZIP.'</li>';
            }

            if(is_array($files))
            {
                foreach ($files as $key => $filePath) {

                    $avoid = false;

                    if(pathinfo($filePath, PATHINFO_EXTENSION) == 'zip'){ continue; }

                    foreach ($avoideFolders as $findstr) {                    
                        if(strstr($filePath, $findstr . '/')  ) {  $avoid = true; break; }
                        if(strstr($filePath, $findstr) && is_dir($filePath) ) {  $avoid = true; break; }
                    }

                    foreach ($avoideFiles as $filestr) {
                        if(strstr($filePath, $filestr) && is_file($filePath) ) {  $avoid = true; break; }
                    }

                    if($avoid === false) {
                        $moveList[] = $filePath;
                        $path = $filePath;
                        if($objopen){

                            $addPath = str_replace($versionPath, '', $path);

                            if (is_dir($path))
                            {
                                $zip->addEmptyDir( $addPath );            
                            }

                            if (is_file($path))
                            {
                                $zip->addFile($path , $addPath );
                            } 

                        }//end if.

                    }//end if. 

                }//end foreach.
            }//end if.

        }//end if.
            
        return  $this->__update_version_code($zip , $versionPath.'/' . _VERSION_UPGRADE_ZIP , $posinfo , $versionInfo);
        
    }//end method.
    
    private function __update_version_code($zip , $versionZipFile , $posinfo , $versionInfo) {
        
        //Version Upgrade Zip Exists.
        $zipexists = file_exists($versionZipFile);
        
        $this->response .= '<li>Zip Exists: '.$versionZipFile.' ('.$zipexists.')</li>';
        
        if($zipexists)
        {
            $this->response .= '<li>Version project Zip is exists.</li>'; 
            
            if($zip->open($versionZipFile) === TRUE) 
            {
                $extracted = $zip->extractTo('../../' . $posinfo['project_directory_path']);
                
                $zip->close();
                
                //Rename Eshop Old Project If exists in POS Directory.
                $oldShopDirectory = '../../' . $posinfo['project_directory_path'].'/shop';

                if(is_dir($oldShopDirectory)){

                    if(rename($oldShopDirectory, $oldShopDirectory.'_old'))            
                    {
                        $this->response .= '<li class="text-success">Old Shop Directory Renamed Successfully</li>';
                    } else {
                        $this->response .= '<li class="text-danger">Old Shop Directory Renamed failed</li>';
                    }
                }
				
                if(!$extracted){
                    $data['status']= "ERROR"; 
                    $this->response .= '<li class="text-danger">Version project Zip could no extracted.</li>';
                } else {
                   $this->response .= '<li class="text-success">Version project Zip extracted successfully.</li>';
                   $data['status'] = "SUCCESS"; 
                   $data['code']['upgrade'] = 1;				   
				   
                    //Set Project Baseurl.                   
                    $configFile = '../../' . $posinfo['project_directory_path'] . "/app/config/config.php";
                    if(is_writable($configFile)) :
                            $fhandle1 = fopen($configFile,"r");
                            $content1 = fread($fhandle1,filesize($configFile));
                            $content1 = str_replace('[MERCHANT_PHONE]', $posinfo['phone'] , $content1);
                            $content1 = str_replace('[PROJECT_BASE_URL]', $posinfo['pos_url'] , $content1);
                            $fhandle1 = fopen($configFile,"w");
                            $fw2 = fwrite($fhandle1,$content1);
                            $this->response .= '<li class="text-Success">Comfiguration updated.</li>'; 
                            fclose($fhandle1);
                            
                            $data['sql'] = $this->__upgrade_version_database($posinfo, $versionInfo);                            
                    else :
                            $this->response .=  '<li class="text-danger">app/config/config.php file not writable.</li>';                            
                    endif;
                    
                    //Copy Eshop Theams Default Images.                   
                    $eshopTheamsImagesPath = '../../' . $posinfo['project_directory_path'] . "/assets/uploads/eshop_user";
                    $eshopTheamsImageSorce = '';
                    
                    
                   return $data;
                }
            } else {
                 $data['status']= "ERROR"; 
                 $data['msg']= "Zip could not open : ".$versionZipFile; 
                 $this->response .= '<li class="text-danger">Version project Zip could not open.</li>';
            }
           
        }
        else{
            $data['status']= "ERROR"; 
            $data['msg']= "Version Upgrade Zip could not Found : ".$versionZipFile;
            $this->response .= '<li class="text-info">Please Select Version and Try again</li>';
        }
            
         return $data; 
    }
    
    /**
     * 
     * @param int $backup_version_id
     * @return boolean
     */
    private function __getPosVersionBackups($backup_version_id) {
        
        $sql = "SELECT `pos_code_file`, `pos_sql_file`, `version` FROM ".TABLE_MERCHANT_POS_BACKUPS_LOG."  WHERE `id` = '$backup_version_id' "; 
        
        $result = $this->conn->query($sql);  
        
        if($data['num'] = $result->num_rows) 
        {             
             $row = $result->fetch_assoc();            
             return $row;
        } else {
             return false;
        }
    }

    private function __get_pos_backup( $pos_directory_path ) {
        
       /*
        * PHP: Recursively Backup Files & Folders to ZIP-File
        * (c) 2012-2014: Marvin Menzerath - http://menzerath.eu
       */
       // Make sure the script can handle large folders/files
       ini_set('max_execution_time', 600);
       ini_set('memory_limit','1024M');

        $dirarr = ['version_backup','code'];
        $dirpath = '../../'.$pos_directory_path;
        foreach($dirarr as $dir){
           $dirpath .= '/' .$dir;
           $set = $this->appCommon->set_dir($dirpath);
           if(!$set) { $this->appCommon->set_dir($dir); }
        }  
            
        $count = 0; 
       
          $zip = new ZipArchive();

           try { 
               define('_POS_DIR_', '../../'.$pos_directory_path);
               
               $dir_pos_path    =   _POS_DIR_;
               $backup_file     =   _POS_BACKUPS_ZIP;
               
                $dir_pos_backup  =   $dir_pos_path . '/version_backup/code'; 
               
                $objopen = $zip->open($dir_pos_backup .'/'. $backup_file, ZipArchive::CREATE);            
                
                if($objopen)
                {
                   $zipFileCount = $this->appCommon->addFileToZip( $zip , $dir_pos_path );
                   $zip->close();
                   
                    if($zipFileCount)
                    {
                        $data['response']['files'] = $zipFileCount;
                        $backupFilePath = $pos_directory_path .'/version_backup/code/'. $backup_file;
                        
                        if(is_file('../../'.$backupFilePath)) {
            
                            $data['status'] = "SUCCESS";
                            $data['msg'] = "POS Backups successfull.";
                            $data['response']['backup_file'] = $backupFilePath;
                            
                            $posBackFileCopy = str_replace('/', '_', $pos_directory_path).'_'.time().'.zip';
                        
                            $destinationPath = '../../' . _DIR_POS_BACKUPS_CODE . '/' . $posBackFileCopy; 
                            $copy = copy($dir_pos_backup .'/'. $backup_file , $destinationPath);

                            if($copy){            
                                $data['response']['backup_copy'] = _DIR_POS_BACKUPS_CODE . '/' . $posBackFileCopy;                             
                            } 
                        } else {
                            $data['status'] = "ERROR";
                            $data['msg'] = "Backup file not found.";
                            $data['backup_file'] = $backupFilePath;
                        }                                              
                    }
                }
           } catch (Exception $exc) {
            $data['status'] = "ERROR";
            $data['msg'] = $exc->getMessage();
        }
        
        return $data;
    }
    
    private function __set_pos_backup_log($backupFile, $merchant_id, $type='sql', $pos_current_version='' ) {
        
        if($type == 'sql') { 
            $fieldname = " `pos_sql_file` ";
        } 
        elseif($type == 'code') { 
            $fieldname = " `pos_code_file` ";
        }
        $backupid = $this->isExistPosBackup( $pos_current_version , $merchant_id );
        
        if($backupid) {
            
            $sql = "UPDATE  ".TABLE_MERCHANT_POS_BACKUPS_LOG." SET `backup_time` = CURRENT_TIMESTAMP , $fieldname = '$backupFile' "
                    . " WHERE `id` = '$backupid' ";            
        } else {
        
            $sql = "INSERT INTO ".TABLE_MERCHANT_POS_BACKUPS_LOG." (`backup_time`, `merchant_id`, `version`, `type`, $fieldname ) "
                    . " VALUES ( CURRENT_TIMESTAMP, '$merchant_id', '$pos_current_version', '$type', '$backupFile')";
        }
        $result = $this->conn->query($sql);  
        
        if($result) { return true; } else { return false; }
        
    }
        
    private function isExistPosBackup($version , $merchant_id ) {
        
        $sql = "SELECT max(`id`) id FROM ".TABLE_MERCHANT_POS_BACKUPS_LOG." WHERE `merchant_id` = '$merchant_id' AND `version`='$version' ";
        
        $result = $this->conn->query($sql);  
        
        if($data['num'] = $result->num_rows) { 
            
             $row = $result->fetch_assoc();            
             return $row['id'];
        } else {
             return false;
        }
    }

    /**
     * 
     * @param array $posinfo
     * @param array $versionInfo
     * @return string
     */
    private function __upgrade_version_database(array $posinfo , array $versionInfo) {
        
        $merchant_id = $posinfo['id'];
        
        $current_pos_version = $posinfo['pos_current_version'];
        
        $upgraded_pos_version = $versionInfo['version'];
        
        $sqlInfo = $this->get_upgrade_pos_sql_list($current_pos_version , $upgraded_pos_version);
        
        if(is_array($sqlInfo['up'])) {
            
            foreach ($sqlInfo['up'] as $sql_version => $sql_path) {
                
                if(file_exists('../'.$sql_path)){                    
            
                   $data[$sql_version] = $this->appCommon->runSqlFile($this->conn_pos , '../'.$sql_path);
                   
                   if($data[$sql_version]['total_query'] == $data[$sql_version]['query_success'])
                   {
                       $this->response .= '<li class="text-success">Sql Version Updated: '. $sql_version.'</li>';
                       $data[$sql_version]['version_update'] = $this->updateMerchantCurrentPosVersionInfo(['id'=>$merchant_id, 'sql_current_version'=> $sql_version, 'pos_current_version'=>$upgraded_pos_version]);
                   }
                } else {
                   $data[$sql_version] = $sql_path. " File Not Found.";
                   $this->response .= '<li class="text-danger">Sql File Not Found : '.$sql_path.' </li>';
                   break;
                }
                
            }//end foreach
            
        }//end if.
        
        return $data;
    }
    
    /**
     * 
     * @param array $merchantVersions
     * @return boolean
     */
    public function updateMerchantCurrentPosVersionInfo( array $merchantVersions ) {
        
       $merchant_id = $merchantVersions['id'];
       $sql_current_version = $merchantVersions['sql_current_version'];
       $pos_current_version = $merchantVersions['pos_current_version'];
       
       $sql = "UPDATE ".TABLE_MERCHANTS." "
               . " SET `sql_current_version` = '$sql_current_version', `pos_current_version` = '$pos_current_version' "
               . " WHERE `id` = '$merchant_id' ";
       
       $result = $this->conn->query($sql); 
       
       if($result){
           return true;
       } else {
           return false;
       }
       
    }
    
    /**
     * 
     * @param float $current_pos_version
     * @param float $upgraded_pos_version
     * @param string $methos
     * @return boolean
     */
    public function get_upgrade_pos_sql_list($current_pos_version , $upgraded_pos_version, $methos='up') {
        
        if(!is_numeric($current_pos_version)) return false;
        
        $orderSys = ($methos=='up') ? ' ASC ' : ' DESC ';
        
        $sql = "SELECT  `id` , `version`, `upgread_sql`, `sql_file_path_up`, `sql_file_path_down` "
                . " FROM ".TABLE_POS_VERSIONS." "
                . " WHERE `version` > '$current_pos_version' AND  `version` <= '$upgraded_pos_version' "
                . " ORDER BY `version` $orderSys ";
        
         $result = $this->conn->query($sql); 
        
        if($data['num'] = $result->num_rows) {           
            while ($row = $result->fetch_assoc()) 
            {
                if(!empty($row['sql_file_path_up'])) {
                    $data['up'][$row['version']] = $row['sql_file_path_up'];
                    $down[$row['version']] = $row['sql_file_path_down'];
                } else {
                    $data['num'] = $data['num'] - 1;
                }
            }//end while. 
            
            $data['down']  = array_reverse($down);
        }
        
        return $data;
    }
    
    /**
     * 
     * @param string $db_name
     * @return Array
     */
    public function getDatabaseTablesAndViewsList($db_name) {
        
        $dbData = $this->appCommon->get_database_description($db_name , $this->conn_pos);
            
        if(is_array($dbData)){
            $count=0;
            foreach ($dbData as $key => $dbArr) {
                if($dbArr['TABLE_TYPE']=='VIEW') {
                    $dbTables['view'][] = $dbArr['TABLE_NAME'];
                } else {
                    $dbTables['table'][] = $dbArr['TABLE_NAME'];
                }
                $count++;
            }
            $dbTables['count'] = $count;
            return $dbTables;
        }
        
        return $dbTables['count'] = 0;
    }
    
    /**
     * 
     * @param string $db_name
     * @return boolean
     */
    public function deletePosDbTables($db_name ) {
        
        $dbTables = $this->getDatabaseTablesAndViewsList($db_name );
        
        if($dbTables['count'] > 0)
        {
            $tableList = join(',', $dbTables['table']); 
            $sql     = "DROP TABLE IF EXISTS $tableList ";
            
            $result = $this->conn_pos->query($sql);

            if($result){
                $this->response = 'DB tables deleted.';

                if(count($dbTables['view']) > 0) {
                    $viewList = join(',', $dbTables['view']);
                    $sqlview = "DROP VIEW  IF EXISTS $viewList ";

                    $resultView = $this->conn_pos->query($sqlview);

                    if($resultView ){
                        $this->response = 'DB views deleted.';
                        return true;
                    } else {
                        $this->response = $result;
                        return false;
                    }
                } else {
                    return true;
                }

            } else {
               $this->response = $result; 
               return false;
            }//end else.
        }//end if.
        else
        {
            return true;
        }
    }
    
    /**
     * 
     * @param string $pos_sql_file
     * @return boolean
     */
    public function importDbBackups($pos_sql_file) {
        
        $sqlBackupFile = '../../'.$pos_sql_file;
       
        if(file_exists($sqlBackupFile)) {
            
            $data = $this->appCommon->runSqlFile($this->conn_pos , $sqlBackupFile);
            
            if($data['total_query'] == $data['query_success'])
            {
                $this->response .= 'Backup Database Imported Successfully.';
                return true;
				//$d = array('status'=>true, 'data'=>$data);
				//return $d;
            } 
            
            return false;
            //$d = array('status'=>false, 'data'=>$data);
            //return $d;
        } 
    }
    
    public function restorePosCodeBackup($posinfo , $pos_code_file) {
        
        $backupPath = '../../'.$pos_code_file;
        //Backup Restore Zip Exists.
        $zipexists = file_exists($backupPath);
        
        if($zipexists)
        { 
            $zip = new ZipArchive();
            
            $this->response = 'Backup Zip Exists : '.$backupPath;
            
            if($zip->open($backupPath) === TRUE) 
            {
                $projectPath = '../../'.$posinfo['project_directory_path'];
                
                if(file_exists($projectPath . '/index.php')){
                    
                   $this->response = 'Project Path Found : '.$projectPath; 
                   
                    $extracted = $zip->extractTo($projectPath);
                
                    $zip->close();
                    
                    if($extracted) { return true; }
                    else { $this->response = 'POS Backup could not extracted at project path.'; }
                    
                } else {
                    $this->response = 'Project Path Dose Not Found : '.$projectPath;                    
                }                
               
            } else {
                $this->response = 'Backup Zip Could Not Open.';
            }
            
        } else {
            $this->response = 'Backup Zip Dose Not Exists : '.$backupPath;
        }
        
        return false;
    }
    
    /**
     * 
     * @param int $merchant_id
     * @param int $backup_version_id
     * @return array
     */
    public function pos_rollback_setup($merchant_id , $backup_version_id) {
        
        $this->connect_merchant_pos_db($merchant_id); 
        
        $isDbDeleted = $this->deletePosDbTables($this->conn_posinfo['db_name']); 
            
        $data['isDbDeleted'] = $isDbDeleted;
        
        if($isDbDeleted) 
        {
        	$data['my_status'] = 'isDbDeleted is true';
        	
			$backups = $this->__getPosVersionBackups($backup_version_id);
			
			$data['backups'] = $backups;
			
			$posinfo = $this->getMerchantPosData($merchant_id);
			
			$data['posinfo'] = $posinfo;

			$isDbImported = $this->importDbBackups( $backups['pos_sql_file'] );
			
			$data['isDbImported'] = $isDbImported;

			//Connection Closed.
			$this->desconnect_merchant_pos_db();
           
            if($isDbImported) // $isDbImported['status']
            {               
            
            	$data['my_status'] = 'isDbImported is true';
            	
                $backupRestore = $this->restorePosCodeBackup($posinfo , $backups['pos_code_file']);
                
                $data['backupRestore'] = $backupRestore;
            
                if($backupRestore) {
                    
                	$versionUpdate = $this->updateMerchantCurrentPosVersionInfo(['id'=>$merchant_id, 'sql_current_version'=> $backups['version'], 'pos_current_version'=>$backups['version'] ]);
					if($versionUpdate) {
						$data['status'] = 'SUCCESS';
						$this->response = "Merchant Current Version Changed.";
						$this->logUserActivity(['merchant_id'=>$merchant_id , 'activity'=>'Rollback pos version '. $backups['version'].' update.']);
					} else {
						$this->response = "Could not change merchant current version.";
						$data['status'] = 'ERROR';
					}
                } else {
                    $this->response = $backupRestore;
                    $data['status'] = 'ERROR';
                }
            } else {                
                $data['status'] = 'ERROR';
            } 
           
        } else {
           $this->response = 'DB Could Not Deleted.'; 
           $data['status'] = 'ERROR';
        }
        
        $data['msg'] = $this->response;
        
        
        return $data;
    }
    
    
    public function logUserActivity(array $logData) {
        
        $merchant_id = $logData['merchant_id'];
        $activity = $logData['activity'];
        $ip = $this->appCommon->get_client_ip();
        $activityAt = date('Y-m-d H:i:s');
        
        if($logData['action']=='auto') {
            $user       = 'Auto System';        
            $user_id    = '0';            
            $user_name  = 'System Updates';
            $user_type  = 'Systems';
        } else {
            $user       = $_SESSION['login'];        
            $user_id    = $user['user_id'];            
            $user_name  = $user['display_name'];
            $user_type  = $user['group'];
        }
        
        $merchant = $this->get($merchant_id, $select = 'name, phone, pos_url');
       
        $merchant_name  = $merchant['name'];
        $merchant_phone = $merchant['phone'];
        $pos_url        = $merchant['pos_url'];
        
        $sql = "INSERT INTO ".TABLE_ADMIN_USER_LOG.""
                . " (`user_id`,`user_name`,`user_type`,`merchant_id`,`merchant_name`,`merchant_phone`,`pos_url`,`user_activity`,`activity_at`,`activity_ip`)"
                . " VALUES ('$user_id', '$user_name', '$user_type', '$merchant_id', '$merchant_name', '$merchant_phone', '$pos_url', '$activity', '$activityAt', '$ip' )";
        
        $result = $this->conn->query($sql); 
        
        return ($result) ? true : false;
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
            
            return $row = $result->fetch_assoc();
        
        endif; 
        
    }
    
    
    public function getMerchantLog($merchantId) {
        
        $query = "SELECT `user_id`,`user_name`,`user_type`,`user_activity`,`activity_at`,`activity_ip` "
                . " FROM ".TABLE_ADMIN_USER_LOG 
                . " WHERE `merchant_id` = '$merchantId' order by `activity_at` DESC ";
        
        $result = $this->conn->query($query);      
        
        if($result->num_rows):
            while($row = $result->fetch_assoc())
            {
                $logData[] = $row;
            }
            
            return $logData;
            
        endif; 
        
    }
    
    
    public function importPosSql($filename, $posconn){
        
        if($filename == '') return false;
        
        if(!file_exists($filename)) {
                echo '<div class="alert alert-danger">File '.$filename.' Not exists.</div>';    
            }
            //Temporary variable, used to store current query
            $templine = '';
            // Read in entire file
            $lines = file($filename);
            $import = 0;
            // Loop through each line
            foreach ($lines as $line)
            {
                // Skip it if it's a comment
                if(substr($line, 0, 2) == '--' || $line == '')
                    continue;

                // Add this line to the current segment
                $templine .= $line;
                // If it has a semicolon at the end, it's the end of the query
                if (substr(trim($line), -1, 1) == ';')
                {
                    // Perform the query
                    $r = $posconn->query($templine);
                    //mysql_query($templine);
                    //Reset temp variable to empty
                    $templine = '';
                    // echo $posconn->error;
                     $import++;
                }
            }//end foreach.
            
            return $import;
    }
    
    
    public function updatePosTypeVersion(array $projectDataPath , $posconn ) {
        
        $data = array(            
            'version'=>$projectDataPath['pos_version'],
            'sql'=>$projectDataPath['sql_version'],
            'type'=>$projectDataPath['merchant_type'],
            'type_id'=>$projectDataPath['id'],
        );
        
       $jsonData = json_encode($data);
       
       $pos_type = $projectDataPath['merchant_type_keyword'];
       
       $sql = "UPDATE `sma_settings` set `pos_version` = '$jsonData', `pos_type`= '$pos_type' where `setting_id` = '1'";
       
       $r = $posconn->query($sql);
       
       if($r) 
            return true;
       else
            return false;
    }
    
    private function __getPrivateKey($encrypt_pk) {
        
        return $this->appCommon->mc_decrypt($encrypt_pk);
    }
    
    private function __validatePrivateKey($request_pk, $encrypt_pk) {
        
        if(empty($encrypt_pk) || empty($request_pk)) {
            
            return FALSE;
        }
        
        return ($request_pk === $this->__getPrivateKey($encrypt_pk)) ? TRUE : FALSE;
    }
    
    public function __destruct() {        
        /* close connection */
        $this->conn->close();
        unset($this->merchants); 
        unset($this->merchantTypes); 
    }
    
}

?>