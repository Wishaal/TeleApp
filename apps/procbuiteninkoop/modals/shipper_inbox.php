<?php
require_once('../../../php/conf/config.php');
require_once('../php/database.php');
require_once('../php/functions.php');

include "../../../domain/procurementBuitenInkoop/User.php";
include "../../../domain/procurementBuitenInkoop/UserRole.php";
include "../../../domain/procurementBuitenInkoop/Role.php";

include "../../../domain/procurementBuitenInkoop/Afdeling.php";
include "../../../domain/procurementBuitenInkoop/Leverancier.php";
include "../../../domain/procurementBuitenInkoop/BuitenlandseInkoop.php";
include "../../../domain/procurementBuitenInkoop/Authorisatie.php";
include "../../../domain/procurementBuitenInkoop/Koers.php";
include "../../../domain/procurementBuitenInkoop/Shipping.php";
include "../../../domain/procurementBuitenInkoop/Betalingsvoorwaarde.php";
include "../../../domain/procurementBuitenInkoop/Leveringsvoorwaarden.php";
include "../../../domain/procurementBuitenInkoop/Deelbetaling.php";
include "../../../domain/procurementBuitenInkoop/Deellevering.php";
include "../../../domain/procurementBuitenInkoop/Landen.php";
include "../../../domain/procurementBuitenInkoop/Status.php";
include "../../../domain/procurementBuitenInkoop/Bestelling.php";
include "../../../domain/procurementBuitenInkoop/FileUpload.php";
include "../../../domain/procurementBuitenInkoop/UploadType.php";
include "../../../domain/procurementBuitenInkoop/Valuta.php";
include "../../../domain/procurementBuitenInkoop/Ontvangst.php";

