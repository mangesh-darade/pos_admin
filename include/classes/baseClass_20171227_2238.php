<?php
            
class baseClass {
    
    public $conn;
    public $validation_error;    
    public $authMerchantId; 
    
    public function __construct($conn) {

       $this->conn = $conn;
       
       $this->validation_error = [];
          
       $this->defiendSettings();
    }
    
    public function conn(){

       return $this->conn;
       
    }
   
    public function redirected($location) {
        
        header('location:'.$location);
    }
   
    public function baseURL($extend = '')
    {
        if($extend == '') :
            return  BASEURL;
        else : 
           return  BASEURL . $extend;
        endif;
    }
    
    public function defiendSettings(){ 

        $sql = "SELECT `keyword`, `value` FROM ".TABLE_CONFIGURATION." WHERE `is_active` = '1' ";

        $result = $this->conn->query($sql);

        if($result->num_rows){

            while($row = $result->fetch_assoc()) 
            {
                define($row['keyword'], $row['value']);
            }//End while.
        }

    }
    
    public function linkCSS($filename){
        $baseURL = str_replace(['https:','http:'], '', BASEURL);
        return $baseURL . $filename;
    }
    
    public function linkJS($filename){
        $baseURL = str_replace(['https:','http:'], '', BASEURL);
        return $baseURL . $filename;
    }


    public function md5($string){
        
       return md5($string);
    }
    
    /**
	 * Valid URL
	 *
	 * @param	string	$str
	 * @return	bool
	 */
    public function valid_url($str)
	{
		if (empty($str))
		{
			return FALSE;
		}
		elseif (preg_match('/^(?:([^:]*)\:)?\/\/(.+)$/', $str, $matches))
		{
			if (empty($matches[2]))
			{
				return FALSE;
			}
			elseif ( ! in_array($matches[1], array('http', 'https'), TRUE))
			{
				return FALSE;
			}

			$str = $matches[2];
		}

		// PHP 7 accepts IPv6 addresses within square brackets as hostnames,
		// but it appears that the PR that came in with https://bugs.php.net/bug.php?id=68039
		// was never merged into a PHP 5 branch ... https://3v4l.org/8PsSN
		if (preg_match('/^\[([^\]]+)\]/', $str, $matches) && ! is_php('7') && filter_var($matches[1], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== FALSE)
		{
			$str = 'ipv6.host'.substr($str, strlen($matches[1]) + 2);
		}

		$str = 'http://'.$str;

		// There's a bug affecting PHP 5.2.13, 5.3.2 that considers the
		// underscore to be a valid hostname character instead of a dash.
		// Reference: https://bugs.php.net/bug.php?id=51192
		if (version_compare(PHP_VERSION, '5.2.13', '==') OR version_compare(PHP_VERSION, '5.3.2', '=='))
		{
			sscanf($str, 'http://%[^/]', $host);
			$str = substr_replace($str, strtr($host, array('_' => '-', '-' => '_')), 7, strlen($host));
		}

		return (filter_var($str, FILTER_VALIDATE_URL) !== FALSE);
	}
    
    public function validationRule($str , $rule) {
        
       switch($rule) {
           
            case 'required':
                
                    return is_array($str)
			? (empty($str) === FALSE)
			: (trim($str) !== '');
                
                break;
           
            case 'valid_email':
                        
                if (function_exists('idn_to_ascii') && $atpos = strpos($str, '@'))
		{
			$str = substr($str, 0, ++$atpos).idn_to_ascii(substr($str, $atpos));
		}

		return (bool) filter_var($str, FILTER_VALIDATE_EMAIL);
                
                break;

            case 'valid_url':
            
                return $this->valid_url($str);
                
                break;
            
            case 'integer':
                
                return (bool) preg_match('/^[\-+]?[0-9]+$/', $str);
                
                break;
            
            case 'numeric':
                
                return (bool) preg_match('/^[\-+]?[0-9]*\.?[0-9]+$/', $str);
                
                break;
             
            case 'alpha_dash':
                
                return (bool) preg_match('/^[a-z0-9_-]+$/i', $str);
                
                break;
            
             case 'alpha_numeric_spaces':
                
                 return (bool) preg_match('/^[A-Z0-9 ]+$/i', $str);
                
                break;
            
            case 'alpha_numeric':
                
                return ctype_alnum((string) $str);
                
                break;
            
            case 'alpha':
                
                return ctype_alpha($str);
                
                break;
            
            case '':
                
            
                
                break;
            
            case '':
                
            
                
                break;
            
        default:
        case '':
            return true;
            break;
           
           
       }
       
    }
    
    
    public function validate(array $inputArr){
        $inputValue = trim($inputArr[0]);
        $rules      = is_array($inputArr[1]) ? $inputArr[1] : explode("|", $inputArr[1]);
        $fieldName  = $inputArr[2];
                    
        if(is_array($rules)):
            foreach($rules as $rule):
            
              switch ($rule) {
                    case 'required':
                        
                        if(empty( $inputValue)){
                            $this->validation_error[] = $fieldName. " is required.";
                        }

                        break;
                    
                    case 'alphaNum':
                    case 'alphaNumeric':
                        
                        if ( !preg_match ("/^[a-zA-Z0-9\s]+$/",$inputValue)) {
                                $this->validation_error[] =  $fieldName." must only contain letters and numbers!";                                
                        }
                             
                        break;
                        
                    case 'alpha':
                        
                        if ( !preg_match ("/^[a-zA-Z\s]+$/",$inputValue)) {
                                $this->validation_error[] =  $fieldName." must only contain letters!";                                
                        }
                             
                        break;
                        
                    case 'alphaString':
                        
                        if ( !preg_match ("/^[a-zA-Z ]*$/",$inputValue)) {
                                $this->validation_error[] =  $fieldName." must only contain letters and white space!";                                
                        }
                             
                        break;
                    
                    case 'numeric':
                        if(is_numeric($inputValue)){
                            $this->validation_error[] = $fieldName. " must only numeric.";
                            
                        }
                        break;
                    
                    case 'mobile':
                        if(!is_numeric($inputValue) || strlen($inputValue)!=10){
                            $this->validation_error[] = $fieldName. " must 10 disit number.";
                            
                        }
                        break;
                    
                    case 'email':
                        
                        if (!filter_var($inputValue, FILTER_VALIDATE_EMAIL)) {
                            $this->validation_error[] = $fieldName." should valid email format"; 
                        }
                        break;
                    
                    case 'url':
                        
                        if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i" , $inputValue)) {
                          $this->validation_error[] = $fieldName." should valid URL"; 
                          
                        }
                        break;
                } 
            
            endforeach;
        endif;
        
    }
                    
