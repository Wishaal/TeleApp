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

        $error = array();

        include "includes/buitenlandFileUpload.php";

        if (!empty($_POST['bedrag'])) {
            $koers = Koers::orderBy('datum', 'DESC')->first();
            $input->merge(array('datumomrekeningsfactor' => $koers->datum));
            $input->merge(array('Tussenkoers' => $koers->omrekeningskoers));
        }
        BuitenlandseInkoop::create($input->all());
        $msg = 'saved';
        break;

    case 'update';

        $error = array();

        $buiten = BuitenlandseInkoop::firstOrNew(array('aanvraag_id' => $_GET['recordId']));
        $ontvangst = Ontvangst::firstOrNew(array('aanvraag_id' => $_GET['recordId']));
        $ontvangst->save();

        //echo var_dump($input->input('deel_bo_datum'));

        //deelbetalingen
        $betalingsvoorwaarden = $input->input('betalingsvoorwaardenArray');
        $bedrag = $input->input('bedrag_deel');
        $status = $input->input('status');
        $deel_bo_nummer = $input->input('deel_bo_nummer');
        $deel_bo_datum = $input->input('deel_bo_datum');
        $deel_valuta = $input->input('deel_valuta');

        if ($bedrag[0] != '') {
            $sync_data = [];
            for ($i = 0; $i < count($betalingsvoorwaarden); $i++) {
                $sync_data[] = ['aanvraag_id' => $buiten->aanvraag_id, 'deel_bo_nummer' => $deel_bo_nummer[$i], 'deel_bo_datum' => $deel_bo_datum[$i], 'betalingsvoorwaarden_id' => $betalingsvoorwaarden[$i], 'deel_valuta' => $deel_valuta[$i], 'bedrag_deel' => $bedrag[$i], 'status_id' => $status[$i]];
            }
            //print_r($sync_data);
            $buiten->deelbetalingen()->detach();
            $buiten->deelbetalingen()->sync($sync_data);
        }


        //deellevering
        $aantallen = $input->input('aantal');
        $opmerkingen = $input->input('opmerking');

        if ($aantallen[0] != '') {

            $sync_data_levering = [];
            for ($i = 0; $i < count($aantallen); $i++) {
                $sync_data_levering[] = ['aanvraag_id' => $buiten->aanvraag_id, 'aantal' => $aantallen[$i], 'opmerking' => $opmerkingen[$i]];
            }
            //print_r($sync_data);
            $buiten->deellevering()->detach();
            $buiten->deellevering()->sync($sync_data_levering);
        }


        include "includes/buitenlandFileUpload.php";

        if (!empty($_POST['bedrag'])) {
            $koers = Koers::orderBy('datum', 'DESC')->first();
            $input->merge(array('datumomrekeningsfactor' => $koers->datum));
            $input->merge(array('Tussenkoers' => $koers->omrekeningskoers));
        }

        $buiten->fill($input->all());
        $buiten->save();

        if ($input->input('doorsturen') == 'Ja') {
            $status = AanvraagStatus::whereAanvraagId($_GET['recordId'])->first();
            $status->status_id = "7";
            $status->save();
        }

        $msg = 'updated';
        break;

    case 'delete';
        $bestelling = Bestelling::whereAanvraagNr($_GET['id'])->first();
        //echo $bestelling->id;
        $buiten = BuitenlandseInkoop::whereAanvraagId($bestelling->id)->first();
        $buiten->delete();

        $msg = 'deleted';
        break;

}
$user = User::where('username', 'like', getAppUserName())->first();
$buiten = AanvraagStatus::whereUserId($user->id)
    ->whereType(1)
    ->whereStatusId(8)
    ->get();

$buitenAll = AanvraagStatus::whereType(1)
    ->whereStatusId(8)
    ->get();

require_once('tmpl/buitenlandseinkoop.tpl.php');
