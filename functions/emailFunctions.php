<?php

function sendMail(array $mailData )
{
        //SMTP needs accurate times, and the PHP time zone MUST be set
        //This should be done in your php.ini, but this is how to do it if you don't have access to that
        date_default_timezone_set('Etc/UTC');
       
        $mailForm       = $mailData['from'];
        $mailFormName   = $mailData['from_name'];

        $mailReply      = $mailData['reply'];
        $mailReplyName  = $mailData['reply_name'];

        $mailTo         = $mailData['to'];
        $mailToName     = $mailData['to_name'];

        $mailSubject    = $mailData['subject'];
        $mailBody       = $mailData['body'];
            
        //Create a new PHPMailer instance
        $mail = new PHPMailer;
        //Tell PHPMailer to use SMTP
        //$mail->isSMTP();
         $mail->isMail();   
        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $mail->SMTPDebug = 0;
        //Ask for HTML-friendly debug output
        $mail->Debugoutput = 'html';
        //Set the hostname of the mail server
        $mail->Host = SMTP_SERVER;
        //Set the SMTP port number - likely to be 25, 465 or 587
        $mail->Port = 465;
        //Whether to use SMTP authentication
        $mail->SMTPAuth = true;
        //Username to use for SMTP authentication
        $mail->Username = SMTP_USER;
        //Password to use for SMTP authentication
        $mail->Password = SMTP_PASSWORD;
        // Enable TLS encryption, `ssl` also accepted
        $mail->SMTPSecure   = 'tls';                    
        
        //Set who the message is to be sent from
        $mail->setFrom(EMAIL_FROM, EMAIL_FROM_NAME);        
        //Set an alternative reply-to address
        $mail->addReplyTo(REPLY_EMAIL, REPLY_NAME);
        //Set who the message is to be sent to
        $mail->addAddress($mailTo, $mailToName);
       // $mail->addCC($mailToCC, $mailToCCName);
        
        //Set the subject line
        $mail->Subject = $mailSubject;
        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        //$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
        //Replace the plain text body with one created manually
        $mail->Body = $mailBody;
        $mail->AltBody = 'Simply Safe Free TrialRequest Proside';
        //Attach an image file
        //$mail->addAttachment('images/phpmailer_mini.png');
        //send the message, check for errors
        if (!$mail->send()) {
            echo "<div class='text-danger'><b>Mailer Error:</b> " . $mail->ErrorInfo . "</div>";
            return false;
        } else {
            return true;
        }
        
}



?> 