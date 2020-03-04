<?php
require_once('../../../php/conf/config.php');

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

require_once('../php/database.php');
require_once('../php/functions.php');
include "../../../domain/procurementBuitenInkoop/Afdeling.php";
include "../../../domain/procurementBuitenInkoop/Leverancier.php";
include "../../../domain/procurementBuitenInkoop/BuitenlandseInkoop.php";
include "../../../domain/procurementBuitenInkoop/Authorisatie.php";
include "../../../domain/procurementBuitenInkoop/Koers.php";
include "../../../domain/procurementBuitenInkoop/Shipping.php";
$afdeling = Afdeling::all(array('afdelingcode', 'afdelingnaam', 'kostenplaatscode'));
$shipping = Shipping::all(array('id', 'methode'));
$authorisatie = Authorisatie::all(array('id', 'authorisatienr', 'valuta'));
$leverancier = Leverancier::all(array('id', 'name'));
$buiten = BuitenlandseInkoop::find($_GET['id']);
?>
<form name="inputform" id="inputform" enctype="multipart/form-data" xmlns="http://www.w3.org/1999/html">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?php echo ucfirst($_GET['action']); ?> Invoer</h4>
    </div>
    <div class="modal-body">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">BUITENLANDSE BESTELLINGEN INKOOP Tab 1</a></li>
                <li><a href="#tab_2" data-toggle="tab">BUITENLANDSE BESTELLINGEN INKOOP Tab 2</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="naam">PO #</label>
                                        <input type="text" id="po_nr" disabled name="po_nr" class="form-control"
                                               value="<?php echo $buiten->po_nr; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="naam">PO Datum</label>
                                        <input type="text" disabled id="po_datum" name="po_datum" data-date=""
                                               data-date-format="YYYY-MM-DD" data-link-format="yyyy-mm-dd"
                                               data-link-field="po_datum" autocomplete="off" class="form-control"
                                               value="<?php echo $buiten->po_datum; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="naam">Afdeling</label>
                                <select disabled class="select form-control" id="afdeling" name="afdeling">
                                    <?php
                                    foreach ($afdeling as $r) {
                                        if ($r->afdelingcode == $buiten->afdeling) {
                                            $sel = 'selected=selected';
                                        } else {
                                            $sel = '';
                                        }
                                        echo '<option ' . $sel . ' value=' . $r->afdelingcode . '>' . $r->kostenplaatscode . ' ' . $r->afdelingnaam . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="naam">Omschrijving</label>
                                <input disabled type="text" id="omschrijving" name="omschrijving" class="form-control"
                                       value="<?php echo $buiten->omschrijving; ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="naam">BETALINGSVOORWAARDEN</label>
                                <input disabled type="text" id="betalingsvoorwaarden" name="betalingsvoorwaarden"
                                       class="form-control" value="<?php echo $buiten->betalingsvoorwaarden; ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="naam">DELIVERY</label>
                                <input disabled type="text" id="delivery" name="delivery" data-date=""
                                       data-date-format="YYYY-MM-DD" data-link-format="yyyy-mm-dd"
                                       data-link-field="delivery" autocomplete="off" class="form-control"
                                       value="<?php echo $buiten->delivery; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="naam">CONTRACT /OFFERTE/FACTUUR</label>
                                <input disabled type="text" id="cof_nr" name="cof_nr" class="form-control"
                                       value="<?php echo $buiten->cof_nr; ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="naam">Leverancier</label>
                                <select disabled class="select form-control" id="leverancier_id" name="leverancier_id">
                                    <?php
                                    foreach ($leverancier as $r) {
                                        if ($r->id == $buiten->leverancier_id) {
                                            $sel = 'selected=selected';
                                        } else {
                                            $sel = '';
                                        }
                                        echo '<option ' . $sel . ' value=' . $r->id . '>' . $r->name . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="naam">Valuta</label>
                                        <select disabled class="form-control" id="valuta" name="valuta">
                                            <option value="USD">USD</option>
                                            <option value="EURO">EURO</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="naam">Auth #</label>
                                        <select disabled class="select form-control" id="authorisatienr"
                                                name="authorisatienr">
                                            <?php
                                            foreach ($authorisatie as $r) {
                                                if ($r->id == $buiten->authorisatienr) {
                                                    $sel = 'selected=selected';
                                                } else {
                                                    $sel = '';
                                                }
                                                echo '<option ' . $sel . ' value=' . $r->id . '>' . $r->authorisatienr . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="naam">Bedrag US$</label>
                                        <input disabled type="text" id="bedrag" name="bedrag" class="form-control"
                                               value="<?php echo $buiten->bedrag; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="naam">Authorisatie
                                            file <?php if (!empty($buiten->authorisatiefile)) { ?><a
                                                href="apps/<?php echo app_name; ?>/documenten/authorisaties/<?php echo $buiten->authorisatiefile; ?>">
                                                    (download)</a><?php } ?></label>
                                        <input disabled type="file" id="authorisatiefileTmp" name="authorisatiefileTmp"
                                               class="form-control" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="naam">BO DATUM</label>
                                <input disabled type="text" id="bo" name="bo" data-date="" data-date-format="YYYY-MM-DD"
                                       data-link-format="yyyy-mm-dd" data-link-field="bo" autocomplete="off"
                                       class="form-control" value="<?php echo $buiten->bo; ?>">
                            </div>
                        </div>

                    </div>
                </div><!-- /.tab-pane -->
                <div class="tab-pane" id="tab_2">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="naam">Vrijstelling</label>
                                <input disabled type="text" id="vrijstelling" name="vrijstelling" class="form-control"
                                       value="<?php echo $buiten->vrijstelling; ?>">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="naam">LAF Ontv</label>
                                        <input disabled type="text" id="laf_ontv" name="laf_ontv" class="form-control"
                                               value="<?php echo $buiten->laf_ontv; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="naam">LAF Nummer</label>
                                        <input disabled type="text" id="laf_nummer" name="laf_nummer"
                                               class="form-control" value="<?php echo $buiten->laf_nummer; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="naam">Shipping Method</label>
                                <select disabled class="select form-control" id="shipping_method"
                                        name="shipping_method">
                                    <?php
                                    foreach ($shipping as $r) {
                                        if ($r->id == $buiten->shipping_method) {
                                            $sel = 'selected=selected';
                                        } else {
                                            $sel = '';
                                        }
                                        echo '<option ' . $sel . ' value=' . $r->id . '>' . $r->methode . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="naam">INGEKLAARD DATUM</label>
                                <input disabled type="text" id="ingeklaard_datum" name="ingeklaard_datum" data-date=""
                                       data-date-format="YYYY-MM-DD" data-link-format="yyyy-mm-dd"
                                       data-link-field="ingeklaard_datum" autocomplete="off" class="form-control"
                                       value="<?php echo $buiten->ingeklaard_datum; ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="naam">INGEKLAARD OPMERKING</label>
                                <input disabled type="text" id="ingeklaard_opmerking" name="ingeklaard_opmerking"
                                       class="form-control" value="<?php echo $buiten->ingeklaard_opmerking; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="naam">OVERMAKING DATUM</label>
                                <input disabled type="text" id="overmakingdatum" name="overmakingdatum" data-date=""
                                       data-date-format="YYYY-MM-DD" data-link-format="yyyy-mm-dd"
                                       data-link-field="overmakingdatum" autocomplete="off" class="form-control"
                                       value="<?php echo $buiten->overmakingdatum; ?>">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="naam">OVERMAKING
                                            FILE <?php if (!empty($buiten->overmakingbestand)) { ?><a
                                                href="apps/<?php echo app_name; ?>/documenten/overmakingen/<?php echo $buiten->overmakingbestand; ?>">
                                                    (download)</a><?php } ?></label>
                                        <input disabled type="file" id="overmakingbestandTmp"
                                               name="overmakingbestandTmp" class="form-control" value="">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="naam">Shipping date</label>
                                        <input disabled type="text" id="shipping_date" name="shipping_date" data-date=""
                                               data-date-format="YYYY-MM-DD" data-link-format="yyyy-mm-dd"
                                               data-link-field="shipping_date" autocomplete="off" class="form-control"
                                               value="<?php echo $buiten->shipping_date; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="naam">OVERMAKING TEKST</label>
                                        <input disabled type="text" id="overmakingtekst" name="overmakingtekst"
                                               class="form-control" value="">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="naam">Shipped from</label>
                                        <input disabled type="text" id="shipped_from" name="shipped_from"
                                               class="form-control" value="<?php echo $buiten->shipping_date; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="naam">Estimated Delivery</label>
                                <input disabled type="text" id="shipping_estimated_delivery" data-date=""
                                       data-date-format="YYYY-MM-DD" data-link-format="yyyy-mm-dd"
                                       data-link-field="shipping_estimated_delivery" autocomplete="off"
                                       name="shipping_estimated_delivery" class="form-control"
                                       value="<?php echo $buiten->shipping_estimated_delivery; ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="naam">INGEKLAARD ORO NUMMER</label>
                                <input disabled type="text" id="ingeklaard_oro_nummer" name="ingeklaard_oro_nummer"
                                       class="form-control" value="<?php echo $buiten->ingeklaard_oro_nummer; ?>">
                            </div>
                        </div>
                    </div>
                </div><!-- /.tab-pane -->
            </div><!-- /.tab-content -->
        </div>
        <div class="modal-footer" style="padding: 0px 10px 0px;">
            <div class="clearfix">
                <h4>
                    <span class="pull-left label label-<?php echo getSaldo("id", $buiten->authorisatienr) > 0 ? "primary" : "danger"; ?>">Authorisatie Saldo <?php echo getAuthValuta("id", $buiten->authorisatienr) . ' ' . getSaldo("id", $buiten->authorisatienr); ?></span>
                </h4>
                <h4 class="pull-right"><?php echo getPercentageAuthorisatie("id", $buiten->authorisatienr); ?> %</h4>
            </div>
            <div class="progress sm progress-striped active">
                <div class="progress-bar progress-bar-<?php echo getPercentageBarStateColor(getPercentageAuthorisatie("id", $buiten->authorisatienr)); ?>"
                     role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"
                     style="width: <?php echo getPercentageAuthorisatie("id", $buiten->authorisatienr); ?>%">
                </div>
            </div>
        </div>
</form>
