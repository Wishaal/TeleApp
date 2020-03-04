<?php
include('php/database.php');
$menuid = menu;
//global includes
require_once('../../php/conf/config.php');

require_once('../../inc_topnav.php');
require_once('../../inc_sidebar.php');
require_once('php/includes.php');
include('php/functions.php');

$ontvangst = Ontvangst::all();
$binnen = AanvraagStatus::whereType(0)
    ->whereStatusId(7)
    ->get();

$buiten = AanvraagStatus::whereType(1)
    ->whereStatusId(7)
    ->get();
require_once('tmpl/historie/h.ontvangst.tpl.php');

?>