<?php

class pos_versions {
    
    protected $conn;     
    
    public $appCommon;
    public $type;
    public $record_id;
    public $tableData;
    public $pos_projects_zip;
    public $pos_sample_database;
    public $pos_version_list;
    public $pos_latest_version;
    public $pos_latest_version_status;

    public function __construct() {
        
        global $objapp;
        
        $this->appCommon = $objapp;
        
        $this->conn = $this->appCommon->conn();
        
        $this->pos_latest_version = 0.1;
        $this->pos_latest_stable_version = 0.1;
         
        $this->record_id = '';
        
        $this->get();
    } 
    
    public function set_condition(array $array ) {
       $this->type = $array['type'];
       $this->record_id = $array['id'];
    } 
    
    public function view(){
        
        $this->get();
        
        return $this->pos_version_list;        
    }  

    public function get_record() 
    {
       return $this->get();
    }
    
    public function get()
    {               
        $type = $this->type; 
        
        if(is_numeric($this->record_id)){
            
           $where =  " WHERE  `id` IN ( $this->record_id ) " ;
           
        }
        
        $sql = "SELECT *  "
                . " FROM   " . TABLE_POS_VERSIONS
                . " $where "
                . " ORDER BY `version` DESC, `relese_date` DESC ";
    
        $result = $this->conn->query($sql);  
        
        if($result):
                
            $row_cnt = $result->num_rows;
            
            if($row_cnt > 1){
               
                while($row = $result->fetch_array(MYSQLI_ASSOC))
                {
                    if($this->pos_latest_version < $row['version'])
                    {
                        $this->pos_latest_version = $row['version'];
                    }
                    
                    if($this->pos_latest_stable_version < $row['version'] && $row['relese_status'] == 'stable' )
                    {
                        $this->pos_latest_stable_version = $row['version'];
                    }
                    
                    if($row['is_active']==1 && $row['is_delete']==0) 
                    {
                        $this->pos_version_list[$row['id']] = $row;  
                    }
                                  
                }
                
                return  $this->pos_version_list;
               
            } else {
                return $row = $result->fetch_array(MYSQLI_ASSOC);
            } 
           
            
            
            $result->close();
            
        endif;
                 
    }
    
