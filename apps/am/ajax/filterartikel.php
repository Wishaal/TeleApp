<?php
//error_reporting(E_ERROR | E_WARNING | E_PARSE);

include('../php/config.php');
include('../domain/Artikel.php');

$requestedartikelcode = $_REQUEST['afkcode'];
$spareparts = Artikel::whereRaw('artikelcode IN (select artikelcode from assetpart where statusnr = "1" and categorienr = (select categorienr from categorie where afkcode = "' . $requestedartikelcode . '"))')->get();

foreach ($spareparts as $r) {
    echo '<option value="' . $r->artikelcode . '">' . $r->artikelcode . ' - ' . $r->artikelnaam . '</option>';
}


?>