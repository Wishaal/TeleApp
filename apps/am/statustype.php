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
include('domain/Statustype.php');

switch ($action) {

    default:
    case 'overview':

        break;

    case 'new';
        Statustype::create($input->all());
        $msg = 'saved';
        break;

    case 'update';
        $Statustype = Statustype::find($_GET['recordId']);
        $Statustype->fill($input->all());
        $Statustype->save();
        $msg = 'updated';
        break;

    case 'delete';
        $Statustype = Statustype::find($_GET['id']);
        $Statustype->delete();

        $msg = 'deleted';
        break;

}
$Statustypeen = Statustype::all();
$templatefilenaam = 'tmpl/statustype.tpl.php';
if (file_exists($templatefilenaam)) {
    require_once($templatefilenaam);
} else {
    die('File does NOT exists');
}
?>