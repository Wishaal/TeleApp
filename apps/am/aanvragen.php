<?php
include('php/config.php');
include('php/functions.php');

$menuid = menu;

require_once('../../php/conf/config.php');
require_once('../../inc_topnav.php');
require_once('../../inc_sidebar.php');

$action = 'overview';
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

//add domain
include('domain/Aanvragen.php');

switch ($action) {
    default:
    case 'overview':
        break;

    case 'newmulti';
        for ($idx = 1; $idx < 6; $idx++) {
            switch ($idx) {
                case "1":
                    $nieuwewaardeart = $input->artikelcode;
                    $nieuwewaardeaant = $input->aantal;
                    break;
                case "2":
                    $nieuwewaardeart = $input->artikelcode2;
                    $nieuwewaardeaant = $input->aantal2;
                    break;
                case "3":
                    $nieuwewaardeart = $input->artikelcode3;
                    $nieuwewaardeaant = $input->aantal3;
                    break;
                case "4":
                    $nieuwewaardeart = $input->artikelcode4;
                    $nieuwewaardeaant = $input->aantal4;
                    break;
                case "5":
                    $nieuwewaardeart = $input->artikelcode5;
                    $nieuwewaardeaant = $input->aantal5;
                    break;
                default:
                    $nieuwewaardeart = '';
                    $nieuwewaardeaant = '0';
            }
            if (!empty($nieuwewaardeart) && $nieuwewaardeaant >= 1) {
                $aanvraagnr = generateAanvraagNr();
                $filedetail = new Aanvragen;
                $filedetail->aanvraagnr = $aanvraagnr;
                $filedetail->aanvraagdatum = $input->aanvraagdatum;
                $filedetail->statusnr = $input->statusnr;
                $filedetail->badgenr = $input->badgenr;
                $filedetail->afdelingcode = $input->afdelingcode;
                $filedetail->opmerking = $input->opmerking;
                $filedetail->soortaanvraag = $input->soortaanvraag;
                $filedetail->artikelcode = $nieuwewaardeart;
                $filedetail->aantal = $nieuwewaardeaant;
                $filedetail->created_user = $_SESSION[mis][user][username];
                $filedetail->created_at = date('Y-m-d h:i:s');
                $filedetail->save();
            }
        }

        $msg = 'saved';
        break;

    case 'new';
        $aanvraagnr = generateAanvraagNr();
        $input->merge(array('aanvraagnr' => $aanvraagnr));
        Aanvragen::create($input->all());
        $msg = 'saved';
        break;

    case 'update';
        $Aanvragen = Aanvragen::find($_GET['recordId']);
        $Aanvragen->fill($input->all());
        $Aanvragen->save();
        $msg = 'updated';
        break;

    case 'updateremarks';
        include('domain/Werkorder.php');
        for ($idx = 1; $idx < 5; $idx++) {
            $veldnaam = 'woopmerking_' . $idx;
            $updatewerkorder = Werkorder::whereRaw(' aanvraagnr=' . $input->aanvraagnr . ' and volgnr=' . $idx)->update(array('opmerking' => $_POST[$veldnaam]));
        }

        $Aanvragen = Aanvragen::find($_GET['recordId']);
        $Aanvragen->fill($input->all());
        $Aanvragen->save();
        $msg = 'updated';
        die('<script type="text/javascript">window.location.href="' . basename($_SERVER['PHP_SELF']) . '";</script>');
        break;

    case 'returnpart':
        include('domain/Aanvragenparts.php');
        include('domain/Assetpart.php');
        $Aanvragen = Aanvragen::find($_GET['recordId']);
        $opmveld = "";
        $nieuweaantal = 0;
        for ($idx=0; $idx<count($_POST["returnpart"]); $idx++) {
            $Aanvragenparts = Aanvragenparts::find($_POST["returnpart"][$idx]);
            $opmveld .= $Aanvragenparts->serienr. "\n";
            $Aanvragenparts->delete();
            $updatepart = Assetpart::whereRaw(' serienr="' . $Aanvragenparts->serienr . '"')->update(array('statusnr' => '1', 'return_opm' => 'RETURNED '. $_GET['recordId']));
        }
        if (!empty($opmveld)) {
            $opmveld = "\n\n<br>Origineel aangevraagd ". $Aanvragen->aantal. "\n<br><font color='red'>Return Part\n:<br>". $opmveld. "</font><br>";
            $nieuweaantal = $Aanvragen->aantal - count($_POST["returnpart"]);
        }
        $Aanvragen->update(array('opmerking' => $Aanvragen->opmerking. $opmveld, 'aantal' => $nieuweaantal));
        $msg = 'deleted';
        die('<script type="text/javascript">window.location.href="' . basename($_SERVER['PHP_SELF']) . '";</script>');
        break;

    case 'delete';
        $Aanvragen = Aanvragen::find($_GET['id']);
        $Aanvragen->delete();
        $msg = 'deleted';
        break;

}
$Aanvragenen = Aanvragen::orderBy('aanvraagnr', 'desc')->get();
$templatefilenaam = 'tmpl/aanvragen.tpl.php';
if (file_exists($templatefilenaam)) {
    require_once($templatefilenaam);
} else {
    die('File does NOT exists');
}
?>