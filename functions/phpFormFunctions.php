<?php

function prepareInput($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


function flushVariabls(){
    
    $vars = array_keys(get_defined_vars());
    for ($i = 0; $i < sizeOf($vars); $i++) {
        unset($$vars[$i]);
    }
    unset($vars, $i);
}

function baseURL($extend = '')
{
    $baseUrl = "http://" . $_SERVER['SERVER_NAME'];
    
    if($extend == '') :
        return  $baseUrl;
    else : 
       return  $baseUrl .'/'. $extend;
    endif;
}

function getMerchantType(){

        global $conn;
               
                
        $sql = "SELECT `id`, `merchant_type`  "
                    . "FROM  ".TABLE_MERCHANT_TYPE." "
                    . "WHERE `is_active` = '1' "
                    . "ORDER BY `merchant_type` ASC";
    
        $result = $conn->query($sql);  
        
        if($result):
                
            $row_cnt = $result->num_rows;

            while($row = $result->fetch_array(MYSQLI_ASSOC))
            {
                $merchants[$row['id']] = $row['merchant_type'];                    
            }
                
           return  $merchants;
        endif;
                 
}


function get_country_data(){
    global $conn;
     $sql =" SELECT `id`, `country_name` as name ,  `country_code` as code
            FROM  `country` 
            WHERE  `is_active` =  '1'
            ORDER BY  `country_name` ";
   
   $result = $conn->query($sql);  
        
        if($result):
                
            $row_cnt = $result->num_rows;

            while($row = $result->fetch_array(MYSQLI_ASSOC))
            {
                $country[$row['id']] = $row;                    
            }
                
           return  $country;
        endif;
   
}

?> 