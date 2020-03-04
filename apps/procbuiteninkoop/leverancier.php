<?php
include('php/database.php');
$menuid = menu;
//global includes
require_once('../../php/conf/config.php');
require_once('php/includes.php');

require_once('../../inc_topnav.php');
require_once('../../inc_sidebar.php');


$action = 'overview';
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

switch ($action) {

    default:
    case 'overview':

        break;

    case 'new';
        Leverancier::create($input->all());
        $msg = 'saved';
        break;

    case 'update';
        $leverancier = Leverancier::find($_GET['recordId']);
        $leverancier->fill($input->all());
        $leverancier->save();
        $msg = 'updated';
        break;

    case 'delete';
        $leverancier = Leverancier::find($_GET['id']);
        $leverancier->delete();

        $msg = 'deleted';
        break;

}
$leverancier = Leverancier::all();
require_once('tmpl/leverancier.tpl.php');

?>