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
        Shipping::create($input->all());
        $msg = 'saved';
        break;

    case 'update';
        $shipping = Shipping::find($_GET['recordId']);
        $shipping->fill($input->all());
        $shipping->save();
        $msg = 'updated';
        break;

    case 'delete';
        $shipping = Shipping::find($_GET['id']);
        $shipping->delete();

        $msg = 'deleted';
        break;

}
$shipping = Shipping::all();
require_once('tmpl/shipping.tpl.php');

?>