<?php
if (version_compare(PHP_VERSION, '5.3', '>='))
{
error_reporting(E_ALL & E_NOTICE & E_DEPRECATED & E_STRICT & E_USER_NOTICE & ~E_USER_DEPRECATED);
}
else
{
error_reporting(E_ALL & E_NOTICE & E_STRICT & ~E_USER_NOTICE);
}

date_default_timezone_set("Asia/Kolkata");

ini_set('display_errors', '1');
ini_set('max_execution_time', 600); //300 seconds = 5 minutes
ob_start();
session_start();

//error_reporting(1);
 
global $objapp;

include_once('include/config.php');

//require_once('PHPMailer/PHPMailerAutoload.php');

include_once "include/classes/baseClass.php";

$objapp = new baseClass($conn);



/*******************Cpanel Connection Details.******************/
$curl = curl_init();
$cp_access_path = $objapp->mc_decrypt(CP_ACCESS_PATH, MASTER_ENCRYPTION_KEY);
curl_setopt_array($curl, array(
  CURLOPT_URL => $cp_access_path,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "postman-token: 8381e74a-003c-e432-4965-4e676b9441ed"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

foreach(json_decode($response,TRUE) as $key=>$value){
    define($key, $value);
}
/*********************************************************/ 

 

spl_autoload_register(function ($class_name) {
    include_once "include/classes/".$class_name . '.php';
});
  
//Get Exists Root Directory & Subdomain Folder List.
global $ExistsDirectoryArr;


?>