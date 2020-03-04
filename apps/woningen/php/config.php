<?php

$db = new PDO("sqlsrv:Server=; Database=;", "", "");
$db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

function generateAanvraagNr(){
    return "NR".date('Ymdhisu');
}


//encapsulated function for selecting
function pdoquerySelect($db,$selectquery){
	// Define and perform the SQL SELECT query
	$query = $selectquery;
	$result = $db->query($query);
	$data = array();
	// Parse returned data, and displays them
	while($row = $result->fetch(PDO::FETCH_ASSOC)) {
	  $data[] = $row;
	}
	if(count($data) == 0){
		return $data[0];
	} else {
		return $data;
	}
}

function checkExistingRecord($db,$wid,$begin,$eind,$sid,$aanvraagnr,$werknemer){
    $query = "SELECT count(*) as aantal  FROM [woningenVerhuur].[dbo].[reservaties] 
                          where w_id='" . $wid . "' and r_tijd_start='" . $begin . "' and badgenr = '".$werknemer."'
                          and s_id ='2'
                          and r_tijd_eind='" . $eind . "'";
    //echo $query;
    $stmt = $db->prepare($query);
    $stmt->execute();
    $row = $stmt->fetch();

    if ($row['aantal'] >= 1){
        return "nee";
    }else{
        insertReservaties($db,$wid,$begin,$eind,$sid,$aanvraagnr,$werknemer);
        return "ja";
    }
}

function insertReservaties($db,$wid,$begin,$eind,$sid,$aanvraagnr,$werknemer){
	$stmt = $db->prepare("INSERT INTO reservaties (aanvraagnr,badgenr, w_id,r_tijd_start,r_tijd_eind,s_id, created_at, created_by) VALUES (:aanvraagnr,:badgenr, :w_id, :r_tijd_start,:r_tijd_eind,:s_id, GETDATE(),'".getAppUserId()."')");
	$stmt->bindParam(':badgenr', $werknemer);
	$stmt->bindParam(':w_id', $wid);
	$stmt->bindParam(':r_tijd_start', $begin);
	$stmt->bindParam(':r_tijd_eind', $eind);
	$stmt->bindParam(':s_id', $sid);
    $stmt->bindParam(':aanvraagnr', $aanvraagnr);
	$stmt->execute();
}

function insertReservatiesAdmin($db,$badgenr,$wid,$begin,$eind,$sid){
	$stmt = $db->prepare("INSERT INTO reservaties (badgenr, w_id,r_tijd_start,r_tijd_eind,s_id, created_at, created_by) VALUES (:badgenr, :w_id, :r_tijd_start,:r_tijd_eind,:s_id, GETDATE(),'".getAppUserId()."')");
	$stmt->bindParam(':badgenr', $badgenr);
	$stmt->bindParam(':w_id', $wid);
	$stmt->bindParam(':r_tijd_start', $begin);
	$stmt->bindParam(':r_tijd_eind', $eind);
	$stmt->bindParam(':s_id', $sid);
	$stmt->execute();
}

