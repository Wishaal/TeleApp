<?php
include('php/database.php');
$menuid = menu;
//global includes
require_once('../../php/conf/config.php');
require_once('php/includes.php');
require_once('php/functions.php');
require_once('../../inc_topnav.php');
require_once('../../inc_sidebar.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
        $afdelingaanvr = Afdelingaanvr::create($input->all());

        $msg = 'saved';

        break;

    case 'newitem';
        $aanvraagnr = generateAaanvraagNr();
        $input->merge(array('aanvraag_nr' => $aanvraagnr));
        $aanvraag = Bestelling::create($input->all());
        $omschrijving = null;
        if ($input->input('bstl_voorbereider') == 'Accoord') {
            $omschrijving = "Aanvraag gestart en direkt geaccordeerd!";
            $add = EmailGroup::whereName('AANVRAAG_VOORBEREIDER')->first(); // get group name id
            $mailadress = EmailUser::whereEmailGroupId($add->id)->get(); //get users array
            $aanvraagnremail = $aanvraag->aanvraag_nr; //set aanvraag nummer
            $artikelomschrijving = $aanvraag->artikelInfo->artikelomschrijving; //set artikel omschrijving
            require_once 'templates/email/aanvraag_voorbereider_accoord.template.php'; //accoord template
            sendEmail($mailadress, null, 'Voorbereider: Nieuw aanvraag ingevoerd!', $html, null); //send mail function
        } elseif ($input->input('bstl_voorbereider') == 'Geen Accoord') {
            $add = EmailGroup::whereName('AANVRAAG_VOORBEREIDER')->first(); // get group name id
            $mailadress = EmailUser::whereEmailGroupId($add->id)->get(); //get users array
            $opmerking = $input->input('bstl_voorbereider_opmerking');
            $aanvraagnremail = $aanvraag->aanvraag_nr; //set aanvraag nummer
            $artikelomschrijving = $aanvraag->artikelInfo->artikelomschrijving; //set artikel omschrijving
            require_once 'templates/email/aanvraag_voorbereider_niet_accoord.template.php'; //accoord template
            sendEmail($mailadress, null, 'Voorbereider: Nieuw Afgekeurde aanvraag!', $html, null); //send mail function
        }

        if (empty($omschrijving)) {
            $omschrijving = "Aanvraag gestart!";
        }
        setAanvraagLog($aanvraag->id, $omschrijving, getProfileNameSession());

        $status = new AanvraagStatus();
        $status->aanvraag_id = $aanvraag->id;
        $status->status_id = "1";
        $status->save();

        $msg = 'saved';

        break;

    case 'updateitem';
        $bestelling = Bestelling::find($_GET['recordId']);


        if ($input->input('bstl_voorbereider') == 'Accoord') {
            $add = EmailGroup::whereName('AANVRAAG_VOORBEREIDER')->first(); // get group name id
            $mailadress = EmailUser::whereEmailGroupId($add->id)->get(); //get users array
            $aanvraagnremail = $bestelling->aanvraag_nr; //set aanvraag nummer
            $artikelomschrijving = $bestelling->artikelInfo->artikelomschrijving; //set artikel omschrijving
            require_once 'templates/email/aanvraag_voorbereider_accoord.template.php'; //accoord template
            sendEmail($mailadress, null, 'Voorbereider: Nieuw aanvraag ingevoerd!', $html, null); //send mail function

            setAanvraagLog($_GET['recordId'], "Voorbereider: Nieuw goedgekeurde aanvraag!", getProfileNameSession());
        } elseif ($input->input('bstl_voorbereider') == 'Geen Accoord') {
            $add = EmailGroup::whereName('AANVRAAG_VOORBEREIDER')->first(); // get group name id
            $mailadress = EmailUser::whereEmailGroupId($add->id)->get(); //get users array
            $opmerking = $input->input('bstl_voorbereider_opmerking');
            $aanvraagnremail = $bestelling->aanvraag_nr; //set aanvraag nummer
            $artikelomschrijving = $bestelling->artikelInfo->artikelomschrijving; //set artikel omschrijving
            require_once 'templates/email/aanvraag_voorbereider_niet_accoord.template.php'; //accoord template
            sendEmail($mailadress, null, 'Voorbereider: Nieuw Afgekeurde aanvraag!', $html, null); //send mail function

            setAanvraagLog($_GET['recordId'], "Voorbereider: Nieuw Afgekeurde aanvraag!<br>Opmerking:" . $opmerking, getProfileNameSession());
        }
        if ($input->input('bstl_co_logistiek') == 'Accoord') {

            $add = EmailGroup::whereName('AANVRAAG_COLOGISTIEK')->first(); // get group name id
            $mailadress = EmailUser::whereEmailGroupId($add->id)->get(); //get users array
            $aanvraagnremail = $bestelling->aanvraag_nr; //set aanvraag nummer
            $artikelomschrijving = $bestelling->artikelInfo->artikelomschrijving; //set artikel omschrijving
            require_once 'templates/email/aanvraag_cologistiek_accoord.template.php'; //accoord template
            sendEmail($mailadress, null, 'Co-Logistiek: Nieuw goedgekeurde aanvraag!', $html, null); //send mail function

            setAanvraagLog($_GET['recordId'], "Co-Logistiek: Nieuw goedgekeurde aanvraag!", getProfileNameSession());

        } elseif ($input->input('bstl_co_logistiek') == 'Geen Accoord') {
            $input->merge(array('bstl_voorbereider' => 'Geen Accoord'));
            $add = EmailGroup::whereName('AANVRAAG_COLOGISTIEK')->first(); // get group name id
            $mailadress = EmailUser::whereEmailGroupId($add->id)->get(); //get users array
            $aanvraagnremail = $bestelling->aanvraag_nr; //set aanvraag nummer
            $artikelomschrijving = $bestelling->artikelInfo->artikelomschrijving; //set artikel omschrijving
            $opmerking = $input->input('bstl_co_logistiek_opmerking');
            require_once 'templates/email/aanvraag_voorbereider_niet_accoord.template.php'; //accoord template
            sendEmail($mailadress, null, 'Co-Logistiek: Nieuw afgekeurde aanvraag!', $html, null); //send mail function

            setAanvraagLog($_GET['recordId'], "Co-Logistiek: Nieuw afgekeurde aanvraag!<br>Opmerking:" . $opmerking, getProfileNameSession());
        }
        if ($input->input('bstl_hoofd_inventory') == 'Accoord') {
            $input->merge(array('inbox_terug_opmerking' => ''));
            $status = AanvraagStatus::whereAanvraagId($bestelling->id)->first();
            $status->status_id = "2";
            $status->save();

            $add = EmailGroup::whereName('AANVRAAG_MAIL')->first(); // get group name id
            $mailadress = EmailUser::whereEmailGroupId($add->id)->get(); //get users array
            $aanvraagnremail = $bestelling->aanvraag_nr; //set aanvraag nummer
            $artikelomschrijving = $bestelling->artikelInfo->artikelomschrijving; //set artikel omschrijving
            require_once 'templates/email/aanvraag_accoord.template.php'; //accoord template
            sendEmail($mailadress, null, 'Hoofd Inventory: Nieuw goedgekeurde aanvraag!', $html, null); //send mail function

            setAanvraagLog($_GET['recordId'], "Hoofd Inventory: Nieuw goedgekeurde aanvraag!", getProfileNameSession());

        } elseif ($input->input('bstl_hoofd_inventory') == 'Geen Accoord') {
            if ($input->input('terug_naar') == 'Voorbereider') {
                $input->merge(array('bstl_voorbereider' => 'Geen Accoord'));
                $input->merge(array('bstl_co_logistiek' => 'Geen Accoord'));
            } elseif ($input->input('terug_naar') == 'Co-Logistiek') {
                $input->merge(array('bstl_co_logistiek' => 'Geen Accoord'));
            }

            $status = AanvraagStatus::whereAanvraagId($bestelling->id)->first();
            $status->status_id = "10";
            $status->save();


            $opmerking = $input->input('bstl_hoofd_inventory_opmerking');
            $add = EmailGroup::whereName('AANVRAAG_MAIL')->first(); // get group name id
            $mailadress = EmailUser::whereEmailGroupId($add->id)->get(); //get users array
            $aanvraagnremail = $bestelling->aanvraag_nr; //set aanvraag nummer
            $artikelomschrijving = $bestelling->artikelInfo->artikelomschrijving; //set artikel omschrijving
            require_once 'templates/email/aanvraag_voorbereider_niet_accoord.template.php'; //accoord template
            sendEmail($mailadress, null, 'Hoofd Inventory: Nieuwe niet geaccordeerde aanvraag!', $html, null); //send mail function

            setAanvraagLog($_GET['recordId'], "Hoofd Inventory: Nieuwe niet geaccordeerde aanvraag!<br>Opmerking:" . $opmerking, getProfileNameSession());

        } elseif ($input->input('bstl_hoofd_inventory') == 'Afgekeurd') {

            $status = AanvraagStatus::whereAanvraagId($bestelling->id)->first();
            $status->status_id = "6";
            $status->save();


            $opmerking = $input->input('bstl_hoofd_inventory_opmerking');
            $add = EmailGroup::whereName('AANVRAAG_MAIL')->first(); // get group name id
            $mailadress = EmailUser::whereEmailGroupId($add->id)->get(); //get users array
            $aanvraagnremail = $bestelling->aanvraag_nr; //set aanvraag nummer
            $artikelomschrijving = $bestelling->artikelInfo->artikelomschrijving; //set artikel omschrijving
            require_once 'templates/email/aanvraag_voorbereider_niet_accoord.template.php'; //accoord template
            sendEmail($mailadress, null, 'Hoofd Inventory: Afgekeurde aanvraag!', $html, null); //send mail function

            setAanvraagLog($_GET['recordId'], "Hoofd Inventory: Afgekeurde aanvraag!<br>Opmerking:" . $opmerking, getProfileNameSession());
        }

        $bestelling->fill($input->all());
        $bestelling->save();

        $msg = 'updated';
        break;

    case 'deleteitem';
        $bestelling = Bestelling::find($_GET['id']);
        $aanvraagStatus = AanvraagStatus::whereAanvraagId($bestelling->id)->first();
        $aanvraagStatus->delete();
        $bestelling->delete();

        $msg = 'deleted';
        break;

    case 'delete';
        $afdelingaanvr = Afdelingaanvr::find($_GET['id']);
        $afdelingaanvr->delete();
        $msg = 'deleted';
        break;

}

