<?php

global $objapp;

include_once('../include/config.php');

require_once '../PHPMailer/PHPMailerAutoload.php';

include_once "../include/classes/baseClass.php";

$objapp = new baseClass($conn);
 
spl_autoload_register(function ($class_name) {
    include_once "../include/classes/".$class_name . '.php';
});
    
$objMerchant = new merchant;
    
//Update POS Expiry Status and Subscription Status.   
//$objMerchant->setPOSExpiryStatus();
$comment = '';

$objPos = $objMerchant->getGoingToExpiredPosList();


if($objPos['num'] > 0){
    
    foreach ($objPos['data'] as $key => $posData) {
       
        $mailbody = "<p>dear customer,</p><br/><br/>";
         
        switch($posData['validity_balance'])
        {
             case 0:
                $mailData['subject'] = 'Package Expiration Notification';
                 
                $mailbody .="<h1>Package expired notice.</h1>";
                $mailbody .="<p>Your package has been expired, To renew call +91 7554905950 , +91 7554935950 or click on the link below www.simplypos.in</p>";
                
                $sms_text = "Your package has been expired, To renew call +91 7554905950 , +91 7554935950 or click on the link below www.simplypos.in";
                
                break;
             
             case 1:
                $mailData['subject'] = 'URGENT: Final cancellation notice.';
                 
                $mailbody .="<h1>Final cancellation notice.</h1>";
                $mailbody .="<h1>Your subscription will be expired tomorrow.</h1>";
                $mailbody .="<p>Your package is due for renewal. Renew before <q>".$objapp->DateTimeFormat($posData['subscription_end_at'])."</q> to enjoy the services. Call +91 7554905950 , +91 7554935950 or renew online at www.simplypos.in</p>";
                
                $sms_text = "Your package is due for renewal. Renew before ".$objapp->DateTimeFormat($posData['subscription_end_at'])." to enjoy the services. Call +91 7554905950 , +91 7554935950 or renew online at www.simplypos.in";
                        
                break;
             
             default:
                $mailData['subject'] = 'URGENT: Your pos package will cancel in '.$posData['validity_balance'].' days.';
                 
                $mailbody .="<h1>Your subscription will be expired in ".$posData['validity_balance']." days.</h1>";
                $mailbody .="<p>Your package is due for renewal. Renew before <q>".$objapp->DateTimeFormat($posData['subscription_end_at'])."</q> to enjoy the services. Call +91 7554905950 , +91 7554935950 or renew online at www.simplypos.in</p>";
        
                $sms_text = "Your package is due for renewal. Renew before ".$objapp->DateTimeFormat($posData['subscription_end_at'])." to enjoy the services. Call +91 7554905950 , +91 7554935950 or renew online at www.simplypos.in";
                
        } 
        
        $mailbody .="<p><br/><br/>Thank you,<br/>".EMAIL_FROM_NAME."</p>";
        
        $mailData['body'] = $mailbody;
        
        //////////////////////////////////
        //Send Expiry SMS
        //////////////////////////////////
        if(is_numeric($posData['phone']) && strlen($posData['phone']) == 10 && (($posData['subscription_end_at'] % 2) == 1) ) { 
             
           $send = $objapp->SendSMS($posData['phone'], strip_tags($sms_text)); 
           if($send) {             
               $comment['sms_success'][] = $posData['phone'];
           } else {
               $comment['sms_failed'][] = $posData['phone'];
           }
        } 
        
        
        ///////////////////////////////////
        //Send Expiry Emails
        ///////////////////////////////////
        if(!empty($posData['email']) && filter_var($posData['email'], FILTER_VALIDATE_EMAIL) ) 
        {       
            $mailData['to'] = $posData['email'];
            $mailData['to_name'] = $posData['name'];

            if($objapp->sendMail( $mailData )){
               $comment['mail_success'][] = $posData['email'];
            } else {
               $comment['mail_failed'][] =  $posData['email'];
            }            
        }        
        
        
    }//end foreach.
    
    $objapp->setCronLog(['file'=>'package_expiry_alert.php', 'time'=>date('Y-m-d H:i:s'), 'comment'=> json_encode($comment) ]); 
    
} 
    
    
//$objMerchant->setPOSExpiryStatus();    
 
//Set expiry status. 
$objMerchant->expired_pos(); 
//Suspends all demo pos which is expired.
             
$objMerchant->auto_suspeds_expiry_pos();
             
    
?>
