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
        Afgifte::create($input->all());
        $msg = 'saved';
        break;

    case 'update';
        $afgifte = Afgifte::find($_GET['recordId']);
        $afgifte->fill($input->all());
        $afgifte->save();
        $msg = 'updated';
        break;

    case 'delete';
        $afgifte = Afgifte::find($_GET['id']);
        $afgifte->delete();

        $msg = 'deleted';
        break;

}
$afgifte = Afgifte::all();
require_once('tmpl/afgifte.tpl.php');

?>