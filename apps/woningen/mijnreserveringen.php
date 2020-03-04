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

        $historie = getHistory($db);
        $wachtlijsInfos = getWachtlijstInfos($db);
        $reserveringen = getReserveringen($db);

        require_once('tmpl/woningen.tpl.php');

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
            sendEmail("Uw aanvraag is geannuleerd!",$_SESSION['mis']['user']['email'],"");
            header('Location: mijnreserveringen.php?msg=updated');
            exit();

        }
        break;

        case 'annuleringWachtlijst':
        if (isset($_GET['id'])) {

            $query = "update reservaties set s_id='1', updated_by = '".getAppUserId()."', updated_at=GETDATE() WHERE r_id='" . $_GET[id] . "'";
            $resultset = $db->query($query);
            sendEmail("Uw aanvraag is geannuleerd!",$_SESSION['mis']['user']['email'],"");
            header('Location: mijnreserveringen.php?msg=updated');
            exit();
        }
        break;

}


?>