<?php
include('php/config.php');

$menuid = menu;

require_once('../../php/conf/config.php');
require_once('../../inc_topnav.php');
require_once('../../inc_sidebar.php');

//error_reporting(E_ALL);
//ini_set("display_errors", 1);

$action = 'overview';
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}
//add domain
include('domain/Artikel.php');

switch ($action) {

    default:
    case 'overview':

        break;

    case 'new';
        Artikel::create($input->all());
        $msg = 'saved';
        break;

    case 'update';
        $Artikel = Artikel::find($_GET['recordId']);
        $Artikel->fill($input->all());
        $Artikel->save();
        $msg = 'updated';
        break;

    case 'delete';
        $Artikel = Artikel::find($_GET['id']);
        $Artikel->delete();

        $msg = 'deleted';
        break;

}
$Artikelen = Artikel::all();
$templatefilenaam = 'tmpl/artikel.tpl.php';
if (file_exists($templatefilenaam)) {
    require_once($templatefilenaam);
} else {
    die('File does NOT exists');
}
?>