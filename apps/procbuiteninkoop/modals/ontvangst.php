<?php
require_once('../../../php/conf/config.php');
require_once('../php/database.php');
require_once('../php/functions.php');

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

include "../../../domain/procurementBuitenInkoop/Artikel.php";
include "../../../domain/procurementBuitenInkoop/Ontvangst.php";
include "../../../domain/procurementBuitenInkoop/Leverancier.php";
include "../../../domain/procurementBuitenInkoop/OntvangstType.php";
include "../../../domain/procurementBuitenInkoop/OntvangstLokatie.php";
include "../../../domain/procurementBuitenInkoop/TeleAppUsers.php";
include "../../../domain/procurementBuitenInkoop/Bestelling.php";
include "../../../domain/procurementBuitenInkoop/User.php";
include "../../../domain/procurementBuitenInkoop/UserRole.php";
include "../../../domain/procurementBuitenInkoop/Role.php";
include "../../../domain/procurementBuitenInkoop/BuitenlandseInkoop.php";
include "../../../domain/procurementBuitenInkoop/BinnenlandseInkoop.php";
include "../../../domain/procurementBuitenInkoop/FileUpload.php";
include "../../../domain/procurementBuitenInkoop/UploadType.php";
include "../../../domain/procurementBuitenInkoop/Authorisatie.php";
include "../../../domain/procurementBuitenInkoop/Betalingsvoorwaarde.php";
include "../../../domain/procurementBuitenInkoop/Leveringsvoorwaarden.php";
include "../../../domain/procurementBuitenInkoop/Deelbetaling.php";
include "../../../domain/procurementBuitenInkoop/Deellevering.php";
include "../../../domain/procurementBuitenInkoop/Valuta.php";
include "../../../domain/procurementBuitenInkoop/Landen.php";

$landen = Landen::all(array('id', 'nicename'));
$bestelling = Bestelling::find($_GET['aanvraagID']);
$authorisatie = Authorisatie::all(array('id', 'authorisatienr', 'Onderwerp', 'Projectcode'));
if (getInkoopPermisson('Voorbereider')) {
    $files = FileUpload::whereAanvraagId($_GET['aanvraagID'])
        ->whereUploadTypeId('13')->get();
} else {
    $files = FileUpload::whereAanvraagId($_GET['aanvraagID'])->get();
}
$leverancier = Leverancier::all(array('id', 'name'));
$betalingv = Betalingsvoorwaarde::all(array('id', 'omschrijving'));
$leveringsv = Leveringsvoorwaarden::all(array('id', 'omschrijving'));
$valuta = Valuta::all(array('valutacode', 'valutanaam'));
$deelbetalingen = Deelbetaling::whereAanvraagId($bestelling->id)->get();
$lokaties = OntvangstLokatie::all(array('id', 'lokatie'));
$ontvangenTypes = OntvangstType::all(array('id', 'type'));
$users = TeleAppUsers::whereAfd("IM")->get(array('id', 'username'));
$ontvangst = Ontvangst::find($_GET['id']);
$deelleveringen = Deellevering::whereAanvraagId($bestelling->id)->get();

$deelLeveringTotals = 0;
foreach ($deelleveringen as $r) {
    $deelLeveringTotals += $r->aantal;
}


$datum = null;
$factuurnummer = null;
$factuurbedrag = null;
$besteldaantal = null;

if ($_GET['type'] == '0') {
    $binnenland = BinnenlandseInkoop::whereAanvraagId($_GET['aanvraagID'])->first();
    $leverancier_id = $binnenland->leverancier_id;
    $datum = $binnenland->inbver_levering_bestelbon_datum;
    $factuurbedrag = $binnenland->inbver_totaal_te_betalen;
    $factuurnummer = $binnenland->inbver_bestelbonnr;
    $besteldaantal = $binnenland->inbver_aantal;
    $binnen = BinnenlandseInkoop::whereAanvraagId($_GET['aanvraagID'])->first();
    $tab = '1';
} else {
    $buitenland = BuitenlandseInkoop::whereAanvraagId($_GET['aanvraagID'])->first();
    $buiten = BuitenlandseInkoop::whereAanvraagId($bestelling->id)->first();
    $datum = $buitenland->ingeklaard_datum;
    $factuurnummer = $buitenland->cof_nr;
    $factuurbedrag = $buitenland->bedrag;
    $leverancier_id = $buitenland->leverancier_id;
    $besteldaantal = $ontvangst->ontv_aantal;
    $tab = '2';
}
?>

