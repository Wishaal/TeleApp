<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
include('domain/Rma.php');
include('domain/Rmadetail.php');
include('domain/Rmafile.php');

switch ($action) {

    default:
    case 'overview':
        break;

    case 'new';
        $aant = array_filter(array_unique($input->serienr));
        $input[aantal] = count($aant);
        $lastInsertedId = Rma::create($input->all())->rmavolgnr;

        for ($idx = 0; $idx < count($input->serienr); $idx++) {
            if (!empty($input->serienr[$idx])) {
                $detail = new Rmadetail;
                $detail->detailnr = '0';
                $detail->rmavolgnr = $lastInsertedId;
                $detail->serienr = $input->serienr[$idx];
                $detail->reserienr = $input->serienr[$idx];
                $detail->save();
            }
        }
        $msg = 'saved';
        break;

    case 'update';
        $aant1 = array_filter(array_unique($input->serienr));
        $aant2 = array_filter(array_unique($input->reserienr));
        if ($aant1 > $aant2) {
            $aant = $aant1;
        } else {
            $aant = $aant2;
        }
        $input[aantal] = count($aant);

        $araant = count($input->reserienr);

        $Rma = Rma::find($_GET['recordId']);
        $Rma->fill($input->all());
        $Rma->save();

        $rmadetailrecord = Rmadetail::where('rmavolgnr', '=', $input->rmavolgnr)->delete();
        for ($idx = 0; $idx < $araant; $idx++) {
            if (!empty($input->serienr[$idx]) || !empty($input->reserienr[$idx])) {
                $detail = new Rmadetail;
                $detail->detailnr = '0';
                $detail->rmavolgnr = $input->rmavolgnr;
                $detail->serienr = $input->serienr[$idx];
                $detail->reserienr = $input->reserienr[$idx];
                $detail->created_user = $_SESSION[mis][user][username];
                $detail->created_at = date('Y-m-d h:i:s');
                $detail->save();
            }
        }
        $msg = 'updated';
        break;

    case 'delete';
        $rmadetailrecord = Rmadetail::where('rmavolgnr', '=', $_GET['id'])->delete();
        $rmafilerecord = Rmafile::where('rmavolgnr', '=', $_GET['id'])->delete();

        $Rma = Rma::find($_GET['id']);
        $Rma->delete();
        $msg = 'deleted';
        break;
        break;

}
$Rmaen = Rma::all();
$templatefilenaam = 'tmpl/rma.tpl.php';
if (file_exists($templatefilenaam)) {
    require_once($templatefilenaam);
} else {
    die('File does NOT exists');
}
?>