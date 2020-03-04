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
include('domain/District.php');

switch ($action) {

    default:
    case 'overview':

        break;

    case 'new';
        District::create($input->all());
        $msg = 'saved';
        break;

    case 'update';
        $District = District::find($_GET['recordId']);
        $District->fill($input->all());
        $District->save();
        $msg = 'updated';
        break;

    case 'delete';
        $District = District::find($_GET['id']);
        $District->delete();

        $msg = 'deleted';
        break;

}
$Districten = District::all();
$templatefilenaam = 'tmpl/district.tpl.php';
if (file_exists($templatefilenaam)) {
    require_once($templatefilenaam);
} else {
    die('File does NOT exists');
}
?>