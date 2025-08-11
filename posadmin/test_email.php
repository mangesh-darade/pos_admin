<?php

require_once 'PHPMailer/PHPMailerAutoload.php';
 
    $fmail = $rmail = 'info@simplypos.in'; 
    $FromName = 'GWS'; 
    $Name = 'sunil gws';
    $ToEmail = 'sunil.c@greatwebsoft.com';
    $SubEmail = 'Test Email webaddress Send ';
    $BodyEmail = '<p>Email for testing on webmail.</p>';
        
       
    $headers  = "From: stahin <$fmail>\n";
            
    $mail = new PHPMailer;

    //$mail->SMTPDebug = 3;                               // Enable verbose debug output

    //$mail->isSMTP();                                   // Set mailer to use SMTP
    $mail->isMail();                                      // Set mailer to use SMTP
    $mail->Host = 'mail.simplypos.in';                   // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'info@simplypos.in';              // SMTP username
    $mail->Password = 'HagvZ%5eTy!V';                     // SMTP password
    $mail->SMTPSecure = 'no';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465;                                    // TCP port to connect to

    $mail->setFrom($fmail, 'Mailer');
    $mail->addAddress($ToEmail, $Name);                   // Add a recipient
    //$mail->addAddress('ellen@example.com');             // Name is optional
    $mail->addReplyTo($fmail, 'Information');
    // $mail->addCC('sunilkmcharde@gmail.com');
    //$mail->addBCC('bcc@example.com');

    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    $mail->isHTML(true);                                    // Set email format to HTML

    $mail->Subject = $SubEmail;
    $mail->Body    = $BodyEmail;
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if(!$mail->Send())
    {
    echo "Mailer Error: " .  $mail->ErrorInfo;
    }
    else
    {
    echo 'Thank you for sending e-mail on '.$ToEmail;
    }
				
?>  
 
