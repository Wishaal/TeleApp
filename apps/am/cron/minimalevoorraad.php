<?php
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
require_once("../../../php/classes/mail/class.phpmailer.php"); // path to the PHPMailer class

include('../php/config.php');
include('../domain/Artikel.php');
include('../domain/Assetpart.php');

$dataresultset = Artikel::where("minvoorraad", ">", "0")->get();
$tablebody = "";
foreach ($dataresultset as $r) {
    $assetparts = Assetpart::where("artikelcode", "=", $r->artikelcode)->where("statusnr", "=", '1')->count();
    if ($assetparts <= $r->minvoorraad) {
        $tablebody .= "<tr><td>" . $r->artikelcode . "</td><td>" . $r->artikelnaam . "</td><td>" . $r->minvoorraad . "</td><td>" . $assetparts . "</td></tr>";
    }
}
$tabledata = "";
if (!empty($tablebody)) {
    $tabledata = "<table width='80%'><tr><td>Articlecode</td><td>Description</td><td>Minimum</td><td>Available</td></tr>" . $tablebody . "</table>";
}

if (!empty($tabledata)) {
    $mail = new PHPMailer();
    $mail->SMTPDebug = 0;

    $mail->IsSMTP();                // telling the class to use SMTP
    /* -- ivm outlook 365 20180316 instructie Errol
    $mail->Host = "email.telesur.sr";
    $mail->Port = 587;
    $mail->SMTPAuth = true; 		// turn on SMTP authentication
    $mail->SMTPSecure = "tls";
    $mail->Username = "itis"; 		// SMTP username
    $mail->Password = "Mis2016!"; 	// SMTP password
    $mail->From     = "noreply.itis@telesur.sr";
    */
    $mail->Host = "smtp.sr.net";
    $mail->Port = 25;
    $mail->SetFrom('noreply.itis@telesur.sr', 'Telesur Do-Not-Reply');

    $mail->AddAddress("soraya.jasasentika@telesur.sr");
    //$mail->AddAddress("Dienesh.Biharie@telesur.sr");
    $mail->AddAddress("spareparts@telesur.sr");

    $mail->Subject = "Check Minimum SpareParts";
    $mail->Body = "<html><style>* { font-family: Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif; } </style>" .
        "<body>Dear all, <br><br>This is a e-mail sent from SpareParts Application.<br>Check the minimum on spareparts.<br><br>" .
        $tabledata . "</body></html>";
    $mail->WordWrap = 500;
    $mail->IsHTML(true);

    if (!$mail->Send()) {
        echo 'Message was not sent.';
        echo 'Mailer error: ' . $mail->ErrorInfo;
    } else {
        echo 'Message has been sent.';
    }

} else {
    echo 'No data.';
}
?>