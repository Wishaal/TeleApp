<?php

include('php/database.php');

$menuid = menu;
//global includes
require_once('../../php/conf/config.php');
include('php/includes.php');
require_once('../../inc_topnav.php');
require_once('../../inc_sidebar.php');
require_once('php/includes.php');
include('php/functions.php');
//logic goes here

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

$action = 'overview';
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

switch ($action) {

    default:
    case 'overview':

        break;

    case 'update';

        $error = array();

        $buiten = BuitenlandseInkoop::whereAanvraagId($_GET['recordId'])->first();

        $ontvangst = Ontvangst::firstOrCreate(['id' => $_GET['recordId']]);

        //echo var_dump($input->input('deel_bo_datum'));

        include "includes/buitenlandFileUpload.php";

        if (!empty($_POST['bedrag'])) {
            $koers = Koers::orderBy('datum', 'DESC')->first();
            $input->merge(array('datumomrekeningsfactor' => $koers->datum));
            $input->merge(array('Tussenkoers' => $koers->omrekeningskoers));
        }


        $buiten->fill($input->all());
        $ontvangst->fill($input->all());
        $buiten->save();
        $ontvangst->save();
        $msg = 'updated';
        break;

}
//$user = User::where('username','like',getAppUserName())->first();
//$buiten= BuitenlandseInkoop::whereAanvraagId($_GET['recordId'])->first();
//$buiten = AanvraagStatus::whereType(1)
//    ->get();

$buiten = BuitenlandseInkoop::whereShippingDate('0000-00-00')
    ->orWhere('shipped_from', '=', '')
    ->orWhere('shipped_from', '=', NULL)
    ->orWhere('shipping_method', '=', '0')
    ->orWhere('shipping_method', '=', '')
    ->orWhere('bo', '=', '0000-00-00')
    ->get();
//echo $buiten;
require_once('tmpl/shipper_inbox.tpl.php');
