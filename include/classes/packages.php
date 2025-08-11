<?php

class packages {
    
    protected $conn;
    public $appCommon;       
    public $packages;       
    public $adonsPackage;       
    private $postData;
    public $inputError;
    private $edit_package_id;
    

    public function __construct() {
        
        global $objapp;
        $this->appCommon = $objapp;
        
        $this->conn = $this->appCommon->conn();
         
        $this->packages = '';
        $this->adonsPackage = '';
        
        $this->getPackages();
        $this->getAdons();
     
         
    }
    
    public function getPackages($id=''){
        
        if(is_numeric($id)) {
            $whereClause = " AND `id` = '$id' ";
        }
        elseif(is_array($id)) {            
            $ids = join(',' , $id);
            $whereClause = " AND `id` IN ($ids) ";
        } else {
            $whereClause = '';
        }
        
        $sql = "SELECT `id` , `package_name` , `monthly_price` , `annual_price` , `outlet` , `register` , `users` , `products` , `customers` , 
                `features` , `details` , `is_popular` , `is_active`
                FROM ".TABLE_PACKAGES." 
                WHERE `is_delete` = '0' $whereClause 
                ORDER BY `id` ASC ";
        
        $result = $this->conn->query($sql);
        
        if($result->num_rows):
            
            if($result->num_rows > 1) {
              while($row = $result->fetch_assoc()) {
            
                    $row['status']     = ($row['is_active']) ? 'Active' : 'Deactive';

                    $this->packages[$row['id']] = $row;

                }//end while.  
            } else {
                $this->packages = $result->fetch_assoc(); 
            }        
        endif;
        
        /* close result set */
        $result->close();
         
    }
    
    
    
    public function adonsPackage($id){
        
        if(is_numeric($id))
        {
             $list[] = $this->adonsPackage[$id];
             return $list;
        } else {
            if(is_string($id))
            {
                $ids = explode(',', $id);
                
                if(is_array($ids)){
                    foreach ($ids as $aid) {
                      $list[] = $this->adonsPackage[$aid];
                    }
                    return $list;
                }
            }
            else
            {
                return '';
            }
        }        
    }
    
    public function getSmsPackageList() {
        
        $sql = "SELECT `id` , `title` , `price` , `quantity`
                FROM ".TABLE_SMS_PACKAGE."
                WHERE `is_active` = '1'
                AND `is_delete` = '0'
                ORDER BY `quantity` ASC ";
    
        $result = $this->conn->query($sql);  
        $smsPackage = '';
        if($result):
                
            $row_cnt = $result->num_rows;
            if($row_cnt) {
                while($row = $result->fetch_array(MYSQLI_ASSOC))
                {
                    $smsPackage[$row['id']] = $row;                    
                }
                
            }
           
        endif;
          
        /* close result set */
        $result->close();
        
        return $smsPackage;
        
    }
    
    public function getAdons(){               
         
        $sql = "SELECT `id` , `title` , `monthly_price` , `annual_price` , `details` , `is_active`
                FROM ".TABLE_PACKAGE_ADDONS." 
                WHERE `is_delete` = '0'";
    
        $result = $this->conn->query($sql);  
        
        if($result):
                
            $row_cnt = $result->num_rows;
            if($row_cnt) {
                while($row = $result->fetch_array(MYSQLI_ASSOC))
                {
                    $this->adonsPackage[$row['id']] = $row;                    
                }
            }
           
        endif;
          
        /* close result set */
        $result->close();
    }
    
