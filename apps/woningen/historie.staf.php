<?php
$menuid = 1494;

require_once('../../php/conf/config.php');
require_once('../../inc_topnav.php');
require_once('../../inc_sidebar.php');

//	ini_set('display_errors', 1);
//	ini_set('display_startup_errors', 1);
//	error_reporting(E_ALL);

require_once('php/config.php');
//logic goes here


$action = 'overview';
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

switch ($action) {

    default:
    case 'overview':


        $historie = getHistoryAdmin($db);


        require_once('tmpl/historie.staf.tpl.php');

        break;
}


?>