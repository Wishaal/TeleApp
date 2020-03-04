<?php
/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 2/22/2016
 * Time: 9:29 AM
 */

function getProfileNameSession()
{
    global $mis_connPDO;
    return strtok(getProfileInfo($mis_connPDO, 'FirstName', $_SESSION['mis']['user']['badgenr']), " ") . ' ' . getProfileInfo($mis_connPDO, 'Name', $_SESSION['mis']['user']['badgenr']);
}

function setAanvraagLog($id, $omschrijving, $gebruiker)
{
    $status = new AanvraagLog();
    $status->aanvraag_id = $id;
    $status->omschrijving = $omschrijving;
    $status->gebruiker = $gebruiker;
    $status->save();
}

/**
 * @param $arrayName
 * @param $input
 * @param $locatie
 * @param $class
 * @return array
 */
function uploadMultipleFiles($arrayName, $input, $locatie)
{
    // getting all of the post data
    $files = $input->file($arrayName);
    $myarray = array();
    foreach ($files as $file) {
        $destinationPath = $locatie;
        $temp = explode(".", $file->getClientOriginalName());
        $filename = $temp[0] . round(microtime(true)) . str_random(10) . '.' . $file->getClientOriginalExtension();

        $upload_success = $file->move($destinationPath, $filename);
        $myarray[] = array('filepath' => $destinationPath, 'filename' => $filename);
    }

    return $myarray;
}


/**
 * @param $add
 * @param $cc
 * @param $subject
 * @param $body
 * @param $attachment
 * @return bool
 */
function sendEmail($add, $cc, $subject, $body, $attachment)
{
    $sendmail = false;
    require_once('../../php/classes/mail/class.phpmailer.php');

    //Create a new PHPMailer instance
    $mail = new PHPMailer();
    //Tell PHPMailer to use SMTP
    $mail->IsSMTP();
    //Enable SMTP debugging
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    $mail->SMTPDebug = 0;
    //Ask for HTML-friendly debug output
    $mail->Debugoutput = 'html';
    //Set the hostname of the mail server
    //$mail->Host       = "email.telesur.sr";
    $mail->Host = "";
    //Set the SMTP port number - likely to be 25, 465 or 587
    $mail->Port = 25;
    //Whether to use SMTP authentication
    //$mail->SMTPSecure = "tls";
    //$mail->SMTPAuth = true;
    //Set who the message is to be sent from
    $mail->SetFrom('bi.teleapp@telesur.sr', 'BI TeleApp - Telesur');
    if (!empty($add)) {
        foreach ($add as $a) {
            $mail->AddAddress($a->email);
        }
    }
    if (!empty($cc)) {
        foreach ($cc as $c) {
            $mail->AddCC($c->email);
        }
    }
    $mail->Subject = $subject;
    //Read an HTML message body from an external file, convert referenced images to embedded, convert HTML into a basic plain-text alternative body
    $mail->MsgHTML($body);
    // set email attachment
    if (!empty($attachment)) {
        $mail->AddAttachment($attachment);
    }
    //Send the message, check for errors
    if (!$mail->Send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        $sendmail = true;
    }

    return $sendmail;
}

/**
 * @return string
 */
function generateAaanvraagNr()
{
    $begin = "AANV";
    $today = date("ymd");

    $digits = 3;
    $randomnumber = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);

    $final = $begin . $today . $randomnumber;

    return $final;
}

/**
 * @param $soort
 * @param $authnr
 * @return mixed
 */
function getAuthValuta($soort, $authnr)
{

    if ($soort == "id") {
        $authorisatie = Authorisatie::find($authnr);
    } else {
        $authorisatie = Authorisatie::where('authorisatienr', '=', $authnr)->first();
    }

    return $authorisatie->valuta;
}

function getArtikelCode($id)
{

    $artikel = Artikel::find($id);


    return $artikel->artikel;
}

function getArtikelOmschrijving($id)
{

    $artikel = Artikel::find($id);


    return $artikel->artikelomschrijving;
}

/**
 * @param $soort
 * @param $authnr
 * @return mixed
 */
