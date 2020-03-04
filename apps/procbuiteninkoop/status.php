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
        Status::create($input->all());
        $msg = 'saved';
        break;

    case 'update';
        $status = Status::find($_GET['recordId']);
        $status->fill($input->all());
        $status->save();
        $msg = 'updated';
        break;

    case 'delete';
        $status = Status::find($_GET['id']);
        $status->delete();

        $msg = 'deleted';
        break;

}
$status = Status::all();
require_once('tmpl/status.tpl.php');

?>