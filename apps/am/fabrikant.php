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
include('domain/Fabrikant.php');

switch ($action) {

    default:
    case 'overview':

        break;

    case 'new';
        Fabrikant::create($input->all());
        $msg = 'saved';
        break;

    case 'update';
        $Fabrikant = Fabrikant::find($_GET['recordId']);
        $Fabrikant->fill($input->all());
        $Fabrikant->save();
        $msg = 'updated';
        break;

    case 'delete';
        $Fabrikant = Fabrikant::find($_GET['id']);
        $Fabrikant->delete();

        $msg = 'deleted';
        break;

}
$Fabrikanten = Fabrikant::all();
$templatefilenaam = 'tmpl/fabrikant.tpl.php';
if (file_exists($templatefilenaam)) {
    require_once($templatefilenaam);
} else {
    die('File does NOT exists');
}
?>