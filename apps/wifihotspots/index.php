<?php
include('php/database.php');
$menuid = menu;


require_once('../../php/conf/config.php');
require_once('../../inc_topnav.php');
require_once('../../inc_sidebar.php');

//logic goes here
require_once('php/includes.php');

use Illuminate\Database\Query\Expression as raw;

//Action get list/
$action = 'overview';
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}
switch ($action) {

    default:
    case 'overview':
        $date = date("Y-m-d", strtotime("-1 week"));
        $data = Sessions::select(new raw("location,count(*) as totaal"), new raw("DATE(created_at) dag"))
            ->where('created_at', '>', $date . ' 00:00:00')
            ->groupBy('dag')
            ->groupBy('location')
            ->get();
        require_once('tmpl/index.tpl.php');
        break;

}
?>