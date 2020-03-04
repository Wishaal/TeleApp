<?php
include('php/database.php');
$menuid = menu;
//global includes
require_once('../../php/conf/config.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
        $emailGroup = EmailGroup::create($input->all());
        $array = explode(',', $input->get('members'));
        $emailGroup->Users()->sync($array);
        //$emailGroup->id;
        $msg = 'saved';
        break;

    case 'update';
        $emailGroup = EmailGroup::find($_GET['recordId']);
        $array = explode(',', $input->get('members'));
        $emailGroup->Users()->sync($array);
        $emailGroup->fill($input->all());
        $emailGroup->save();
        $msg = 'updated';
        break;

    case 'delete';
        $user = EmailGroup::find($_GET['id']);
        $user->Users()->detach();
        $user->delete();

        $msg = 'deleted';
        break;

}
$groups = EmailGroup::all();
require_once('tmpl/emailgroups.tpl.php');

?>