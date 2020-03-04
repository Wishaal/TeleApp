<?php

include('php/database.php');
$menuid = menu;
require_once('../../php/conf/config.php');
require_once('../../inc_topnav.php');
require_once('../../inc_sidebar.php');


//logic goes here
require_once('php/includes.php');
use Illuminate\Database\Query\Expression as raw;

//Action get list
$action = 'overview';
if(isset($_GET['action'])){
    $action = $_GET['action'];
}
switch($action){

    default:
    case 'overview':

    unset($_SESSION['wifi']['datum1']);
    unset($_SESSION['wifi']['datum2']);
    unset($_SESSION['wifi']['locatie']);
    $locations = Sessions::distinct()->get(['location']);
    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        $date = date("Y-m-d", strtotime("-1 week"));
        $data = Sessions::select(new raw("location,count(*) as totaal"), new raw("DATE(created_at) dag"))
            ->whereBetween('created_at', array($_POST['datum1'].' 00:00:00', $_POST['datum2'].' 23:59:59'))
            ->where('location','=',$_POST['location'])
            ->groupBy('dag')
            ->groupBy('location')
            ->get();

        $dataTable = Sessions::select('client_mac','client_ip','location','mobile','created_at')
            ->whereBetween('created_at', array($_POST['datum1'].' 00:00:00', $_POST['datum2'].' 23:59:59'))
            ->where('location','=',$_POST['location'])
            ->get();

        $_SESSION['wifi']['datum1'] = $_POST['datum1'];
        $_SESSION['wifi']['datum2'] = $_POST['datum2'];
        $_SESSION['wifi']['locatie'] = $_POST['location'];
    }
        //'" . $_POST['datum1'] . "' and '" . $_POST['datum2'] . "'
        require_once('tmpl/detail.tpl.php');

    break;

}
?>