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


$records = pdoquerySelect($db, "SELECT * FROM reservaties where aanvraagnr = 'NR20171110084551000000'");

foreach ($records as $r) {
    $msgEmail.= "<li>" . $r['r_tijd_start'] . " tot " . $r['r_tijd_eind']." voor woning ".getLocatie($db,$r['w_id'])."</li>";
}
$exMessage = ", u bent op de wachtlijst geplaatst!";

$query = "update reservaties set s_id='3' WHERE aanvraagnr='NR20171110084551000000'";
$resultset = $db->query($query);

sendEmail("Bedankt voor uw reservering van vakantiewoning in de periode <br><ul>" . $msgEmail . " </ul>" . $exMessage, "Alan.TsengChingLien@telesur.sr", "wishaal.mathoera@telesur.sr");
