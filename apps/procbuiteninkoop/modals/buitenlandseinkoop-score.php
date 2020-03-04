<?php
require_once('../../../php/conf/config.php');

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

require_once('../php/database.php');
require_once('../php/functions.php');
include "../../../domain/procurementBuitenInkoop/Afdeling.php";
include "../../../domain/procurementBuitenInkoop/Betalingsvoorwaarde.php";
include "../../../domain/procurementBuitenInkoop/Leverancier.php";
include "../../../domain/procurementBuitenInkoop/Leveringsvoorwaarden.php";
include "../../../domain/procurementBuitenInkoop/BuitenlandseInkoop.php";
include "../../../domain/procurementBuitenInkoop/Authorisatie.php";
include "../../../domain/procurementBuitenInkoop/Koers.php";
include "../../../domain/procurementBuitenInkoop/Shipping.php";
include "../../../domain/procurementBuitenInkoop/ScoreInfo.php";
$buiten = BuitenlandseInkoop::find($_GET['id']);
$leverancier = Leverancier::find($buiten->leverancier_id);


$afdeling = Afdeling::all(array('afdelingcode', 'afdelingnaam', 'kostenplaatscode'));
$shipping = Shipping::all(array('id', 'methode'));
$authorisatie = Authorisatie::all(array('id', 'authorisatienr', 'valuta'));

?>
<form class="form-horizontal" action="apps/<?php echo app_name; ?>/authorisaties.php?action=updateScore" method="post"
      name="inputform" id="inputform">
    <input type="hidden" id="aanvraag_id" name="aanvraag_id" value="<?php echo $buiten->aanvraag_id; ?>">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Score</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-2">
                <label>Vendor</label><br>
                <label>Produktomschrijving</label>
            </div>
            <div class="col-md-10">
                <label>: <?php echo $leverancier->name; ?></label><br>
                <label>: <?php echo $buiten->omschrijving; ?></label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <label>PO #</label><br>
            </div>
            <div class="col-md-3">
                <label>: <?php echo $buiten->po_nr; ?></label><br>
            </div>
            <div class="col-md-2">
                <label>PO Datum</label><br>
            </div>
            <div class="col-md-3">
                <label>: <?php echo $buiten->po_datum; ?></label><br>
            </div>
        </div>
        <div class="row">
            <table class="table">
                <thead>
                <tr>
                    <th>BETALINGSVOORWAARDEN</th>
                    <th>LEVERINGS</th>
                    <th>DELIVERY</th>
                    <th>BO</th>
                    <th>OVERMAKING</th>
                    <th>Shipped</th>
                    <th>INGEKLAARD</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?php echo $buiten->getBetalingsvoorwaarden->omschrijving; ?></td>
                    <td><?php echo $buiten->getLeveringsvoorwaarden->omschrijving; ?></td>
                    <td><?php echo $buiten->delivery; ?></td>
                    <td><?php echo $buiten->bo; ?></td>
                    <td><?php echo $buiten->overmakingdatum; ?></td>
                    <td><?php echo $buiten->shipping_date; ?></td>
                    <td><?php echo $buiten->ingeklaard_datum; ?></td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-md-3">
                <label></label><br>
                <label>PO - Delivery</label><br>
                <label>PO - BO</label><br>
                <label>Delivery - BO</label><br>
                <label>BO - Overm</label><br>
                <label>Delivery - Ingekl</label><br>
                <label>Overm - Ingekl</label><br>
                <label>Shipped - Ingekl</label><br>
                <label>Overm - Shipped</label><br>
                <label>Po -Shipped</label><br>
                <label>BO -Shipped</label><br>
            </div>
            <div class="col-md-9">
                <b><label>Dagen</label></b><br>
                <label><?php echo getDaysDiff($buiten->delivery, $buiten->po_datum); ?></label><br>
                <label><?php echo getDaysDiff($buiten->bo, $buiten->po_datum); ?></label><br>
                <label><?php echo getDaysDiff($buiten->bo, $buiten->delivery); ?></label><br>
                <label><?php echo getDaysDiff($buiten->overmakingdatum, $buiten->bo); ?></label><br>
                <label><?php echo getDaysDiff($buiten->ingeklaard_datum, $buiten->delivery); ?></label><br>
                <label><?php echo getDaysDiff($buiten->ingeklaard_datum, $buiten->overmakingdatum); ?></label><br>
                <label><?php echo getDaysDiff($buiten->ingeklaard_datum, $buiten->shipping_date); ?></label><br>
                <label><?php echo getDaysDiff($buiten->shipping_date, $buiten->overmakingdatum); ?></label><br>
                <label><?php echo getDaysDiff($buiten->shipping_date, $buiten->po_datum); ?></label><br>
                <label><?php echo getDaysDiff($buiten->shipping_date, $buiten->bo); ?></label><br>
            </div>
        </div>
        <hr style="margin-top: 0px; border-top: 3px solid #008BDC; margin-bottom: 0px;">
        <div class="row">
            <div class="col-md-3"><label>Criteria</label></div>
            <div class="col-md-3"><label>Gewicht</label></div>
            <div class="col-md-2"><label>Prestatie</label></div>
            <div class="col-md-2"></div>
            <div class="col-md-2"><label>Score</label></div>
        </div>
        <hr style="margin-top: 0px; border-top: 3px solid #008BDC; margin-bottom: 0px;">
        <div class="row">
            <div class="col-md-3">
                <label>On time delivery</label><br>
                <label>Prijs</label><br>
                <label>Kwaliteit</label><br>
                <label>Leveringsbetrouwbaarheid</label><br>

            </div>
            <div class="col-md-3" style="border-left: 3px solid #008BDC;">
                <label>35%</label><br>
                <label>30% (laagste geoff/actuele pr)</label><br>
                <label>20% (afgekeurd)</label><br>
                <label>15% (incompleet)</label><br>
            </div>
            <div class="col-md-3">
                <label><?php echo getDaysDiff($buiten->shipping_date, $buiten->overmakingdatum); ?></label><br>
                <label><?php echo $buiten->valuta; ?><?php echo $buiten->bedrag; ?></label><br>
                <label><input type="text" id="kwaliteit" value="<?php echo $buiten->getScoreExtra->kwaliteit; ?>"
                              name="kwaliteit"></label><br>
                <label><input type="text" id="leveringsbetrouwbaarheid"
                              value="<?php echo $buiten->getScoreExtra->leveringsbetrouwbaarheid; ?>"
                              name="leveringsbetrouwbaarheid"></label><br>
            </div>
            <div class="col-md-3">
                <label><?php $result4 = getScoreDelivery(getDaysDiff($buiten->shipping_date, $buiten->overmakingdatum));
                    echo $result4; ?></label><br>
                <label><?php $result = (30 * ($buiten->bedrag / $buiten->bedrag));
                    echo $result; ?></label><br>
                <label><?php $result2 = (20 * (1 - $buiten->getScoreExtra->kwaliteit));
                    echo $result2; ?></label><br>
                <label><?php $result3 = (15 * (1 - (0.07 * $buiten->getScoreExtra->leveringsbetrouwbaarheid)));
                    echo $result3; ?></label><br>

            </div>
        </div>
        <div class="row">

            <div class="col-md-9"><label class="pull-right">Totaal score</label></div>
            <div class="col-md-3">
                <hr style="margin-top: 0px; border-top: 3px solid #008BDC; margin-bottom: 0px;">
                <label><?php $eind = ($result4 + $result2 + $result3 + $result);
                    echo $eind; ?></label></div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="btn_submit">Save changes</button>
    </div>
</form>
