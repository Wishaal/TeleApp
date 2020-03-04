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
include('domain/Leverancier.php');

switch ($action) {

    default:
    case 'overview':

        break;

    case 'new';
        Leverancier::create($input->all());
        $msg = 'saved';
        break;

    case 'update';
        $Leverancier = Leverancier::find($_GET['recordId']);
        $Leverancier->fill($input->all());
        $Leverancier->save();
        $msg = 'updated';
        break;

    case 'delete';
        $Leverancier = Leverancier::find($_GET['id']);
        $Leverancier->delete();

        $msg = 'deleted';
        break;

}
$Leverancieren = Leverancier::all();
$templatefilenaam = 'tmpl/leverancier.tpl.php';
if (file_exists($templatefilenaam)) {
    require_once($templatefilenaam);
} else {
    die('File does NOT exists');
}
?>