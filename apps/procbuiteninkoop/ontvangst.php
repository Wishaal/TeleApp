<?php
include('php/database.php');
$menuid = menu;
//global includes
require_once('../../php/conf/config.php');

require_once('../../inc_topnav.php');
require_once('../../inc_sidebar.php');
require_once('php/includes.php');
include('php/functions.php');

$action = 'overview';
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

switch ($action) {

    default:
    case 'overview':

        break;

    case 'new';
        Ontvangst::create($input->all());
        $msg = 'saved';
        break;

    case 'update';

        $ontvangst = Ontvangst::firstOrCreate(['id' => $_GET['recordId']]);

        $bestelling = Bestelling::find($input->input('aanvraag_id'));

        $artikelcode = $input->input('ontv_artikelcode');
        $artikelomschrijving = $input->input('ontv_artikel_omschrijving');
        $besteld = $input->input('inbver_aantal');
        $ontvangen = $input->input('ontv_aantal');
        $verschil = $ontvangen - $besteld;
        $deellevering = $input->input('ontv_deellevering');
        $bestelnr = $input->input('inbver_bestelbonnr');
        $opmerking = $input->input('ontv_opmerkingen');

        if ($input->input('ontv_voorbereider') == 'Accoord') {

            $input->merge(array('ontv_keuring' => 'Goedgekeurd'));
            $add = EmailGroup::whereName('ONTVANGST_VOORBEREIDER')->first(); // get group name id
            $mailadress = EmailUser::whereEmailGroupId($add->id)->get(); //get users array
            $aanvraagnremail = $bestelling->aanvraag_nr; //set aanvraag nummer
            require_once 'templates/email/ontvangst_voorbereider_accoord.template.php'; //accoord template
            sendEmail($mailadress, null, 'Voorbereider: Nieuw goedgekeurde ontvangst!', $html, null); //send mail function
        } elseif ($input->input('ontv_voorbereider') == 'Geen Accoord') {
            $add = EmailGroup::whereName('ONTVANGST_VOORBEREIDER')->first(); // get group name id
            $mailadress = EmailUser::whereEmailGroupId($add->id)->get(); //get users array
            $opmerking = $input->input('bstl_voorbereider_opmerking');
            $aanvraagnremail = $bestelling->aanvraag_nr; //set aanvraag nummer
            require_once 'templates/email/ontvangst_voorbereider_niet_accoord.template.php'; //accoord template
            sendEmail($mailadress, null, 'Voorbereider: Nieuw Afgekeurde ontvangst!', $html, null); //send mail function
        }
        if ($input->input('ontv_administratie') == 'Accoord') {
            $add = EmailGroup::whereName('ONTVANGST_ADMINISTRATIE')->first(); // get group name id
            $mailadress = EmailUser::whereEmailGroupId($add->id)->get(); //get users array
            $aanvraagnremail = $bestelling->aanvraag_nr; //set aanvraag nummer
            require_once 'templates/email/ontvangst_cologistiek_accoord.template.php'; //accoord template
            sendEmail($mailadress, null, 'Administratie: Nieuw goedgekeurde ontvangst!', $html, null); //send mail function

        } elseif ($input->input('ontv_administratie') == 'Geen Accoord') {
            $input->merge(array('ontv_administratie' => 'Geen Accoord'));
            $add = EmailGroup::whereName('ONTVANGST_ADMINISTRATIE')->first(); // get group name id
            $mailadress = EmailUser::whereEmailGroupId($add->id)->get(); //get users array
            $aanvraagnremail = $bestelling->aanvraag_nr; //set aanvraag nummer
            require_once 'templates/email/ontvangst_voorbereider_niet_accoord.template.php'; //accoord template
            sendEmail($mailadress, null, 'Administratie: Nieuw afgekeurde ontvangst!', $html, null); //send mail function
        }
        if ($input->input('ontv_hoofd_inventory') == 'Accoord') {
            $add = EmailGroup::whereName('ONTVANGST_CO')->first(); // get group name id
            $mailadress = EmailUser::whereEmailGroupId($add->id)->get(); //get users array
            $aanvraagnremail = $bestelling->aanvraag_nr; //set aanvraag nummer
            require_once 'templates/email/ontvangst_accoord.template.php'; //accoord template
            sendEmail($mailadress, null, 'Nieuw goedgekeurde ontvangst!', $html, null); //send mail function

            $status = AanvraagStatus::whereAanvraagId($bestelling->id)->first();
            $status->status_id = "9";
            $status->save();


        } elseif ($input->input('ontv_hoofd_inventory') == 'Geen Accoord') {
            $input->merge(array('ontv_co_logistiek' => 'Geen Accoord'));
            $add = EmailGroup::whereName('ONTVANGST_CO')->first(); // get group name id
            $mailadress = EmailUser::whereEmailGroupId($add->id)->get(); //get users array
            $aanvraagnremail = $bestelling->aanvraag_nr; //set aanvraag nummer
            require_once 'templates/email/ontvangst_voorbereider_niet_accoord.template.php'; //accoord template
            sendEmail($mailadress, null, 'Hoofd Inventory: Nieuw afgekeurde ontvangst!', $html, null); //send mail function
        }

        //deellevering
        $aantallen = $input->input('aantal');
        $opmerkingen = $input->input('opmerking');
        $datum = $input->input('datum');

        $sync_data_levering = [];
        for ($i = 0; $i < count($aantallen); $i++) {
            $sync_data_levering[] = ['aanvraag_id' => $bestelling->id, 'aantal' => $aantallen[$i], 'opmerking' => $opmerkingen[$i], 'datum' => $datum[$i]];
        }
        //print_r($sync_data);
        $ontvangst->deellevering()->detach();
        $ontvangst->deellevering()->sync($sync_data_levering);


        $ontvangst->fill($input->all());
        $ontvangst->save();

        include "includes/ontvangstFileUpload.php";

        if (!empty($input->input('ontv_oronr'))) {

            if ($_GET['type'] == '1') {

                $buitenland = BuitenlandseInkoop::whereAanvraagId($bestelling->id)->first();
                $buitenland->ingeklaard_oro_nummer = $input->input('ontv_oronr');
                $buitenland->save();
            }

        }

        $msg = 'updated';
        break;

    case 'delete';
        $bestelling = Ontvangst::find($_GET['id']);
        $bestelling->delete();

        $msg = 'deleted';
        break;

}


