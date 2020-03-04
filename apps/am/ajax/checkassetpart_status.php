<?php
//error_reporting(E_ERROR | E_WARNING | E_PARSE);

include('../php/config.php');
include('../domain/Assetpart.php');

$bestaandrecord = Assetpart::where('serienr', '=', $_REQUEST['serialnr'])->where('artikelcode', '=', $_REQUEST['artikelcode'])->where('statusnr', '=', '1')->get();
print_r($bestaandrecord->count());
?>