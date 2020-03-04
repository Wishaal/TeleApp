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

//    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//
//        $aanvraagnr = generateAanvraagNr();
//        $dates = $_POST['daterange'];
//        $pieces = explode(" - ", $dates);
//
//        $myDateTimebegin = DateTime::createFromFormat('m/d/Y', $pieces[0]);
//        $begin1 = $myDateTimebegin->format('Y-m-d');
//
//        $myDateTimeeind = DateTime::createFromFormat('m/d/Y', $pieces[1]);
//        $myDateTimeeind->modify('+1 day');
//        $eind1 = $myDateTimeeind->format('Y-m-d');
//
//        $begin = new DateTime($begin1);
//        $end = new DateTime($eind1);
//
//
//        $interval = DateInterval::createFromDateString('1 day');
//        $period = new DatePeriod($begin, $interval, $end);
//
//        foreach ($period as $dt) {
//            $date = DateTime::createFromFormat('Y-m-d', $dt->format("Y-m-d"));
//            $date->modify('+1 day');
//            $stmt = $db->prepare("SELECT count(*) as aantal  FROM [woningenVerhuur].[dbo].[reservaties] where w_id='" . $_POST['w_id'] . "' and r_tijd_start='" . $dt->format("Y-m-d" . " 08:00:00") . "' and r_tijd_eind='" . $date->format("Y-m-d" . " 08:00:00") . "' and s_id='2'");
//            $stmt->execute();
//            $row = $stmt->fetch();
//            if ($row['aantal'] >= 1) {
//                $msg = "Niet beschikbaar van " . $dt->format("Y-m-d" . " 08:00:00") . " tot " . $date->format("Y-m-d" . " 08:00:00");
//                $message .= "<div class=\"alert alert-danger alert-dismissable\">
//							<i class=\"fa fa-info\"></i>
//							<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
//							<b>Alert!</b>$msg</div>";
//                $messageWachtlijst .= $dt->format("Y-m-d" . " 08:00:00") . " tot " . $date->format("Y-m-d" . " 08:00:00") . " <br>";
//
//            }
//
//        }
//
//        if (!empty($message)) {
//
//            $wachtlijst = 1;
//            $modalshow = true;
//        }
//        $wachtlijstVol = false;
//        if (empty($message) || ($_POST['wachtlijst'] == 3)) {
//            $extraMessage = false;
//            foreach ($period as $dt) {
//                $date = DateTime::createFromFormat('Y-m-d', $dt->format("Y-m-d"));
//                $date->modify('+1 day');
//                //echo "SELECT count(*) as aantal  FROM [woningenVerhuur].[dbo].[reservaties] where w_id='" . $_POST['w_id'] . "' and r_tijd_start='" .$dt->format("Y-m-d"." 08:00:00" ) . "' and r_tijd_eind='" . $date->format( "Y-m-d"." 08:00:00" ) . "'";
//                $stmt = $db->prepare("SELECT count(*) as aantal  FROM [woningenVerhuur].[dbo].[reservaties] where w_id='" . $_POST['w_id'] . "' and r_tijd_start='" . $dt->format("Y-m-d" . " 08:00:00") . "' and r_tijd_eind='" . $date->format("Y-m-d" . " 08:00:00") . "' and s_id in (2,3)");
//                $stmt->execute();
//                $row = $stmt->fetch();
//                if ($row['aantal'] >= 1 && $row['aantal'] <= 2) {
//                    $msgEmail.= "<li>" . $dt->format("Y-m-d" . " 08:00:00") . " tot " . $date->format("Y-m-d" . " 08:00:00")." voor woning ".getLocatie($db,$_POST['w_id'])."</li>";
//                    insertReservatiesAdmin($db, $_POST['badgenr'], $_POST['w_id'], $dt->format("Y-m-d" . " 08:00:00"), $date->format("Y-m-d" . " 08:00:00"), '3',$aanvraagnr);
//                    $extraMessage = true;
//
//                    $modalshow = false;
//                } elseif ($row['aantal'] < 1) {
//                    $msgEmail.= "<li>" . $dt->format("Y-m-d" . " 08:00:00") . " tot " . $date->format("Y-m-d" . " 08:00:00")." voor woning ".getLocatie($db,$_POST['w_id'])."</li>";
//                    insertReservatiesAdmin($db, $_POST['badgenr'],$_POST['w_id'], $dt->format("Y-m-d" . " 08:00:00"), $date->format("Y-m-d" . " 08:00:00"), '2',$aanvraagnr);
//                    $extraMessage = false;
//                    $modalshow = false;
//                } elseif ($row['aantal'] > 2) {
//                    $wachtlijstVol = true;
//                }
//            }
//            if ($extraMessage == true){
//                $exMessage = ", u bent op de wachtlijst geplaatst!";
//            }else{
//                $exMessage = "";
//            }
//            //sendEmail("Uw aanvraag <br><ul>".$msgEmail." </ul> is doorgevoerd!".$exMessage,$_SESSION['mis']['user']['email'],"wishaal.mathoera@telesur.sr");
//        }
//
//        if ($wachtlijstVol == true) {
//            $message .= "<div class=\"alert alert-danger alert-dismissable\">
//							<i class=\"fa fa-info\"></i>
//							<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
//							<b>Alert!</b>De wachtlijst is al vol, gelieve een andere datum gekiezen.</div>";
//        }
//
//    }

        $wachtlijsInfos = getWachtlijstInfosAdmin($db);
        $reserveringen = getReserveringenAdmin($db);

        require_once('tmpl/adminwoningen.tpl.php');

        break;

    case 'annulering':
        if (isset($_GET['id'])) {

            //stap 1
            $stmt1 = $db->prepare("SELECT * FROM reservaties where r_id= '".$_GET[id]."'");
            $stmt1->execute();
            $row1 = $stmt1->fetch();

            //stap 2
            $query ="SELECT top 1 * FROM reservaties where w_id='".$row1['w_id']."' 
                                            and badgenr not in (SELECT badgenr  from  (  select * FROM [woningenVerhuur].[dbo].[reservaties] 
                                            where year(r_tijd_start) = YEAR(getdate()) and s_id='2' ) as a
                                            group by badgenr
                                            having count(distinct(aanvraagnr)) > 1) and s_id='3' 
                                            and r_tijd_start = '".$row1['r_tijd_start']."'  
                                            and r_tijd_eind='".$row1['r_tijd_eind']."' 
                                            order by r_id";

            $stmt2 = $db->prepare($query);
            $stmt2->execute();
            $row2 = $stmt2->fetch();
            if(!empty($row2)) {
                //stap 3
                $query1 = "update reservaties set s_id='2' ,updated_by= '30', updated_at=GETDATE()  WHERE r_id='" . $row2['r_id'] . "'";
                $resultset1 = $db->query($query1);
                $msg = " van " . $row2['r_tijd_start'] . " tot " . $row2['r_tijd_eind'] ." voor woning ".getLocatie($db,$row2['w_id']);
                sendEmail("Uw aanvraag ".$msg." is goedgekeurd en vanuit de wachtlijst weggehaald!", getEmailPDO($mis_connPDO,$row2['created_by']), "");

            }

            //stap 4
            $query = "update reservaties set s_id='1',updated_by = '".getAppUserId()."', updated_at=GETDATE()  WHERE r_id='" . $_GET[id] . "'";
            $resultset = $db->query($query);
            header('Location: administratie.php?msg=updated');
            exit();
        }
        break;

    case 'annuleringWachtlijst':
        if (isset($_GET['id'])) {

            $query = "update reservaties set s_id='1', updated_by = '".getAppUserId()."', updated_at=GETDATE() WHERE r_id='" . $_GET[id] . "'";
            $resultset = $db->query($query);
            sendEmail("Uw aanvraag is geannuleerd!",$_SESSION['mis']['user']['email'],"");
            header('Location: administratie.php?msg=updated');
            exit();
        }
        break;

}


?>