    public function prepareInput($data , $trim_only=0) {        
      
        $data = trim($data);
        
        if($trim_only==0) {
            $data = addslashes($data);
            $data = htmlspecialchars($data);
        }
        return $data;
    }
	
    
    public function count_merchant(){
        
        $whereData = "";
        if($_SESSION['login']['is_disrtibuter']) {
            $whereData = " AND `distributor_id` = '".$_SESSION['session_user_id']."' ";
        }
                
        $sql = "SELECT COUNT(id) as num FROM ".TABLE_MERCHANTS." WHERE `id` NOT IN ("._HIDE_POS_.") $whereData ";
        
        $result = $this->conn->query($sql);
        
        if( $result ) {
            
           $row = $result->fetch_array(MYSQLI_ASSOC);
            
           return $row['num'];
        }
        
    }
    
     public function count_pending_request(){
        
        $whereData = "";
        if($_SESSION['login']['is_disrtibuter']) {
            $whereData = " AND `distributor_id` = '".$_SESSION['session_user_id']."' ";
        }
                
        $sql = "SELECT COUNT(id) as num FROM ".TABLE_DISTRIBUTORS_REQUEST." WHERE `request_status` = 'pending' AND is_delete='0' AND is_active='1' $whereData ";
        
        $result = $this->conn->query($sql);
        
        if( $result ) {
            
           $row = $result->fetch_array(MYSQLI_ASSOC);
            
           return $row['num'];
        }
        
    }
    
    public function errorLogsCount(){
        
        $sql = "SELECT COUNT(id) as num FROM  ".TABLE_POS_ERROR_LOG;
        
        $result = $this->conn->query($sql);
        
        if( $result ) {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            
           return $row['num'];
        }
        
    }
    
    public function adminUserCount(){
        
        $sql = "SELECT COUNT(user_id) as num FROM ".TABLE_ADMIN." where is_delete = '0' ";
        
        $result = $this->conn->query($sql);
        
        if( $result ) {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            
           return $row['num'];
        }
        
    }
    
