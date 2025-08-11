<?php

include_once('application_main.php');


$query = "SELECT `id`, `password`, `db_password` FROM `merchants`";

$result = $conn->query($query);

    if($result->num_rows > 1){
        $update = 0;
        while($row = $result->fetch_assoc()) 
        {
            $password_encript    = (empty($row['password'])) ? '' : $objapp->mc_encrypt($row['password'], MASTER_ENCRYPTION_KEY);
            $db_password_encript = (empty($row['db_password'])) ? '' : $objapp->mc_encrypt($row['db_password'], MASTER_ENCRYPTION_KEY);
            
            $sqlUpdate = "UPDATE  `merchants` set `password_encript` = '$password_encript' , `db_password_encript` = '$db_password_encript' WHERE `id` = '".$row['id']."' ";
            
           if( $conn->query($sqlUpdate)) {
               $update++;
           }
        }
        
        echo "<h1>".$update." records updated.</h1>";
    }

    
    
?>  
 
