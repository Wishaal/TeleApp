<?php
require_once('../class.phpmailer.php');

    $mail             = new PHPMailer(); // defaults to using php "mail()"
    $body             = file_get_contents('contents.html');
    $body             = eregi_replace("[\]",'',$body);
        print ($body ); // to verify that I got the html
    $mail->AddReplyTo("reply@domain.com","my name");
    $mail->SetFrom('from@domain.com', 'my name');
    $address = "wishaal1993@gmail.com";
    $mail->AddAddress($address);
    $mail->Subject    = "PHPMailer Test Subject via mail(), basic";
    $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
    $mail->MsgHTML($body);
    //$mail->AddAttachment("images/phpmailer.gif");      // attachment
    //$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment

    if(!$mail->Send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        echo "Message sent!";
    }
?>