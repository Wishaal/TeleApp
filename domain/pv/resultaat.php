<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

include 'includes.php';
//logic goes here

$action = 'overview';
if (isset($_POST['action'])) {
    $action = $_POST['action'];
}
$input = Illuminate\Http\Request::createFromGlobals();
switch ($action) {



    default:
    case 'overview':
        $Resultaten = JongerenKamp::all();
        require_once('tmpl/resultaat.tpl.php');
        break;


}


