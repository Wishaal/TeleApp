<?php
//error_reporting(E_ERROR | E_WARNING | E_PARSE);

include('../php/config.php');
include "../domain/Personeel.php";
include('../domain/Afdeling.php');

$requestedbadgenr = $_REQUEST['badgenr'];
$bestaandrecord = Personeel::where('badgenr', '=', $_REQUEST['badgenr'])->get();


if (!empty($bestaandrecord[0]->afdelingcode)) {
    echo $bestaandrecord[0]->afdelingcode;
} else {
    echo "";
}
?>