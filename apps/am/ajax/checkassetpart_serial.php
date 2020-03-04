<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);

include('../php/config.php');
include('../domain/Assetpart.php');
$requestedserienr = $_REQUEST['serienr'];
$bestaandrecord = Assetpart::where('serienr', '=', $_REQUEST['serienr'])->get();

if ($requestedserienr == $bestaandrecord[0]->serienr) {
    echo 'Serialnr must be unique';
} else {
    echo '';
}
?>