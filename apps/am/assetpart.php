<?php
include('php/config.php');
/*
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
 */

$menuid = menu;

require_once('../../php/conf/config.php');
require_once('../../inc_topnav.php');
require_once('../../inc_sidebar.php');
/*
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
 */

$action = 'overview';
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}
//add domain
include('domain/Assetpart.php');
include('domain/Artikel.php');
include('domain/Categorie.php');

function getArtikelCount($artikel)
{
    $artikel = Assetpart::where(['statusnr' => '1', 'artikelcode' => $artikel])->get();
    $artikel = $artikel->count();

    return $artikel;
}


function getArtikelName($artikel)
{
    $artikel = Assetpart::where(['statusnr' => '1', 'artikelcode' => $artikel])->first();
    //    $artikel = $artikel->all();

    return $artikel;
}

/*
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
 */
switch ($action) {

    default:
    case 'overview':
        break;

    case 'new';
        $Artikelrecord = Artikel::find($input['artikelcode']);
        if ($Artikelrecord->hulpstuk == "J") {
            $mynewquery = 'artikelcode = "' . $input[artikelcode] . '"';
            $Assetpartlaatste = Assetpart::whereRaw($mynewquery)->max('serienr');
            if (empty($Assetpartlaatste)) {
                $idz = 1;
                $idy = $input->aantal;
            } else {
                $idz = ltrim(substr($Assetpartlaatste, 7), '0') + 1;
                $idy = $input->aantal + $idz - 1;
            }
            for ($idx = $idz; $idx <= $idy; $idx++) {
                $input[serienr] = $input->artikelcode . str_pad($idx, 30, "0", STR_PAD_LEFT);
                $input[aantal] = 1;
                Assetpart::create($input->all());
            }
        } else {
            $input[aantal] = 1;
            Assetpart::create($input->all());
        }
        $msg = 'saved';
        break;

    case 'update';
        $Assetpart = Assetpart::find($_GET['recordId']);
        $Assetpart->fill($input->all());
        $Assetpart->save();
        $msg = 'updated';
        break;

    case 'delete';
        $Assetpart = Assetpart::find($_GET['id']);
        $Assetpart->delete();
        header("Location: assetpart.php");
        $msg = 'deleted';
        break;

    case 'multi';
        $aant = array_filter(array_unique($input->serienrmulti));
        foreach ($aant as $key => $value) {
            if (!empty($value)) {
                $input[aantal] = 1;
                $input[serienr] = $value;
                Assetpart::create($input->all());
            }
        }
        $msg = 'saved';
        break;
}
//$Assetparten = Assetpart::all(); //20170606 iov Samsi reedsuitgegeven niet tonen in mainscreen
$catogorien = Categorie::all();

if (isset($_POST['categorieSubmit'])) {

    $categorie = $_POST['categorie'];
    if (isset($_POST['detailCheck'])) {

        $assetparts = Assetpart::where(['statusnr' => '1', 'categorienr' => $categorie])->get();
    } else {
        //        $assetpartsForCount = Assetpart::where(['statusnr' => '1', 'categorienr' => $categorie])->distinct('artikelcode')->get();
        $assetpartsForCount = Assetpart::select('artikelcode')->where(['statusnr' => '1', 'categorienr' => $categorie])->distinct('artikelcode')->get();
    }
}
// $Assetparten = Assetpart::where('statusnr', 1)->get();

$templatefilenaam = 'tmpl/assetpart.tpl.php';
if (file_exists($templatefilenaam)) {
    require_once($templatefilenaam);
} else {
    die('File does NOT exists');
}