<form action="apps/<?php echo app_name; ?>/ontvangst.php?action=<?php echo $_GET['action']; ?>&recordId=<?php echo $_GET['id']; ?>&type=<?php echo $_GET['type']; ?>#tab_<?php echo $tab; ?>"
      method="post" enctype="multipart/form-data" name="inputform" id="inputform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?php echo ucfirst($_GET['action']); ?> Ontvangst |
            Aanvraagnr: <?php echo $bestelling->aanvraag_nr; ?></h4>
    </div>
    <div class="modal-body" style="padding: 0px;">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_5" data-toggle="tab">Aanvraag Informatie</a></li>
                <li id="deellevering"><a href="#tab_8" data-toggle="tab">Deelleveringen</a></li>
                <li><a href="#tab_7" data-toggle="tab">Meer Informatie</a></li>
                <li><a href="#tab_6" data-toggle="tab">Documenten (Offertes etc...)</a></li>
            </ul>
            <div class="tab-content <?php echo getInkoopPermisson('Administratie') ? 'readonly' : ''; ?>">
                <div class="tab-pane active" id="tab_5">
                    <input type="hidden" name="aanvraag_id" id="aanvraag_id" value="<?php echo $bestelling->id; ?>">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="naam">Datum ontvangst goederen</label>
                                <input type="text" readonly id="ontv_datum_ontvangst" name="ontv_datum_ontvangst"
                                       data-date=""
                                       autocomplete="off" class="form-control" value="<?php echo $datum; ?>">
                            </div>
                            <?php if ($_GET['type'] == '1') { ?>
                                <div class="form-group">
                                    <label class="control-label" for="naam">ORO NR</label>
                                    <input type="text" id="ontv_oronr" name="ontv_oronr" class="form-control"
                                           value="<?php echo $ontvangst->ontv_oronr; ?>">
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="naam">Gegevens van ontvangst</label>
                                    <input type="text" id="ontv_gegevens_van_ontvangst"
                                           name="ontv_gegevens_van_ontvangst" class="form-control"
                                           value="<?php echo $ontvangst->ontv_gegevens_van_ontvangst; ?>">
                                </div>
                            <?php } ?>
                            <div class="form-group">
                                <label class="control-label" for="naam">Lokatie ontvangst</label>
                                <select class="selectpicker form-control" id="ontv_lokatie_ontvangst"
                                        name="ontv_lokatie_ontvangst">
                                    <?php
                                    foreach ($lokaties as $r) {
                                        if ($r->id == $ontvangst->ontv_lokatie_ontvangst) {
                                            $sel = 'selected=selected';
                                        } else {
                                            $sel = '';
                                        }
                                        echo '<option ' . $sel . ' value=' . $r->id . '>' . $r->lokatie . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="naam">Ontvangen door</label>
                                <select class="selectpicker form-control" id="ontv_ontvangen_door"
                                        name="ontv_ontvangen_door">
                                    <?php
                                    foreach ($users as $r) {
                                        if ($r->id == $ontvangst->ontv_ontvangen_door) {
                                            $sel = 'selected=selected';
                                        } else {
                                            $sel = '';
                                        }
                                        echo '<option ' . $sel . ' value=' . $r->id . '>' . $r->username . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="naam">Leverancier</label>
                                <select disabled class="selectpicker form-control" id="leverancier_id"
                                        name="leverancier_id">
                                    <?php
                                    foreach ($leverancier as $r) {
                                        if ($r->id == $leverancier_id) {
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
                                <label class="control-label" for="naam">Factuurnummer</label>
                                <input type="text" id="ontv_factuurnummer" name="ontv_factuurnummer" readonly
                                       class="form-control" value="<?php echo $factuurnummer; ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="naam">Factuurbedrag</label>
                                <input type="text" id="ontv_factuurbedrag" name="ontv_factuurbedrag" readonly
                                       class="form-control" value="<?php echo $factuurbedrag; ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="naam">Ontvangen (colli)</label>
                                        <select class="selectpicker form-control" <?php echo $_GET['type'] == '0' ? "disabled" : "" ?>
                                                id="ontv_ontvangen_colli" name="ontv_ontvangen_colli">
                                            <?php
                                            foreach ($ontvangenTypes as $r) {
                                                if ($r->id == $ontvangst->ontv_ontvangen_colli) {
                                                    $sel = 'selected=selected';
                                                } else {
                                                    $sel = '';
                                                }
                                                echo '<option ' . $sel . ' value=' . $r->id . '>' . $r->type . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="naam">Aantal Colli</label>
                                        <input type="text"
                                               id="ontv_aantal_colli" <?php echo $_GET['type'] == '0' ? "disabled" : "" ?>
                                               name="ontv_aantal_colli" class="form-control"
                                               value="<?php echo $ontvangst->ontv_aantal_colli; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="naam">Artikelcode</label>
                                <input type="text" id="ontv_artikelcode" name="ontv_artikelcode" readonly
                                       class="form-control"
                                       value="<?php echo getArtikelCode($bestelling->bstl_artikelcode); ?>">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="naam">Aantal</label>
                                        <input type="text" id="ontv_aantal"
                                               name="ontv_aantal" <?php echo ($ontvangst->ontv_deellevering) == "JA" ? "readonly" : "" ?>
                                               class="form-control" value="<?php echo $ontvangst->ontv_aantal; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="naam">Deellevering?</label>
                                        <select class="selectpicker form-control" id="ontv_deellevering"
                                                name="ontv_deellevering">
                                            <option value="NEE" <?php echo ($ontvangst->ontv_deellevering) == "NEE" ? "selected=selected" : "" ?>>
                                                Nee
                                            </option>
                                            <option value="JA" <?php echo ($ontvangst->ontv_deellevering) == "JA" ? "selected=selected" : "" ?>>
                                                Ja
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <?php if ($_GET['type'] == '1') { ?>
                                <div class="form-group">
                                    <label class="control-label" for="naam">Seedstock</label>
                                    <input type="text" id="ontv_seedstock" name="ontv_seedstock" class="form-control"
                                           value="<?php echo $ontvangst->ontv_seedstock; ?>">
                                </div>
                            <?php } ?>
                            <div class="form-group">
                                <label class="control-label" for="naam">Keuring</label>
                                <select class="selectpicker form-control" id="ontv_keuring" name="ontv_keuring">
                                    <option></option>
                                    <option value="Afgekeurd" <?php echo ($ontvangst->ontv_keuring) == "Afgekeurd" ? "selected=selected" : "" ?>>
                                        Afgekeurd
                                    </option>
                                    <option value="Goedgekeurd" <?php echo ($ontvangst->ontv_keuring) == "Goedgekeurd" ? "selected=selected" : "" ?>>
                                        Goedgekeurd
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="naam">Verwerkt in Exact</label>
                                <select <?php echo (getInkoopPermisson('Voorbereider')) ? "disabled" : "" ?>
                                        class="selectpicker form-control" id="ontv_verwerkt_exact"
                                        name="ontv_verwerkt_exact">
                                    <option></option>
                                    <option value="Nee" <?php echo ($ontvangst->ontv_verwerkt_exact) == "Nee" ? "selected=selected" : "" ?>>
                                        Nee
                                    </option>
                                    <option value="Ja" <?php echo ($ontvangst->ontv_verwerkt_exact) == "Ja" ? "selected=selected" : "" ?>>
                                        Ja
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="naam">Datum in Exact</label>
                                <input <?php echo (getInkoopPermisson('Voorbereider')) ? "disabled" : "" ?> type="text"
                                                                                                            id="ontv_datum_exact"
                                                                                                            name="ontv_datum_exact"
                                                                                                            class="form-control"
                                                                                                            data-date=""
                                                                                                            data-date-format="YYYY-MM-DD"
                                                                                                            data-link-format="yyyy-mm-dd"
                                                                                                            data-link-field="ontv_datum_exact"
                                                                                                            value="<?php echo $ontvangst->ontv_datum_exact; ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="naam">Opmerkingen</label>
                                <input type="text" id="ontv_opmerkingen" name="ontv_opmerkingen" class="form-control"
                                       value="<?php echo $ontvangst->ontv_opmerkingen; ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="naam">Artikel Omschrijving</label>
                                <input type="text" id="ontv_artikel_omschrijving" name="ontv_artikel_omschrijving"
                                       readonly class="form-control"
                                       value="<?php echo $bestelling->bstl_omschrijving; ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="naam">Oro Upload</label>
                                <input type="file" id="orofileTmp" <?php echo $_GET['type'] == '0' ? "disabled" : "" ?>
                                       multiple="multiple" name="orofileTmp[]"
                                       class="form-control" value="">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="naam">AirwayBill Upload</label>
                                <input type="file"
                                       id="airwayfileTmp" <?php echo $_GET['type'] == '0' ? "disabled" : "" ?>
                                       multiple="multiple" name="airwayfileTmp[]"
                                       class="form-control" value="">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="naam">Factuur Upload</label>
                                <input type="file" id="factuurfileTmp" multiple="multiple" name="factuurfileTmp[]"
                                       class="form-control" value="">
                            </div>
                            <?php if (getInkoopPermisson('Voorbereider')) { ?>
                                <div class="form-group">
                                    <label class="control-label" for="naam">Voorbereider</label>
                                    <select name="ontv_voorbereider" id="ontv_voorbereider" class="form-control">
                                        <option></option>
                                        <option value="Accoord" <?php echo ($ontvangst->ontv_voorbereider) == "Accoord" ? "selected=selected" : "" ?>>
                                            Accoord
                                        </option>
                                        <option value="Geen Accoord" <?php echo ($ontvangst->ontv_voorbereider) == "Geen Accoord" ? "selected=selected" : "" ?>>
                                            Geen Accoord
                                        </option>
                                    </select>
                                </div>
                            <?php } ?>

                            <?php
                            if (getInkoopPermisson('Administratie') && ($ontvangst->ontv_voorbereider) == "Accoord") { ?>
                                <div class="form-group">
                                    <label class="control-label" for="naam">Administratie</label>
                                    <select name="ontv_administratie" id="ontv_administratie" class="form-control">
                                        <option></option>
                                        <option value="Accoord" <?php echo ($ontvangst->ontv_administratie) == "Accoord" ? "selected=selected" : "" ?>>
                                            Accoord
                                        </option>
                                        <option value="Geen Accoord" <?php echo ($ontvangst->ontv_administratie) == "Geen Accoord" ? "selected=selected" : "" ?>>
                                            Geen Accoord
                                        </option>
                                    </select>
                                </div>
                            <?php } ?>

                            <?php if (getInkoopPermisson('Hoofd Inventory') && ($ontvangst->ontv_administratie) == "Accoord") { ?>
                                <div class="form-group">
                                    <label class="control-label" for="naam">Hoofd Inventory</label>
                                    <select name="ontv_hoofd_inventory" id="ontv_hoofd_inventory" class="form-control">
                                        <option></option>
                                        <option value="Accoord" <?php echo ($ontvangst->ontv_hoofd_inventory) == "Accoord" ? "selected=selected" : "" ?>>
                                            Accoord
                                        </option>
                                        <option value="Geen Accoord" <?php echo ($ontvangst->ontv_hoofd_inventory) == "Geen Accoord" ? "selected=selected" : "" ?>>
                                            Geen Accoord
                                        </option>
                                    </select>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab_8">
                    <div class="row">
                        <div class="form-group" style="padding-bottom: 30px;">
                            <div class="col-sm-2">
                                <label class="control-label">#</label>
                            </div>
                            <div class="col-sm-2">
                                <label class="control-label">Datum</label>
                            </div>
                            <div class="col-sm-2">
                                <label class="control-label">Aantal</label>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label">Opmerking</label>
                            </div>
                        </div>
                        <div class="form-group" style="padding-bottom: 30px;">
                            <div class="col-sm-2">
                                <label class="control-label">1</label>
                            </div>
                            <div class="col-sm-2">
                                <input type="text" id="deel_dat1" name="datum[]" class="form-control" data-date=""
                                       data-date-format="YYYY-MM-DD"
                                       data-link-format="yyyy-mm-dd" data-link-field="deel_dat1"
                                       value="<?php echo($deelleveringen[0]->datum == "0000-00-00" ? '' : $deelleveringen[0]->datum); ?>">
                            </div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control qty1" placeholder="aantal..." name="aantal[]"
                                       value="<?php echo $deelleveringen[0]->aantal; ?>"
                                       id="aantal">
                            </div>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" placeholder="opmerking..." name="opmerking[]"
                                       value="<?php echo $deelleveringen[0]->opmerking; ?>"
                                       id="opmerking">
                            </div>
                        </div>
                        <div class="form-group" style="padding-bottom: 30px;">
                            <div class="col-sm-2">
                                <label class="control-label">2</label>
                            </div>
                            <div class="col-sm-2">
                                <input type="text" id="deel_dat2" name="datum[]" class="form-control" data-date=""
                                       data-date-format="YYYY-MM-DD"
                                       data-link-format="yyyy-mm-dd" data-link-field="deel_dat2"
                                       value="<?php echo($deelleveringen[1]->datum == "0000-00-00" ? '' : $deelleveringen[1]->datum); ?>">
                            </div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control qty1" placeholder="aantal..." name="aantal[]"
                                       value="<?php echo $deelleveringen[1]->aantal; ?>"
                                       id="aantal">
                            </div>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" placeholder="opmerking..." name="opmerking[]"
                                       value="<?php echo $deelleveringen[1]->opmerking; ?>"
                                       id="opmerking">
                            </div>
                        </div>
                        <div class="form-group" style="padding-bottom: 30px;">
                            <div class="col-sm-2">
                                <label class="control-label">3</label>
                            </div>
                            <div class="col-sm-2">
                                <input type="text" id="deel_dat3" name="datum[]" class="form-control" data-date=""
                                       data-date-format="YYYY-MM-DD"
                                       data-link-format="yyyy-mm-dd" data-link-field="deel_dat3"
                                       value="<?php echo($deelleveringen[2]->datum == "0000-00-00" ? '' : $deelleveringen[2]->datum); ?>">
                            </div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control qty1" placeholder="aantal..." name="aantal[]"
                                       value="<?php echo $deelleveringen[2]->aantal; ?>"
                                       id="aantal">
                            </div>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" placeholder="opmerking..." name="opmerking[]"
                                       value="<?php echo $deelleveringen[2]->opmerking; ?>"
                                       id="opmerking">
                            </div>
                        </div>
                        <div class="form-group" style="padding-bottom: 30px;">
                            <div class="col-sm-2">
                                <label class="control-label">4</label>
                            </div>
                            <div class="col-sm-2">
                                <input type="text" id="deel_dat4" name="datum[]" class="form-control" data-date=""
                                       data-date-format="YYYY-MM-DD"
                                       data-link-format="yyyy-mm-dd" data-link-field="deel_dat4"
                                       value="<?php echo($deelleveringen[3]->datum == "0000-00-00" ? '' : $deelleveringen[3]->datum); ?>">
                            </div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control qty1" placeholder="aantal..." name="aantal[]"
                                       value="<?php echo $deelleveringen[3]->aantal; ?>"
                                       id="aantal">
                            </div>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" placeholder="opmerking..." name="opmerking[]"
                                       value="<?php echo $deelleveringen[3]->opmerking; ?>"
                                       id="opmerking">
                            </div>
                        </div>
                        <div class="form-group" style="padding-bottom: 30px;">
                            <div class="col-sm-2">
                                <label class="control-label">5</label>
                            </div>
                            <div class="col-sm-2">
                                <input type="text" id="deel_dat5" name="datum[]" class="form-control" data-date=""
                                       data-date-format="YYYY-MM-DD"
                                       data-link-format="yyyy-mm-dd" data-link-field="deel_dat5"
                                       value="<?php echo($deelleveringen[4]->datum == "0000-00-00" ? '' : $deelleveringen[4]->datum); ?>">
                            </div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control qty1" placeholder="aantal..." name="aantal[]"
                                       value="<?php echo $deelleveringen[4]->aantal; ?>"
                                       id="aantal">
                            </div>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" placeholder="opmerking..." name="opmerking[]"
                                       value="<?php echo $deelleveringen[4]->opmerking; ?>"
                                       id="opmerking">
                            </div>
                        </div>

                    </div>
                </div>
                <div class="tab-pane" id="tab_7">
                    <?php if ($_GET['type'] == '0') { ?>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label" for="naam">Bestelbon nummer</label>
                                    <input readonly type="text" id="inbver_bestelbonnr" name="inbver_bestelbonnr"
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
                                    <input type="text" disabled id="inbver_saldo" name="inbver_saldo"
                                           class="form-control"
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

                            </div>
                            <div class="col-md-3">

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
                                            <input readonly type="text" id="inbver_aantal" name="inbver_aantal"
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
                                    <input disabled <?php echo((empty($binnen->inbver_getekende_bestelbon_datum) || ($binnen->inbver_getekende_bestelbon_dir_datum == "0000-00-00")) ? "" : "disabled"); ?>
                                           type="text" id="inbver_getekende_bestelbon_datum"
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
                                    <input disabled type="text" id="inbver_getekende_bestelbon_dir_datum"
                                        <?php echo((!empty($binnen->inbver_getekende_bestelbon_datum) && ($binnen->inbver_getekende_bestelbon_datum != "0000-00-00")) ? "" : "disabled"); ?>
                                           name="inbver_getekende_bestelbon_dir_datum" data-date=""
                                           data-date-format="YYYY-MM-DD" data-link-format="yyyy-mm-dd"
                                           data-link-field="inbver_getekende_bestelbon_dir_datum"
                                           autocomplete="off" class="form-control"
                                           value="<?php echo ($binnen->inbver_getekende_bestelbon_dir_datum == "0000-00-00") ? '' : $binnen->inbver_getekende_bestelbon_dir_datum; ?>">
                                </div>
                            </div>
                            <div class="col-md-3">

                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label" for="naam">Datum Levering bestelbon </label>
                                    <input disabled type="text" id="inbver_levering_bestelbon_datum"
                                        <?php echo (!empty($binnen->inbver_getekende_bestelbon_dir_datum) && (empty($binnen->inbver_getekende_bestelbon_dir_datum) || ($binnen->inbver_levering_bestelbon_datum))) == "0000-00-00" ? "" : "disabled"; ?>
                                           name="inbver_levering_bestelbon_datum" data-date=""
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

                            </div>
                        </div>
                    <?php } else { ?>
                        <div disabled class="row">
                            <div disabled class="col-md-3">
                                <div disabled class="form-group">
                                    <label disabled class="control-label" for="naam">PO #</label>
                                    <input type="text" id="po_nr" name="po_nr" disabled class="form-control"
                                           value="<?php echo $buiten->po_nr; ?>">
                                </div>
                                <div disabled class="form-group">
                                    <label disabled class="control-label" for="naam">Leverancier</label>
                                    <select disabled class="select form-control" id="leverancier_id"
                                            name="leverancier_id">
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
                                <div disabled class="form-group">
                                    <label disabled class="control-label" for="naam">Afdeling</label>
                                    <select disabled class="selectpicker form-control" data-live-search="true"
                                            id="afdeling" name="afdeling">
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
                                <div disabled class="row">
                                    <div disabled class="col-md-6">
                                        <div disabled class="form-group">
                                            <label disabled class="control-label" for="naam">Valuta</label>
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
                                    <div disabled class="col-md-6">
                                        <div disabled class="form-group">
                                            <label disabled class="control-label" for="naam">Aantal</label>
                                            <input type="text" id="aantalStuks" name="aantalStuks"
                                                   disabled class="form-control nummer"
                                                   value="<?php echo $buiten->aantalStuks; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div disabled class="form-group">
                                    <label disabled class="control-label" for="naam">LAF Nummer</label>
                                    <input type="text" id="laf_nummer" name="laf_nummer" disabled class="form-control"
                                           value="<?php echo $buiten->laf_nummer; ?>">
                                </div>
                                <div disabled class="row">
                                    <div disabled class="col-md-6">
                                        <div disabled class="form-group">
                                            <label disabled class="control-label" for="naam">Estimated Delivery</label>
                                            <input type="text" id="shipping_estimated_delivery" data-date=""
                                                   data-date-format="YYYY-MM-DD"
                                                   data-link-format="yyyy-mm-dd"
                                                   data-link-field="shipping_estimated_delivery"
                                                   autocomplete="off" name="shipping_estimated_delivery" disabled
                                                   class="form-control"
                                                   value="<?php echo ($buiten->shipping_estimated_delivery == "0000-00-00") ? '' : $buiten->shipping_estimated_delivery; ?>">
                                        </div>
                                    </div>
                                    <div disabled class="col-md-6">
                                        <div disabled class="form-group">
                                            <label disabled class="control-label" for="naam">Shipping date</label>
                                            <input <?php echo (getInkoopPermisson('BUITENLAND_SHIPPER')) ? '' : 'disabled'; ?>
                                                    type="text" id="shipping_date" name="shipping_date" data-date=""
                                                    data-date-format="YYYY-MM-DD" data-link-format="yyyy-mm-dd"
                                                    data-link-field="shipping_date"
                                                    autocomplete="off" disabled class="form-control"
                                                    value="<?php echo ($buiten->shipping_date == "0000-00-00") ? '' : $buiten->shipping_date; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div disabled class="row">
                                    <div disabled class="col-md-6">
                                        <div disabled class="form-group">
                                            <label disabled class="control-label" for="naam">BO DATUM</label>
                                            <input type="text" id="bo" name="bo" data-date=""
                                                   data-date-format="YYYY-MM-DD"
                                                   data-link-format="yyyy-mm-dd" data-link-field="bo" autocomplete="off"
                                                   disabled class="form-control"
                                                   value="<?php echo ($buiten->bo == "0000-00-00") ? '' : $buiten->bo; ?>">
                                        </div>
                                    </div>
                                    <div disabled class="col-md-6">
                                        <div disabled class="form-group">
                                            <label disabled class="control-label" for="naam">BO Upload</label>
                                            <input type="file" id="bofileTmp" multiple="multiple" name="bofileTmp[]"
                                                   disabled class="form-control" value="">
                                        </div>
                                    </div>
                                </div>


                                <div disabled class="form-group">
                                    <label disabled class="control-label" for="naam">ORO No.</label>
                                    <input type="text" id="ingeklaard_oro_nummer" name="ingeklaard_oro_nummer" disabled
                                           class="form-control"
                                           value="<?php echo $buiten->ingeklaard_oro_nummer; ?>">
                                </div>
                            </div>
                            <div disabled class="col-md-3">
                                <div disabled class="row">
                                    <div disabled class="col-md-6">
                                        <div disabled class="form-group">
                                            <label disabled class="control-label" for="naam">PO Upload</label>
                                            <input type="file" id="pofileTmp" multiple="multiple" name="pofileTmp[]"
                                                   disabled class="form-control" value="">
                                        </div>
                                    </div>
                                    <div disabled class="col-md-6">
                                        <div disabled class="form-group">
                                            <label disabled class="control-label" for="naam">PO Datum</label>
                                            <input type="text" id="po_datum" name="po_datum" data-date=""
                                                   data-date-format="YYYY-MM-DD"
                                                   data-link-format="yyyy-mm-dd" data-link-field="po_datum"
                                                   autocomplete="off"
                                                   disabled class="form-control"
                                                   value="<?php echo ($buiten->po_datum == "0000-00-00") ? '' : $buiten->po_datum; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div disabled class="form-group">
                                    <label disabled class="control-label" for="naam">CONTRACT /OFFERTE/FACTUUR #</label>
                                    <input type="text" id="cof_nr" name="cof_nr" disabled class="form-control"
                                           value="<?php echo $buiten->cof_nr; ?>">
                                </div>
                                <div disabled class="form-group">
                                    <label disabled class="control-label" for="naam">Shipped from</label>
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
                                <div disabled class="form-group">
                                    <label disabled class="control-label" for="naam">Eenheidprijs</label>
                                    <input type="text" id="eenheidprijs" name="eenheidprijs"
                                           disabled class="form-control"
                                           value="<?php echo $buiten->eenheidprijs; ?>">
                                </div>
                                <div disabled class="form-group">
                                    <label disabled class="control-label" for="naam">BETALINGSVOORWAARDEN</label>
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
                                <div disabled class="form-group">
                                    <label disabled class="control-label" for="naam">Laf ontvangsten Upload</label>
                                    <input type="file" id="laffileTmp" multiple="multiple" name="laffileTmp[]"
                                           disabled class="form-control" value="">
                                </div>
                                <div disabled class="row">
                                    <div disabled class="col-md-6">
                                        <div disabled class="form-group">
                                            <label disabled class="control-label" for="naam">INGEKL. DATUM</label>
                                            <input <?php echo (getInkoopPermisson('BUITENLAND_INKLAARDER')) ? '' : 'disabled'; ?>
                                                    type="text" id="ingeklaard_datum" name="ingeklaard_datum"
                                                    data-date=""
                                                    data-date-format="YYYY-MM-DD" data-link-format="yyyy-mm-dd"
                                                    data-link-field="ingeklaard_datum" autocomplete="off" disabled
                                                    class="form-control"
                                                    value="<?php echo ($buiten->ingeklaard_datum == "0000-00-00") ? '' : $buiten->ingeklaard_datum; ?>">
                                        </div>
                                    </div>
                                    <div disabled class="col-md-6">
                                        <div disabled class="form-group">
                                            <label disabled class="control-label" for="naam">Ingekl. Upload</label>
                                            <input type="file"
                                                   id="ingeklaardfileTmp" <?php echo (getInkoopPermisson('BUITENLAND_INKLAARDER')) ? '' : 'disabled'; ?>
                                                   multiple="multiple" name="ingeklaardfileTmp[]"
                                                   disabled class="form-control" value="">
                                        </div>
                                    </div>
                                </div>

                                <div disabled class="form-group">
                                    <label disabled class="control-label" for="naam">ORO Upload</label>
                                    <input type="file" id="orofileTmp" multiple="multiple" name="orofileTmp[]"
                                           disabled class="form-control" value="">
                                </div>
                            </div>
                            <div disabled class="col-md-3">
                                <div disabled class="form-group">
                                    <label disabled class="control-label" for="naam">Auth #</label>
                                    <select disabled class="selectpicker form-control" id="authorisatienr"
                                            name="authorisatienr">
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
                                <div disabled class="form-group">
                                    <label disabled class="control-label" for="naam">Contract Upload</label>
                                    <input type="file" id="contractfileTmp" multiple="multiple" name="contractfileTmp[]"
                                           disabled class="form-control" value="">
                                </div>
                                <div disabled class="form-group">
                                    <label disabled class="control-label" for="naam">LEVERINGSVOORWAARDEN</label>
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
                                <div disabled class="form-group">
                                    <label disabled class="control-label" for="naam">Korting in bedrag</label>
                                    <input type="text" id="korting_in_bedrag" name="korting_in_bedrag"
                                           disabled class="form-control"
                                           value="<?php echo $buiten->korting_in_bedrag; ?>">
                                </div>
                                <div disabled class="form-group">
                                    <label disabled class="control-label" for="naam">Shipping Method</label>
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
                                <div disabled class="form-group">
                                    <label disabled class="control-label" for="naam">Vrijstelling</label>
                                    <input type="text" id="vrijstelling" name="vrijstelling" disabled
                                           class="form-control"
                                           value="<?php echo $buiten->vrijstelling; ?>">
                                </div>
                                <div disabled class="form-group">
                                    <label disabled class="control-label" for="naam">Factuur Datum</label>
                                    <input type="text" id="factuur_datum" name="factuur_datum" data-date=""
                                           data-date-format="YYYY-MM-DD"
                                           data-link-format="yyyy-mm-dd" data-link-field="factuur_datum"
                                           autocomplete="off"
                                           disabled class="form-control"
                                           value="<?php echo ($buiten->factuur_datum == "0000-00-00") ? '' : $buiten->factuur_datum; ?>">
                                </div>
                                <div disabled class="form-group">
                                    <label disabled class="control-label" for="naam">OVERMAKING DATUM</label>
                                    <input type="text" id="overmakingdatum" name="overmakingdatum" data-date=""
                                           data-date-format="YYYY-MM-DD" data-link-format="yyyy-mm-dd"
                                           data-link-field="overmakingdatum"
                                           autocomplete="off" disabled class="form-control"
                                           value="<?php echo ($buiten->overmakingdatum == "0000-00-00") ? '' : $buiten->overmakingdatum; ?>">
                                </div>
                            </div>
                            <div disabled class="col-md-3">
                                <div disabled class="form-group">
                                    <label disabled class="control-label" for="naam">Saldo</label>
                                    <input type="text" id="inbver_saldo" name="inbver_saldo" disabled
                                           class="form-control"
                                           value="">
                                </div>
                                <div disabled class="form-group">
                                    <label disabled class="control-label" for="naam">Omschrijving</label>
                                    <input type="text" id="omschrijving" name="omschrijving" disabled
                                           class="form-control"
                                           value="<?php echo $buiten->omschrijving; ?>">
                                </div>
                                <div disabled class="form-group">
                                    <label disabled class="control-label" for="naam">DELIVERY</label>
                                    <input type="text" id="delivery" name="delivery" data-date=""
                                           data-date-format="YYYY-MM-DD"
                                           data-link-format="yyyy-mm-dd" data-link-field="delivery" autocomplete="off"
                                           disabled class="form-control" value="<?php echo $buiten->delivery; ?>">
                                </div>
                                <div disabled class="form-group">
                                    <label disabled class="control-label" for="naam">Totaal te bet.</label>
                                    <input type="text" id="bedrag" name="bedrag"
                                           disabled class="form-control"
                                           value="<?php echo $buiten->bedrag; ?>">
                                </div>
                                <div disabled class="form-group">
                                    <label disabled class="control-label" for="naam">Deellevering</label>
                                    <select disabled class="form-control" id="deellevering" name="deellevering">
                                        <option value="USD">JA</option>
                                        <option value="EURO">Nee</option>
                                    </select>
                                </div>
                                <div disabled class="form-group">
                                    <label disabled class="control-label" for="naam">Vrijstelling Upload</label>
                                    <input type="file" id="vrijstellingfileTmp" multiple="multiple"
                                           name="vrijstellingfileTmp[]"
                                           disabled class="form-control" value="">
                                </div>
                                <div disabled class="form-group">
                                    <label disabled class="control-label" for="naam">Deelbetaling</label>
                                    <select disabled class="form-control" id="deelbetaling" name="deelbetaling">
                                        <option value="USD">JA</option>
                                        <option value="EURO">Nee</option>
                                    </select>
                                </div>
                                <div disabled class="form-group">
                                    <label disabled class="control-label" for="naam">OVERMAKING FILE Upload</label>
                                    <input type="file" id="overmakingbestandTmp" multiple="multiple"
                                           name="overmakingbestandTmp[]"
                                           disabled class="form-control" value="">
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
                    <?php } ?>
                </div>
                <div class="tab-pane" id="tab_6">
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
        <button type="submit" class="btn btn-primary" id="btn_submit">Save changes</button>
    </div>
</form>
<script>


    $('#ontv_datum_ontvangst').datetimepicker({
        pickTime: false,
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
    $('#ontv_datum_exact').datetimepicker({
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

    ///////////start deellevering datum///////////////////////
    $('#deel_dat1').datetimepicker({
        pickTime: false,
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
    $('#deel_dat2').datetimepicker({
        pickTime: false,
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
    $('#deel_dat3').datetimepicker({
        pickTime: false,
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
    $('#deel_dat4').datetimepicker({
        pickTime: false,
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
    $('#deel_dat5').datetimepicker({
        pickTime: false,
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
    ///////////end deellevering datum///////////////////////

    $(document).ready(function () {
        $('.readonly').find('input, textarea, select').attr('disabled', 'disabled');

        <?php if(getInkoopPermisson('Administratie')) { ?>
        $('#ontv_verwerkt_exact').prop("disabled", false);
        $('#ontv_datum_exact').prop("disabled", false);
        $('#ontv_administratie').prop("disabled", false);
        <?php } ?>

        if ($('#ontv_deellevering').val() == 'JA') { // or this.value == 'volvo'
            $('#deellevering').show();
            $('#ontv_aantal').prop("readonly", true);
        } else {
            $('#deellevering').hide();
            $('#ontv_aantal').prop("readonly", false);
        }
    });

    $('#ontv_deellevering').change(function () {
        if ($(this).val() == 'JA') { // or this.value == 'volvo'
            $('#deellevering').show();
            $('#ontv_aantal').prop("readonly", true);

            var sum = 0;
            $(".qty1").each(function () {
                sum += +$(this).val();
            });
            $("#ontv_aantal").val(sum);
        } else {
            $('#deellevering').hide();
            $('#ontv_aantal').prop("readonly", false);
        }
    });

    $(document).on("change", ".qty1", function () {
        var sum = 0;
        $(".qty1").each(function () {
            sum += +$(this).val();
        });
        $("#ontv_aantal").val(sum);
    });

</script>

