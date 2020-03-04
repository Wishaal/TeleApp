<?php
require_once('../../../../php/conf/config.php');
require_once('../../php/database.php');
require_once('../../php/functions.php');
include "../../../../domain/procurementBuitenInkoop/User.php";
include "../../../../domain/procurementBuitenInkoop/UserRole.php";
include "../../../../domain/procurementBuitenInkoop/Role.php";
include "../../../../domain/procurementBuitenInkoop/Bestelling.php";
include "../../../../domain/procurementBuitenInkoop/BinnenlandseInkoop.php";
include "../../../../domain/procurementBuitenInkoop/Leverancier.php";
include "../../../../domain/procurementBuitenInkoop/Authorisatie.php";
include "../../../../domain/procurementBuitenInkoop/Betalingsvoorwaarde.php";
include "../../../../domain/procurementBuitenInkoop/Leveringsvoorwaarden.php";
include "../../../../domain/procurementBuitenInkoop/FileUpload.php";
include "../../../../domain/procurementBuitenInkoop/UploadType.php";
include "../../../../domain/procurementBuitenInkoop/Deelbetaling.php";
include "../../../../domain/procurementBuitenInkoop/Deellevering.php";
include "../../../../domain/procurementBuitenInkoop/Status.php";
include "../../../../domain/procurementBuitenInkoop/Valuta.php";

