<?php
include('php/database.php');
$menuid = menu;
//global includes
require_once('../../php/conf/config.php');

require_once('php/includes.php');
require_once('php/functions.php');
require_once('../../inc_topnav.php');
require_once('../../inc_sidebar.php');


$action = 'overview';
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

switch ($action) {

    default:
    case 'overview':

        break;

    case 'new';
        $user = User::create($input->all());
        $tags = $input->input('rollen');

        $user->userRollen()->sync($tags);
        $msg = 'saved';
        break;

    case 'update';
        $user = User::find($_GET['recordId']);
        $tags = $input->input('rollen');

        $user->userRollen()->sync($tags);
        $user->fill($input->all());
        $user->save();
        $msg = 'updated';
        break;

    case 'delete';
        $user = User::find($_GET['id']);
        $user->userRollen()->detach();
        $user->delete();

        $msg = 'deleted';
        break;

}
$users = User::all();
require_once('tmpl/users.tpl.php');

?>