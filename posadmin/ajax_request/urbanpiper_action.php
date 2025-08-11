<?php

include_once('../../application_main.php');
include_once('session.php');
include_once('xmlapi.php');
require_once('../../functions/phpFormFunctions.php');
$objMerchant = new merchant($conn);
$response = array();
$username = $_POST['username'];
$password = $_POST['password'];
if (empty($username)) {
    $response['status'] = 'error';
    $response['messages'] = "Username is required.";
}
if (empty($password)) {
    $response['status'] = 'error';
    $response['messages'] = "Password is required.";
}
//production / development
$upQuintEnvirnment = 'production';

if($upQuintEnvirnment == 'production') {
    $urbanpiperQuintApiUrl = 'https://api.urbanpiper.com/';
} else {
    $urbanpiperQuintApiUrl = 'https://staging.urbanpiper.com/';
}

$userid = $_SESSION['login']['user_id'];

if ((!empty($username) && !empty($password)) && !empty($userid)) {
    $encr_password = md5($password);
    // global $conn;
    $sql = "Select user_id from admin where user_id = '" . $userid . "' and username = '" . $username . "' and password = '" . $encr_password . "' and is_delete ='0' ";

    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        switch ($_POST['action']) {
            case 'add_store': // Add Store Urbanpiper Portal
                $id = $_POST['merchant_id'];
                $getdata = marchantNo($id);
                if (!empty($getdata['city'])) {
                    if ($getdata['add_urbanpiper'] == '1') {
                        $response['status'] = 'error';
                        $response['messages'] = 'Store Allready Add Urbanpiper';
                    } else {
                        $store_details = array(
                            'stores' => array(
                                array(
                                    'city' => ($getdata['city']) ? $getdata['city'] : '',
                                    'name' => ($getdata['business_name']) ? $getdata['business_name'] : '',
                                    'contact_phone' => ($getdata['phone']) ? $getdata['phone'] : '',
                                    'ref_id' => $getdata['phone'],
                                    'address' => $getdata['address'],
                                    'notification_emails' => array(($getdata['email']) ? $getdata['email'] : ''),
                                    'zip_codes' => array(($getdata['pincode']) ? $getdata['pincode'] : ''),
                                    'active' => ($getdata['urbanpiper_action']) ? false : true,
                                ),
                            ),
                        );

                        $URL = $urbanpiperQuintApiUrl.'external/api/v1/stores/';
                        $getresponse = call_urbanpiper($URL, $store_details);
                        $phpObject = json_decode($getresponse);
                        if ($phpObject->status == 'success') {
                            $update_ref = array('add_urbanpiper' => '1');
                            $update_response = "UPDATE merchants SET add_urbanpiper = 1 where id = $id ";
                            mysqli_query($conn, $update_response);
                            $response['status'] = 'success';
                            $response['messages'] = $phpObject->message;
                        } else if ($phpObject->status == 'error') {
                            $response['status'] = 'error';
                            $response['messages'] = $phpObject->message;
                        } else {
                            $response['status'] = 'error';
                            $response['messages'] = 'Sorry Store Not Add, Please Try Agian';
                        }
                    }
                } else {
                    $response['status'] = 'error';
                    $response['messages'] = 'Store city not added, Please add store city name.';
                }
                // echo json_encode($response);
                break;

            case 'status_change':  // Status Change Urbanpiper Portal
                $id = $_POST['merchant_id'];

                $getdata = marchantNo($id);
                $ordering_action = array(// Urbanpiper Send data
                    "stats" => array(
                        "updated" => 1,
                        "errors" => 0,
                        "created" => 1
                    ),
                    "stores" => array(
                        array(
                            "ref_id" => $getdata['phone'],
                            "city" => ($getdata['city']) ? $getdata['city'] : '',
                            "name" => ($getdata['business_name']) ? $getdata['business_name'] : '',
                            "active" => ($getdata['urbanpiper_action']) ? false : true,
                            "upipr_status" => array(
                                "action" => "U",
                                "id" => 3923,
                                "error" => false
                            ),
                        ),
                    ),
                );
                $status = ($getdata['urbanpiper_action']) ? NULL : 1;
//                         
                $URL = $urbanpiperQuintApiUrl.'external/api/v1/stores/';
                $getresponse = call_urbanpiper($URL, $ordering_action);
                $phpObject = json_decode($getresponse);
                if ($phpObject->status == 'success') {
                    $update_ref = array('add_urbanpiper' => '1');
                    $update_response = "UPDATE merchants SET urbanpiper_action = '" . $status . "' where id = $id ";
                    mysqli_query($conn, $update_response);
                    $response['status'] = 'success';
                    $response['messages'] = $phpObject->message;
                } else if ($phpObject->status == 'error') {
                    $response['status'] = 'error';
                    $response['messages'] = $phpObject->message;
                } else {
                    $response['status'] = 'error';
                    $response['messages'] = 'Sorry Store Status Not Change, Please Try Agian';
                }

                //  echo json_encode($response);
                //print_r($ordering_action);
                break;

            case 'add_api_key':

                $id = $_POST['merchant_id'];
                $getdata = marchantNo($id);
                $api_key = rtrim($_POST['api_key'], " ");
                $datasend = array('api_key' => $api_key);
                $URL = $getdata['pos_url'] . 'urban_piper/api_key_add';
                $res = pass_data($URL, $datasend);
                $someArray = json_decode($res, true);
                if ($someArray['status'] == "SUCCESS") {
                    $update_response = "UPDATE merchants SET urbanpiper_api_key = '" . $api_key . "' where id = $id ";
                    $sqlquery = mysqli_query($conn, $update_response);
                    $response['status'] = 'success';
                    $response['messages'] = '<span class="text-success" > API add successfully.</span>';
                } else {
                    $response['status'] = 'error';
                    $response['messages'] = '<span class="text-danger" >Changes not found.</span>';
                }



                /* $id = $_POST['merchant_id'];
                  $getdata = marchantNo($id);
                  $api_key = $_POST['api_key'];
                  $update_response ="UPDATE merchants SET urbanpiper_api_key = '".$api_key."' where id = $id ";

                  $sqlquery=  mysqli_query($conn, $update_response);
                  if(mysqli_affected_rows($conn)){

                  $datasend = array('api_key'=>$api_key);
                  $URL = $getdata['pos_url'].'urban_piper/api_key_add';
                  $res =  pass_data($URL,$datasend);

                  $response['status']= 'success';
                  $response['messages'] = 'API Key Add Successfully';

                  }else{
                  $response['status']= 'error';
                  $response['messages'] = "Sorry Please Try Again!";
                  } */

                break;

            case 'Webhooks':
                $id = $_POST['merchant_id'];
                $getdata = marchantNo($id);
            
                $URL = $urbanpiperQuintApiUrl.'external/api/v1/webhooks/';
                $up_api_key = $getdata['urbanpiper_api_key'];
                $pos_url = $getdata['pos_url'];
                // Order Place Webhook
                $up_webhooks['order_placed'] = array(
                    'active' => true,
                    'event_type' => 'order_placed',
                    'retrial_interval_units' => 'seconds',
                    'url' => $pos_url . 'urban_piper/add_order',
                    'headers' => array('content-type' => 'application/json')
                );

                $up_webhooks['order_status_update'] = array(
                    'active' => true,
                    'event_type' => 'order_status_update',
                    'retrial_interval_units' => 'seconds',
                    'url' => $pos_url . 'urban_piper/orderstatus',
                    'headers' => array('content-type' => 'application/json')
                );

                $up_webhooks['rider_status_update'] = array(
                    'active' => true,
                    'event_type' => 'rider_status_update',
                    'retrial_interval_units' => 'seconds',
                    'url' => $pos_url . 'urban_piper/orderrider',
                    'headers' => array('content-type' => 'application/json')
                );

                $up_webhooks['inventory_update'] = array(
                    'active' => true,
                    'event_type' => 'inventory_update',
                    'retrial_interval_units' => 'minutes',
                    'url' => $pos_url . 'urban_piper/inventorycallback',
                    'headers' => array('content-type' => 'application/json')
                );

                $up_webhooks['store_creation'] = array(
                    'active' => true,
                    'event_type' => 'store_creation',
                    'retrial_interval_units' => 'minutes',
                    'url' => $pos_url . 'urban_piper/storescallback',
                    'headers' => array('content-type' => 'application/json')
                );

                $up_webhooks['store_action'] = array(
                    'active' => true,
                    'event_type' => 'store_action',
                    'retrial_interval_units' => 'minutes',
                    'url' => $pos_url . 'urban_piper/storeactioncallback',
                    'headers' => array('content-type' => 'application/json')
                );

                $wh = 0;
                foreach ($up_webhooks as $key => $webhookJson) {
                    $getplace = call_urbanpiper($URL, $webhookJson, $up_api_key);
                    $phpObject = json_decode($getplace);

                    if ($phpObject->status == 'success') {
                        $response[$key]['status'] = 'success';
                        $wh++;
                    } else {
                        $response[$key]['status'] = $phpObject->status;
                        $response[$key]['messages'] = $phpObject->message;
                    }
                }//end foreach

                if ($wh) {
                    $update_response = "UPDATE merchants SET up_webhook_status = '$wh' where id = $id ";
                    $sqlquery = mysqli_query($conn, $update_response);
                    if ($sqlquery) {
                        $response['status'] = 'success';
                        $response['messages'] = "$wh webhooks updated.";
                    } else {
                        $response['status'] = 'error';
                        $response['messages'] = "Sql Error: " . mysql_error();
                    }
                } else {
                    $response['status'] = 'error';
                    $response['messages'] = "webhooks errors.";
                }

                break;

            /*
              case 'Webhooks':
              $id = $_POST['merchant_id'];
              $getdata = marchantNo($id);
             // $URL = 'https://staging.urbanpiper.com/external/api/v1/webhooks/';
              $URL = $urbanpiperQuintApiUrl.'external/api/v1/webhooks/';
              $up_api_key = $getdata['urbanpiper_api_key'];
              $pos_url = $getdata['pos_url'];
              // Order Place Webhook
              $order_place = array(
              'active'=>true,
              'event_type'=>'order_placed',
              'retrial_interval_units'=>'seconds',
              'url'=>$pos_url.'urban_piper/add_order',
              'headers'=>array('content-type'=>'application/json')
              );

              $getplace =  call_urbanpiper($URL,$order_place,$up_api_key); // order place Webhook
              $phpObject = json_decode($getplace);
              if($phpObject->status=='success'){
              // order Status Webhook
              $order_status = array(
              'active'=>true,
              'event_type'=>'order_status_update',
              'retrial_interval_units'=>'seconds',
              'url'=>$pos_url.'urban_piper/orderstatus',
              'headers'=>array('content-type'=>'application/json')
              );
              $getorderstatus =  call_urbanpiper($URL,$order_status,$up_api_key);
              $res_orderstatus = json_decode($getorderstatus);
              if($res_orderstatus->status=='success'){

              // Start Rider webhook
              $rider_status = array(
              'active'=>true,
              'event_type'=>'rider_status_update',
              'retrial_interval_units'=>'seconds',
              'url'=>$pos_url.'urban_piper/orderrider',
              'headers'=>array('content-type'=>'application/json')
              );
              $getorderrider =  call_urbanpiper($URL,$rider_status,$up_api_key);
              $res_riderstatus = json_decode($getorderrider);
              if($res_riderstatus->status=='success'){

              // Update Database
              $update_response ="UPDATE merchants SET up_webhook_status = 1 where id = $id ";
              $sqlquery=  mysqli_query($conn, $update_response);
              if(mysqli_affected_rows($conn)){
              $response['status']= 'success';
              $response['messages'] = $res_riderstatus->message;
              }
              // End Update Database

              }else if($res_orderstatus->status=='error'){
              $response['status']= 'error';
              $response['messages'] = $res_riderstatus->message;
              }else{
              $response['status']= 'error';
              $response['messages'] = 'Sorry Store Status Not Change, Please Try Agian';
              }
              // End Rider Webhook


              }else if($res_orderstatus->status=='error'){
              $response['status']= 'error';
              $response['messages'] = $res_orderstatus->message;
              }else{
              $response['status']= 'error';
              $response['messages'] = 'Sorry Store Status Not Change, Please Try Agian';
              }
              // End order Status Webhook


              }else if($phpObject->status=='error'){
              $response['status']= 'error';
              $response['messages'] = $phpObject->message;
              }else{
              $response['status']= 'error';
              $response['messages'] = 'Sorry Store Status Not Change, Please Try Agian';
              }
              // End order place Webhook

              break;
             */
            case 'update_package':
                $update_value = trim($_POST['api_key']);
                $id = $_POST['merchant_id'];
                $getdata = marchantNo($id);
                $datasend = array('ordercounts' => $update_value);
                $URL = $getdata['pos_url'] . 'urban_piper/update_UP_Package';
                $res = pass_data($URL, $datasend);
                $someArray = json_decode($res, true);
                if ($someArray['status'] == "success") {
                    if ($objMerchant->updateMerchantUPPackageCounts(['id' => $id, 'orders' => $update_value, 'action' => 'add'])) {
                        $logres = $objMerchant->logUserActivity(['merchant_id' => $id, 'activity' => 'UrbanPiper order package updated with ' . $update_value . ' orders.']);
                        $response['status'] = 'success';
                        $response['messages'] = 'Order package update successfully.';
                    } else {
                        $response['status'] = 'error';
                        $response['messages'] = "Merchant data package not updated";
                    }
                } else {
                    $response['status'] = 'error';
                    $response['messages'] = "package not update, please try again.";
                }

                break;

            default :
                $response['status'] = 'error';
                $response['messages'] = "Sorry....!";
                break;
        }
    } else {
        $response['status'] = 'error';
        $response['messages'] = "Invalid Username & Password.";
    }
}

