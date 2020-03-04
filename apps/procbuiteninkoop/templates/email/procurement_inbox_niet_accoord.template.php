<?php
/**
 * Created by PhpStorm.
 * User: telesur
 * Date: 4/28/2016
 * Time: 8:38 AM
 */


$html .= 'Beste Collegae, <p>';
$html .= 'Er is een nieuwe aanvraag teruggestuurd! <br>';
$html .= 'Opmerking:' . $opmerking . '<p>';
$html .= 'Aanvraagnr: ' . $aanvraagnremail . '<p>';
$html .= 'Artikelomschrijving: ' . $artikelomschrijving . '<p>';
$html .= 'Met vriendelijke groeten,<br>';
$html .= strtok(getProfileInfo($mis_connPDO, 'FirstName', $_SESSION['mis']['user']['badgenr']), " ") . ' ' . getProfileInfo($mis_connPDO, 'Name', $_SESSION['mis']['user']['badgenr']);

