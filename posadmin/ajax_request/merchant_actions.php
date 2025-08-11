<?php

include_once('../../application_main.php');

$objMerchant = new merchant($conn);

if (isset($_POST) || isset($_GET)) {
    $requestData = $_REQUEST;
}

switch ($requestData['action']) {
    case 'changeStatus':

        $merchant_id = $requestData['id'];
        $newStatus   = $requestData['newStatus'];

        if ($newStatus == 1) {
            $result = $objMerchant->merchant_activeted($merchant_id);
        } else {
            $result = $objMerchant->merchant_deactiveted($merchant_id);
        }

        if ($result == true) {
            $data['status'] = 'SUCCESS';
            $data['msg'] = 'Status changed successfully.';
        } else {
            $data['status'] = 'ERROR';
            $data['msg'] = $result;
        }

        echo json_encode($data);

        break;

    case 'merchantList':

        $posLatestVersions = $objMerchant->getPosLatestVersion();        
    
        //$requestData['conditions']['is_delete'] = 0;

        $result_type = $requestData['result_type'];
    
        if ($result_type == 'filter') {

            if ($requestData['filter'] != '') {
                
                $filterConditionArr = explode('~', $requestData['filter']);
                
                foreach ($filterConditionArr as $key => $filterCondition) {
                     $filterArr = explode('-', $filterCondition);
                     $requestData['conditions'][$filterArr[0]] = $filterArr[1];
                }
            }

            if ($requestData['sort'] != '') {

                if ($requestData['sort'] != 'all') {
                    $sortArr = explode('-', $requestData['sort']);
                    $requestData['conditions'][$sortArr[0]] = $sortArr[1];
                }
            }

            if ($requestData['type'] != '') {

                if ($requestData['type'] != 'all') {
                    $sortTypeArr = explode('-', $requestData['type']);
                    $requestData['conditions'][$sortTypeArr[0]] = $sortTypeArr[1];
                }
            }
        }

        if ($result_type == 'search') {

            $search_key = trim($requestData['search_key']);
            $requestData['search_key'] = $search_key;
        }


        $requestData['perpage'] = $requestData['perpage'];
        $requestData['page'] = $requestData['page'];

        $merchantsData = $objMerchant->filter_merchants($requestData);

        $posStatusCount = $objMerchant->getPosStatusCounts();

        if (count($merchantsData)) {

            $objDistributor = new distributors;
            
            $Distributors = $objDistributor->get_list();
            
            $adminUsers = $objMerchant->getAdminUserList();
            
            $sedSMSCount = $objMerchant->getusedSMSCount();
            
            $Distributors[0]['name'] = 'Simplysafe';

            include_once('merchants_list.php');
        }

        break;

    case 'suspend_pos':

        // $merchant_id = $requestData['id'];

        $suspended = $objMerchant->suspend_pos($requestData);

        if ($suspended) {
            echo '<div class="alert alert-success">POS suspended successfully.</div>';
        } else {
            echo '<div class="alert alert-danger">Request failed.</div>';
        }

        break;

    case 'unsuspend_pos':

        $merchant_id = $requestData['id'];

        $unsuspended = $objMerchant->unsuspend_pos($merchant_id);

        if ($unsuspended == true) {
            echo '<div class="alert alert-success">POS unsuspended successfully.</div>';
        } else {
            echo '<div class="alert alert-danger">Request failed.</div>';
        }

        break;

    case 'temparary_delete':

        $merchant_id = $requestData['id'];

        $deleted = $objMerchant->merchant_deleted($merchant_id);

        if ($deleted) {
            echo '<div class="alert alert-success">Merchant Deleted Successfully.</div>';
        } else {
            echo '<div class="alert alert-danger">Request failed.</div>';
        }

        break;

    case 'change_distributor':

        $merchant_id = $requestData['id'];

        $merchantInfo = $objMerchant->get($merchant_id, 'id, name, business_name, phone, pos_name, pos_url, distributor_id, pos_status');

        $objDistributor = new distributors;

        $distList = $objDistributor->get_list();

        include_once('change_distributor.php');

        break;

    case 'update_distributor':

        $merchant_id = $requestData['id'];
        $distributor_id = $requestData['distributor_id'];
        $old_distributor = $requestData['old_distributor'];

        if (!$merchant_id || $distributor_id == '') {
            echo '<div class="alert alert-danger">Invalid Merchant Or Distributor Data</div>';
        } else {

            $updated = $objMerchant->updateDistributor($merchant_id, $distributor_id);

            if ($updated) {

                if ($distributor_id > 0) {

                    $objDistributor = new distributors;

                    $rec = $objDistributor->get_record($distributor_id, $select = 'user_id as id, display_name');

                    $new_distributor = $rec['display_name'];
                } else {
                    $new_distributor = 'Simplysafe';
                }

                $activity = "Distributor has been changed from <q><b>$old_distributor</b></q> to <q><b>$new_distributor</b></q> ";

                $objMerchant->logUserActivity(['merchant_id' => $merchant_id, 'activity' => $activity]);

                echo '<div class="alert alert-success">Distributor has been Changed Successfully.</div>';
            } else {
                echo '<div class="alert alert-danger">Sorry! Error in update process.</div>';
            }
        }

        break;

    case 'undelete':

        $merchant_id = $requestData['id'];

        $deleted = $objMerchant->merchant_undeleted($merchant_id);

        if ($deleted) {
            echo '<div class="alert alert-success">Merchant Undeleted Successfully.</div>';
        } else {
            echo '<div class="alert alert-danger">Request Failed</div>';
        }

        break;

    case 'reset':

        $merchant_id = $requestData['id'];

        $deleted = $objMerchant->merchant_reset($merchant_id);

        if ($deleted) {
            
            $objMerchant->resetPosSetupLog($merchant_id);
            
            echo '<div class="alert alert-success">Merchant has been restored successfully.</div>';
        } else {
            echo '<div class="alert alert-danger">Request Failed</div>';
        }

        break;

    case 'permanent_delete':

        $merchant_id = $requestData['id'];

        $merchantsData = $objMerchant->get($merchant_id);

        $pos_generate = $merchantsData['pos_generate'];

        if ($pos_generate) {

            include_once('../xmlapi.php');

            $pos_directory = $merchantsData['project_directory_path'];

            $pos_db_name = $merchantsData['db_name'];
            $pos_db_username = $merchantsData['db_username'];
            $pos_url = str_replace(['https://', 'http://', 'www.', '/'], '', $merchantsData['pos_url']);

            $objMerchant->SetCPObject();

            $result_delssl = $objMerchant->cp_deleteSSL($pos_url);

            if ($result_delssl['delete']->data->result != 0) {
                echo '<div class="text-success">' . $result_delssl['delete']->data->result . '</div>';
            } else {
                echo '<div class="text-danger">' . $result_delssl['delete']->data->reason . '</div>';
            }

            $result_sd = $objMerchant->cp_delsubdomain($pos_url);

            if ($result_sd->data->result != 0) {
                echo '<div class="text-success">Subdomain Deleted</div>';
            } else {
                echo '<div class="text-danger">' . $result_sd->data->reason . '</div>';
            }

            $result_du = $objMerchant->cp_deluser($pos_db_username);

            // print_r($result_du); 
            if (empty($result_du->data->result)) {
                echo '<div class="text-success">User Deleted.</div>';
            } else {
                echo '<div class="text-danger">' . $result_du->data->result . '</div>';
            }

            $result_d = $objMerchant->cp_deldb($pos_db_name);

            if ($result_d->event->result != 0) {
                echo '<div class="text-success">Database Deleted</div>';
            } else {
                echo '<div class="text-danger">' . $result_d->error . '</div>';
            }
            //echo '<br/>'. POS_DIR_PATH . $pos_directory;
            if ($pos_directory != '') {
                if (file_exists(POS_DIR_PATH . $pos_directory) && is_dir(POS_DIR_PATH . $pos_directory)) {

                    if ($objMerchant->deletePOSProject(POS_DIR_PATH . $pos_directory)) {
                        echo '<div class="text-success">Project Deleted</div>';
                    } else {
                        echo '<div class="text-danger">Project could not delete</div>';
                    }
                } else {
                    echo '<div class="text-danger">' . POS_DIR_PATH . $pos_directory . ' Project Directory Not Exists. </div>';
                }
            } else {
                echo '<div class="text-danger">' . POS_DIR_PATH . $pos_directory . ' Project Directory Not Found. </div>';
            }

            $objMerchant->logUserActivity(['merchant_id' => $merchant_id, 'activity' => 'POS project code & database deleted']);
        }

        if ($objMerchant->merchant_delete($merchant_id)) {
            $objMerchant->logUserActivity(['merchant_id' => $merchant_id, 'activity' => 'Merchant pos details resetd']);
            echo '<div class="text-success">Merchant POS has been Removed</div>';
        } else {
            echo '<div class="text-danger">Merchant could not remove.</div>';
        }

        break;

    case 'authentication':

        $auth_uid = $auth_pcode = '';

        $merchant_id = $requestData['id'];
        $merchant_group = $requestData['merchant_group'] ? $requestData['merchant_group'] : 1;
        $project_group = $requestData['project_group'] ? $requestData['project_group'] : 1;

        $auth_type = $requestData['auth_type'];

        include_once('authentication.php');

        break;

    case 'checkAuthentication':

        $username = $requestData['username'];
        $password = $requestData['password'];
        $auth_session_id = $requestData['auth_session_id'];

        $data['status'] = '';

        if (empty($username)) {
            $data['msg'] = "Username is required.";
            $data['status'] = 'ERROR';
        } elseif (empty($password)) {
            $data['msg'] = "Password is required.";
            $data['status'] = 'ERROR';
        }

        if ($data['status'] == 'ERROR') {

            echo json_encode($data);
        } else {

            $encr_password = md5($password);

            $sql = "SELECT `user_id` "
                    . "FROM `admin` "
                    . " WHERE `username` = '" . $username . "' AND `password` = '$encr_password' AND `user_id` = '$auth_session_id' AND `is_delete` = '0' AND `is_active` = '1' LIMIT 1";

            $result = $conn->query($sql);

            if ($result) {

                $row_cnt = $result->num_rows;

                if ($row_cnt) {
                    $data['msg'] = "Authentication Success";
                    $data['status'] = 'SUCCESS';
                } else {
                    $data['msg'] = "Authentication Failed";
                    $data['status'] = 'ERROR';
                }
            } else {
                $data['msg'] = $result->error;
                $data['status'] = 'ERROR';
            }

            echo json_encode($data);
        }

        break;

    case 'updateConfig':

        $objConfigs = new configuration;
        $status = $objConfigs->update($requestData);

        if ($status === true) {
            echo 'SUCCESS';
        } else {
            echo $status;
        }

        break;

    case 'smsPackUpgrade':

        $data = (array) $objMerchant->setAdminMerchantTransaction($requestData);

        echo '<div class="alert alert-success">' . $data['msg'] . '</div>';


        break;

    case 'activatePackage':

        if ($requestData['current_package'] < 2) {
            $data = (array) $objMerchant->adminActivatePackage($requestData);
        }

        if ($requestData['current_package'] > 1) {
            $data = (array) $objMerchant->adminActivatePackage($requestData);
        }

        echo json_encode($data);

        break;

    case 'check_version':

        $data = $objMerchant->checkMerchantPosVersion($requestData['id']);

        echo json_encode($data);

        break;

    case 'updatePosSettings':

        $data = $objMerchant->update_pos_settings($requestData);

        echo json_encode($data);

        break;

    case 'posUpdateSetup':

        $merchant_id = $requestData['id'];
        $steps = $requestData['steps'];
        $extra = [];

        if ($steps == 3) {
            $extra['update_version_id'] = $requestData['update_version_id'];
        }

        $data = $objMerchant->pos_update_setup($merchant_id, $steps, $extra);

        echo json_encode($data);

        break;

    case 'getPosLatestVersion':

        $merchant_id = $requestData['id'];
        $project_group = $requestData['project_group'];

        $current_version = $objMerchant->getMerchantPosCurrentVersion($merchant_id);

        $versionData = $objMerchant->getPosLatestVersion($current_version, $project_group);
        
        $data = $versionData[$project_group];
        
        if ($versionData['num']) {
            echo '<div><h4>Select pos version to upgrade (Current Version: ' . $current_version . ').</h4></div><div><table class="table table-bordered">';

            foreach ($data['data'] as $key => $version) {

                echo '<tr><td><input type="radio" name="update_version" id="version_' . $version['id'] . '" value="' . $version['id'] . '" /></td>'
                . '<td><label for="version_' . $version['id'] . '"> POS Version ' . $version['version'] . '</label></td>'
                . '<td>' . $version['relese_status'] . '</td>'
                . '<td>' . $version['relese_date'] . '</td></tr>';
            }
            echo '</table></div><div id="showValidation"></div>';
        }

        break;

    case 'merchantPosBackups':

        $merchant_id = $requestData['id'];
        $limit = $requestData['limit'];

        $data = $objMerchant->getMerchantPosBackups($merchant_id, $limit = '');

        if ($data['num']) {
            echo '<div><h4>Select backup file to restore.</h4></div><div><table class="table table-bordered">';
            echo '<tr><th>#</th><th>POS Version</th><th>Backups Data</th><th>Backup&nbsp;Datetime</th></tr>';

            foreach ($data['data'] as $key => $backups) {

                echo '<tr><td><input type="radio" name="restore_version" id="backup_' . $backups['id'] . '" value="' . $backups['id'] . '" /></td>'
                . '<td><label for="backup_' . $backups['id'] . '">Version ' . $backups['version'] . '</label></td>'
                . '<td><b>Code:</b>&nbsp;' . str_replace('pos_backups/code/', '', $backups['pos_code_file']) . ' </br>'
                . '<b>DB:</b>&nbsp;' . str_replace('pos_backups/sql/', '', $backups['pos_sql_file']) . ' </td>'
                . '<td>' . $objapp->DateTimeFormat($backups['backup_time'], 'jS M Y h:i A') . '</td></tr>';
            }//end foreach.

            echo '</table></div><div id="showValidation"></div>';
        } else {
            echo '<div class="alert alert-warning">POS Backup Not Exists. </div>';
        }

        break;

    case 'posRollbackSetup':

        $merchant_id = $requestData['id'];
        $backup_version_id = $requestData['backup_version_id'];

        $data = $objMerchant->pos_rollback_setup($merchant_id, $backup_version_id);

        echo json_encode($data);

        break;

    case 'posExpiryUpdate':

        $merchant_id = $requestData['id'];
        $new_expiry_date = $requestData['new_expiry_date'];

        $data = $objMerchant->update_pos_expry_date($merchant_id, $new_expiry_date);

        echo json_encode($data);

        break;

    case 'merchantGenuine':

        $merchant_id = $requestData['id'];

        $data = $objMerchant->setToggleMerchantGenuineStatus($merchant_id);

        echo json_encode($data);

        break;

    case 'merchantLog' :
        $merchantData = $objMerchant->getMerchantPosData($requestData['id'], '`name`, `business_name` , `pos_url`');
        $logData = $objMerchant->getMerchantLog($requestData['id']);
        $logType = 'merchantLog';

        include_once 'activity_log.php';

        break;

    case 'merchantShortInfo':

        $objDistributors = new distributors;

        $requestExist = $objDistributors->isRequestExists($requestData['request_type'], $requestData['id']);

        $data = $objMerchant->get($requestData['id'], $select = 'id, name, pos_name, pos_generate,pos_url,type, pos_current_version, pos_status, subscription_end_at, sms_balance');

        if (is_array($data)) {
            $data['type_name'] = $objMerchant->merchantType($data['type']);
            $data['status'] = 'SUCCESS';
            $data['request'] = $requestExist;

            echo json_encode($data);
        }

        break;

    case 'submitDistributorsRequest':

        $objDistributors = new distributors;

        $request_id = $objDistributors->submitRequest($requestData);

        if ($request_id) {
            $data['status'] = 'SUCCESS';
            $data['request_id'] = $request_id;
        } else {
            $data['status'] = 'ERROR';
        }

        echo json_encode($data);

        break;
    
    case 'add_feedback':
        $MerchantId = $_POST['MerchantId'];
        $Feedback = $_POST['feedback'];
        $FeedbackId = $_POST['FeedbackId'];
        $UserId = $_POST['UserId'];
        //echo $MerchantId.' '.$Feedback;
        if ($FeedbackId == '')
            $objMerchant->add_feedback($MerchantId, $Feedback, $UserId);
        else
            $objMerchant->update_feedback($MerchantId, $Feedback, $FeedbackId);
        break;
    
    case 'delete_feedback':
        $MerchantId = $_POST['MerchantId'];
        $FeedbackId = $_POST['FeedbackId'];
        //echo $MerchantId.' '.$Feedback;
        $objMerchant->delete_feedback($MerchantId, $FeedbackId);
        break;
    
    case 'edit_feedback':
        $MerchantId = $_POST['MerchantId'];
        $FeedbackId = $_POST['FeedbackId'];
        //echo $MerchantId.' '.$Feedback;
        $Row = $objMerchant->getFeedbackByFeedbackId($MerchantId, $FeedbackId);
        $Update = array('rows' => $Row);
        echo json_encode($Update);
        break;
    
    case 'FeedbackList':
        $Data['MerchantId'] = $MerchantId = $_REQUEST['MerchantId'];
        $total = $objMerchant->count_feedback_by_merchant_id($Data, isset($_REQUEST['search']) ? $_REQUEST['search'] : "");
        $data = array();
        $Result = $objMerchant->get_feedback_by_merchant_id($Data, isset($_REQUEST['start']) ? $_REQUEST['start'] : "", isset($_REQUEST['length']) ? $_REQUEST['length'] : "", isset($_REQUEST['search']) ? $_REQUEST['search'] : "");
        //print_r($Result->result_array()); exit;
        if ($Result->num_rows > 0) {
            while ($Rows = $Result->fetch_assoc()) {
                $row_data['feedback_id'] = $Rows['feedback_id'];
                $row_data['feedback'] = $Rows['feedback'];
                $row_data['created_date'] = date('d-m-Y H:i', strtotime($Rows['created_date']));
                $data[] = $row_data;
            }
        }
        //$datas = array_map('array_values', $data);
        $DataArray = array('draw' => $_REQUEST['draw'], 'recordsTotal' => $total, 'recordsFiltered' => $total, 'data' => $data);
        echo json_encode($DataArray);
        break;
}//end switch.
?>
