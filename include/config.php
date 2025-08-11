<?php
    
include_once('define_db_tables.php');
/*
 * Global Define keys
 */

define('HOSTNAME', str_replace('www.', '', $_SERVER['SERVER_NAME']));

switch(HOSTNAME) {
    case 'localhost':    
        define('BASEURL', 'http://'.$_SERVER['SERVER_NAME'].'/simplypos.in/');
        define('POS_DIR_PATH', '../../../');
    break; 

    case 'simplypos.in':
    	define('BASEURL', 'https://'.$_SERVER['SERVER_NAME'].'/');
        define('POS_DIR_PATH', '../../');
    break; 
    
    case 'simplypos.org.in':
    	define('BASEURL', 'https://'.$_SERVER['SERVER_NAME'].'/');
        define('POS_DIR_PATH', '../../');
    break; 
}

define('MAIL_HOSTNAME'	, 'simplysafe.in');
define('DIR_ADMIN'	, 'posadmin');
define('DIR_MERCHANT'	, 'merchant');
 
define('EMAIL_POS'	, 'pos@'	. MAIL_HOSTNAME );
define('EMAIL_SALE'	, 'possales@'   . MAIL_HOSTNAME );
define('EMAIL_INFO'	, 'info@'       . MAIL_HOSTNAME );

define('EMAIL_ADMIN'	, EMAIL_POS);

define('REPLY_EMAIL'	, EMAIL_SALE );
define('REPLY_NAME'	, 'Reply POS Sales' );

define('NOREPLY_EMAIL'	, 'noreply@'   . MAIL_HOSTNAME );
define('NOREPLY_NAME'	, 'POS Noreply' );

define('EMAIL_FROM'     , EMAIL_SALE );
//define('EMAIL_FROM'   , 'simplyposbhopal@gmail.com');
define('EMAIL_FROM_NAME', 'POS Sales');

define('EMAIL_TO'     , EMAIL_POS );
//define('EMAIL_TO'   , 'simplyposbhopal@gmail.com' );
define('EMAIL_TO_NAME'  , 'POS Simplysafe');

define('SMTP_SERVER'    , 'mail.'.MAIL_HOSTNAME );
define('SMTP_USER'      ,  EMAIL_SALE);
define('SMTP_PASSWORD'  , 'Simplysafe1$' );

define('TIMEZONE'   , 'Asia/Kolkata' );
define('NOW'        , date('Y-m-d h:i:s') );

define('SESSION_MERCHANT_KEY'  , 'session_merchant_id' );

define('MERCHANT_LOGOUT_RETURN_PAGE'  , '../login.php' );

//define('FREE_DEMO_DAYS'     ,  14 );
//define('SERVICE_TAX_RATE'   ,  18 );

define('DEFAULT_POS_PROJECT_ZIP'    ,  'pos_project_3.05.zip' );
define('DEFAULT_POS_SQL'            ,  'pos_sql_common_3.05.sql' );

define('POS_PROJECT_DIR'       ,  'posmerchants/' );

define('SMS_PREFIX'            ,  'Dear Customer, ' );
define('SMS_SUFIX'             ,  ' Thanks and regards.' );
define('SMS_TPL'               ,  "Dear Customer, [SMSTEXT] Thanks and regards." );

define('SMS_API_URL'           ,  'http://payonlinerecharge.com/vendorsms/pushsms.aspx');
define('SMS_API_USER'          ,  "simplysafe");
define('SMS_API_PASSWD'        ,  "Simplysafe1$$");


define('_DIR_POS_BACKUPS_SQL'            ,  'pos_backups/sql' );
define('_DIR_POS_BACKUPS_CODE'           ,  'pos_backups/code' );
define('_POS_BACKUPS_ZIP'                ,  'pos_backup.zip' );
define('_VERSION_UPGRADE_ZIP'            ,  'version_upgrade.zip' );

include_once('database.php');

 
define('_HIDE_POS_'   ,  '1,2,3,98' );

//Do not change this key in any cost.
define('MASTER_ENCRYPTION_KEY', 'd0a3e4567b6d5fcd55f4b5c56211b87cd923e85677b63bf2941ef420dc8ca191');

define('CP_ACCESS_PATH'	, "VBCa9kML6jeWKpjy3FzCokVikxqBQp9QPApgV3yrCi8zJVMIxSUcs5QFJepc1ESW3k6gF3EC33uSyJ60SGZY06tA9WdzcIiVh1XhXS/k2FuFeCHJLtIMlxuk+sO2/qPn/m2xfCSPEw67Vp15Yw66+goOvQNWd1xCB7CZmKoJpRM=|RItSS6aSdEefEIl7+GgtKBrCAu4+41zXEGVYZ9qiy/4=");


?>