if (getInkoopPermisson('Voorbereider')) {
    $bestelling = Bestelling::where('bstl_voorbereider', '!=', 'Accoord')->where('refnr', '!=', '')->orWhereNull('bstl_voorbereider')->get();
} elseif (getInkoopPermisson('Co- logistiek')) {
    $bestelling = Bestelling::where('bstl_voorbereider', '=', 'Accoord')
        ->where('bstl_co_logistiek', '!=', 'Accoord')
        ->orWhereNull('bstl_co_logistiek')->get();
    //echo var_dump($bestelling);
} elseif (getInkoopPermisson('Hoofd Inventory')) {
    $bestelling = Bestelling::whereHas('aanvraagStatus', function ($query) {
        $query->where('status_id', '<>', 6);
        $query->where('bstl_voorbereider', '=', 'Accoord');
        $query->where('bstl_co_logistiek', '=', 'Accoord');
        $query->where('bstl_hoofd_inventory', '<>', 'Accoord');
        $query->orWhere('bstl_hoofd_inventory', '=', null);
        $query->orWhere('bstl_hoofd_inventory', '=', 'Geen Accoord');
    })->get();
}
$afdelingaanvr = Afdelingaanvr::where('voorbereider', '!=', 'Accoord')->orWhereNull('voorbereider')->get();

require_once('tmpl/afdelingaanvr.tpl.php');

?>