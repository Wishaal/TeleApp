<?php
//error_reporting(E_ERROR | E_WARNING | E_PARSE);

include('../php/config.php');
include('../domain/Artikel.php');
include('../domain/Categorie.php');

$requestedartikelcode = $_REQUEST['artikelcode'];
$bestaandrecord = Artikel::where('artikelcode', '=', $_REQUEST['artikelcode'])->get();
$catbestaandrecord = Categorie::where('afkcode', '=', substr($_REQUEST['artikelcode'], 0, 2))->get();

if (!empty($bestaandrecord[0]->artikelnaam)) {
    echo $bestaandrecord[0]->artikelnaam . "*******" . $bestaandrecord[0]->hulpstuk . "*******" . $catbestaandrecord[0]->categorienr;
} else {
    echo '';
}
?>