<?php
require_once('../../../php/conf/config.php');

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

require_once('../php/database.php');
require_once('../php/functions.php');
include "../../../domain/procurementBuitenInkoop/Afdeling.php";
include "../../../domain/procurementBuitenInkoop/AanvraagStatus.php";
include "../../../domain/procurementBuitenInkoop/Leverancier.php";
include "../../../domain/procurementBuitenInkoop/BuitenlandseInkoop.php";
include "../../../domain/procurementBuitenInkoop/BinnenlandseInkoop.php";
include "../../../domain/procurementBuitenInkoop/Bestelling.php";
include "../../../domain/procurementBuitenInkoop/Authorisatie.php";
include "../../../domain/procurementBuitenInkoop/Koers.php";
include "../../../domain/procurementBuitenInkoop/Shipping.php";
$bestellen = Bestelling::where('authorisatie_id', '=', $_GET['id'])->get();
$leverancier = Leverancier::find($buiten->leverancier_id);
$authorisatie = Authorisatie::find($_GET['id']);

$afdeling = Afdeling::all(array('afdelingcode', 'afdelingnaam', 'kostenplaatscode'));
$shipping = Shipping::all(array('id', 'methode'));
?>
<form name="inputform" id="inputform" enctype="multipart/form-data" xmlns="http://www.w3.org/1999/html"
      xmlns="http://www.w3.org/1999/html">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Bestedingsoverzicht</h4>
    </div>
    <div class="modal-body">
        <table class="table">
            <tr>
                <th>Onderwerp:</th>
                <th><?php echo $authorisatie->Onderwerp; ?></th>
                <th colspan="3"></th>
                <th>Projectcode:</th>
                <th colspan="3"><?php echo $authorisatie->Projectcode; ?> </th>
            </tr>
            <tr>
                <th>Autoristatie:</th>
                <th><?php echo $authorisatie->authorisatienr; ?></th>
                <th colspan="4"></th>
                <th></th>
                <th>Datum Omr.fact.</th>
                <th>Tussenkoers</th>
            </tr>
            <tr>
                <th>Autorisatie Bedrag:</th>
                <th><?php echo $authorisatie->bedrag; ?></th>
                <th colspan="4"></th>
                <th><?php echo $authorisatie->bedrag; ?></th>
                <th colspan="2"></th>
            </tr>
            <tbody>
            <tr></tr>
            <tr>
                <td>Type:</td>
                <td>PO #:</td>
                <td>PO Datum:</td>
                <td>Leverancier:</td>
                <td>Omschrijving:</td>
                <td>Te betalen:</td>
                <td colspan="3"></td>
            </tr>
            <?php
            $sum = 0;
            foreach ($bestellen as $bestel) {
                if ($bestel->aanvraagStatus->type == '1') {

                    echo '<tr>
                        <td>Buitenland</td>
                        <td>' . $bestel->aanvraagStatus->getBuitenlandseInkoop->po_nr . '</td>
                        <td>' . $bestel->aanvraagStatus->getBuitenlandseInkoop->po_datum . '</td>
                        <td>' . $bestel->aanvraagStatus->getBuitenlandseInkoop->getLeverancier->name . '</td>
                        <td>' . $bestel->aanvraagStatus->getBuitenlandseInkoop->omschrijving . '</td>
                        <td>' . $bestel->aanvraagStatus->getBuitenlandseInkoop->bedrag . '</td>
                        <td>' . $bestel->aanvraagStatus->getBuitenlandseInkoop->bedrag . '</td>
                        <td></td>
                        <td></td>
                      </tr>';
                    $sum += $bestel->aanvraagStatus->getBuitenlandseInkoop->bedrag;
                    $count++;
                } else {
                    echo '<tr>
                        <td>Binnenland</td>
                        <td>' . $bestel->aanvraagStatus->getBinnenlandseInkoop->inbver_bestelbonnr . '</td>
                        <td>' . $bestel->aanvraagStatus->getBinnenlandseInkoop->inbver_getekende_bestelbon_datum . '</td>
                        <td>' . $bestel->aanvraagStatus->getBinnenlandseInkoop->getLeverancier->name . '</td>
                        <td>' . $bestel->aanvraagStatus->getBinnenlandseInkoop->inbver_opmerkingen . '</td>
                        <td>' . $bestel->aanvraagStatus->getBinnenlandseInkoop->inbver_totaal_te_betalen . '</td>
                        <td>' . $bestel->aanvraagStatus->getBinnenlandseInkoop->inbver_totaal_te_betalen . '</td>
                        <td></td>
                        <td></td>
                      </tr>';
                    $sum += $bestel->aanvraagStatus->getBinnenlandseInkoop->inbver_totaal_te_betalen;
                    $count++;
                }
            }
            ?>
            <tr>
                <td colspan="5"></td>
                <td><b>PO’s Samen</b></td>
                <td><?php echo $sum; ?></td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan="5"></td>
                <td>Autor. Saldo</td>
                <td><?php echo(($authorisatie->bedrag) - $sum); ?></td>
                <td colspan="2"></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="modal-footer"></div>
</form>
