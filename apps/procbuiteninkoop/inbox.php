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

    case 'assign';
        $aanvraag = AanvraagStatus::whereAanvraagId($_GET['recordId'])->first();
        $aanvraag->user_id = $_GET['userId'];

        if ($aanvraag->status_id == '2') {
            $aanvraag->status_id = '8';
        }
        $aanvraag->type = $_GET['type'];
        $aanvraag->save();
        header('Location: inbox.php?msg=saved');
        break;

    case 'reassign';
        $aanvraag = AanvraagStatus::whereAanvraagId($_GET['recordId'])->first();
        $aanvraag->user_id = null;
        $aanvraag->save();
        header('Location: inbox.php?msg=saved');
        break;

    case 'sendBack';

        $aanvraagX = AanvraagStatus::whereAanvraagId($_GET['recordId'])->first();
        $aanvraagX->status_id = '6';
        $aanvraagX->save();

        $aanvraag = Bestelling::find($_GET['recordId']);
        $aanvraag->bstl_hoofd_inventory = '';
        $aanvraag->inbox_terug_opmerking = $input->input('inbox_terug_opmerking');
        $aanvraag->save();

        $add = EmailGroup::whereName('INBOX_AANVRAAG_AFGEKEURD')->first(); // get group name id
        $mailadress = EmailUser::whereEmailGroupId($add->id)->get(); //get users array
        $aanvraagnremail = $aanvraag->aanvraag_nr; //set aanvraag nummer
        $opmerking = $input->input('inbox_terug_opmerking'); //set aanvraag nummer
        $artikelomschrijving = $aanvraag->artikelInfo->artikelomschrijving;
        require_once 'templates/email/procurement_inbox_niet_accoord.template.php'; //accoord template
        sendEmail($mailadress, null, 'Procurement: Aanvraag terug gestuurd!', $html, null); //send mail function


        header('Location: inbox.php?msg=saved');

        break;

}
$openAanvragen = AanvraagStatus::whereNotIn('status_id', [1, 6])
    ->whereNull('user_id')
    ->get();

$bezetAanvragen = AanvraagStatus::whereNotIn('status_id', [1, 6, 7, 9])
    ->whereNotNull('user_id')
    ->get();
require_once('tmpl/inbox.tpl.php');

?>