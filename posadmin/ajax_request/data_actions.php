<?php

include_once('../../application_main.php');

if (isset($_POST) || isset($_GET)) {
    $requestData = $_REQUEST;
}

$id = $requestData['id'];
$tableName = $requestData['table'];
$tableIdField = ($requestData['id_filed']) ? $requestData['id_filed'] : 'id';
$library = $requestData['library'];

switch ($requestData['action']) {
    case 'changeStatus':

        $newStatus = $requestData['newStatus'];

        $sql = "UPDATE $tableName  SET `is_active` = '$newStatus' WHERE  $tableIdField = '$id' ";

        runAction($id, $sql);

        break;

    case 'trash':

        $sql = "UPDATE $tableName  SET `is_delete` = '1' WHERE  $tableIdField = '$id' ";

        runAction($id, $sql);

        break;

    case 'untrash':

        $sql = "UPDATE $tableName  SET `is_delete` = '0' WHERE  $tableIdField = '$id' ";

        runAction($id, $sql);

        break;

    case 'showForm':

        switch ($library) {
            case 'merchant':
                include_once 'form_merchant_type.php';
                break;

            default:
                $objLib = '';
                break;
        }

        break;

    case 'insert':

        $objLib = getLibraryObject($library);

        $response = $objLib->insert($requestData);

        echo json_encode($response);

        break;

    case 'update':

        $objLib = getLibraryObject($library);

        $response = $objLib->update($requestData);

        echo json_encode($response);

        break;

    case 'dataList':

        $requestData = generateFilterCondition($requestData);

        $objLib = getLibraryObject($library);
        
        $tableData = $objLib->filter_data($requestData);

        include_once( $library . '_list.php' );


        break;

    case 'view':

        $objLib = getLibraryObject($library);

        $tableData = $objLib->view();

        include_once( $library . '_list.php' );

        break;

    case 'get_record':

        $objLib = getLibraryObject($library);

        $objLib->set_condition(['id' => $id]);

        $data = $objLib->get_record();

        echo json_encode($data);

        break;

    case 'get_request':

        $objLib = getLibraryObject($library);

        $data = $objLib->get_request($id);

        echo json_encode($data);

        break;

    case 'requestList':

        $requestData = generateFilterCondition($requestData);

        $objLib = getLibraryObject($library);

        $tableData = $objLib->requestList($requestData);

        if (count($tableData)) {

            include_once( $library . '_request_list.php' );
        }

        break;

    case 'request_update':

        $objLib = getLibraryObject($library);

        $data = $objLib->updateRequest($requestData);

        echo json_encode($data);

        break;
}//end switch.

function generateFilterCondition($requestData) {
    $requestData['conditions']['is_delete'] = 0;

    $result_type = $requestData['result_type'];
    $requestData['result_type'] = $result_type;

    if ($result_type == 'filter') {

        if (isset($requestData['filter']) && $requestData['filter'] != '') {
            $filterArr = explode('-', $requestData['filter']);

            $requestData['conditions'][$filterArr[0]] = $filterArr[1];
        }

        if (isset($requestData['sort']) && $requestData['sort'] != '') {

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

    return $requestData;
}

function runAction($id, $sql) {

    global $objapp;

    if (is_numeric($id)) {
        $result = $objapp->conn->query($sql);

        if ($result) {
            $data['status'] = 'SUCCESS';
        } else {
            $data['status'] = 'ERROR';
            $data['msg'] = '<b>Sql Error:</b> ' . $objapp->conn->error;
        }
    } else {
        $data['status'] = 'ERROR';
        $data['msg'] = '<b>Data Error:</b> Invalid merchant id.';
    }

    echo json_encode($data);
}

function getLibraryObject($library) {
    switch ($library) {
        case 'merchant_type':
            $objLib = new merchant_type;
            break;

        case 'merchant':
            $objLib = new merchant;
            break;

        case 'pos_project_zip':
            $objLib = new pos_project_zip;
            break;

        case 'pos_project_sql':
            $objLib = new pos_project_sql;
            break;

        case 'pos_versions':
            $objLib = new pos_versions;
            break;

        case 'distributors':
            $objLib = new distributors;
            break;

        case 'adminUser':
            $objLib = new adminUser;
            break;

        default:
            $objLib = '';
            break;
    }

    return $objLib;
}

?>