    public function filter_data(array $resuestData)
    {
        $whereClause = "";
        
        $itemsPerPage   = $resuestData['perpage'];
        $pageno         = $resuestData['page'];
        
        $this->tableData['itemsPerPage'] = $itemsPerPage; 
        $this->tableData['pageno']       = $pageno; 
        $this->tableData['sort']         = $resuestData['sort'];  
        
        $developerCondition = "";
        
        if($resuestData['result_type'] == 'filter') {
            
            if(is_array($resuestData['conditions'])){

                foreach($resuestData['conditions'] as $field=>$value) 
                {
                    if(in_array($field, ['perpage','page'])) continue;
                    $whereData[] = " `$field` = '$value' ";
                }
                
                $whereClause = join(' AND ', $whereData);
            }
        
            $sqlCount = "SELECT count(id) as num FROM " . TABLE_POS_VERSIONS . " WHERE " . $whereClause . " " . $developerCondition ;
            
            $query = "SELECT * FROM " . TABLE_POS_VERSIONS . " 
                     WHERE " . $whereClause . " " . $developerCondition . " ORDER BY `version`  DESC   
                     LIMIT " . ( $pageno - 1 ) * $itemsPerPage . ", " . $itemsPerPage;
            
        }
        
        if($resuestData['result_type'] == 'search') {
            
            $this->tableData['search_key'] = $resuestData['search_key']; 
            
            $search_key = $this->appCommon->prepareInput($resuestData['search_key']);
            
            $sqlCount = " SELECT count(id) as num FROM ".TABLE_POS_VERSIONS."  WHERE ( `version` LIKE '%$search_key%'  || `relese_status` LIKE '%$search_key%' || `relese_type` LIKE '%$search_key%'  )  
                                     ".$developerCondition;
            
            $query = " SELECT * FROM ".TABLE_POS_VERSIONS."  WHERE ( `version` LIKE '%$search_key%'  || `relese_status` LIKE '%$search_key%' || `relese_type` LIKE '%$search_key%' )
                                    ".$developerCondition . 
                                    " ORDER BY `version`  DESC  
                                    LIMIT ".( $pageno - 1 ) * $itemsPerPage .", " .$itemsPerPage;
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
        
    public function insert($postData) {
        
        extract($postData);
        $now = date('Y-m-d');
        
        $insert['version']          = $this->appCommon->prepareInput($version);
        $insert['relese_status']    = $this->appCommon->prepareInput($relese_status);
        $insert['relese_type']      = $this->appCommon->prepareInput($relese_type);
        
        $insert['relese_date']                   = $now;
        $insert['relese_date_'.$relese_status]   = $now;
        
        $insert['upgread_sql']  = $this->appCommon->prepareInput($upgread_sql);
        
        if($upgread_sql == 1)
        {            
            $insert['sql_file_path_up']     = $this->appCommon->prepareInput($sql_file_path_up);
            $insert['sql_file_path_down']   = $this->appCommon->prepareInput($sql_file_path_down);
        }
        
        $insert['project_code_path']      = $this->appCommon->prepareInput($project_code_path);
        $insert['update_log_file_path']   = $this->appCommon->prepareInput($update_log_file_path);
        
        $insert['is_active']   = 1;
        $insert['is_delete']   = 0;        
               
        if($this->projectVersionIsExists($insert['version'] , 0) == true)
        {
            $data['status'] ='ERROR';
            $data['msg'] = 'Project version alredy exist.';
            return $data;
        }
        
        if($this->projectVersionPathIsExists($insert['project_code_path'] , 0) == true)
        {
            $data['status'] ='ERROR';
            $data['msg'] = 'Project version files path already exist.';
            return $data;
        } 
        
        if(is_array($insert))
        {
            foreach ($insert as $key => $value) {
               $fieldsName[]    =  $key;
               $fieldsValues[]  =  $value;
            }
            
            $sqlFileds = join(", ", $fieldsName );
            $sqlFiledValues = join("', '", $fieldsValues );
            
            $sql = "INSERT INTO " . TABLE_POS_VERSIONS . " ( ".$sqlFileds." ) VALUES ( '".$sqlFiledValues."' )";
            
            $data['sql'] = $sql;
            
            $result = $this->conn->query($sql);

            if($result){
                $data['status'] = 'SUCCESS'; 
            } else {
                $data['status'] ='ERROR';
                $data['msg'] ='<b>Sql Error:</b> '. $this->conn->error;
            }
          
        } else {
            $data['status'] ='ERROR';
            $data['msg'] ='Request empty data error.';
        }
          
        return $data;
    }
    
    public function projectVersionIsExists($inpurValue , $id='') {
        
        $where = "";
        if(is_numeric($id))
        {
            $where = " AND `id` NOT IN ($id) ";
        }
        
         $sql = "SELECT `id` FROM " . TABLE_POS_VERSIONS . " WHERE `version` = '$inpurValue'  $where ";
        
        $result = $this->conn->query($sql);
        
        if($result){
           return  ( $result->num_rows ) ? true : false;
        }
    }
    
    public function projectVersionPathIsExists($inpurValue , $id='') {
        
        $where = "";
        if(is_numeric($id))
        {
            $where = " AND `id` NOT IN ($id) ";
        }
        
         $sql = "SELECT `id` FROM " . TABLE_POS_VERSIONS . " WHERE `project_code_path` = '$inpurValue'  $where ";
        
        $result = $this->conn->query($sql);
        
        if($result){
           return  ( $result->num_rows ) ? true : false;
        }
    }
    
    public function update($postData) {
        
        extract($postData);
        $now = date('Y-m-d');
        
        $insert['version']          = $this->appCommon->prepareInput($version);
        $insert['relese_status']    = $this->appCommon->prepareInput($relese_status);
        $insert['relese_type']      = $this->appCommon->prepareInput($relese_type);
        
        //$insert['relese_date']                   = $now;
        $insert['relese_date_'.$relese_status]   = $now;
        
        $insert['upgread_sql']  = $this->appCommon->prepareInput($upgread_sql);
        
        if($upgread_sql == 1)
        {            
            $insert['sql_file_path_up']     = $this->appCommon->prepareInput($sql_file_path_up);
            $insert['sql_file_path_down']   = $this->appCommon->prepareInput($sql_file_path_down);
        }
        
        $insert['project_code_path']   = $this->appCommon->prepareInput($project_code_path);
         $insert['update_log_file_path']   = $this->appCommon->prepareInput($update_log_file_path);
               
        if($this->projectVersionIsExists($insert['version'] , $id) == true)
        {
            $data['status'] ='ERROR';
            $data['msg'] = 'Project version alredy exist.';
            return $data;
        }
        
        if($this->projectVersionPathIsExists($insert['project_code_path'] , $id) == true)
        {
            $data['status'] ='ERROR';
            $data['msg'] = 'Project version files path already exist.';
            return $data;
        }
          
       
        if(is_array($insert))
        {
            
            foreach ($insert as $key => $value) {
               $sqlUpdate[] = "`$key` = '$value' "; 
            }
            
            $sql = "UPDATE " . TABLE_POS_VERSIONS . " SET "
                    . join(", ", $sqlUpdate )  
                    . "  WHERE `id` = '$id' ";          
            
            
            $data['sql'] = $sql;
            
            $result = $this->conn->query($sql);

            if($result){
                $data['status'] = 'SUCCESS'; 
            } else {
                $data['status'] ='ERROR';
                $data['msg'] ='<b>Sql Error:</b> '. $this->conn->error;
            }
          
        } else {
            $data['status'] ='ERROR';
            $data['msg'] ='Request empty data error.';
        }
          
        return $data;
    }
    
    public function get_pos_project_list() {
        
     $sql = "SELECT `id` , `title`, `project_file` as file_name, `version`  "
                . " FROM " . TABLE_POS_PROJECT
                . " WHERE `is_active` = '1' && `is_delete` = '0' "
                . " GROUP BY `title` "
                . " ORDER BY `title` , `updated_on` DESC ";
    
        $result = $this->conn->query($sql);  
        
        if($result):
                
            $row_cnt = $result->num_rows;
            
            if($row_cnt > 0){
        
                while($row = $result->fetch_array(MYSQLI_ASSOC))
                {
                    $this->pos_projects[$row['id']] = $row;                    
                } 
                
                return $this->pos_projects;
            } else {
                return false;
            }
            
            $result->close();
            
        endif;
                 
    }
    
    public function get_pos_sample_database_list() {
        
     $sql = "SELECT `id` , `title`, `database_file` as file_name, `version`  "
                    . " FROM   " . TABLE_POS_SAMPLE_DATA
                    . " WHERE `is_active` = '1' && `is_delete` = '0' "
                    . " GROUP BY `title` "
                    . " ORDER BY `title` , `updated_on` DESC";
    
        $result = $this->conn->query($sql);  
        
        if($result):
                
            $row_cnt = $result->num_rows;
            
            if($row_cnt > 0){
        
                while($row = $result->fetch_array(MYSQLI_ASSOC))
                {
                    $this->pos_sample_database[$row['id']] = $row;                    
                }
                 return $this->pos_sample_database;
            }
            
            $result->close();
            
        endif;
                 
    } 
    
    public function __destruct() {
        
        /* close connection */
        $this->conn->close();
          
        unset($this->pos_sample_database); 
        unset($this->pos_projects); 
        unset($this->appCommon); 
        unset($this->tableData); 
        unset($this->pos_version_list); 
        unset($this->pos_latest_stable_version); 
        unset($this->pos_latest_version); 
        unset($this->record_id); 
        unset($this->type); 
    }
    
}

?>