$bestelling = Bestelling::whereAanvraagNr($_GET['id'])->first();
$authorisatie = Authorisatie::all(array('id', 'authorisatienr', 'Onderwerp', 'Projectcode'));
$leverancier = Leverancier::all(array('id', 'name'));
$betalingv = Betalingsvoorwaarde::all(array('id', 'omschrijving'));
$leveringsv = Leveringsvoorwaarden::all(array('id', 'omschrijving'));
$valuta = Valuta::all(array('valutacode', 'valutanaam'));
$deelbetalingen = Deelbetaling::whereAanvraagId($bestelling->id)->get();
$deelleveringen = Deellevering::whereAanvraagId($bestelling->id)->get();
$statussen = Status::whereSoort("betaling")->get(array('id', 'status_omschrijving'));
$binnen = BinnenlandseInkoop::whereAanvraagId($bestelling->id)->first();
$files = FileUpload::whereAanvraagId($bestelling->id)->get();
?>
<form name="inputform" id="inputform" enctype="multipart/form-data">
    <input type="hidden" id="aanvraag_id" name="aanvraag_id" value="<?php echo $bestelling->id; ?>">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?php echo ucfirst($_GET['action']); ?> Invoer</h4>
    </div>
    <div class="modal-body" style="padding: 0px;">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">Aanvraag Informatie</a></li>
                <li><a href="#tab_2" data-toggle="tab">Meer infomatie</a></li>
                <!--                <li><a href="#tab_4" data-toggle="tab">Deelleveringen</a></li>-->
                <li><a href="#tab_3" data-toggle="tab">Documenten (Offertes etc...)</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="naam">Bestelbon nummer</label>
                                <input disabled type="text" id="inbver_bestelbonnr" name="inbver_bestelbonnr"
                                       class="form-control"
                                       value="<?php echo $binnen->inbver_bestelbonnr; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="naam">Auth #</label>
                                <select disabled class="selectpicker form-control" id="authorisatie_id"
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
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="naam">Saldo</label>
                                <input type="text" disabled id="inbver_saldo" name="inbver_saldo" class="form-control"
                                       value="">
                            </div>
                        </div>
                        <div class="col-md-3">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="naam">Datum Prijsvergelijking </label>
                                <input disabled type="text" id="inbver_prijsvergelijking_datum"
                                       name="inbver_prijsvergelijking_datum" data-date=""
                                       data-date-format="YYYY-MM-DD" data-link-format="yyyy-mm-dd"
                                       data-link-field="inbver_prijsvergelijking_datum"
                                       autocomplete="off" class="form-control"
                                       value="<?php echo ($binnen->inbver_prijsvergelijking_datum == "0000-00-00") ? '' : $binnen->inbver_prijsvergelijking_datum; ?>">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="naam">Prijs verg. Upload</label>
                                <input type="file" id="prijs_vergfileTmp" multiple="multiple" name="prijs_vergfileTmp[]"
                                       class="form-control" value="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="naam">Offerte Upload</label>
                                <input disabled type="file" id="offertefileTmp" multiple="multiple"
                                       name="offertefileTmp[]"
                                       class="form-control" value="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="naam">Offerte Opvr. Datum</label>
                                <input disabled type="text" id="inbver_offerte_opvraag_datum"
                                       name="inbver_offerte_opvraag_datum"
                                       data-date=""
                                       data-date-format="YYYY-MM-DD" data-link-format="yyyy-mm-dd"
                                       data-link-field="inbver_offerte_opvraag_datum"
                                       autocomplete="off" class="form-control"
                                       value="<?php echo ($binnen->inbver_offerte_opvraag_datum == "0000-00-00") ? '' : $binnen->inbver_offerte_opvraag_datum; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="naam">Offerte #</label>
                                        <input disabled type="text" id="offertenummer" name="offertenummer"
                                               class="form-control nummer"
                                               value="<?php echo $binnen->offertenummer; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="naam">Offerte Datum</label>
                                        <input disabled type="text" id="inbver_offertes_datum"
                                               name="inbver_offertes_datum" data-date=""
                                               data-date-format="YYYY-MM-DD" data-link-format="yyyy-mm-dd"
                                               data-link-field="inbver_offertes_datum"
                                               autocomplete="off" class="form-control"
                                               value="<?php echo ($binnen->inbver_offertes_datum == "0000-00-00") ? '' : $binnen->inbver_offertes_datum; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="naam">Leverancier</label>
                                <select disabled class="selectpicker form-control" id="leverancier_id"
                                        name="leverancier_id">
                                    <?php
                                    foreach ($leverancier as $r) {
                                        if ($r->id == $binnen->leverancier_id) {
                                            $sel = 'selected=selected';
                                        } else {
                                            $sel = '';
                                        }
                                        echo '<option ' . $sel . ' value=' . $r->id . '>' . $r->name . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="naam">BETALINGSVOORWAARDEN</label>
                                <select disabled class="selectpicker form-control" id="betalingsvoorwaarden"
                                        name="betalingsvoorwaarden">
                                    <?php
                                    foreach ($betalingv as $r) {
                                        if ($r->id == $binnen->betalingsvoorwaarden) {
                                            $sel = 'selected=selected';
                                        } else {
                                            $sel = '';
                                        }
                                        echo '<option ' . $sel . ' value=' . $r->id . '>' . $r->omschrijving . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="naam">LEVERINGSVOORWAARDEN</label>
                                <select disabled class="selectpicker form-control" id="leveringsvoorwaarden"
                                        name="leveringsvoorwaarden">
                                    <?php
                                    foreach ($leveringsv as $r) {
                                        if ($r->id == $binnen->leveringsvoorwaarden) {
                                            $sel = 'selected=selected';
                                        } else {
                                            $sel = '';
                                        }
                                        echo '<option ' . $sel . ' value=' . $r->id . '>' . $r->omschrijving . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="naam">Valuta</label>
                                        <select disabled class="form-control" id="inbver_valuta_eenheidprijs"
                                                name="inbver_valuta_eenheidprijs">
                                            <?php
                                            foreach ($valuta as $r) {
                                                if ($r->valutacode == $binnen->inbver_valuta_eenheidprijs) {
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
                                        <label class="control-label" for="naam">Aantal</label>
                                        <input disabled type="text" id="inbver_aantal" name="inbver_aantal"
                                               class="form-control nummer"
                                               value="<?php echo $binnen->inbver_aantal; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="naam">Eenheidprijs</label>
                                <input disabled type="text" id="inbver_eenheidprijs" name="inbver_eenheidprijs"
                                       class="form-control"
                                       value="<?php echo $binnen->inbver_eenheidprijs; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="naam">Korting in bedrag</label>
                                <input disabled type="text" id="inbver_korting_in_bedrag"
                                       name="inbver_korting_in_bedrag"
                                       class="form-control"
                                       value="<?php echo $binnen->inbver_korting_in_bedrag; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="naam">Totaal te bet.</label>
                                <input disabled type="text" id="inbver_totaal_te_betalen"
                                       name="inbver_totaal_te_betalen"
                                       class="form-control"
                                       value="<?php echo $binnen->inbver_totaal_te_betalen; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="naam">Datum getekende bestel bon H-Proc</label>
                                <input <?php echo((empty($binnen->inbver_getekende_bestelbon_datum) || ($binnen->inbver_getekende_bestelbon_dir_datum == "0000-00-00")) ? "" : "disabled"); ?>
                                        disabled type="text" id="inbver_getekende_bestelbon_datum"
                                        name="inbver_getekende_bestelbon_datum" data-date=""
                                        data-date-format="YYYY-MM-DD" data-link-format="yyyy-mm-dd"
                                        data-link-field="inbver_getekende_bestelbon_datum"
                                        autocomplete="off" class="form-control"
                                        value="<?php echo ($binnen->inbver_getekende_bestelbon_datum == "0000-00-00") ? '' : $binnen->inbver_getekende_bestelbon_datum; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="naam">Dat. Getek. best.bon Dir </label>
                                <input type="text" id="inbver_getekende_bestelbon_dir_datum"
                                    <?php echo((!empty($binnen->inbver_getekende_bestelbon_datum) && ($binnen->inbver_getekende_bestelbon_datum != "0000-00-00")) ? "" : "disabled"); ?>
                                       disabled name="inbver_getekende_bestelbon_dir_datum" data-date=""
                                       data-date-format="YYYY-MM-DD" data-link-format="yyyy-mm-dd"
                                       data-link-field="inbver_getekende_bestelbon_dir_datum"
                                       autocomplete="off" class="form-control"
                                       value="<?php echo ($binnen->inbver_getekende_bestelbon_dir_datum == "0000-00-00") ? '' : $binnen->inbver_getekende_bestelbon_dir_datum; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="naam">Upload get. bestelbon</label>
                                <input disabled type="file" id="bestelbonfileTmp" multiple="multiple"
                                       name="bestelbonfileTmp[]"
                                       class="form-control" value="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="naam">Datum Levering bestelbon </label>
                                <input type="text" id="inbver_levering_bestelbon_datum"
                                    <?php echo (!empty($binnen->inbver_getekende_bestelbon_dir_datum) && (empty($binnen->inbver_getekende_bestelbon_dir_datum) || ($binnen->inbver_levering_bestelbon_datum))) == "0000-00-00" ? "" : "disabled"; ?>
                                       disabled name="inbver_levering_bestelbon_datum" data-date=""
                                       data-date-format="YYYY-MM-DD" data-link-format="yyyy-mm-dd"
                                       data-link-field="inbver_levering_bestelbon_datum"
                                       autocomplete="off" class="form-control"
                                       value="<?php echo ($binnen->inbver_levering_bestelbon_datum == "0000-00-00") ? '' : $binnen->inbver_levering_bestelbon_datum; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="control-label" for="naam">Opmerkingen</label>
                                <textarea disabled id="inbver_opmerkingen" name="inbver_opmerkingen" rows="2"
                                          class="form-control"><?php echo $binnen->inbver_opmerkingen; ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="naam">Door sturen naar Inventory?</label>

                                <select disabled class="selectpicker form-control" id="inbver_doorsturen"
                                        name="inbver_doorsturen">
                                    <option></option>
                                    <option value="Nee" <?php echo ($binnen->inbver_doorsturen) == "Nee" ? "selected=selected" : "" ?>>
                                        Nee
                                    </option>
                                    <option value="Ja" <?php echo ($binnen->inbver_doorsturen) == "Ja" ? "selected=selected" : "" ?>>
                                        Ja
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="tab-pane" id="tab_2">
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
                <div class="tab-pane" id="tab_4">
                    <div class="row">
                        <?php if (count($deelleveringen) > 0) {
                            $count = 1;
                            foreach ($deelleveringen as $deellevering) { ?>
                                <div class="form-group clonedInputLevering" style="padding-bottom: 30px;">
                                    <div class="col-sm-1">
                                        <label><?php echo $count; ?></label>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" placeholder="aantal..." name="aantal[]"
                                               value="<?php echo $deellevering->aantal; ?>"
                                               id="aantal">
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" placeholder="opmerking..."
                                               name="opmerking[]" value="<?php echo $deellevering->opmerking; ?>"
                                               id="opmerking">
                                    </div>
                                    <div class="col-sm-2 ">
                                        <input type="button" class="btn btn-danger pull-right btnDel2" value="Delete"
                                               disabled="disabled"/>
                                    </div>
                                </div>
                                <?php $count++;
                            }
                        } else { ?>
                            <div class="form-group clonedInputLevering" style="padding-bottom: 30px;">
                                <div class="col-sm-1">
                                    <label></label>
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" placeholder="aantal..." name="aantal[]"
                                           id="bedrag">
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" placeholder="opmerking..."
                                           name="opmerking[]"
                                           id="opmerking">
                                </div>
                                <div class="col-sm-2 ">
                                    <input type="button" class="btn btn-danger pull-right btnDel2" value="Delete"
                                           disabled="disabled"/>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="button" class="btn btn-success pull-right" id="btnAdd2"
                                       value="Add rows +"/>
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
    </div>
</form>