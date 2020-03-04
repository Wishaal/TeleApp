<?php
include('php/database.php');
$menuid = menu;
//global includes
require_once('../../php/conf/config.php');
include('php/includes.php');
require_once('../../inc_topnav.php');
require_once('../../inc_sidebar.php');

#ini_set('display_errors', 1);
#ini_set('display_startup_errors', 1);
#error_reporting(E_ALL);

//logic goes here

$action = 'overview';
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}


switch ($action) {

    default:
    case 'overview':

        require_once('tmpl/index.tpl.php');

        break;


}


?>