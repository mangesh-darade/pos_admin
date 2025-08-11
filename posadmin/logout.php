<?php
 session_start();
 
if(isset($_SESSION['session_user_id'])){
        
    unset($_SESSION['session_user_id']);
    unset($_SESSION['session_user_group']);
    unset($_SESSION['login']);
    
} 

header("location:login.php");


?>