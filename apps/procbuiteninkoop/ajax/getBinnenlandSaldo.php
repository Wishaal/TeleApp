<?php
/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 2/22/2016
 * Time: 1:11 PM
 */
include('../php/database.php');
include('../php/functions.php');
include('../../../domain/procurementBuitenInkoop/BinnenlandseInkoop.php');
include('../../../domain/procurementBuitenInkoop/BuitenlandseInkoop.php');
include('../../../domain/procurementBuitenInkoop/Authorisatie.php');

if (!empty($input->get('id')) && $input->get('id') != 'Geen') {
    $authorisatie = Authorisatie::where('id', '=', $input->get('id'))->first();
    $binnen = BinnenlandseInkoop::where('authorisatie_id', '=', $input->get('id'))->get();
    $sum = $binnen->sum('inbver_totaal_te_betalen');

    $buiten = BuitenlandseInkoop::where('authorisatienr', '=', $input->get('id'))->get();
    $sumBuiten = $buiten->sum('bedrag');

    $totaal = $sum + $sumBuiten;

    $eind = $authorisatie->bedrag - $totaal;

    $arr = array('bedrag' => $authorisatie->valuta . ' ' . number_format($eind, 2));

    echo json_encode($arr);
}


