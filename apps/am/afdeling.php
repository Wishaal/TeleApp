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
include('domain/Afdeling.php');

switch ($action) {

    default:
    case 'overview':

        break;

    case 'new';
        Afdeling::create($input->all());
        $msg = 'saved';
        break;

    case 'update';
        $Afdeling = Afdeling::find($_GET['recordId']);
        $Afdeling->fill($input->all());
        $Afdeling->save();
        $msg = 'updated';
        break;

    case 'delete';
        $Afdeling = Afdeling::find($_GET['id']);
        $Afdeling->delete();

        $msg = 'deleted';
        break;

}
$Afdelingen = Afdeling::all();
$templatefilenaam = 'tmpl/afdeling.tpl.php';
if (file_exists($templatefilenaam)) {
    require_once($templatefilenaam);
} else {
    die('File does NOT exists');
}
?>