<?php

require_once('../../php/conf/config.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('php/config.php');

$error = array();
$status = array();

$dates = '01/01/2018 - 01/03/2018';
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

foreach ($period as $dt) {
    $date = DateTime::createFromFormat('Y-m-d', $dt->format("Y-m-d"));
    $date->modify('+1 day');
    $stmt = $db->prepare("SELECT count(*) as aantal  FROM [woningenVerhuur].[dbo].[reservaties] where w_id='" . $wid . "' and r_tijd_start='" . $dt->format("Y-m-d" . " 08:00:00") . "' and r_tijd_eind='" . $date->format("Y-m-d" . " 08:00:00") . "' and s_id in (2,3)");
    $stmt->execute();
    $row = $stmt->fetch();

    echo $dt->format("Y-m-d");
}

