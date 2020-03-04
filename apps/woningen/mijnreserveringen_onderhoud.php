<?php
$menuid = 1494;

require_once('../../php/conf/config.php');
require_once('../../inc_topnav.php');
require_once('../../inc_sidebar.php');

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

require_once('php/config.php');
//logic goes here


$action = 'overview';
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

switch ($action) {

    default:
    case 'overview':
        $message = "";
        $wachtlijst = 0;
        $modalshow = false;


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $aanvraagnr = generateAanvraagNr();
            $dates = $_POST['daterange'];
            $pieces = explode(" - ", $dates);

            $myDateTimebegin = DateTime::createFromFormat('m/d/Y', $pieces[0]);
            $begin1 = $myDateTimebegin->format('Y-m-d');

            $myDateTimeeind = DateTime::createFromFormat('m/d/Y', $pieces[1]);
            $myDateTimeeind->modify('+1 day');
            $eind1 = $myDateTimeeind->format('Y-m-d');

            $begin = new DateTime($begin1);
            $end = new DateTime($eind1);

            //checken als men al eerder heeft geregistreerd.
            $newDate = $begin->format('Y');
            $stmtCheck = $db->prepare("SELECT count(distinct(aanvraagnr)) as aantal  from  (  select * FROM [woningenVerhuur].[dbo].[reservaties] 
                          where badgenr='" . $_SESSION['mis']['user']['badgenr'] . "' and year(r_tijd_start) = '" . $newDate . "' and s_id='2' ) as a");
            $stmtCheck->execute();
            $rowCheck = $stmtCheck->fetch();

            if ($rowCheck['aantal'] <= 1) {


                $interval = DateInterval::createFromDateString('1 day');
                $period = new DatePeriod($begin, $interval, $end);

                //checken als er al een aanvraag voor die datum
                foreach ($period as $dt) {
                    $date = DateTime::createFromFormat('Y-m-d', $dt->format("Y-m-d"));
                    $date->modify('+1 day');
                    $stmt = $db->prepare("SELECT count(*) as aantal  FROM [woningenVerhuur].[dbo].[reservaties] where w_id='" . $_POST['w_id'] . "' and r_tijd_start='" . $dt->format("Y-m-d" . " 08:00:00") . "' and r_tijd_eind='" . $date->format("Y-m-d" . " 08:00:00") . "' and s_id='2'");
                    $stmt->execute();
                    $row = $stmt->fetch();
                    if ($row['aantal'] >= 1) {
                        $msg = "Niet beschikbaar van " . $dt->format("Y-m-d" . " 08:00:00") . " tot " . $date->format("Y-m-d" . " 08:00:00");
                        $message .= "<div class=\"alert alert-danger alert-dismissable\">
							<i class=\"fa fa-info\"></i>
							<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
							<b>Alert!</b>$msg</div>";
                        $messageWachtlijst .= $dt->format("Y-m-d" . " 08:00:00") . " tot " . $date->format("Y-m-d" . " 08:00:00") . " <br>";

                    }

                }
                //checken als message leeg is
                if (!empty($message)) {
                    $wachtlijst = 1;
                    $modalshow = true;
                }

                $wachtlijstVol = false;
                if (empty($message) || ($_POST['wachtlijst'] == 3)) {
                    $extraMessage = false;
                    $msgEmail = "";
                    $exMessage = "";
                    foreach ($period as $dt) {
                        $date = DateTime::createFromFormat('Y-m-d', $dt->format("Y-m-d"));
                        $date->modify('+1 day');
                        //echo " SELECT count(*) as aantal  FROM [woningenVerhuur].[dbo].[reservaties] where w_id='" . $_POST['w_id'] . "' and r_tijd_start='" . $dt->format("Y-m-d" . " 08:00:00") . "' and r_tijd_eind='" . $date->format("Y-m-d" . " 08:00:00") . "' and s_id='2'";
                        $stmt = $db->prepare("SELECT count(*) as aantal  FROM [woningenVerhuur].[dbo].[reservaties] where w_id='" . $_POST['w_id'] . "' and r_tijd_start='" . $dt->format("Y-m-d" . " 08:00:00") . "' and r_tijd_eind='" . $date->format("Y-m-d" . " 08:00:00") . "' and s_id in (2,3)");
                        $stmt->execute();
                        $row = $stmt->fetch();
                        if ($row['aantal'] >= 1 && $row['aantal'] <= 2) {
                            $msgEmail .= "<li>" . $dt->format("Y-m-d" . " 08:00:00") . " tot " . $date->format("Y-m-d" . " 08:00:00") . " voor woning " . getLocatie($db, $_POST['w_id']) . "</li>";
                            $showMessage = checkExistingRecord($db, $_POST['w_id'], $dt->format("Y-m-d" . " 08:00:00"), $date->format("Y-m-d" . " 08:00:00"), '3', $aanvraagnr);
                            $extraMessage = true;

                            $modalshow = false;
                        } elseif ($row['aantal'] < 1) {
                            $msgEmail .= "<li>" . $dt->format("Y-m-d" . " 08:00:00") . " tot " . $date->format("Y-m-d" . " 08:00:00") . " voor woning " . getLocatie($db, $_POST['w_id']) . "</li>";
                            $showMessage = checkExistingRecord($db, $_POST['w_id'], $dt->format("Y-m-d" . " 08:00:00"), $date->format("Y-m-d" . " 08:00:00"), '2', $aanvraagnr);
                            $extraMessage = false;
                            $modalshow = false;
                        } elseif ($row['aantal'] > 2) {
                            $wachtlijstVol = true;
                        }
                    }
                    if ($extraMessage == true) {
                        $exMessage = ", u bent op de wachtlijst geplaatst!";
                    } else {
                        $exMessage = "";
                    }

                }

                if ($wachtlijstVol != true) {
                    sendEmail("Bedankt voor uw reservering van vakantiewoning in de periode <br><ul>" . $msgEmail . " </ul>" . $exMessage, $_SESSION['mis']['user']['email'], "wishaal.mathoera@telesur.sr");
                }

                if ($wachtlijstVol == true) {
                    $message .= "<div class=\"alert alert-danger alert-dismissable\">
							<i class=\"fa fa-info\"></i>
							<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
							<b>Alert!</b>De wachtlijst is al vol, gelieve een andere datum gekiezen.</div>";
                }

            } else {
                $messageVol .= "<div class=\"alert alert-danger alert-dismissable\">
							<i class=\"fa fa-info\"></i>
							<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
							<b>Alert!</b>U heeft al twee keren gereserveerd.</div>";
            }

        }
        $historie = getHistory($db);
        $wachtlijsInfos = getWachtlijstInfos($db);
        $reserveringen = getReserveringen($db);

        require_once('tmpl/woningen.tpl.php');

        break;

    case 'annulering':
        if (isset($_GET['id'])) {

            //stap 1
            $stmt1 = $db->prepare("SELECT * FROM reservaties where r_id= '" . $_GET[id] . "'");
            $stmt1->execute();
            $row1 = $stmt1->fetch();

            //stap 2
            $stmt2 = $db->prepare("SELECT top 1 * FROM reservaties where w_id='" . $row1['w_id'] . "' and s_id='3' order by r_id");
            $stmt2->execute();
            $row2 = $stmt2->fetch();
            if (!empty($row2)) {
                //stap 3
                $query1 = "update reservaties set s_id='2' WHERE r_id='" . $row2['r_id'] . "'";
                $resultset1 = $db->query($query1);
                $msg = " van " . $row2['r_tijd_start'] . " tot " . $row2['r_tijd_eind'] . " voor woning " . getLocatie($db, $row2['w_id']);
                sendEmail("Uw aanvraag " . $msg . " is goedgekeurd en vanuit de wachtlijst weggehaald!", getEmailPDO($mis_connPDO, $row2['created_by']), "");

            }

            //stap 4
            $query = "update reservaties set s_id='1' WHERE r_id='" . $_GET[id] . "'";
            $resultset = $db->query($query);
            sendEmail("Uw aanvraag is geannuleerd!", $_SESSION['mis']['user']['email'], "");
            header('Location: mijnreserveringen.php?msg=updated');
            exit();
        }
        break;

    case 'annuleringWachtlijst':
        if (isset($_GET['id'])) {

            $query = "update reservaties set s_id='1' WHERE r_id='" . $_GET[id] . "'";
            $resultset = $db->query($query);
            sendEmail("Uw aanvraag is geannuleerd!", $_SESSION['mis']['user']['email'], "");
            header('Location: mijnreserveringen.php?msg=updated');
            exit();
        }
        break;

}


?>