$bestelling = Bestelling::whereAanvraagNr($_GET['id'])->first();
$valuta = Valuta::all(array('valutacode', 'valutanaam'));
$afdeling = Afdeling::all(array('afdelingcode', 'afdelingnaam', 'kostenplaatscode'));
$landen = Landen::all(array('id', 'nicename'));
$betalingv = Betalingsvoorwaarde::all(array('id', 'omschrijving'));
$leveringsv = Leveringsvoorwaarden::all(array('id', 'omschrijving'));
$statussen = Status::whereSoort("betaling")->get(array('id', 'status_omschrijving'));
$shipping = Shipping::all(array('id', 'methode'));
$authorisatie = Authorisatie::all(array('id', 'authorisatienr', 'valuta'));
$deelbetalingen = Deelbetaling::whereAanvraagId($bestelling->id)->get();
$deelleveringen = Deellevering::whereAanvraagId($bestelling->id)->get();
$leverancier = Leverancier::all(array('id', 'name'));
$buiten = BuitenlandseInkoop::whereAanvraagId($bestelling->id)->first();
$ontvangst = Ontvangst::whereAanvraagId($bestelling->id)->first();
$files = FileUpload::whereAanvraagId($bestelling->id)->get();
?>
<form
        action="apps/<?php echo app_name; ?>/shipper_inbox.php?action=<?php echo $_GET['action']; ?>&recordId=<?php echo $bestelling->id; ?>"
        method="post" name="inputform" id="inputform" enctype="multipart/form-data" xmlns="http://www.w3.org/1999/html">
    <input type="hidden" id="aanvraag_id" name="aanvraag_id" value="<?php echo $bestelling->id; ?>">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?php echo ucfirst($_GET['action']); ?> Invoer | Aanvraag #
            : <?php echo $_GET['id']; ?></h4>
    </div>
    <div class="modal-body" style="padding: 0px;">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">Aanvraag Informatie</a></li>
                <li><a href="#tab_7" data-toggle="tab">Buitenland Informatie</a></li>
                <li><a href="#tab_5" data-toggle="tab">Bestelling Informatie</a></li>
                <li><a href="#tab_3" data-toggle="tab">Documenten (Offertes etc...)</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="naam">Shipping Method</label>
                                <select class="select form-control" id="shipping_method" name="shipping_method">
                                    <option></option>
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
                                <label class="control-label" for="naam">Shipping date</label>
                                <input type="text" id="shipping_date" name="shipping_date" data-date=""
                                       data-date-format="YYYY-MM-DD" data-link-format="yyyy-mm-dd"
                                       data-link-field="shipping_date"
                                       autocomplete="off" class="form-control"
                                       value="<?php echo ($buiten->shipping_date == "0000-00-00") ? '' : $buiten->shipping_date; ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="naam">Shipped from</label>
                                <select class="select form-control" id="shipped_from" name="shipped_from">
                                    <option></option>
                                    <?php
                                    foreach ($landen as $r) {
                                        if ($r->id == $buiten->shipped_from) {
                                            $sel = 'selected=selected';
                                        } else {
                                            $sel = '';
                                        }
                                        echo '<option ' . $sel . ' value=' . $r->id . '>' . $r->nicename . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="naam">BO Upload</label>
                                <input type="file" id="bofileTmp" multiple="multiple" name="bofileTmp[]"
                                       class="form-control" value="">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="naam">BO DATUM</label>
                                <input type="text" id="bo" name="bo" data-date="" data-date-format="YYYY-MM-DD"
                                       data-link-format="yyyy-mm-dd" data-link-field="bo" autocomplete="off"
                                       class="form-control"
                                       value="<?php echo ($buiten->bo == "0000-00-00") ? '' : $buiten->bo; ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="naam">Aantal defect</label>
                                <input type="text" id="ontv_aantal_defect" name="ontv_aantal_defect"
                                       class="form-control" value="<?php echo $ontvangst->ontv_aantal_defect; ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="naam">Staat defect</label>
                                <input type="text" id="ontv_staat_defect" name="ontv_staat_defect" class="form-control"
                                       value="<?php echo $ontvangst->ontv_staat_defect; ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="naam">Niet compleet</label>
                                <input type="text" id="ontv_niet_compleet" name="ontv_niet_compleet"
                                       class="form-control" value="<?php echo $ontvangst->ontv_niet_compleet; ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab_7">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="naam">PO #</label>
                                <input disabled type="text" id="po_nr" name="po_nr" class="form-control"
                                       value="<?php echo $buiten->po_nr; ?>">
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
                            <div class="form-group">
                                <label class="control-label" for="naam">Afdeling</label>
                                <select disabled class="selectpicker form-control" data-live-search="true" id="afdeling"
                                        name="afdeling">
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
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="naam">Valuta</label>
                                        <select disabled class="form-control" id="valuta" name="valuta">
                                            <?php
                                            foreach ($valuta as $r) {
                                                if ($r->valutacode == $buiten->valuta) {
                                                    $sel = 'selected=selected';
                                                } else {
                                                    $sel = '';
                                                }
                                                echo '<option ' . $sel . ' value=' . $r->valutacode . '>' . $r->valutacode . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="naam">Bedrag</label>
                                        <input disabled type="text" id="bedrag" name="bedrag" class="form-control"
                                               value="<?php echo $buiten->bedrag; ?>">
                                    </div>

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="naam">LAF Nummer</label>
                                <input disabled type="text" id="laf_nummer" name="laf_nummer" class="form-control"
                                       value="<?php echo $buiten->laf_nummer; ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="naam">Estimated Delivery</label>
                                <input disabled type="text" id="shipping_estimated_delivery" data-date=""
                                       data-date-format="YYYY-MM-DD"
                                       data-link-format="yyyy-mm-dd" data-link-field="shipping_estimated_delivery"
                                       autocomplete="off" name="shipping_estimated_delivery" class="form-control"
                                       value="<?php echo ($buiten->shipping_estimated_delivery == "0000-00-00") ? '' : $buiten->shipping_estimated_delivery; ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="naam">BO DATUM</label>
                                <input disabled type="text" id="bo" name="bo" data-date="" data-date-format="YYYY-MM-DD"
                                       data-link-format="yyyy-mm-dd" data-link-field="bo" autocomplete="off"
                                       class="form-control"
                                       value="<?php echo ($buiten->bo == "0000-00-00") ? '' : $buiten->bo; ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="naam">ORO No.</label>
                                <input disabled type="text" id="ingeklaard_oro_nummer" name="ingeklaard_oro_nummer"
                                       class="form-control"
                                       value="<?php echo $buiten->ingeklaard_oro_nummer; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="naam">PO Upload</label>
                                <input disabled type="file" id="pofileTmp" multiple="multiple" name="pofileTmp[]"
                                       class="form-control" value="">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="naam">CONTRACT /OFFERTE/FACTUUR #</label>
                                <input disabled type="text" id="cof_nr" name="cof_nr" class="form-control"
                                       value="<?php echo $buiten->cof_nr; ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="naam">Shipped from</label>
                                <select disabled class="select form-control" id="shipped_from" name="shipped_from">
                                    <?php
                                    foreach ($landen as $r) {
                                        if ($r->id == $buiten->shipped_from) {
                                            $sel = 'selected=selected';
                                        } else {
                                            $sel = '';
                                        }
                                        echo '<option ' . $sel . ' value=' . $r->id . '>' . $r->nicename . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="naam">BETALINGSVOORWAARDEN</label>
                                <select disabled class="select form-control" id="betalingsvoorwaarden"
                                        name="betalingsvoorwaarden">
                                    <?php
                                    foreach ($betalingv as $r) {
                                        if ($r->id == $buiten->betalingsvoorwaarden) {
                                            $sel = 'selected=selected';
                                        } else {
                                            $sel = '';
                                        }
                                        echo '<option ' . $sel . ' value=' . $r->id . '>' . $r->omschrijving . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="naam">Laf ontvangsten Upload</label>
                                <input disabled type="file" id="laffileTmp" multiple="multiple" name="laffileTmp[]"
                                       class="form-control" value="">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="naam">Shipping date</label>
                                        <input disabled type="text" id="shipping_date" name="shipping_date" data-date=""
                                               data-date-format="YYYY-MM-DD" data-link-format="yyyy-mm-dd"
                                               data-link-field="shipping_date"
                                               autocomplete="off" class="form-control"
                                               value="<?php echo ($buiten->shipping_date == "0000-00-00") ? '' : $buiten->shipping_date; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="naam">INGEKL. DATUM</label>
                                        <input disabled type="text" id="ingeklaard_datum" name="ingeklaard_datum"
                                               data-date=""
                                               data-date-format="YYYY-MM-DD" data-link-format="yyyy-mm-dd"
                                               data-link-field="ingeklaard_datum" autocomplete="off"
                                               class="form-control"
                                               value="<?php echo ($buiten->ingeklaard_datum == "0000-00-00") ? '' : $buiten->ingeklaard_datum; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="naam">BO Upload</label>
                                <input disabled type="file" id="bofileTmp" multiple="multiple" name="bofileTmp[]"
                                       class="form-control" value="">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="naam">ORO Upload</label>
                                <input disabled type="file" id="orofileTmp" multiple="multiple" name="orofileTmp[]"
                                       class="form-control" value="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="naam">PO Datum</label>
                                <input disabled type="text" id="po_datum" name="po_datum" data-date=""
                                       data-date-format="YYYY-MM-DD"
                                       data-link-format="yyyy-mm-dd" data-link-field="po_datum" autocomplete="off"
                                       class="form-control"
                                       value="<?php echo ($buiten->po_datum == "0000-00-00") ? '' : $buiten->po_datum; ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="naam">Contract Upload</label>
                                <input disabled type="file" id="contractfileTmp" multiple="multiple"
                                       name="contractfileTmp[]"
                                       class="form-control" value="">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="naam">LEVERINGSVOORWAARDEN</label>
                                <select disabled class="select form-control" id="leveringsvoorwaarden"
                                        name="leveringsvoorwaarden">
                                    <?php
                                    foreach ($leveringsv as $r) {
                                        if ($r->id == $buiten->leveringsvoorwaarden) {
                                            $sel = 'selected=selected';
                                        } else {
                                            $sel = '';
                                        }
                                        echo '<option ' . $sel . ' value=' . $r->id . '>' . $r->omschrijving . '</option>';
                                    }
                                    ?>
                                </select>
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
                                <label class="control-label" for="naam">Vrijstelling</label>
                                <input disabled type="text" id="vrijstelling" name="vrijstelling" class="form-control"
                                       value="<?php echo $buiten->vrijstelling; ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="naam">Ingekl. Upload</label>
                                <input disabled type="file"
                                       id="ingeklaardfileTmp" <?php echo (getInkoopPermisson('BUITENLAND_INKLAARDER')) ? '' : 'disabled'; ?>
                                       multiple="multiple" name="ingeklaardfileTmp[]"
                                       class="form-control" value="">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="naam">Factuur Datum</label>
                                <input disabled type="text" id="factuur_datum" name="factuur_datum" data-date=""
                                       data-date-format="YYYY-MM-DD"
                                       data-link-format="yyyy-mm-dd" data-link-field="factuur_datum" autocomplete="off"
                                       class="form-control"
                                       value="<?php echo ($buiten->factuur_datum == "0000-00-00") ? '' : $buiten->factuur_datum; ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="naam">OVERMAKING DATUM</label>
                                <input disabled type="text" id="overmakingdatum" name="overmakingdatum" data-date=""
                                       data-date-format="YYYY-MM-DD" data-link-format="yyyy-mm-dd"
                                       data-link-field="overmakingdatum"
                                       autocomplete="off" class="form-control"
                                       value="<?php echo ($buiten->overmakingdatum == "0000-00-00") ? '' : $buiten->overmakingdatum; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="naam">Auth #</label>
                                <select disabled class="select form-control" id="authorisatienr" name="authorisatienr">
                                    <option>Geen</option>
                                    <?php
                                    foreach ($authorisatie as $r) {
                                        if ($r->id == $bestelling->authorisatie_id) {
                                            $sel = 'selected=selected';
                                        } else {
                                            $sel = '';
                                        }
                                        echo '<option ' . $sel . ' value=' . $r->id . '>' . $r->authorisatienr . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="naam">Omschrijving</label>
                                <textarea disabled id="omschrijving" name="omschrijving"
                                          class="form-control"><?php echo $buiten->omschrijving; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="naam">DELIVERY</label>
                                <input disabled type="text" id="delivery" name="delivery" data-date=""
                                       data-date-format="YYYY-MM-DD"
                                       data-link-format="yyyy-mm-dd" data-link-field="delivery" autocomplete="off"
                                       class="form-control" value="<?php echo $buiten->delivery; ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="naam">Deellevering</label>
                                <select disabled class="form-control" id="deellevering" name="deellevering">
                                    <option value="USD">JA</option>
                                    <option value="EURO">Nee</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="naam">Vrijstelling Upload</label>
                                <input disabled type="file" id="vrijstellingfileTmp" multiple="multiple"
                                       name="vrijstellingfileTmp[]"
                                       class="form-control" value="">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="naam">Deelbetaling</label>
                                <select disabled class="form-control" id="deelbetaling" name="deelbetaling">
                                    <option value="USD">JA</option>
                                    <option value="EURO">Nee</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="naam">OVERMAKING FILE Upload</label>
                                <input disabled type="file" id="overmakingbestandTmp" multiple="multiple"
                                       name="overmakingbestandTmp[]"
                                       class="form-control" value="">
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="naam">Opmerkingen</label>
                                <textarea class="form-control" disabled id="ingeklaard_opmerking"
                                          name="ingeklaard_opmerking"><?php echo $buiten->ingeklaard_opmerking; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab_5">
                    <!-- start basic details like request date and user info-->
                    <div class="row form-horizontal">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="naam">Aanvraag datum</label>
                                <div class="col-sm-9">
                                    <input disabled type="text" id="bstl_aanvraag_datum" name="bstl_aanvraag_datum"
                                           class="form-control"
                                           value="<?php echo (!empty($bestelling->bstl_aanvraag_datum)) ? $bestelling->bstl_aanvraag_datum : date("Y-m-d"); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="naam">Afdeling</label>
                                <div class="col-sm-9">
                                    <input type="text" disabled id="bstl_afdeling" readonly name="bstl_afdeling"
                                           class="form-control"
                                           value="<?php echo (!empty($bestelling->bstl_afdeling)) ? $bestelling->bstl_afdeling : getAppUserAfdeling(); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="naam">Contactpersoon</label>
                                <div class="col-sm-9">
                                    <input type="text" disabled id="bstl_contactpersoon" name="bstl_contactpersoon"
                                           class="form-control" value="<?php echo $bestelling->bstl_contactpersoon; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="naam">Auth #</label>
                                <div class="col-sm-9">
                                    <select disabled class="select form-control" id="authorisatie_id"
                                            name="authorisatie_id">
                                        <option>Geen</option>
                                        <?php
                                        foreach ($authorisatie as $r) {
                                            if ($r->id == $bestelling->authorisatie_id) {
                                                $sel = 'selected=selected';
                                            } else {
                                                $sel = '';
                                            }
                                            echo '<option ' . $sel . ' value=' . $r->id . '>' . $r->authorisatienr . ' | Projectcode: ' . $r->Projectcode . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="naam">Ingevoerd door</label>
                                <div class="col-sm-9">
                                    <input disabled type="text" id="bstl_ingevoerd_door" name="bstl_ingevoerd_door"
                                           class="form-control"
                                           value="<?php echo $_SESSION['mis']['user']['badgenr']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="naam">T.b.v</label>
                                <div class="col-sm-9">
                                    <input type="text" disabled id="bstl_tbv" name="bstl_tbv" class="form-control"
                                           value="<?php echo $bestelling->bstl_tbv; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr style="margin: 0 0 10px 0;border-style: solid;border-color: #2B8836;border-width: 1px 0 0 0;">
                    <!---- end basic info --->
                    <div class="row form-horizontal">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="naam">Artikelcode</label>
                                <div class="col-sm-9">
                                    <input type="text" id="bstl_artikelcode" disabled name="bstl_artikelcode"
                                           class="form-control" value="<?php echo $bestelling->bstl_artikelcode; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="naam">Omschrijving</label>
                                <div class="col-sm-9">
                                    <textarea id="bstl_omschrijving" disabled name="bstl_omschrijving"
                                              class="form-control"><?php echo $bestelling->bstl_omschrijving; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="naam">Te bestellen</label>
                                <div class="col-sm-9">
                                    <input type="text" id="bstl_te_bestellen" disabled name="bstl_te_bestellen"
                                           class="form-control" value="<?php echo $bestelling->bstl_te_bestellen; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="naam">Eenheid</label>
                                <div class="col-sm-9">
                                    <input type="text" id="bstl_eenheid" disabled name="bstl_eenheid"
                                           class="form-control" value="<?php echo $bestelling->bstl_eenheid; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="naam">Huidig voorraad</label>
                                <div class="col-sm-9">
                                    <input type="text" id="bstl_huidig_voorraad" disabled name="bstl_huidig_voorraad"
                                           class="form-control"
                                           value="<?php echo $bestelling->bstl_huidig_voorraad; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="naam">Verbruik voorgaand jr</label>
                                <div class="col-sm-9">
                                    <input type="text" id="bstl_verbruik_voorgaand_jr" disabled
                                           name="bstl_verbruik_voorgaand_jr" class="form-control"
                                           value="<?php echo $bestelling->bstl_verbruik_voorgaand_jr; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="naam">Opmerkingen</label>
                                <div class="col-sm-9">
                                    <textarea id="bstl_opmerkingen" name="bstl_opmerkingen" disabled
                                              class="form-control"><?php echo $bestelling->bstl_opmerkingen; ?></textarea>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab_3">
                    <table class="table table-bordered table-striped dataTable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Soort</th>
                            <th>Naam</th>
                            <th>Download</th>
                            <th>Datum</th>
                            <th>Delete?</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $count = 1;
                        foreach ($files as $r) {
                            echo '<tr class="clickable-row" id =' . $r->id . ' naam ="' . $r->getUploadType->up_soort . '"">
                                    <td>' . $count . '</td>
                                    <td>' . $r->getUploadType->up_soort . '</td>
                                    <td>' . $r->filenaam . '</td>
                                    <td><a href="apps/' . app_name . '/' . $r->file_path . $r->filenaam . '">Download</a></td>
                                    <td>' . $r->created_at . '</td>
                                    <td><div class="btn btn-sm btn-danger delete_class" id="' . $r->id . '" >DELETE</div></td>
                                    '; ?>
                            </td>
                            </tr>
                            <?php
                            $count++;
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="btn_submit">Save changes</button>
    </div>
</form>
<script>
    $('#shipping_estimated_delivery').datetimepicker({
        pickTime: false,
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
    $('#factuur_datum').datetimepicker({
        pickTime: false,
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
    $('#shipping_date').datetimepicker({
        pickTime: false,
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
    $('#bo').datetimepicker({
        pickTime: false,
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
    $('#overmakingdatum').datetimepicker({
        pickTime: false,
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
    $('#po_datum').datetimepicker({
        pickTime: false,
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
    $('#ingeklaard_datum').datetimepicker({
        pickTime: false,
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
    $('#deel_bo_datum').datetimepicker({
        pickTime: false,
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
    $('#delivery').datetimepicker({
        pickTime: false,
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
    $('.selectpicker').selectpicker({});

    $('.delete_class').click(function () {
        var tr = $(this).closest('tr'),
            del_id = $(this).attr('id');
        //alert(del_id);
        $.ajax({
            url: "apps/procbuiteninkoop/ajax/deleteFileBinnenland.php?id=" + del_id,
            cache: false,
            success: function (result) {
                tr.fadeOut(1000, function () {
                    $(this).remove();
                });
            }
        });
    });

    $(document).ready(function () {
        var inputs = 1;

        $('#btnAdd').click(function () {
            $('.btnDel:disabled').removeAttr('disabled');
            var c = $('.clonedInput:first').clone(true);
            c.children(':text').attr('name', 'input' + (++inputs));
            $('.clonedInput:last').after(c);
        });

        $('.btnDel').click(function () {
            if (confirm('continue delete?')) {
                --inputs;
                $(this).closest('.clonedInput').remove();
                $('.btnDel').attr('disabled', ($('.clonedInput').length < 2));
            }
        });

        var inputs2 = 1;

        $('#btnAdd2').click(function () {
            $('.btnDel2:disabled').removeAttr('disabled');
            var c = $('.clonedInputLevering:first').clone(true);
            c.children(':text').attr('name', 'input' + (++inputs2));
            $('.clonedInputLevering:last').after(c);
        });

        $('.btnDel2').click(function () {
            if (confirm('continue delete?')) {
                --inputs2;
                $(this).closest('.clonedInputLevering').remove();
                $('.btnDel2').attr('disabled', ($('.clonedInputLevering').length < 2));
            }
        });


    });
</script>