    public function updatePackage(array $postData) {
        
        if($this->validatePackageData($postData))
        {
            foreach ($this->postData as $key => $value) {
                
                $queryBuilt[] = " `$key` = '$value' ";
            }
            
            $sqlUpdate = join(', ', $queryBuilt);
            
           $sqlQuery = "UPDATE `packages` SET $sqlUpdate WHERE `id` = '".$this->edit_package_id."'";
            
            $result = $this->conn->query($sqlQuery);
            
            if($result) {
                return true;
            } else {
               $this->inputError = 'MySql Error: '. $result->error;
               return false;
            }
            
        } else {
            
            return false;
        }
        
    }
    
    
    public function updateAdonsPackage(array $postData) {
        
        if($this->validateAdonsPackageData($postData))
        {
            foreach ($this->postData as $key => $value) {
                
                $queryBuilt[] = " `$key` = '$value' ";
            }
            
            $sqlUpdate = join(', ', $queryBuilt);
            
           $sqlQuery = "UPDATE `package_addons` SET $sqlUpdate WHERE `id` = '".$this->edit_package_id."'";
            
            $result = $this->conn->query($sqlQuery);
            
            if($result) {
                return true;
            } else {
               $this->inputError = 'MySql Error: '. $result->error;
               return false;
            }
            
        } else {
            
            return false;
        }
        
    }
    
    private function validateAdonsPackageData(array $postData) {
        
        if(trim($postData['title']) == ''){
            $this->inputError['title'] = "Addon Name is required.";
        } 
        
        if(trim($postData['details']) == ''){
            $this->inputError['details'] = "Package details is required.";
        } 
        
        if(trim($postData['monthly_price']) == '' || !is_numeric($postData['monthly_price'])){
            $this->inputError['monthly_price'] = "Package monthly price is required & should be only number.";
        } 
        
        if(trim($postData['annual_price']) == '' || !is_numeric($postData['annual_price'])){
            $this->inputError['annual_price'] = "Package annual price is required & should be only number.";
        } 
        
        if(count($this->inputError)) {
            return false;
        }
        else
        {  
            $this->edit_package_id = $postData['package_id'];
            unset($postData['formAction']);
            unset($postData['package_id']);
            
            foreach ($postData as $key => $value) {
                $this->postData[$key] = $this->appCommon->prepareInput($value);
            } 
            return true;
        }
        
        
    }
    
    
    
    
     private function validatePackageData(array $postData) {
        
        if(trim($postData['package_name']) == ''){
            $this->inputError['package_name'] = "Package name is required.";
        } 
        
        if(trim($postData['details']) == ''){
            $this->inputError['details'] = "Package details is required.";
        } 
        
        if(trim($postData['monthly_price']) == '' || !is_numeric($postData['monthly_price'])){
            $this->inputError['monthly_price'] = "Package monthly price is required & should be only number.";
        } 
        
        if(trim($postData['annual_price']) == '' || !is_numeric($postData['annual_price'])){
            $this->inputError['annual_price'] = "Package annual price is required & should be only number.";
        } 
        
        if(trim($postData['outlet']) == '' || !is_numeric($postData['outlet'])){
            $this->inputError['outlet'] = "outlet is required & should be only number.";
        } 
        
        if(trim($postData['register']) == '' || !is_numeric($postData['register'])){
            $this->inputError['register'] = "register is required & should be only number.";
        } 
        
        if(trim($postData['users']) == '' || !is_numeric($postData['users'])){
            $this->inputError['users'] = "users is required & should be only number.";
        } 
        
        if(trim($postData['products']) == '' || !is_numeric($postData['products'])){
            $this->inputError['products'] = "products is required & should be only number.";
        } 
       
        if(trim($postData['customers']) == '' || !is_numeric($postData['customers'])){
            $this->inputError['customers'] = "customers is required & should be only number.";
        } 
        
        if(count($this->inputError)) {
            return false;
        }
        else
        {  
            $this->edit_package_id = $postData['package_id'];
            unset($postData['formAction']);
            unset($postData['package_id']);
            
            foreach ($postData as $key => $value) {
                $this->postData[$key] = $this->appCommon->prepareInput($value);
            } 
            return true;
        }
        
        
    }
    
    
    
    
    
    
    
    public function __destruct() {
        
        /* close connection */
        $this->conn->close();
         
    }
    
}

?>