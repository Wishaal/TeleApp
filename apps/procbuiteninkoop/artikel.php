<?php
include('php/database.php');
$menuid = menu;
//global includes
require_once('../../php/conf/config.php');
require_once('php/includes.php');
require_once('../../inc_topnav.php');
require_once('../../inc_sidebar.php');

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

    case 'new';
        Artikel::create($input->all());
        $msg = 'saved';
        break;

    case 'import';

        if (isset($_FILES['artikelbestand'])) {
            $file = $_FILES['artikelbestand']['tmp_name'];
            $handle = fopen($file, "r");

            while (($fileop = fgetcsv($handle, 1000, ",")) !== false) {

                $artikelcode = trim($fileop[0]);
                $omscrhijving = trim($fileop[1]);
                $eenheid = trim($fileop[2]);
                $geleverd = trim($fileop[3]);
                $jaar = trim($fileop[4]);

                //echo $artikel.' '.$omscrhijving.'<br>';
                //::firstOrNew(array('artikel' => $artikel, 'jaar' => $jaar));
                //echo var_dump($artikel);
                $artikel = Artikel::firstOrNew(array('artikel' => $artikelcode, 'jaar' => $jaar));
                $artikel->artikel = $artikelcode;
                $artikel->artikelomschrijving = $omscrhijving;
                $artikel->eenheid = $eenheid;
                $artikel->geleverd = $geleverd;
                $artikel->jaar = $jaar;
                $artikel->save();

            }
        }

        break;

    case 'update';
        $artikel = Artikel::find($_GET['recordId']);
        $artikel->fill($input->all());
        $artikel->save();
        $msg = 'updated';
        break;

    case 'delete';
        $artikel = Artikel::find($_GET['id']);
        $artikel->delete();

        $msg = 'deleted';
        break;

}
$artikels = Artikel::all();
require_once('tmpl/artikel.tpl.php');

?>