<?php
include('php/config.php');

$menuid = menu;

require_once('../../php/conf/config.php');
require_once('../../inc_topnav.php');
require_once('../../inc_sidebar.php');
require_once("../../php/classes/mail/class.phpmailer.php"); // path to the PHPMailer class
require_once('php/functions.php');

$action = 'overview';
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}
//add domain
include('domain/Aanvragen.php');
include('domain/Werkorder.php');
include('domain/Personeel.php');
include('domain/Assetpart.php');

switch ($action) {

    default:
    case 'overview':
        break;

    case 'new';
        Werkorder::create($input->all());
        $msg = 'saved';

        if (!empty($_GET['parent'])) {
            $updateaanvraag = Aanvragen::find($_GET['recordId']);
            $updateaanvraag->statusnr = '101';
            $updateaanvraag->save();

            $currentstock = Assetpart::where(['statusnr' => '1', 'artikelcode' => $updateaanvraag->artikelcode])->get()->count();

            $mail = new PHPMailer();
            $mail->IsSMTP();                // telling the class to use SMTP
            /* --ivm outlook 365 20180316 instructie Errol
            $mail->Host = "email.telesur.sr";
            $mail->Port = 587;
            $mail->SMTPAuth = true; 		// turn on SMTP authentication
            $mail->SMTPSecure = "tls";
            $mail->Username = "itis"; 		// SMTP username
            $mail->Password = "Mis2016!"; 	// SMTP password
            $mail->From		= "noreply.itis@telesur.sr";
            */
            $mail->Host = "smtp.sr.net";
            $mail->Port = 25;
            $mail->SetFrom('noreply.itis@telesur.sr', 'Telesur Do-Not-Reply');

            if ($_SESSION[mis][user][username] == 'jasamis') {
                $mail->AddAddress("soraya.jasasentika@telesur.sr");
            } else {
                $mail->AddAddress("spareparts@telesur.sr");
            }

            $mail->Subject = "SpareParts Request Approval Needed for " . $_GET['recordId'];
            $mail->Body = "Dear all, \n\nThis is a e-mail sent from SpareParts Application.\nRequest Approval Needed." .
                "\n\n Requestnr	: " . $_GET['recordId'] .
                "\n Requestdate	: " . $updateaanvraag->aanvraagdatum .
                "\n Requested by	: " . $updateaanvraag->badgenr . " - " . getPersoneel('badgenr', $updateaanvraag->badgenr) .
                "\n Department	: " . getAfdeling('afdelingcode', $updateaanvraag->afdelingcode) .
                "\n Article		: " . $updateaanvraag->artikelcode . " - " . getArtikel('artikelcode', $updateaanvraag->artikelcode) .
                "\n Quantity	: " . $updateaanvraag->aantal .
                "\n Current stock	: " . $currentstock .
                "\n\n Remark	: " . $updateaanvraag->opmerking;
            $mail->WordWrap = 150;
            $mail->Send();
            die('<script type="text/javascript">window.location.href="' . $_GET['parent'] . '.php";</script>');
        }
        break;

    case 'approve';
        $updateaanvraag = Aanvragen::find($_GET['recordId']);;
        $updateaanvraag->statusnr = '104';
        $updateaanvraag->save();

        $Werkorder = Werkorder::find($_GET['recordId']);
        $Werkorder->fill($input->all());
        $Werkorder->save();
        $msg = 'updated';

        $newopdracht = new Werkorder;
        $newopdracht->aanvraagnr = $Werkorder->aanvraagnr;
        $newopdracht->volgnr = '2';
        $newopdracht->afdelingcode = $Werkorder->afdelingcode;
        $newopdracht->taaknaam = 'Retrieve Spareparts';
        $newopdracht->taakverstuurd = $Werkorder->taakafgemeld;
        $newopdracht->created_user = $_SESSION[mis][user][username];
        $newopdracht->save();


        if (!empty($_GET['parent'])) {
            $updateaanvraag = Aanvragen::find($_GET['recordId']);
            $aanvragerrec = getPersoneel('id', $updateaanvraag->badgenr);

            $mynewquery = 'badgenr = (select badgenr from afdelingkoppel where functienr="1" and afdelingcode = (select afdelingcode from afdelingkoppel where badgenr ="' . $updateaanvraag->badgenr . '"))';
            $managerdata = Personeel::whereRaw($mynewquery)->get();


            $mail = new PHPMailer();
            $mail->IsSMTP();                // telling the class to use SMTP
            /* --ivm outlook 365 20180316 instructie Errol
            $mail->Host = "email.telesur.sr";
            $mail->Port = 587;
            $mail->SMTPAuth = true; 		// turn on SMTP authentication
            $mail->SMTPSecure = "tls";
            $mail->Username = "itis"; 		// SMTP username
            $mail->Password = "Mis2016!"; 	// SMTP password
            $mail->From		= "noreply.itis@telesur.sr";
            */
            $mail->Host = "smtp.sr.net";
            $mail->Port = 25;
            $mail->SetFrom('noreply.itis@telesur.sr', 'Telesur Do-Not-Reply');

            $mail->AddAddress($aanvragerrec->emailadres);
            foreach ($managerdata as $r) {
                $mail->AddAddress($r->emailadres);
            }

            if ($_SESSION[mis][user][username] == 'jasamis') {
                $mail->AddAddress("soraya.jasasentika@telesur.sr");
            } else {
                $mail->AddAddress("Dienesh.Biharie@telesur.sr");
                $mail->AddAddress("InventoryManagement@telesur.sr");
                $mail->AddAddress("spareparts@telesur.sr");
            }


            $mail->Subject = "SpareParts Request Approved for " . $_GET['recordId'];
            $mail->Body = "Dear " . getPersoneel('badgenr', $updateaanvraag->badgenr) . ",\n\nThis is a e-mail sent from SpareParts Application. " .
                "\nYour request has been approved. Please pick up spareparts" .
                "\n\n Requestnr	: " . $_GET['recordId'] .
                "\n Requestdate	: " . $updateaanvraag->aanvraagdatum .
                "\n Requested by	: " . $updateaanvraag->badgenr . " - " . getPersoneel('badgenr', $updateaanvraag->badgenr) .
                "\n Department	: " . getAfdeling('afdelingcode', $updateaanvraag->afdelingcode) .
                "\n Article		: " . $updateaanvraag->artikelcode . " - " . getArtikel('artikelcode', $updateaanvraag->artikelcode) .
                "\n Quantity	: " . $updateaanvraag->aantal .
                "\n\n Approved by	: " . $Werkorder->badgenr . " - " . getPersoneel('badgenr', $Werkorder->badgenr) .
                "\n Remark	: " . $updateaanvraag->opmerking . "\n" . $Werkorder->opmerking;
            $mail->WordWrap = 150;
            $mail->Send();
            die('<script type="text/javascript">window.location.href="' . $_GET['parent'] . '.php";</script>');
        }
        break;

    case 'cancelreq';
        $updateaanvraag = Aanvragen::find($_GET['recordId']);

        if ($updateaanvraag->statusnr == '101') {
            $Werkorder = Werkorder::find($_GET['recordId']);
            $Werkorder->delete();

            $updateaanvraag->delete();
        } else {
            $updateaanvraag->statusnr = '103';
            $updateaanvraag->save();

            $Werkorder = Werkorder::find($_GET['recordId']);
            $Werkorder->fill($input->all());
            $Werkorder->save();

            if (!empty($_GET['parent'])) {
                $aanvragerrec = getPersoneel('id', $updateaanvraag->badgenr);

                $mail = new PHPMailer();
                $mail->IsSMTP();                // telling the class to use SMTP
				/* --ivm outlook 365 20180316 instructie Errol
				$mail->Host = "email.telesur.sr";
				$mail->Port = 587;
				$mail->SMTPAuth = true; 		// turn on SMTP authentication
				$mail->SMTPSecure = "tls";
				$mail->Username = "itis"; 		// SMTP username
				$mail->Password = "Mis2016!"; 	// SMTP password
				$mail->From		= "noreply.itis@telesur.sr";
				*/
				$mail->Host = "smtp.sr.net";
				$mail->Port = 25;
				$mail->SetFrom('noreply.itis@telesur.sr', 'Telesur Do-Not-Reply');

                $mail->AddAddress($aanvragerrec->emailadres);
                $mail->AddAddress("Dienesh.Biharie@telesur.sr");
                $mail->AddAddress("InventoryManagement@telesur.sr");
                $mail->AddAddress("spareparts@telesur.sr");

                $mail->Subject = "SpareParts Request Canceled for " . $_GET['recordId'];
                $mail->Body = "Dear " . getPersoneel('badgenr', $updateaanvraag->badgenr) . ",\n\nThis is a e-mail sent from SpareParts Application. " .
                    "\nYour request has been CANCELED" .
                    "\n\n Requestnr	: " . $_GET['recordId'] .
                    "\n Requestdate	: " . $updateaanvraag->aanvraagdatum .
                    "\n Requested by	: " . $updateaanvraag->badgenr . " - " . getPersoneel('badgenr', $updateaanvraag->badgenr) .
                    "\n Department	: " . getAfdeling('afdelingcode', $updateaanvraag->afdelingcode) .
                    "\n Article		: " . $updateaanvraag->artikelcode . " - " . getArtikel('artikelcode', $updateaanvraag->artikelcode) .
                    "\n Quantity	: " . $updateaanvraag->aantal .
                    "\n\n Canceled by	: " . $Werkorder->badgenr . " - " . getPersoneel('badgenr', $Werkorder->badgenr) .
                    "\n Remark	: " . $updateaanvraag->opmerking . "\n" . $Werkorder->opmerking;
                $mail->WordWrap = 150;
                $mail->Send();
                die('<script type="text/javascript">window.location.href="' . $_GET['parent'] . '.php";</script>');
            }

        }
        die('<script type="text/javascript">window.location.href="' . $_GET['parent'] . '.php";</script>');
        break;

    case 'update';
        $Werkorder = Werkorder::find($_GET['recordId']);
        $Werkorder->fill($input->all());
        $Werkorder->save();
        $msg = 'updated';
        break;

    case 'delete';
        $Werkorder = Werkorder::find($_GET['id']);
        $Werkorder->delete();
        $msg = 'deleted';
        break;
}

$Werkorders = Werkorder::all();
$templatefilenaam = 'tmpl/werkorder.tpl.php';
if (file_exists($templatefilenaam)) {
    require_once($templatefilenaam);
} else {
    die('File does NOT exists');
}
?>