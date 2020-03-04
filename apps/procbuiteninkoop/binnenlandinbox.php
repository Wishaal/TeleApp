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

#ini_set('display_errors', 1);
#ini_set('display_startup_errors', 1);
#error_reporting(E_ALL);

$action = 'overview';
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

switch ($action) {

    default:
    case 'overview':

        break;

    case 'new';
        $aanvraag = BinnenlandseInkoop::create($input->all());
        $_GET['recordId'] = $aanvraag->aanvraag_id;
        include "includes/binnenlandFileUpload.php";

        $msg = 'saved';
        break;

    case 'update';

        $buiten = BinnenlandseInkoop::firstOrNew(array('aanvraag_id' => $_GET['recordId']));

        $ontvangst = Ontvangst::firstOrNew(array('aanvraag_id' => $_GET['recordId']));
        $ontvangst->save();
//		//deelbetalingen
//		$betalingsvoorwaarden = $input->input('betalingsvoorwaarden');
//		$bedrag = $input->input('bedrag');
//		$status = $input->input('status');
//
//		$sync_data = [];
//		for($i = 0; $i < count($betalingsvoorwaarden); $i++){
//			$sync_data[] =  ['aanvraag_id' => $buiten->aanvraag_id,'betalingsvoorwaarden_id' => $betalingsvoorwaarden[$i],'bedrag' => $bedrag[$i],'status_id' => $status[$i]];
//		}
//		//print_r($sync_data);
//		$buiten->deelbetalingen()->detach();
//		$buiten->deelbetalingen()->sync($sync_data,false);

//		//deellevering
//		$aantallen = $input->input('aantal');
//		$opmerkingen = $input->input('opmerking');
//
//		$sync_data_levering = [];
//		for($i = 0; $i < count($aantallen); $i++){
//			$sync_data_levering[] =  ['aanvraag_id' => $buiten->aanvraag_id,'aantal' => $aantallen[$i],'opmerking' => $opmerkingen[$i]];
//		}
//		//print_r($sync_data);
//		$buiten->deellevering()->detach();
//		$buiten->deellevering()->sync($sync_data_levering);

        include "includes/binnenlandFileUpload.php";

        $buiten->fill($input->all());
        $buiten->save();
        if ($input->input('inbver_doorsturen') == 'Ja') {
            $status = AanvraagStatus::whereAanvraagId($_GET['recordId'])->first();
            $status->status_id = "7";
            $status->save();
        }
        $msg = 'updated';
        break;

    case 'delete';
        $bestelling = Bestelling::whereAanvraagNr($_GET['id'])->first();
        //echo $bestelling->id;
        $buiten = BinnenlandseInkoop::whereAanvraagId($bestelling->id)->first();
        $buiten->delete();

        $msg = 'deleted';
        break;

}
$user = User::where('username', 'like', getAppUserName())->first();
$buiten = AanvraagStatus::whereUserId($user->id)
    ->whereType(0)
    ->whereStatusId(8)
    ->get();

$buitenAll = AanvraagStatus::whereType(0)
    ->whereStatusId(8)
    ->get();

require_once('tmpl/binnenlandinbox.tpl.php');