echo json_encode($response);

//echo json_encode($response);


/*  switch ($_GET['action']){

  case 'add_store': // Add Store Urbanpiper Portal
  $id = $_GET['id'];
  $getdata = marchantNo($id);

  if($getdata['add_urbanpiper']=='1'){
  $response['status']= 'error';
  $response['messages'] = 'Store Allready Add Urbanpiper';
  }else{
  $store_details = array (
  'stores' => array (
  array (
  'city' => ($getdata['city'])?$getdata['city']:'',
  'name' => ($getdata['business_name'])?$getdata['business_name']:'',
  'contact_phone' =>($getdata['phone'])?$getdata['phone']:'',
  'ref_id' =>$getdata['phone'],
  'address' =>$getdata['address'],
  'notification_emails' =>array(($getdata['email'])?$getdata['email']:''),
  'zip_codes' =>array(($getdata['pincode'])?$getdata['pincode']:''),
  'active' =>($getdata['urbanpiper_action'])?false:true,
  ),
  ),
  );

 // $URL = 'https://staging.urbanpiper.com/external/api/v1/stores/';
  $URL = $urbanpiperQuintApiUrl.'external/api/v1/stores/';
  $getresponse =call_urbanpiper($URL,$store_details );
  $phpObject = json_decode($getresponse);
  if($phpObject->status=='success'){
  $update_ref  =array('add_urbanpiper'=>'1');
  $update_response ="UPDATE merchants SET add_urbanpiper = 1 where id = $id ";
  mysqli_query($conn, $update_response);
  $response['status']= 'success';
  $response['messages'] = $phpObject->message;
  }else if($phpObject->status=='error'){
  $response['status']= 'error';
  $response['messages'] = $phpObject->message;
  }else{
  $response['status']= 'error';
  $response['messages'] = 'Sorry Store Not Add, Please Try Agian';
  }
  }
  echo json_encode($response);
  break;

  case 'status_change':  // Status Change Urbanpiper Portal
  $id = $_GET['id'];

  $getdata = marchantNo($id);
  $ordering_action = array(  // Urbanpiper Send data
  "stats"=>array(
  "updated"=>1,
  "errors"=>0,
  "created"=>1
  ),
  "stores"=>array(
  array(
  "ref_id"=>$getdata['phone'],
  "city" => ($getdata['city'])?$getdata['city']:'',
  "name" => ($getdata['business_name'])?$getdata['business_name']:'',
  "active"=>($getdata['urbanpiper_action'])?false:true,
  "upipr_status"=>array(
  "action"=>"U",
  "id"=> 3923,
  "error"=> false
  ),
  ),
  ),
  );
  //$URL = 'https://staging.urbanpiper.com/external/api/v1/stores/';
  $URL = $urbanpiperQuintApiUrl.'external/api/v1/stores/';
  $getresponse =call_urbanpiper($URL,$ordering_action);
  $phpObject = json_decode($getresponse);
  if($phpObject->status=='success'){
  $update_ref  =array('add_urbanpiper'=>'1');
  $update_response ="UPDATE merchants SET urbanpiper_action = 1 where id = $id ";
  mysqli_query($conn, $update_response);
  $response['status']= 'success';
  $response['messages'] = $phpObject->message;
  }else if($phpObject->status=='error'){
  $response['status']= 'error';
  $response['messages'] = $phpObject->message;
  }else{
  $response['status']= 'error';
  $response['messages'] = 'Sorry Store Status Not Change, Please Try Agian';
  }

  echo json_encode($response);
  //print_r($ordering_action);
  break;

  case 'details':
  $id = $_GET['id'];
  $getdata = marchantNo($id);

  $table = '<b><table class="table"><tbody>';
  $table.='<tr>';
  $table.="<td>Name </td>";
  $table.="<td>:</td>";
  $table.="<td>".$getdata['name']."<td>";
  $table.="</tr>";
  $table.='<tr>';
  $table.="<td>Email </td>";
  $table.="<td>:</td>";
  $table.="<td>".$getdata['email']."<td>";
  $table.="</tr>";
  $table.='<tr>';
  $table.="<td>Phone No. </td>";
  $table.="<td>:</td>";
  $table.="<td>".$getdata['phone']."<td>";
  $table.="</tr>";
  $table.='<tr>';
  $table.="<td>Address </td>";
  $table.="<td>:</td>";
  $table.="<td>".$getdata['address']."<td>";
  $table.="</tr>";
  $table.='<tr>';
  $table.="<td>City </td>";
  $table.="<td>:</td>";
  $table.="<td>".$getdata['city']." - ".$getdata['pincode']."<td>";
  $table.="</tr>";
  $table.='<tr>';
  $table.="<td>Business Name </td>";
  $table.="<td>:</td>";
  $table.="<td>".$getdata['business_name']."<td>";
  $table.="</tr>";
  $table.='<tr>';
  $table.="<td>Pos Name  </td>";
  $table.="<td>:</td>";
  $table.="<td>".$getdata['pos_name']."<td>";
  $table.="</tr>";
  $table.='<tr>';
  $table.="<td>Pos URL </td>";
  $table.="<td>:</td>";
  $table.="<td>".$getdata['pos_url']."<td>";
  $table.="</tr>";
  $table.='</tbody></table></b>';
  echo $table;
  break;
  }
 */

//Merchant number
function marchantNo($merchant) {
    global $conn;
    $MsgArr = array();
    if (!empty($merchant)) {
        $sqlInsert = "SELECT * FROM `merchants` WHERE `id` ='$merchant'";
        if ($result = mysqli_query($conn, $sqlInsert)) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $MsgArr = $row;
            return $MsgArr;
        }
    } else {
        $MsgArr["res"] = "error";
        $MsgArr["msg"] = "All Mandatory Field Are Not Pass";
    }
    return $MsgArr;
}

// Call Urbanpiper URL POST
function call_urbanpiper($URL, $data, $up_api_key) {
    $data_json = json_encode($data);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $URL);
    /* curl_setopt($ch, CURLOPT_HTTPHEADER,$headers); */
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: '.$up_api_key));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

// End Call Urbanpiper URL POST 
// Pass Data POST URL
function pass_data($URL, $datasend) {

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $URL);
    //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $datasend);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

// End pass data pos URL
     