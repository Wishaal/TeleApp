<?php

include('php/config.php');
$menuid = menu;
	
require_once('../../php/conf/config.php');
require_once('../../inc_topnav.php');
require_once('../../inc_sidebar.php');


$action = 'overview';
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

switch ($action) {

    default:
    case 'overview':

        require_once('tmpl/am.tpl.php');

        break;

}

?>