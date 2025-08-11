<?php 
    include_once('../include/database.php'); 
    class Smscron {

        public $date;
        public $_dt;
        public $_url = '/api/send_smsdashboard_sms?SMSKEY=435DS87945235464713213SFJKJ29345321&EDATE=';
  	public $_url1 = '/api/send_smsdashboard_email?SMSKEY=435DS87945235464713213SFJKJ29345321&EDATE=';
  	
        public function __construct($conn) {
            date_default_timezone_set("Asia/Kolkata");
            $this->date = date('Y-m-d');
            $this->_dt = date("m-d");
            $this->_url = $this->_url.$this->_dt;
            $this->_url1 = $this->_url1.$this->_dt;
            $this->conn = $conn;
        }
        
        
        public function init() {

           $sql =" SELECT  `id`, `pos_url` ,`pos_sms_cron_type` FROM `merchants` WHERE subscription_is_active = '1' and is_active='1' and is_delete = '0' and  `pos_sms_cron`='1' and pos_sms_cron_type in (1,2) and "
                    . "id  not in ( SELECT `merchant_id` FROM `poscron` WHERE  date(`crondate`) = '".$this->date."' )"
                    . " order by id limit 0, 10 ";

            if ($result = mysqli_query($this->conn, $sql)):
               
                $row_count=mysqli_num_rows($result);
               
                if($row_count > 0){
               
                    $MsgArr["row_count"]  = $row_count ; 
                    $res  = array();
                    while ($row = mysqli_fetch_array($result)) {
                        $merchantID = $row['id'];
                        $merchant_url = $row['pos_url'];
                        $apiUrl = rtrim($merchant_url,'/').'/'.$this->_url;
                        if($row['pos_sms_cron_type']==2){
                          $apiUrl = rtrim($merchant_url,'/').'/'.$this->_url1;
                        }
                        //echo $apiUrl;
                        $this->executeApi($apiUrl);
                        $this->markAsSend($merchantID);
                    }
                    $MsgArr["result"]  = $res ;  
                }
            endif;
        }
        
        public function markAsSend($mid){
            $sql = "INSERT INTO  `poscron` (`merchant_id` ,`crondate` )VALUES ( '$mid', '".date("Y-m-d H:i:s")."')"; 
            if ($result = mysqli_query($this->conn, $sql)) {
              return  mysqli_insert_id($this->conn);
            }
            return false;
        }
        
        public function executeApi($url) {
            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => $url,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 1200,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "GET", 
            ));
	 
            $response = curl_exec($curl);
            $err = curl_error($curl);
           
            curl_close($curl);
        }
    }
    $smsObj = new Smscron($conn);
    $smsObj->init();
?>