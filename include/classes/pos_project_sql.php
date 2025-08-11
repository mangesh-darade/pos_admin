<?php

class pos_project_sql {
    
    protected $conn;     
    
    public $appCommon;
    public $type;
    public $record_id;
    public $tableData;
    public $pos_projects_zip;
    public $pos_sample_database;
    public $pos_version_list;
    public $pos_latest_version;

    public function __construct() {
        
        global $objapp;
        
        $this->appCommon = $objapp;
        
        $this->conn = $this->appCommon->conn();

        $this->pos_projects_zip    = '';
        $this->pos_sample_database = '';
         
        $this->record_id = '';
    } 
    
    public function set_condition(array $array ) {
       $this->type = $array['type'];
       $this->record_id = $array['id'];
    } 
    
    public function view(){
        
        $this->get();
        
        return $this->merchantTypeList;        
    }  

    public function get_record() 
    {
       return $this->get();
    }
    
    public function get()
    {               
        $type = $this->type; 
        
        if(is_numeric($this->record_id)){
            
           $where =  ($where == '') ? " WHERE  `id` IN ( $this->record_id ) " : " AND  `id` IN ( $this->record_id ) ";           
        }
        
        $sql = "SELECT *  "
                . " FROM   " . TABLE_POS_SAMPLE_DATA
                . " $where "
                . " ORDER BY `updated_on` DESC ";
    
        $result = $this->conn->query($sql);  
        
        if($result):
                
            $row_cnt = $result->num_rows;
            
            if($row_cnt > 1){
        
                    while($row = $result->fetch_array(MYSQLI_ASSOC))
                    {
                        if($row['is_active']==1 && $row['is_delete']==0) {
                            $merchants[$row['id']] = $row['merchant_type'];  
                        }

                        $this->merchantTypeList[$row['id']] = $row;                    
                    }

                   /* close result set */
                   $merchants = array_unique($merchants);
                   
                   return  $merchants;
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
        
            $sqlCount = "SELECT count(id) as num FROM " . TABLE_POS_SAMPLE_DATA . " WHERE " . $whereClause . " " . $developerCondition ;
            
            $query = "SELECT * FROM " . TABLE_POS_SAMPLE_DATA . " 
                     WHERE " . $whereClause . " " . $developerCondition . " ORDER BY `updated_on`  DESC   
                     LIMIT " . ( $pageno - 1 ) * $itemsPerPage . ", " . $itemsPerPage;
            
        }
        
        if($resuestData['result_type'] == 'search') {
            
            $this->tableData['search_key'] = $resuestData['search_key']; 
            
            $search_key = $this->appCommon->prepareInput($resuestData['search_key']);
            
            $sqlCount = " SELECT count(id) as num FROM ".TABLE_POS_SAMPLE_DATA."  WHERE ( `title` LIKE  '%$search_key%' || `version` LIKE '%$search_key%'  || `database_file` LIKE '%$search_key%'  )  
                                     ".$developerCondition;
            
            $query = " SELECT * FROM ".TABLE_POS_SAMPLE_DATA."  WHERE ( `title` LIKE  '%$search_key%' || `version` LIKE '%$search_key%'  || `database_file` LIKE '%$search_key%'  )
                                    ".$developerCondition . 
                                    " ORDER BY `updated_on`  DESC  
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
        
        $title              = $this->appCommon->prepareInput($title);
        $sample_data_file   = $this->appCommon->prepareInput($sample_data_file);
        $database_file      = $this->appCommon->prepareInput($database_file);
        $images_zip_file    = $this->appCommon->prepareInput($images_zip_file);
        $version            = $this->appCommon->prepareInput($version);
        
        if($this->projectFileIsExists($sample_data_file , 0) == true)
        {
            $data['status'] ='ERROR';
            $data['msg'] = 'Project sample database files already exist.';
            return $data;
        }
        
        $now = date('Y-m-d H:i:s');
        
        $sql = "INSERT INTO " . TABLE_POS_SAMPLE_DATA . " ( `title`, `sample_data_file`, `database_file`, `images_zip_file`, `version`, `updated_on`, `is_active` )
                VALUES ('$title', '$sample_data_file', '$database_file', '$images_zip_file', '$version', '$now', '1')";
       
        $result = $this->conn->query($sql);

        if($result){
            $data['status'] = 'SUCCESS'; 
        } else {
            $data['status'] ='ERROR';
            $data['msg'] ='<b>Sql Error:</b> '. $objapp->conn->error;
        }
        
        return $data;
    }
    
    public function projectFileIsExists($inpurValue , $id='') {
        
        $where = "";
        if(is_numeric($id))
        {
            $where = " AND `id` NOT IN ($id) ";
        }
        
         $sql = "SELECT `id` FROM " . TABLE_POS_SAMPLE_DATA . " WHERE `sample_data_file` = '$inpurValue'  $where ";
        
        $result = $this->conn->query($sql);
        
        if($result){
           return  ( $result->num_rows ) ? true : false;
        }
    }
    
    public function update($postData) {
        
        extract($postData);
        
        $title          = $this->appCommon->prepareInput($title);
        $database_file   = $this->appCommon->prepareInput($database_file);
        $images_zip_file   = $this->appCommon->prepareInput($images_zip_file);
        $version        = $this->appCommon->prepareInput($version);
        
        if($this->projectFileIsExists($database_file , $id) == true)
        {
            $data['status'] ='ERROR';
            $data['msg'] = 'Project version files already exist.';
            return $data;
        }
        
        $now = date('Y-m-d H:i:s');
        
        $sql = "UPDATE " . TABLE_POS_SAMPLE_DATA . " SET "
                . " `title` = '$title', "
                . " `database_file` = '$database_file', "
                . " `images_zip_file` = '$images_zip_file', "
                . " `version` = '$version', "
                . " `updated_on` = '$now' "
                . "  WHERE `id` = '$id' ";
       $data['sql'] = $sql;
        $result = $this->conn->query($sql);

        if($result){
            $data['status'] = 'SUCCESS'; 
        } else {
            $data['status'] ='ERROR';
            $data['msg'] ='<b>Sql Error:</b> '. $objapp->conn->error;
        }
        
        return $data;
    }
    
    public function get_pos_project_list() {
        
     $sql = "SELECT `id` , `title`, `database_file` as file_name, `images_zip_file`, `version`  "
                . " FROM " . TABLE_POS_SAMPLE_DATA
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
        
     $sql = "SELECT `id` , `title`, `database_file` as file_name, `images_zip_file`, `version`  "
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
          
        unset($this->merchantTypes); 
    }
    
}

?>