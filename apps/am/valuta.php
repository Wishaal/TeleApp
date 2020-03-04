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
include('domain/Valuta.php');

switch ($action) {

    default:
    case 'overview':

        break;

    case 'new';
        Valuta::create($input->all());
        $msg = 'saved';
        break;

    case 'update';
        $Valuta = Valuta::find($_GET['recordId']);
        $Valuta->fill($input->all());
        $Valuta->save();
        $msg = 'updated';
        break;

    case 'delete';
        $Valuta = Valuta::find($_GET['id']);
        $Valuta->delete();

        $msg = 'deleted';
        break;

}
$Valutaen = Valuta::all();
$templatefilenaam = 'tmpl/valuta.tpl.php';
if (file_exists($templatefilenaam)) {
    require_once($templatefilenaam);
} else {
    die('File does NOT exists');
}
?>