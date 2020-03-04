<?php
	$menuid = 1494;

	require_once('../../php/conf/config.php');
	require_once('../../inc_topnav.php');
	require_once('../../inc_sidebar.php');

	//logic goes here

$action = 'overview';
if(isset($_GET['action'])){
	$action = $_GET['action'];
}


switch($action){

	default:
	case 'overview':

	require_once('tmpl/index.tpl.php');

	break;


}

	
?>