function getEmployeeStatus($db, $index){
	$stmt = $db->prepare("SELECT case when Schaal between 'N' and 'P' then 'STAF' else 'DAG' end soort, *
  FROM [telesur_mis].[dbo].[users] a join [telesur_mis].[dbo].[VPWerknemers] b on a.badge=b.werk_persnr
  where a.id='".$index."'");
	$stmt->execute();
	$row = $stmt->fetch();
	return $row['soort'];
}

function getEmployee($db, $aantal1){
    if( strlen($aantal1) < 7) {
        $aantal =  strlen($aantal1); // 14
        if($aantal == 4){
            $index = "W".$aantal1;
        }else{
            $index = $aantal1;
        }

        $stmt = $db->prepare("SELECT * FROM [telesur_mis].[dbo].[VPWerknemers] where werk_persnr ='" . $index . "'");
        $stmt->execute();
        $row = $stmt->fetch();

        if (!empty($row)) {
            return $row['werknaam'] . ' ' . $row['werkvoorn'];
        } elseif (strpos($index, 'W') === false) {
            $stmt = $db->prepare("SELECT * FROM [woningenVerhuur].[dbo].[externe_gegevens] where id ='" . $index . "'");
            $stmt->execute();
            $row = $stmt->fetch();

            if(!empty($row)){
                return $row['name'];
            }else{
                return "Onbekend";
            }
        }
        else{
            return "Onbekend";
        }
    }else{
        return "Onbekend";
    }

}

function getStatus($db, $index){
	$stmt = $db->prepare("SELECT st_naam FROM statussen where st_id = '".$index."'"); 
	$stmt->execute(); 
	$row = $stmt->fetch();
	return $row['st_naam'];
}
function getBedrijf($db, $index){
	$stmt = $db->prepare("SELECT bd_naam FROM bedrijven where bd_id = '".$index."'"); 
	$stmt->execute(); 
	$row = $stmt->fetch();
	return $row['bd_naam'];
}
function getItem($db, $index){
	$stmt = $db->prepare("SELECT item_naam FROM items where id = '".$index."'"); 
	$stmt->execute(); 
	$row = $stmt->fetch();
	return $row['item_naam'];
}

function getLocatie($db, $index){
	$stmt = $db->prepare("select loc_omschrijving + ' '+ w_code as locatie from woningen a join locaties b on a.loc_id=b.loc_id where a.w_id=  '".$index."'");
	$stmt->execute();
	$row = $stmt->fetch();
	return $row['locatie'];
}

function getAfdeling($db, $index){
	$stmt = $db->prepare("SELECT af_afdeling FROM afdelingen where af_id = '".$index."'"); 
	$stmt->execute(); 
	$row = $stmt->fetch();
	return $row['af_afdeling'];
}
function getHistory($db)
{
	$historie = pdoquerySelect($db, "select a.badgenr, a.r_id as id,
											a.r_tijd_start as start,
											a.r_tijd_eind as 'end',
											c.loc_omschrijving + ' ' + b.w_code AS  title
											,e.s_soort as description
											from reservaties a,woningen b,locaties c,woningSoort d, [woningenVerhuur]..[status] e
											where a.w_id=b.w_id and c.loc_id=b.loc_id and b.ws_id=d.ws_id and a.s_id=e.s_id and a.badgenr='" . $_SESSION['mis']['user']['badgenr'] . "' and a.s_id='1'");
	return $historie;
}

function getHistoryCAO($db)
{
	$historie = pdoquerySelect($db, "select a.badgenr, a.r_id as id,
a.r_tijd_start as start,
a.r_tijd_eind as 'end',
c.loc_omschrijving + ' ' + b.w_code AS  title
,e.s_soort as description
from reservaties a,woningen b,locaties c,woningSoort d, [woningenVerhuur]..[status] e
where a.w_id=b.w_id and c.loc_id=b.loc_id and b.ws_id=d.ws_id and a.s_id=e.s_id and b.ws_id in (1,3) and a.s_id='2' and
a.r_tijd_eind < GETDATE()-1
union
select a.badgenr, a.r_id as id,
a.r_tijd_start as start,
a.r_tijd_eind as 'end',
c.loc_omschrijving + ' ' + b.w_code AS  title
,e.s_soort as description
from reservaties a,woningen b,locaties c,woningSoort d, [woningenVerhuur]..[status] e
where a.w_id=b.w_id and c.loc_id=b.loc_id and b.ws_id=d.ws_id and a.s_id=e.s_id and b.ws_id in (1,3) and a.s_id='1'
order by r_tijd_start asc");
	return $historie;
}

function getHistoryAdmin($db)
{
	$historie = pdoquerySelect($db, "select a.badgenr, a.r_id as id,
											a.r_tijd_start as start,
											a.r_tijd_eind as 'end',
											c.loc_omschrijving + ' ' + b.w_code AS  title
											,e.s_soort as description
											from reservaties a,woningen b,locaties c,woningSoort d, [woningenVerhuur]..[status] e
											where a.w_id=b.w_id and c.loc_id=b.loc_id and b.ws_id=d.ws_id and a.s_id=e.s_id and b.ws_id in (2,3,4) and a.s_id='1'
											UNION 
											select a.badgenr, a.r_id as id,
											a.r_tijd_start as start,
											a.r_tijd_eind as 'end',
											c.loc_omschrijving + ' ' + b.w_code AS  title
											,e.s_soort as description
											from reservaties a,woningen b,locaties c,woningSoort d, [woningenVerhuur]..[status] e
											where a.w_id=b.w_id and c.loc_id=b.loc_id and b.ws_id=d.ws_id and a.s_id=e.s_id and b.ws_id in (2,3,4) and a.s_id='2' and
                                            a.r_tijd_eind < GETDATE()-1 order by r_tijd_start asc");
	return $historie;
}

function getWachtlijstInfos($db)
{
	$wachtlijsInfos = pdoquerySelect($db, "select a.badgenr, a.r_id as id,
											a.r_tijd_start as start,
											a.r_tijd_eind as 'end',
											c.loc_omschrijving + ' ' + b.w_code AS  title
											,e.s_soort as description
											from reservaties a,woningen b,locaties c,woningSoort d, [woningenVerhuur]..[status] e
											where a.w_id=b.w_id and c.loc_id=b.loc_id and b.ws_id=d.ws_id and a.s_id=e.s_id and a.badgenr='" . $_SESSION['mis']['user']['badgenr'] . "' and a.s_id='3'");
	return $wachtlijsInfos;
}

function getWachtlijstInfosCAO($db)
{
	$wachtlijsInfos = pdoquerySelect($db, "select a.badgenr, a.r_id as id,
											a.r_tijd_start as start,
											a.r_tijd_eind as 'end',
											c.loc_omschrijving + ' ' + b.w_code AS  title
											,e.s_soort as description
											from reservaties a,woningen b,locaties c,woningSoort d, [woningenVerhuur]..[status] e
											where a.w_id=b.w_id and c.loc_id=b.loc_id and b.ws_id=d.ws_id and a.s_id=e.s_id and b.ws_id in (1,3) and a.s_id='3'");
	return $wachtlijsInfos;
}

function getWachtlijstInfosAdmin($db)
{
	$wachtlijsInfos = pdoquerySelect($db, "select a.badgenr, a.r_id as id,
											a.r_tijd_start as start,
											a.r_tijd_eind as 'end',
											c.loc_omschrijving + ' ' + b.w_code AS  title
											,e.s_soort as description
											from reservaties a,woningen b,locaties c,woningSoort d, [woningenVerhuur]..[status] e
											where a.w_id=b.w_id and c.loc_id=b.loc_id and b.ws_id=d.ws_id and a.s_id=e.s_id and b.ws_id in (2,3,4) and a.s_id='3'");
	return $wachtlijsInfos;
}
function getReserveringen($db)
{
	$reserveringen = pdoquerySelect($db, "select a.badgenr, a.r_id as id,
											a.r_tijd_start as start,
											a.r_tijd_eind as 'end',
											c.loc_omschrijving + ' ' + b.w_code AS  title
											,e.s_soort as description
											from reservaties a,woningen b,locaties c,woningSoort d, [woningenVerhuur]..[status] e
											where a.w_id=b.w_id and c.loc_id=b.loc_id and b.ws_id=d.ws_id and a.s_id=e.s_id and a.badgenr='" . $_SESSION['mis']['user']['badgenr'] . "' and a.s_id='2'");
	return $reserveringen;
}

function getReserveringenCAO($db)
{
	$reserveringen = pdoquerySelect($db, "select a.badgenr, a.r_id as id,aanvraagnr,
                                            a.r_tijd_start as start,
                                            a.r_tijd_eind as 'end',
                                            c.loc_omschrijving + ' ' + b.w_code AS  title
                                            ,e.s_soort as description
                                            from reservaties a,woningen b,locaties c,woningSoort d, [woningenVerhuur]..[status] e
                                            where a.w_id=b.w_id and c.loc_id=b.loc_id and b.ws_id=d.ws_id and a.s_id=e.s_id and b.ws_id in (1,3) and a.s_id='2' and
                                            a.r_tijd_eind > GETDATE()-5
                                            order by r_tijd_start");
	return $reserveringen;
}

function getReserveringenAdmin($db)
{
	$reserveringen = pdoquerySelect($db, "select a.badgenr, a.r_id as id,
											a.r_tijd_start as start,
											a.r_tijd_eind as 'end',
											c.loc_omschrijving + ' ' + b.w_code AS  title
											,e.s_soort as description
											from reservaties a,woningen b,locaties c,woningSoort d, [woningenVerhuur]..[status] e
											where a.w_id=b.w_id and c.loc_id=b.loc_id and b.ws_id=d.ws_id and a.s_id=e.s_id and b.ws_id in (2,3,4) and a.s_id='2' and
                                            a.r_tijd_eind > GETDATE()-5");
	return $reserveringen;
}

function sendEmail($message,$extramessage,$AddAddress,$AddCC){
    $parts = explode(".", $AddAddress);
    $username = $parts[0];
	require_once '../../php/classes/mail/class.phpmailer.php';

    $mail = new PHPMailer();
    //Tell PHPMailer to use SMTP
    $mail->IsSMTP();
    //Enable SMTP debugging
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    $mail->SMTPDebug  = 0;
    //Ask for HTML-friendly debug output
    $mail->Debugoutput = 'html';
    //Set the hostname of the mail server
    $mail->Host       = "";
    //Set the SMTP port number - likely to be 25, 465 or 587
    $mail->Port       = 25;
    //Whether to use SMTP authentication
    //$mail->SMTPSecure = "tls";
    //$mail->SMTPAuth = true;
    //Set who the message is to be sent from
    $mail->SetFrom('', '');
	//Set who the message is to be sent to
	$mail->AddAddress($AddAddress);
	$mail->AddBCC($AddCC);
	//Set the subject line
	$mail->Subject = ' Woningregistratie';
	//Read an HTML message body from an external file, convert referenced images to embedded, convert HTML into a basic plain-text alternative body
	$mail->IsHTML(true);
	$mail->Body = "Beste ".ucfirst($username).",<p>".$message."</p><p>".$extramessage."</p>
<p>Vriendelijke groeten,<br> Commissie Vakantiewoningen</p>";
	$mail->AltBody="This is text only alternative body.";

	//Send the message, check for errors
	if(!$mail->Send()) {
		//echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
		//header('Location: data_email.php?msg=sent');
	}
	return true;
}


function getDatum($datum,$soort){
    //datum pakken van datepicker
    $dates = $datum;
//datum opsplitsen
    $pieces = explode(" - ", $dates);

//start datum conversie
    $myDateTimebegin = DateTime::createFromFormat('m/d/Y', $pieces[0]);
    $begin1 = $myDateTimebegin->format('Y-m-d');

//eind datum conversie met plus 1 om 1 extra dag te plaatsen
    $myDateTimeeind = DateTime::createFromFormat('m/d/Y', $pieces[1]);
    $myDateTimeeind->modify('+1 day');
    $eind1 = $myDateTimeeind->format('Y-m-d');

//finale datum bepalen
    $begin = new DateTime($begin1);
    $end = new DateTime($eind1);

    if($soort == "s"){
        return $begin;
    }else{
        return $end;
    }
}


function aantalGoedekeurdeRegistratie($db,$begin,$werknemer){
    //checken als men al eerder heeft geregistreerd.
    $newDate = $begin->format('Y');
    $stmtCheck = $db->prepare("SELECT count(distinct(aanvraagnr)) as aantal  from  (  select * FROM [woningenVerhuur].[dbo].[reservaties] 
                          where badgenr='" . $werknemer . "' and year(r_tijd_start) = '" . $newDate . "' and s_id='2' ) as a");
    $stmtCheck->execute();
    $rowCheck = $stmtCheck->fetch();

    return $rowCheck;
}

//checken als iemand twee woningen probeert te reseveren op 1 datum
function checkIfSameDateRegistration($db,$begin,$end,$werknemer){
    $interval = DateInterval::createFromDateString('1 day');
    $period = new DatePeriod($begin, $interval, $end);
    $error = array();

    //checken als er al een aanvraag voor die datum
    foreach ($period as $dt) {
        $date = DateTime::createFromFormat('Y-m-d', $dt->format("Y-m-d"));
        $date->modify('+1 day');
        $query = "SELECT count(*) as aantal  FROM [woningenVerhuur].[dbo].[reservaties] where badgenr='" . $werknemer . "' and r_tijd_start='" . $dt->format("Y-m-d" . " 08:00:00") . "' and r_tijd_eind='" . $date->format("Y-m-d" . " 08:00:00") . "' and s_id='2'";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch();
        if ($row['aantal'] >= 1) {
            $error[] = $dt->format("Y-m-d" . " 08:00:00") . " tot " . $date->format("Y-m-d" . " 08:00:00");
        }
    }

    return $error;
}


//checken als er al een reservering is voor die datum
function checkIfRegistrationExist($db,$wid,$begin,$end){
    $interval = DateInterval::createFromDateString('1 day');
    $period = new DatePeriod($begin, $interval, $end);
    $error = array();

    //checken als er al een aanvraag voor die datum
    foreach ($period as $dt) {
        $date = DateTime::createFromFormat('Y-m-d', $dt->format("Y-m-d"));
        $date->modify('+1 day');
        $stmt = $db->prepare("SELECT count(*) as aantal  FROM [woningenVerhuur].[dbo].[reservaties] where w_id='" . $wid . "' and r_tijd_start='" . $dt->format("Y-m-d" . " 08:00:00") . "' and r_tijd_eind='" . $date->format("Y-m-d" . " 08:00:00") . "' and s_id='2'");
        $stmt->execute();
        $row = $stmt->fetch();
        if ($row['aantal'] >= 1) {
            $error[] = $dt->format("Y-m-d" . " 08:00:00") . " tot " . $date->format("Y-m-d" . " 08:00:00");
        }

    }

    return $error;
}

function checkWachtlijstStatus($db,$wid,$begin,$end){
    $interval = DateInterval::createFromDateString('1 day');
    $period = new DatePeriod($begin, $interval, $end);
    $error = array();


    foreach ($period as $dt) {
        $date = DateTime::createFromFormat('Y-m-d', $dt->format("Y-m-d"));
        $date->modify('+1 day');
        $stmt = $db->prepare("SELECT count(*) as aantal  FROM [woningenVerhuur].[dbo].[reservaties] where w_id='" . $wid . "' and r_tijd_start='" . $dt->format("Y-m-d" . " 08:00:00") . "' and r_tijd_eind='" . $date->format("Y-m-d" . " 08:00:00") . "' and s_id in (2,3)");
        $stmt->execute();
        $row = $stmt->fetch();
        if ($row['aantal'] > 2) {
            $error[] = "Vol";
        }
    }

    return $error;
}

function finalInsert($db,$wid,$beginx,$werknemer){
    $dates = $beginx;
    $pieces = explode(" - ", $dates);

    $myDateTimebegin = DateTime::createFromFormat('m/d/Y', $pieces[0]);
    $begin1 = $myDateTimebegin->format('Y-m-d');

    $myDateTimeeind = DateTime::createFromFormat('m/d/Y', $pieces[1]);
    $myDateTimeeind->modify('+1 day');
    $eind1 = $myDateTimeeind->format('Y-m-d');

    $begin = new DateTime($begin1);
    $end = new DateTime($eind1);

    $interval = DateInterval::createFromDateString('1 day');
    $period = new DatePeriod($begin, $interval, $end);

    $error = array();
    $msgEmail = null;
    $exMessage = null;
    //geneer aanvraag nummer
    $aanvraagnr = "NR".date('Ymdhisu');

    foreach ($period as $dt) {
        $date = DateTime::createFromFormat('Y-m-d', $dt->format("Y-m-d"));
        $date->modify('+1 day');
        $stmt = $db->prepare("SELECT count(*) as aantal  FROM [woningenVerhuur].[dbo].[reservaties] where w_id='" . $wid . "' and r_tijd_start='" . $dt->format("Y-m-d" . " 08:00:00") . "' and r_tijd_eind='" . $date->format("Y-m-d" . " 08:00:00") . "' and s_id in (2,3)");
        $stmt->execute();
        $row = $stmt->fetch();
        if ($row['aantal'] >= 1 && $row['aantal'] <= 2) {
            $msgEmail .= "<li>" . $dt->format("Y-m-d" . " 08:00:00") . " tot " . $date->format("Y-m-d" . " 08:00:00") . " voor woning " . getLocatie($db, $wid) . "</li>";
            $exMessage = ", u bent op de wachtlijst geplaatst!";
            $error[] = checkExistingRecord($db, $wid, $dt->format("Y-m-d" . " 08:00:00"), $date->format("Y-m-d" . " 08:00:00"), '3', $aanvraagnr,$werknemer);

        } elseif ($row['aantal'] < 1) {
            $msgEmail .= "<li>" . $dt->format("Y-m-d" . " 08:00:00") . " tot " . $date->format("Y-m-d" . " 08:00:00") . " voor woning " . getLocatie($db, $wid) . "</li>";
            $error[] = checkExistingRecord($db, $wid, $dt->format("Y-m-d" . " 08:00:00"), $date->format("Y-m-d" . " 08:00:00"), '2', $aanvraagnr,$werknemer);
        }
    }

    if(!empty($exMessage)) {
        $afhaalmessage = "";
    }elseif ($wid == 3 || $wid == 4){
        $afhaalmessage = "Voor het ophalen van de sleutels kunt u kontakt maken met de heer Ingemar Zerp of mevrouw Diana Sweet. Geniet van uw verblijf, ga zuinig en voorzichtig om met de inventaris en geef het door indien iets niet in orde is.";
    }else{
        $afhaalmessage = "Voor het ophalen van de sleutels kunt u kontakt maken met de dames M.Islam-Boschmans en J.Geerdorf. Geniet van uw verblijf, ga zuinig en voorzichtig om met de inventaris en geef het door indien iets niet in orde is.";
    }

    if(in_array('ja', $error, true)){
        sendEmail("Bedankt voor uw reservering van vakantiewoning in de periode <br><ul>" . $msgEmail . " </ul>" . $exMessage,$afhaalmessage, getEmailPDO($mis_connPDO,getUserIdByBadgenr($mis_connPDO,$werknemer)), "wishaal.mathoera@telesur.sr");
    }

    return $error;
}