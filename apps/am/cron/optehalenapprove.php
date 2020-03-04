<?php
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
require_once("../../../php/classes/mail/class.phpmailer.php"); // path to the PHPMailer class

include('../php/config.php');
include('../domain/Werkorder.php');
include('../domain/Aanvragen.php');
include('../domain/Personeel.php');

$query = "taaknaam = 'RETRIEVE SPAREPARTS' and (taakafgemeld is null or taaknaam = '0000-00-00') and taakverstuurd <= curdate()-5 and aanvraagnr in (select aanvraagnr from aanvragen where statusnr = '104')";
$dataresultset = Werkorder::whereRaw($query)->get();
$tablebody = "";
foreach ($dataresultset as $r) {
    $aresultset = Aanvragen::find($r->aanvraagnr);
    $presultset = Personeel::find($aresultset->badgenr);
    $tablebody .= "<tr><td>" . $r->aanvraagnr . "</td><td>" . $r->taakverstuurd . "</td><td>" . $aresultset->artikelcode . "</td><td>" . $aresultset->badgenr . "</td><td>" . $presultset->naam . " " . $presultset->voornaam . "</td></tr>";
}
$tabledata = "";
if (!empty($tablebody)) {
    $tabledata = "<table width='100%'><tr><td>Requestnr</td><td>Date Approved</td><td>Article</td><td>Badgenr</td><td>Name</td></tr>" . $tablebody . "</table>";
}

if (!empty($tabledata)) {
    $mail = new PHPMailer();
    $mail->SMTPDebug = 0;

    $mail->IsSMTP();                // telling the class to use SMTP
    /* --ivm outlook 365 20180316 instructie Errol
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

    //$mail->AddAddress("soraya.jasasentika@telesur.sr");
    $mail->AddAddress("spareparts@telesur.sr");
    //$mail->AddAddress("Dienesh.Biharie@telesur.sr");
    //$mail->AddAddress("robby.kalloe@telesur.sr");
    //$mail->AddAddress("marlon.samsi@telesur.sr");

    $mail->Subject = "SpareParts Requests Needing Pick-up";
    $mail->Body = "<html><style>* { font-family: Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif; } </style>" .
        "<body>Dear all, <br><br>This is a e-mail sent from SpareParts Application.<br>Requests needing pick-up.<br><br>" .
        $tabledata . "</body></html>";
    $mail->WordWrap = 500;
    $mail->IsHTML(true);

    if (!$mail->Send()) {
        echo 'Message was not sent.';
        echo 'Mailer error: ' . $mail->ErrorInfo;
    } else {
        echo 'Message has been sent.';
    }

}
?>