function getSaldo($soort, $authnr)
{

    if ($soort == "id") {
        $authorisatie = Authorisatie::find($authnr);
    } else {
        $authorisatie = Authorisatie::where('authorisatienr', '=', $authnr)->first();
    }

    $inkoop = Bestelling::where('authorisatie_id', '=', $authorisatie->id)->get();


    $sum = 0;
    $valuta = $authorisatie->valuta;
    foreach ($inkoop as $r) {
        //$sum+= $r->aanvraagStatus->getBuitenlandseInkoop->bedrag;
        if ($valuta != $r->aanvraagStatus->getBuitenlandseInkoop->valuta) {
            if ($r->aanvraagStatus->getBuitenlandseInkoop->valuta == 'US') {
                $sum += $r->aanvraagStatus->getBuitenlandseInkoop->bedrag / getKoers();
            } else {
                $sum += $r->aanvraagStatus->getBuitenlandseInkoop->bedrag * getKoers();
            }
        } else {
            $sum += $r->aanvraagStatus->getBuitenlandseInkoop->bedrag;
        }
    }
    $saldo = $authorisatie->bedrag - $sum;

    return $saldo;
}

/**
 * @param $valuta
 * @param $bedrag
 * @return float
 */
function getWisselBedrag($valuta, $bedrag)
{
    $sum = 0;
    if ($valuta == 'USD') {
        //$diff = ($r->valuta == 'USD') ? '*' : '/';
        $sum += $bedrag * 1.105;
    } else {
        $sum += $bedrag / 1.105;
    }

    //$sum = 10000 / 1.105;

    $saldo = $sum;

    return $saldo;
}

/**
 * @return mixed
 */
function getKoers()
{
    //$str = strtolower($val);
    $koers = Koers::orderBy('datum', 'DESC')->first();

    return $koers->omrekeningskoers;
}

/**
 * @param $soort
 * @param $authnr
 * @return string
 */
function getPercentageAuthorisatie($soort, $authnr)
{
    if ($soort == "id") {
        $authorisatie = Authorisatie::find($authnr);
    } else {
        $authorisatie = Authorisatie::where('authorisatienr', '=', $authnr)->first();
    }

    $saldo = getSaldo($soort, $authnr);

    $verschil = $authorisatie->bedrag - $saldo;

    $per = ($verschil / $authorisatie->bedrag) * 100;

    $val = number_format($per, 2);

    if (is_nan(acos($val))) {
        $eind = $val;
    } else {
        $eind = 0;
    }

    return $eind;
}

/**
 * @param $val
 * @return string
 */
function getPercentageBarStateColor($val)
{
    if ($val < 50) {
        $color = "primary";
    } elseif ($val > 50 && $val < 90) {
        $color = "success";
    } elseif ($val > 100) {
        $color = "danger";
    } else {
        $color = "warning";
    }
    return $color;
}

/**
 * @param $start
 * @param $eiind
 * @return string
 */
function getDaysDiff($start, $eiind)
{
    $date1 = new DateTime($start);
    $date2 = new DateTime($eiind);

    $diff = $date2->diff($date1)->format("%r%a");

    return $diff;
}

/**
 * @param $val
 * @return int
 */
function getScoreDelivery($val)
{
    if ($val < 1) {
        $score = 40;
    } elseif ($val <= 14) {
        $score = 35;
    } elseif ($val <= 20) {
        $score = 30;
    } elseif ($val <= 25) {
        $score = 25;
    } elseif ($val <= 30) {
        $score = 20;
    } elseif ($val <= 35) {
        $score = 15;
    } elseif ($val <= 40) {
        $score = 10;
    } elseif ($val <= 200) {
        $score = 1;
    }

    return $score;
}

/**
 * @param $getpermission
 * @return bool
 */
function getInkoopPermisson($getpermission)
{
    // Define and perform the SQL SELECT query
    $user = User::where('username', '=', getAppUserName())->first();
    $permission = 0;
    foreach ($user->userRollen as $role) {
        $permissionid = Role::where('rolnaam', '=', $getpermission)->first();

        if (!empty($permissionid->id)) {
            if ($permissionid->id == $role->id) {
                $permission = 1;
            }
        } else {
            $permission = 0;
        }
    }

    return ($permission == 1 ? true : false);
}