if (getInkoopPermisson('Voorbereider')) {
    $binnen = Ontvangst::whereHas('aanvraagStatus', function ($query) {
        $query->whereType(0);
        $query->whereStatusId(7);
        $query->where('ontvangst.ontv_voorbereider', '!=', 'Accoord');
        $query->orWhereNull('ontvangst.ontv_voorbereider');
    })->get();

    $buiten = Ontvangst::whereHas('aanvraagStatus', function ($query) {
        $query->whereType(1);
        $query->whereStatusId(7);
        $query->where('ontvangst.ontv_voorbereider', '!=', 'Accoord');
        $query->orWhereNull('ontvangst.ontv_voorbereider');
    })->get();

} elseif (getInkoopPermisson('Administratie')) {
    $binnen = Ontvangst::whereHas('aanvraagStatus', function ($query) {
        $query->whereType(0);
        $query->whereStatusId(7);
        $query->where('ontv_voorbereider', '=', 'Accoord');
        $query->where('ontv_administratie', '<>', 'Accoord');
        $query->orWhereNull('ontv_administratie');
    })->get();

    $buiten = Ontvangst::whereHas('aanvraagStatus', function ($query) {
        $query->whereType(1);
        $query->whereStatusId(7);
        $query->where('ontv_voorbereider', '=', 'Accoord');
        $query->where('ontv_administratie', '<>', 'Accoord');
        $query->orWhereNull('ontv_administratie');
    })->get();
} elseif (getInkoopPermisson('Hoofd Inventory')) {
    $binnen = Ontvangst::whereHas('aanvraagStatus', function ($query) {
        $query->whereType(0);
        $query->whereStatusId(7);
        $query->where('ontv_voorbereider', '=', 'Accoord');
        $query->where('ontv_administratie', '=', 'Accoord');
        $query->where('ontv_hoofd_inventory', '<>', 'Accoord');
        $query->orWhere('ontv_hoofd_inventory', '=', null);
        $query->orWhere('ontv_hoofd_inventory', '=', 'Geen Accoord');
    })->get();

    $buiten = Ontvangst::whereHas('aanvraagStatus', function ($query) {
        $query->whereType(1);
        $query->whereStatusId(7);
        $query->where('ontv_voorbereider', '=', 'Accoord');
        $query->where('ontv_administratie', '=', 'Accoord');
        $query->where('ontv_hoofd_inventory', '<>', 'Accoord');
        $query->orWhere('ontv_hoofd_inventory', '=', null);
        $query->orWhere('ontv_hoofd_inventory', '=', 'Geen Accoord');
    })->get();
}

$ontvangst = Ontvangst::all();

require_once('tmpl/ontvangst.tpl.php');

?>