    public function isMerchantLogin() {
        
        if(isset($_SESSION[SESSION_MERCHANT_KEY])){
            return true;
        } else {
            return false;
        }
    }
    
    public function logout_merchant() {        
        unset($_SESSION[SESSION_MERCHANT_KEY]);
        unset($_SESSION['sess_merchant_name']);
        unset($this->authMerchantId);
        unset($_SESSION);
        $this->loadPage('index.php');
    }
    
    public function loadPage($pageName) {
        header('location:' . $pageName);
    }
    
    public function pageLink($pageName) {
        return $this->baseURL($pageName);
    }
    
    public function authenticateMerchant() {
        if($this->isMerchantLogin()===false){
            $this->loadPage(MERCHANT_LOGOUT_RETURN_PAGE);
        } else {
            $this->authMerchantId = $_SESSION[SESSION_MERCHANT_KEY];
            return true;
        }
    }
    
    public function is_exists(array $requestData ){
        
       $tableName = $requestData['table'];
       $fieldName = $requestData['field'];
       $fieldValue = $requestData['value'];
       $where = $requestData['where'];
       
       if($where != '') {
           $requestData['extend_query'] = $where;
       }
       
       $extend_query = "";
       if(isset($requestData['extend_query'])) {
           $extend_query = $requestData['extend_query'];
       }
       
       $sql = "SELECT COUNT(".$fieldName.") as num FROM ".$tableName." where $fieldName = '$fieldValue' $extend_query ";
        
       $result = $this->conn->query($sql);
        
        if( $result ) 
        {
            $row = $result->fetch_array(MYSQLI_ASSOC);
                    
            return ($row['num']) ? true : false;
        }        
    }
    
    public function authenticationLinks() {
        if($this->isMerchantLogin()) {
           echo '<li class=""><a href="'.$this->pageLink('merchant/index.php').'" class="text-danger"><strong>MY ACCOUNT</strong></a></li>';
           echo '<li class=""><a href="'.$this->pageLink('logout.php').'" class="text-danger"><strong>LOGOUT</strong></a></li>';
        } else {
           echo '<li class=""><a href="'.$this->pageLink('login.php').'"><strong>LOGIN</strong></a></li>';
        }
    }
    
     public function SendSMS($phone, $sms_text){
        
        $sms = str_replace('[SMSTEXT]', $sms_text, SMS_TPL);
        
        $datasms = array(
           "user" => SMS_API_USER,
           "password" => SMS_API_PASSWD,
           "msisdn" => "+91" .$phone ,
           "sid" => "SIMPLY",
           "msg" => $sms,
           "fl" => 0,
           "gwid" => 2
        );                    
        
       $urlsms = SMS_API_URL;
       $ressms = $this->PostSMSURL($urlsms, $datasms); 
       return $ressms;
    }

