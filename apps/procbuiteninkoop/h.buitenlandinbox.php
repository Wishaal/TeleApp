<?php
include('php/database.php');
$menuid = menu;
//global includes
require_once('../../php/conf/config.php');
require_once('php/includes.php');
require_once('php/functions.php');
require_once('../../inc_topnav.php');
require_once('../../inc_sidebar.php');


$buiten = AanvraagStatus::whereType(1)
    ->get();

require_once('tmpl/historie/h.buitenlandinbox.tpl.php');

?>