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
        Koers::create($input->all());
        $msg = 'saved';
        break;

    case 'update';
        $koers = Koers::find($_GET['recordId']);
        $koers->fill($input->all());
        $koers->save();
        $msg = 'updated';
        break;

    case 'delete';
        $koers = Koers::find($_GET['id']);
        $koers->delete();

        $msg = 'deleted';
        break;

}
$koers = Koers::all();
require_once('tmpl/koers.tpl.php');

?>