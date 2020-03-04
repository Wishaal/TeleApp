<?php
/**
 * Created by PhpStorm.
 * User: telesur
 * Date: 4/28/2016
 * Time: 8:38 AM
 */


$html .= 'Beste Collegae, <p>';
$html .= 'Er is een nieuwe aanvraag(ontvangst) goedgekeurd! <p>';
$html .= 'Aanvraagnr: ' . $aanvraagnremail . '<br>';
$html .= 'Artikelcode: ' . $artikelcode . '<br>';
$html .= 'Artikelomschrijving: ' . $artikelomschrijving . '<br>';
$html .= 'Aantal besteld: ' . $besteld . '<br>';
$html .= 'Aantal ontvangen: ' . $ontvangen . '<br>';
$html .= 'Verschil: ' . $verschil . '<br>';
$html .= 'Deellevering?: ' . $deellevering . '<br>';
$html .= 'Bestel / PO #: ' . $bestelnr . '<p>';
$html .= 'Opmerking: ' . $opmerking . '<p>';
$html .= 'Met vriendelijke groeten,<br>';
$html .= strtok(getProfileInfo($mis_connPDO, 'FirstName', $_SESSION['mis']['user']['badgenr']), " ") . ' ' . getProfileInfo($mis_connPDO, 'Name', $_SESSION['mis']['user']['badgenr']);
