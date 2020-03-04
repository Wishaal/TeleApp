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
include('domain/Project.php');

switch ($action) {

    default:
    case 'overview':

        break;

    case 'new';
        Project::create($input->all());
        $msg = 'saved';
        break;

    case 'update';
        $Project = Project::find($_GET['recordId']);
        $Project->fill($input->all());
        $Project->save();
        $msg = 'updated';
        break;

    case 'delete';
        $Project = Project::find($_GET['id']);
        $Project->delete();

        $msg = 'deleted';
        break;

}
$Projecten = Project::all();
$templatefilenaam = 'tmpl/project.tpl.php';
if (file_exists($templatefilenaam)) {
    require_once($templatefilenaam);
} else {
    die('File does NOT exists');
}
?>