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
include('domain/Personeel.php');

switch ($action) {

    default:
    case 'overview':

        break;

    case 'new';
        Personeel::create($input->all());
        $msg = 'saved';
        break;

    case 'update';
        $Personeel = Personeel::find($_GET['recordId']);
        $Personeel->fill($input->all());
        $Personeel->save();
        $msg = 'updated';
        break;

    case 'delete';
        $Personeel = Personeel::find($_GET['id']);
        $Personeel->delete();

        $msg = 'deleted';
        break;

}
$Personeelen = Personeel::all();
$templatefilenaam = 'tmpl/personeel.tpl.php';
if (file_exists($templatefilenaam)) {
    require_once($templatefilenaam);
} else {
    die('File does NOT exists');
}
?>