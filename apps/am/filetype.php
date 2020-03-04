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
include('domain/Filetype.php');

switch ($action) {

    default:
    case 'overview':

        break;

    case 'new';
        Filetypen::create($input->all());
        $msg = 'saved';
        break;

    case 'update';
        $Filetype = Filetypen::find($_GET['recordId']);
        $Filetype->fill($input->all());
        $Filetype->save();
        $msg = 'updated';
        break;

    case 'delete';
        $Filetype = Filetypen::find($_GET['id']);
        $Filetype->delete();

        $msg = 'deleted';
        break;

}
$Filetypeen = Filetypen::all();
$templatefilenaam = 'tmpl/filetype.tpl.php';
if (file_exists($templatefilenaam)) {
    require_once($templatefilenaam);
} else {
    die('File does NOT exists');
}
?>