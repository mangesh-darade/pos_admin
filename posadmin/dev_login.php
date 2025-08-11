<?php
// Localhost-only dev login bypass. Remove before deploying to production.
// Usage: http://localhost/pos_admin/posadmin/dev_login.php?t=DEV_ONLY_TOKEN

include_once('application_main.php');

// Allow only from localhost
$remote = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
if (!in_array($remote, array('127.0.0.1','::1'))) {
    http_response_code(403);
    echo 'Forbidden';
    exit;
}

// Optional simple token check (change as you wish)
$requiredToken = 'DEV_ONLY_TOKEN';
$givenToken = isset($_GET['t']) ? $_GET['t'] : '';
if ($givenToken !== $requiredToken) {
    http_response_code(403);
    echo 'Forbidden (token)';
    exit;
}

// If already logged in, go to dashboard
if (isset($_SESSION['session_user_id']) && $_SESSION['session_user_id']) {
    header('Location: merchants.php');
    exit;
}

// Find an active, non-deleted admin user
$userId = null;
$username = 'admin';
$display = 'Administrator';
$email = 'admin@localhost';
$mobile = '';
$group = 'admin';
$is_distributor = 0;
$last_login = date('Y-m-d H:i:s');
$is_active = 1;

if (isset($conn) && $conn instanceof mysqli) {
    if ($stmt = $conn->prepare("SELECT `user_id`, `username`, `display_name`, `email_id`, `mobile_no`, `last_login`, `is_disrtibuter`, `group`, `is_active` FROM `admin` WHERE `is_delete`='0' ORDER BY `user_id` ASC LIMIT 1")) {
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res && $res->num_rows > 0) {
            $row = $res->fetch_assoc();
            $userId = (int)$row['user_id'];
            $username = $row['username'];
            $display = $row['display_name'];
            $email = $row['email_id'];
            $mobile = $row['mobile_no'];
            $last_login = $row['last_login'];
            $is_distributor = isset($row['is_disrtibuter']) ? (int)$row['is_disrtibuter'] : 0;
            $group = $row['group'];
            $is_active = (int)$row['is_active'];
        }
        $stmt->close();
    }
}

if (!$userId) {
    // Fallback to user id 1 if DB lookup failed
    $userId = 1;
}

// Set session and redirect
$_SESSION['session_user_id'] = $userId;
$_SESSION['session_user_group'] = $group;
$_SESSION['login']['is_disrtibuter'] = $is_distributor;
$_SESSION['login']['user_id'] = $userId;
$_SESSION['login']['username'] = $username;
$_SESSION['login']['display_name'] = $display;
$_SESSION['login']['email_id'] = $email;
$_SESSION['login']['mobile_no'] = $mobile;
$_SESSION['login']['last_login'] = $last_login;
$_SESSION['login']['is_active'] = $is_active;

header('Location: merchants.php');
exit;
