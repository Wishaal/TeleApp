<?php
/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 2/22/2016
 * Time: 1:11 PM
 */


include('../php/database.php');
include('../php/functions.php');
include "../../../domain/procurementBuitenInkoop/Afdeling.php";
include "../../../domain/procurementBuitenInkoop/AanvraagStatus.php";
include "../../../domain/procurementBuitenInkoop/Leverancier.php";
include "../../../domain/procurementBuitenInkoop/BuitenlandseInkoop.php";
include "../../../domain/procurementBuitenInkoop/BinnenlandseInkoop.php";
include "../../../domain/procurementBuitenInkoop/Bestelling.php";
include('../../../domain/procurementBuitenInkoop/Koers.php');
include('../../../domain/procurementBuitenInkoop/Authorisatie.php');

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

$bestellen = Bestelling::where('authorisatie_id', '=', $_GET['id'])->get();

$count = 0;
foreach ($bestellen as $bestel) {
    if ($bestel->aanvraagStatus->type == '1') {

        echo '<tr class="clickable-row" id =' . $bestel->aanvraagStatus->getBuitenlandseInkoop->id . ' naam ="' . $bestel->aanvraagStatus->getBuitenlandseInkoop->po_nr . '"">
            <td>Buitenland</td>
            <td>' . $bestel->aanvraagStatus->getBuitenlandseInkoop->po_nr . '</td>
            <td>' . $bestel->aanvraagStatus->getBuitenlandseInkoop->po_datum . '</td>
            <td>' . $bestel->aanvraagStatus->getBuitenlandseInkoop->getLeverancier->name . '</td>
            <td>' . $bestel->aanvraagStatus->getBuitenlandseInkoop->omschrijving . '</td>
            <td>' . $bestel->aanvraagStatus->getBuitenlandseInkoop->bedrag . '</td>
          </tr>';

        $count++;
    } else {
        echo '<tr class="clickable-row" id =' . $bestel->aanvraagStatus->getBinnenlandseInkoop->id . ' naam ="' . $bestel->aanvraagStatus->getBinnenlandseInkoop->inbver_bestelbonnr . '"">
            <td>Binnenland</td>
            <td>' . $bestel->aanvraagStatus->getBinnenlandseInkoop->inbver_bestelbonnr . '</td>
            <td>' . $bestel->aanvraagStatus->getBinnenlandseInkoop->inbver_getekende_bestelbon_datum . '</td>
            <td>' . $bestel->aanvraagStatus->getBinnenlandseInkoop->getLeverancier->name . '</td>
            <td>' . $bestel->aanvraagStatus->getBinnenlandseInkoop->inbver_opmerkingen . '</td>
            <td>' . $bestel->aanvraagStatus->getBinnenlandseInkoop->inbver_totaal_te_betalen . '</td>
          </tr>';
        $count++;
    }
}

