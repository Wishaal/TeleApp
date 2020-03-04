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
include('domain/Categorie.php');

switch ($action) {

    default:
    case 'overview':

        break;

    case 'new';
        Categorie::create($input->all());
        $msg = 'saved';
        break;

    case 'update';
        $Categorie = Categorie::find($_GET['recordId']);
        $Categorie->fill($input->all());
        $Categorie->save();
        $msg = 'updated';
        break;

    case 'delete';
        $Categorie = Categorie::find($_GET['id']);
        $Categorie->delete();

        $msg = 'deleted';
        break;

}
$Categorieen = Categorie::all();
$templatefilenaam = 'tmpl/categorie.tpl.php';
if (file_exists($templatefilenaam)) {
    require_once($templatefilenaam);
} else {
    die('File does NOT exists');
}
?>