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
//add domain
include('domain/Aanvragennr.php');

switch ($action) {

    default:
    case 'overview':

        break;

    case 'new';
        Aanvragennr::create($input->all());
        $msg = 'saved';
        break;

    case 'update';
        $Aanvragennr = Aanvragennr::find($_GET['recordId']);
        $Aanvragennr->fill($input->all());
        $Aanvragennr->save();
        $msg = 'updated';
        break;

    case 'delete';
        $Aanvragennr = Aanvragennr::find($_GET['id']);
        $Aanvragennr->delete();

        $msg = 'deleted';
        break;

}
$Projecten = Aanvragennr::all();
$templatefilenaam = 'tmpl/aanvragennr.tpl.php';
if (file_exists($templatefilenaam)) {
    require_once($templatefilenaam);
} else {
    die('File does NOT exists');
}
?>