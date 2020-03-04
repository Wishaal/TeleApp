<?php
include('php/database.php');
$menuid = menu;
//global includes
require_once('../../php/conf/config.php');
require_once('php/includes.php');
require_once('php/functions.php');
require_once('../../inc_topnav.php');
require_once('../../inc_sidebar.php');


$bestelling = Bestelling::whereHas('aanvraagStatus', function ($query) {
    $query->where('status_id', '<>', 6);
})->get();
$bestellingAfgekeurd = Bestelling::whereHas('aanvraagStatus', function ($query) {
    $query->where('status_id', '=', 6);
})->get();

require_once('tmpl/historie/h.bestelling.tpl.php');

?>