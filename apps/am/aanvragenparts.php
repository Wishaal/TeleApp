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
include('domain/Aanvragenparts.php');
include('domain/Aanvragen.php');
include('domain/Werkorder.php');
include('domain/Assetpart.php');
include('domain/Artikel.php');

switch ($action) {

    default:
    case 'overview':

        break;

    case 'new';
        Aanvragenparts::create($input->all());
        $msg = 'saved';
        break;

    case 'update';
        $Aanvragenparts = Aanvragenparts::find($_GET['recordId']);
        $Aanvragenparts->fill($input->all());
        $Aanvragenparts->save();
        $msg = 'updated';
        break;

    case 'delete';
        $Aanvragenparts = Aanvragenparts::find($_GET['id']);
        $Aanvragenparts->delete();

        $msg = 'deleted';
        break;

    case 'finalize';
        $aanvragenrecord = Aanvragen::find($_GET['recordId']);
        $artikelrecord = Artikel::find($aanvragenrecord->artikelcode);

        if ($artikelrecord->hulpstuk == "J") {
            $getserials = Assetpart::whereRaw(' statusnr=1 and artikelcode="' . $aanvragenrecord->artikelcode . '"')->get();
            for ($idx = 0; $idx < $aanvragenrecord->aantal; $idx++) {
                $newopdracht = new Aanvragenparts;
                $newopdracht->aanvraagnr = $input->aanvraagnr;
                $newopdracht->serienr = $getserials[$idx]->serienr;
                $newopdracht->rbadgenr = $input->rbadgenr;
                $newopdracht->dbadgenr = $input->dbadgenr;
                $newopdracht->save();

                $updatepart = Assetpart::whereRaw(' serienr="' . $newopdracht->serienr . '"')->update(array('statusnr' => '3'));
            }
        } else {
            for ($idx = 0; $idx < count($input->serialnr); $idx++) {
                $newopdracht = new Aanvragenparts;
                $newopdracht->aanvraagnr = $input->aanvraagnr;
                $newopdracht->serienr = $input->serialnr[$idx];
                $newopdracht->rbadgenr = $input->rbadgenr;
                $newopdracht->dbadgenr = $input->dbadgenr;
                $newopdracht->save();

                $updatepart = Assetpart::whereRaw(' serienr="' . $newopdracht->serienr . '"')->update(array('statusnr' => '3'));
            }
        }

        $updatewerkorder = Werkorder::whereRaw(' taakafgemeld is null and aanvraagnr=' . $input->aanvraagnr)->update(array('taakafgemeld' => date('Y-m-d'), 'aanvraagafgemeld' => date('Y-m-d'), 'updated_user' => $_SESSION[mis][user][username], 'badgenr' => $_SESSION[mis][user][badgenr]));

        $updateaanvraag = Aanvragen::find($_GET['recordId']);
        $updateaanvraag->statusnr = '100';
        $updateaanvraag->save();

        die('<script type="text/javascript">window.location.href="' . $_GET['parent'] . '.php";</script>');
        break;
}
$Aanvragenparts = Aanvragenparts::all();
$templatefilenaam = 'tmpl/aanvragenparts.tpl.php';
if (file_exists($templatefilenaam)) {
    require_once($templatefilenaam);
} else {
    die('File does NOT exists');
}
?>