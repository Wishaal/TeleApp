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
        Role::create($input->all());
        $msg = 'saved';
        break;

    case 'update';
        $Role = Role::find($_GET['recordId']);
        $Role->fill($input->all());
        $Role->save();
        $msg = 'updated';
        break;

    case 'delete';
        $Role = Role::find($_GET['id']);
        $Role->delete();

        $msg = 'deleted';
        break;

}
$roles = Role::all();
require_once('tmpl/rollen.tpl.php');

?>