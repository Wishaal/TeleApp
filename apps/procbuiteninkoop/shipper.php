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
        Shipper::create($input->all());
        $msg = 'saved';
        break;

    case 'update';
        $shipper = Shipper::find($_GET['recordId']);
        $shipper->fill($input->all());
        $shipper->save();
        $msg = 'updated';
        break;

    case 'delete';
        $shipper = Shipper::find($_GET['id']);
        $shipper->delete();

        $msg = 'deleted';
        break;

}
$shipper = Shipper::all();
require_once('tmpl/shipper.tpl.php');

?>