    private function PostSMSURL($url, $data) {
       $fields = '';
       foreach ($data as $key => $value) {
           $fields .= $key . '=' . $value . '&';
       }
       rtrim($fields, '&');
       $post = curl_init();
       curl_setopt($post, CURLOPT_URL, $url);
       curl_setopt($post, CURLOPT_POST, count($data));
       curl_setopt($post, CURLOPT_POSTFIELDS, $fields);
       curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
       $result = curl_exec($post);

       return $result;
    }


    
    public function sendMail(array $mailData )
    {
        //SMTP needs accurate times, and the PHP time zone MUST be set
        //This should be done in your php.ini, but this is how to do it if you don't have access to that
        date_default_timezone_set(TIMEZONE);
       
        $mailForm       = $mailData['from'];
        $mailFormName   = $mailData['from_name'];

        $mailReply      = $mailData['reply'];
        $mailReplyName  = $mailData['reply_name'];

        $mailTo         = $mailData['to'];
        $mailToName     = $mailData['to_name'];

        $mailSubject    = $mailData['subject'];
        $mailBody       = $mailData['body'];
            
        $mail = new PHPMailer;

        $mail->SMTPDebug = 0;                   // Enable verbose debug output
/*
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = SMTP_SERVER;                          // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = SMTP_USER;                        // SMTP username
        $mail->Password = SMTP_PASSWORD;                           // SMTP password
        $mail->SMTPSecure = 'no';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to
*/
        
        $mail->isMail();                                // Set mailer to use SMTP
        $mail->Host         = SMTP_SERVER;      // Specify main and backup SMTP servers
        $mail->SMTPAuth     = true;                     // Enable SMTP authentication
        $mail->Username     = SMTP_USER;      // SMTP username
        $mail->Password     = SMTP_PASSWORD;           // SMTP password
        $mail->SMTPSecure   = 'tls';                    // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;                              // TCP port to connect to
        
        
        $mail->setFrom(EMAIL_FROM, EMAIL_FROM_NAME);
        $mail->addAddress($mailTo, $mailToName);                // Add a recipient
        //$mail->addAddress('ellen@example.com');               // Name is optional
        $mail->addReplyTo(REPLY_EMAIL, REPLY_NAME);
        //$mail->addCC('cc@gmail.com');
        //$mail->addBCC('bcc@example.com');

        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = $mailSubject;
        $mail->Body    = $mailBody;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if (!$mail->send()) {
            echo "<div class='alert alert-danger'>Mailer Error: " . $mail->ErrorInfo ."</div>";
            return false;
        } else {
            return true;
        }
        
    }
    
    
    public function randomPasswd($length = 10) 
    {
        $characters = 'ABCDEFGHJKLMNPQRSTUVWYZ09!@%&*4567+{}[]38?12abcdefghjkmnpqrstuvwyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    
    

///////////////////////////////////////////////////////////////////////////////////
// #Format: Y-m-d H:i:s 		=> 	#output: 2012-03-24 17:45:12
// #Format: Y-m-d h:i A			=> 	#output: 2012-03-24 05:45 PM
// #Format: d/m/Y H:i:s 		=> 	#output: 24/03/2012 17:45:12
// #Format: d/m/Y 				=> 	#output: 24/03/2012
// #Format: g:i A 				=> 	#output: 5:45 PM
// #Format: h:ia 				=> 	#output: 05:45pm
// #Format: g:ia \o\n l jS F Y 	=> 	#output: 5:45pm on Saturday 24th March 2012
// #Format: l jS F Y 			=> 	#output: Saturday 24th March 2012
// #Format: D jS M Y 			=> 	#output: Sat 24th Mar 2012
// #Format: jS F Y g:ia			=> 	#output: 24th March 2012 5:45pm
// #Format: j F Y				=> 	#output: 24 March 2012
// #Format: j M y				=> 	#output: 24 Mar 12
// #Format: F j					=> 	#output: March 24 
// #Format: F Y					=> 	#output: March 2012
/////////////////////////////////////////////////////////////////////////////////////
public function DateTimeFormat($dateTime , $dateFormat = 'jS M Y' )
    {
	$date = date_create($dateTime);
	
	$newDateFormat = date_format($date, $dateFormat);
	
	$newDateFormat = str_replace('th ' , '<sup>th </sup>' , $newDateFormat);
	$newDateFormat = str_replace('1st ' , '1<sup>st </sup>' , $newDateFormat);
	$newDateFormat = str_replace('nd ' , '<sup>nd </sup>' , $newDateFormat);
	$newDateFormat = str_replace('rd ' , '<sup>rd </sup>' , $newDateFormat);
	
	return $newDateFormat;
    }


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//PARA: Date Should In YYYY-MM-DD Format
//RESULT FORMAT:
// '%y Year %m Month %d Day %h Hours %i Minute %s Seconds'		=>  1 Year 3 Month 14 Day 11 Hours 49 Minute 36 Seconds
// '%y Year %m Month %d Day'									=>  1 Year 3 Month 14 Days
// '%m Month %d Day'											=>  3 Month 14 Day
// '%d Day %h Hours'											=>  14 Day 11 Hours
// '%d Day'														=>  14 Days
// '%h Hours %i Minute %s Seconds'								=>  11 Hours 49 Minute 36 Seconds
// '%i Minute %s Seconds'										=>  49 Minute 36 Seconds
// '%h Hours													=>  11 Hours
// '%a Days														=>  468 Days
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
public function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' )
    {
	$datetime1 = date_create($date_1);
	$datetime2 = date_create($date_2);
	
	$interval = date_diff($datetime1, $datetime2);
	
	return $interval->format($differenceFormat);
	
    }
                    
    
    
 ////
//PARA: Start Date FORMAT (YYYY-MM-DD)
//PARA: Start Date FORMAT (YYYY-MM-DD)
////
public function dateDiff($startDate, $endDate) 
{

	$start_ts = strtotime($startDate);
	
	$end_ts = strtotime($endDate);
	
	$diff = $end_ts - $start_ts;
	
	return round($diff / 86400);

}   
    
 
    public function date_ddmmyy_to_format($ddate , $dateFormat='Y-m-d H:i:s')
    {

            $d=substr($ddate,0,2);
            $m=substr($ddate,3,2);
            $y=substr($ddate,6,4);
            $t=substr($ddate,11,8);

            $ymdt = $y."-".$m."-".$d." ".$t;            

          return $this->DateTimeFormat($ymdt , $dateFormat);

    }
    
    public function date_mmddyy_to_format($ddate , $dateFormat='Y-m-d H:i:s')
    {
        $m=substr($ddate,0,2);
        $d=substr($ddate,3,2);
        $y=substr($ddate,6,4);
        $t=substr($ddate,11,8);

        $ymdt = $y."-".$m."-".$d." ".$t;            

        return $this->DateTimeFormat($ymdt , $dateFormat);

    }

    
    public function asTitle($string) {
        
        $string = str_replace(['_','-','.'], ' ', $string);
        
        return ucwords($string);
    }
   
    
    
    public function getExistRootDirectory() {
        
       global $ExistsDirectoryArr;
        
       $projectDir = '../'.POS_PROJECT_DIR;
       
        if(HOSTNAME == 'simplypos.in') {

            $ExistsDirectory = array_filter( glob($projectDir.'*'), 'is_dir');

            foreach($ExistsDirectory as $directory){
                $ExistsDirectoryArr[] = strtolower(str_replace($projectDir, '', $directory));
            }
        } 
        if(HOSTNAME == 'simplypos.org.in') {

            $ExistsDirectory = array_filter( glob($projectDir.'*'), 'is_dir');

            foreach($ExistsDirectory as $directory){
                $ExistsDirectoryArr[] = strtolower(str_replace($projectDir, '', $directory));
            }
        }  else {
                    
             $ExistsDirectory = array_filter( glob($projectDir.'*'), 'is_dir');
             
             foreach($ExistsDirectory as $directory){
                $ExistsDirectoryArr[] = strtolower(str_replace($projectDir, '', $directory));
            }
        }
                    
        return $ExistsDirectoryArr;
        
    }
    
    public function isValidPosName($posname) {
        
        if(trim($posname)=='') return false;
                    
        if($this->min_length($posname, 3) == false) return false;
                    
        if($this->max_length($posname, 20) == false) return false;
                    
        if(!preg_match('/^[a-z0-9]+$/i', $posname )) return false;
                    
        return true;
    }
    
    public function min_length($str, $val)
    {
        if ( ! is_numeric($val))
        {
                return FALSE;
        }

        return ($val <= strlen($str)) ? true : false;
    }


    public function max_length($str, $val)
    {
        if ( ! is_numeric($val))
        {
                return FALSE;
        }

        return ($val >= strlen($str)) ? true : false;
    }

  
    public function deleteDirectory($path)
    {
        try{
          $iterator = new DirectoryIterator($path);
          foreach ( $iterator as $fileinfo ) {
            if($fileinfo->isDot())continue;
            if($fileinfo->isDir()){
              if($this->deleteDirectory($fileinfo->getPathname()))
                @rmdir($fileinfo->getPathname());
            }
            if($fileinfo->isFile()){
              @unlink($fileinfo->getPathname());
            }
          }
        } catch ( Exception $e ){
           // write log
           return false;
        }

        if($fileinfo->isDir()){
              @rmdir($path);
        }

        return true;
    }
    
    public function file_containt_replace($file_path , array $findArr, array $replaceArr){
        
        
        if(is_file($file_path) && is_writable($file_path)){
                    
            $fhandle1 = fopen($file_path,"r");
            $content1 = fread($fhandle1,filesize($file_path));

            $content1 = str_replace($findArr, $replaceArr , $content1);
            $fhandle1 = fopen($file_path, "w");
            $fw2 = fwrite($fhandle1, $content1);
            fclose($fhandle1); 
            if($fw2 ){
                return true;
            } else {
               return false;  
            }

        } else {
            return false;
        }
    }
    
    
    public function get_table_description($tableName = 'admin'){

	$result = $this->conn->query('DESCRIBE '.$tableName);

	if( $result ) {
		while($row = $result->fetch_array(MYSQLI_ASSOC)) {
			echo "<pre>";
			print_r($row);
			echo "</pre>";
		}
	}
}


public function get_database_description($db_name='' , $conn='')
{
    $dbconn  = ($conn) ? $conn : $this->conn;    
    
    $result = $dbconn->query("SELECT * FROM INFORMATION_SCHEMA.TABLES
                                        WHERE TABLE_SCHEMA = '$db_name'");

    if( $result )
    {
        while($row = $result->fetch_array(MYSQLI_ASSOC))
        {
            $data[] = $row;
        }
    }
        
    return $data;
}
    
    
    public function setCronLog(array $cronData) {
        
       $file = $cronData['file'];
       $comment = $cronData['comment'];
       $time = $cronData['time'];
        
        $sql = "INSERT INTO `cron_log` (`cron_file`, `cron_time`, `comment`) VALUES ('$file', '$time', '$comment')";
        
       $this->conn->query($sql); 
        
    }
    
   
    public function isJson($string,$return_data = false) 
    {
        $data = json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE) ? ($return_data ? $data : TRUE) : FALSE;
    }
    
    //https://github.com/tazotodua/useful-php-scripts
    public function export_database($dbCon,  $mysqlDatabaseName , $version='1.0', $backup_path='' )
    {
        //$mysqli = new mysqli($host, $user, $pass,$name); 
        //$mysqli->select_db($name);
        
        $filename   = $mysqlDatabaseName.'_v_'.str_replace('.', '_', $version).'_'. time() . '.sql';
                    
        $mysqli   = $dbCon;
        $db_data  = $this->get_database_description($mysqlDatabaseName , $mysqli);
                    
        if(is_array($db_data)) {
            foreach ($db_data as $key=>$dbdata) {
                $tables[] = $dbdata['TABLE_NAME'];
                $tablesInfo[$dbdata['TABLE_NAME']]  = $dbdata['TABLE_TYPE'];
            }
        }
        
        $mysqli->query("SET NAMES 'utf8'");
        $queryTables = $mysqli->query('SHOW TABLES'); 

        while($row = $queryTables->fetch_row()) 
        { 
            $target_tables[] = $row[0];     
        }   

        if($tables !== false) 
        { 
            $target_tables = array_intersect( $target_tables, $tables); 
        }

        $content = "--\n-- Database: `".$mysqlDatabaseName."`\n--\n\n";


        foreach($target_tables as $table)
        {
            $result = $mysqli->query('SELECT * FROM '.$table);  
            $fields_amount=$result->field_count;  
            $rows_num=$mysqli->affected_rows;     
            $res = $mysqli->query('SHOW CREATE TABLE '.$table); 
                    
            if($res) {
                $TableMLine=$res->fetch_row();
            }
            
            if(isset($content))
            {
               $content .= "-- --------------------------------------------------------\n\n--\n-- Table structure for table `".$table."`\n--\n\n";
               $content .= "DROP TABLE IF EXISTS `".$table."`;\n\n";
               $content .= $TableMLine[1].";\n\n";
            }
            
           if($tablesInfo[$table] == 'VIEW') continue;
           
            $content .= "--\n-- Dumping data for table `".$table."` \n--\n";   

            for ($i = 0, $st_counter = 0; $i < $fields_amount;   $i++, $st_counter=0) 
            {
                while($row = $result->fetch_row())  { //when started (and every after 100 command cycle):

                    if ($st_counter%100 == 0 || $st_counter == 0 )  {$content .= "\nINSERT INTO ".$table." VALUES";}
                        $content .= "\n(";
                        for($j=0; $j<$fields_amount; $j++)  
                        { 
                            $row[$j] = str_replace("\n","\\n", addslashes($row[$j]) );
                            if (isset($row[$j])){ $content .= "'".$row[$j]."'" ; } 
                            else { $content .= "''"; }     
                            if ($j<($fields_amount-1)) { $content.= ','; }
                        }

                        $content .=")";

                    //every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
                    if ( (($st_counter+1)%100==0 && $st_counter!=0) || $st_counter+1==$rows_num) {$content .= ";";} else {$content .= ",";} $st_counter=$st_counter+1;
                }
            } 
            $content .="\n\n\n";
        }           
        
        $backup_file_path = '../../'.$backup_path .'/'. $filename; 

        $myfile = fopen($backup_file_path, "w") or die("Unable to open file! Path: $backup_file_path");

        fwrite($myfile, $content);

        fclose($myfile);

        if(file_exists($backup_file_path)) {
            $data['status'] = 'SUCCESS';
            $data['msg'] = 'Database backup success.';
            $data['backup'] = $backup_file_path;
            
        } else {
            $data['status'] = 'ERROR';
            $data['msg'] = 'Database backup failed.';
        }
        
        return $data;           
    }
    
    public function runSqlFile($posconn , $filename) {
        
        //Temporary variable, used to store current query
            $templine = '';
            // Read in entire file
            $lines = file($filename);
            $import = $s = $e = 0;
            // Loop through each line
            foreach ($lines as $line)
            {
                // Skip it if it's a comment
                if(substr($line, 0, 2) == '--' || $line == ''){ continue; }

                // Add this line to the current segment
                $templine .= $line;
                // If it has a semicolon at the end, it's the end of the query
                if (substr(trim($line), -1, 1) == ';')
                {
                    // Perform the query
                   $r = $posconn->query($templine) ;
                   $import++;
                   
                    if($r) {
                        $s++;                        
                        $dataResponse['response'][$import] = 'Success';
                        $data['query_success'] = $s;
                    } else {
                        
                        if( strpos($posconn->error, 'Duplicate' ) !== false || strpos($posconn->error, 'already exists' ) !== false  ) {
                            $s++;                        
                            $dataResponse['response'][$import] = 'Success';
                            $data['query_success'] = $s;
                        } else {
                            $dataResponse['response'][$import] = $posconn->error;                        
                            $e++;
                            $data['query_failed'] = $e;
                        }
                    } 
                    
                    //Reset temp variable to empty
                    $templine = ''; 
                }
            }//end foreach.
            
            if( $e ) { $data['response'] = $dataResponse['response']; }
            
            $data['total_query'] = $import; 
             
        return $data;
    }
    
    public function addFileToZip($zip , $pos_path  ){
    
        static $count;
        
        $handle = opendir($pos_path);
                    
        if ($handle)
        {
            //Add all files inside the directory
            while (false !== ($entry = readdir($handle)))
            { 
                $path = $pos_path.'/' . $entry;
              
                if(strstr('/'.$entry, '/.') && $entry != '.htaccess' ) { continue; }
                if(strstr($path,'version_backup')  ) { continue; }  
                 
                 $count++; 
                 
                    $addPath = str_replace(_POS_DIR_, '', $path);
                    
                    if (is_dir($path))
                    {
                        $zip->addEmptyDir( $addPath );
                        $this->addFileToZip($zip , $path );
                    }
                
                    if (is_file($path))
                    {
                        $zip->addFile($path , $addPath );
                    } 
            }
            closedir($handle);
        }
        
        return $count;
   }

    
    public function getFilesAndSubfoldersList( $dir_path  ){ 
        static $data;
        if(!is_dir($dir_path)) return false;
       
        $handle = opendir($dir_path);
                    
        if ($handle)
        {
            //get all files inside the directory
            while (false !== ($entry = readdir($handle)))
            { 
                $path = $dir_path.'/' . $entry;
              
                if(strstr('/'.$entry, '/.') && $entry != '.htaccess' ) { continue; } 
                
                $data[] = $path;

                if(is_dir($path))
                {
                    $this->getFilesAndSubfoldersList( $path );
                }
                    
            }
            closedir($handle);
        }
        
        return $data;
   }

    public function getSubFolderList( $dir_path  ){ 
                    
        if(!is_dir($dir_path)) return false;
       
        $handle = opendir($dir_path);
                    
        if ($handle)
        {
            //get all files inside the directory
            while (false !== ($entry = readdir($handle)))
            { 
                $path = $dir_path.'/' . $entry; 

                if(is_dir($path))
                {
                    $subFolders[] = $entry;
                }                    
            }
            closedir($handle);
        }
        
        return $subFolders;
   }
    
    public function set_dir($dir){
    
    if(!is_dir($dir)){
       return mkdir($dir, 0777);         
    }
    return true;
} 
    
    
    
    public function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}  
    
  
    
}//end baseClass




?>