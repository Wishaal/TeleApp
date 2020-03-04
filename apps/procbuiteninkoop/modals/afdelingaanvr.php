<?php
require_once('../../../php/conf/config.php');
require_once('../php/database.php');
require_once('../php/functions.php');

include "../../../domain/procurementBuitenInkoop/Bestelling.php";
include "../../../domain/procurementBuitenInkoop/User.php";
include "../../../domain/procurementBuitenInkoop/UserRole.php";
include "../../../domain/procurementBuitenInkoop/Role.php";
include "../../../domain/procurementBuitenInkoop/Authorisatie.php";
include "../../../domain/procurementBuitenInkoop/AanvraagLog.php";
include "../../../domain/procurementBuitenInkoop/Afdelingaanvr.php";
include "../../../domain/procurementBuitenInkoop/Valuta.php";

$bestelling = Bestelling::find($_GET['id']);
$valuta = Valuta::all(array('valutacode', 'valutanaam'));
$afdelingaanvr = Afdelingaanvr::find($_GET['id']);
$authorisatie = Authorisatie::all(array('id', 'authorisatienr', 'Onderwerp', 'Projectcode'));

$log = AanvraagLog::where('aanvraag_id', "=", $afdelingaanvr->id)->get();
?>
<form class="form-horizontal"
      action="apps/<?php echo app_name; ?>/afdelingaanvr.php?action=<?php echo $_GET['action']; ?>&recordId=<?php echo $_GET['id']; ?>"
      method="post" name="inputform" id="inputform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?php echo ucfirst($_GET['action']); ?> Afdeling |
            Aanvraagnr: <?php echo $afdelingaanvr->aanvraag_nr; ?></h4>
    </div>
    <div class="modal-body">
        <!-- start basic details like request date and user info-->
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="naam">Datum</label>
                    <div class="col-sm-9">
                        <input type="text" id="datumtijd" name="datumtijd" class="form-control"
                               value="<?php echo (!empty($afdelingaanvr->datumtijd)) ? $afdelingaanvr->datumtijd : date("Y-m-d"); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="naam">Afdeling</label>
                    <div class="col-sm-9">
                        <input type="text" id="afdeling" readonly name="afdeling" class="form-control"
                               value="<?php echo (!empty($afdelingaanvr->afdeling)) ? $afdelingaanvr->afdeling : getAppUserAfdeling(); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="naam">Naam</label>
                    <div class="col-sm-9">
                        <input type="text" id="naam" name="naam" class="form-control"
                               value="<?php echo $afdelingaanvr->naam; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="naam">Refnr</label>
                    <div class="col-sm-9">
                        <input type="text" id="refnr" name="refnr" class="form-control"
                               value="<?php echo $afdelingaanvr->refnr; ?>">
                    </div>
                </div>

            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="naam">Auth #</label>
                    <div class="col-sm-9">
                        <select class="select form-control" id="auto" name="auto">
                            <option value="0">Geen</option>
                            <?php
                            foreach ($authorisatie as $r) {

                                if ($r->id == $afdelingaanvr->auto) {
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
                        <input class="form-control" readonly
                               value="<?php echo (!empty($afdelingaanvr->bstl_ingevoerd_door)) ? strtok(getProfileInfo($mis_connPDO, 'FirstName', $afdelingaanvr->bstl_ingevoerd_door), " ") . ' ' . getProfileInfo($mis_connPDO, 'Name', $afdelingaanvr->bstl_ingevoerd_door) : strtok(getProfileInfo($mis_connPDO, 'FirstName', $_SESSION['mis']['user']['badgenr']), " ") . ' ' . getProfileInfo($mis_connPDO, 'Name', $_SESSION['mis']['user']['badgenr']); ?>">
                        <input type="hidden" id="bstl_ingevoerd_door" name="bstl_ingevoerd_door" class="form-control"
                               value="<?php echo (!empty($afdelingaanvr->bstl_ingevoerd_door)) ? $afdelingaanvr->bstl_ingevoerd_door : $_SESSION['mis']['user']['badgenr']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="naam">Goedkeurings brief</label>
                    <div class="col-sm-9">
                        <input type="text" id="goedbrief" name="goedbrief" class="form-control" value="goedbrief">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="naam">Bestedings overzicht</label>
                    <div class="col-sm-9">
                        <input type="text" id="bestover" name="bestover" class="form-control" value="bestover">
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <?php foreach ($log as $item) {
                    echo '<div class="direct-chat-msg right">
                            <div class="direct-chat-info clearfix">
                                <span class="direct-chat-name pull-right">' . $item->gebruiker . '</span>
                                <span class="direct-chat-timestamp pull-left">' . $item->created_at . '</span>
                            </div>
                            <div class="direct-chat-text">
                               ' . $item->omschrijving . '
                            </div>
                        </div><hr style="margin: 0 0 10px 0;border-style: solid;border-color: #e0cf1f;border-width: 1px 0 0 0;">';
                }
                ?>
            </div>
        </div>

        <!---- end basic info --->
        <div class="row">

            <div class="col-md-4">
            </div>

            <div class="col-md-4">

                <?php if (getInkoopPermisson('Voorbereider')) { ?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="naam">Voorbereider</label>
                        <div class="col-sm-9">
                            <select <?php echo ($afdelingaanvr->bstl_voorbereider) == "Accoord" ? "disabled" : "" ?>
                                    name="bstl_voorbereider" id="bstl_voorbereider" class="form-control">
                                <option></option>
                                <option value="Accoord" <?php echo ($afdelingaanvr->bstl_voorbereider) == "Accoord" ? "selected=selected" : "" ?>>
                                    Accoord
                                </option>
                            </select>
                        </div>
                    </div>
                    <div id="voorbereider_opmerking" class="form-group">
                        <label class="col-sm-3 control-label" for="naam">Opmerkingen</label>
                        <div class="col-sm-9">
                            <textarea <?php echo ($afdelingaanvr->bstl_voorbereider) == "Accoord" ? "disabled" : "" ?>
                                    id="bstl_voorbereider_opmerking" name="bstl_voorbereider_opmerking"
                                    class="form-control"></textarea>
                        </div>
                    </div>
                <?php } ?>

                <?php if (getInkoopPermisson('Co- logistiek') && ($afdelingaanvr->bstl_voorbereider) == "Accoord") { ?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="naam">Manager</label>
                        <div class="col-sm-9">
                            <select <?php echo ($afdelingaanvr->manager) == "Accoord" ? "disabled" : "" ?>
                                    name="manager" id="bstl_co_logistiek" class="form-control">
                                <option></option>
                                <option value="Accoord" <?php echo ($afdelingaanvr->manager) == "Accoord" ? "selected=selected" : "" ?>>
                                    Accoord
                                </option>
                                <option value="Geen Accoord" <?php echo ($afdelingaanvr->manager) == "Geen Accoord" ? "selected=selected" : "" ?>>
                                    Geen Accoord
                                </option>
                            </select>
                        </div>
                    </div>

                <?php } ?>

            </div>
        </div>


        <hr style="margin-top: 0px; border-top: 3px solid #008BDC; margin-bottom: 0px;">
        <div class="row">
            <div class="col-md-1">Artikel</div>
            <div class="col-md-1">ArtikelOmsch</div>
            <div class="col-md-1">Leverancier</div>
            <div class="col-md-1">Offertenr</div>
            <div class="col-md-1">Offertedatum</div>
            <div class="col-md-1">OfferteUpload</div>
            <div class="col-md-1">Omschrijving</div>
            <div class="col-md-1">Eenheid</div>
            <div class="col-md-1">Valuta</div>
            <div class="col-md-1">Prijs</div>
            <div class="col-md-1">Totaal</div>
            <div class="col-md-1"></div>
        </div>
        <div class="row">
            <?php if (count($deelbetalingen) > 0) {
                $count = 1;
                foreach ($deelbetalingen as $deelbetaling) { ?>
                    <div class="form-group clonedInput" style="padding-bottom: 30px;">
                        <div class="col-sm-1">
                            <input type="text" class="form-control" value="<?php echo $deelbetaling->deel_bo_nummer; ?>"
                                   name="artik[]"
                                   id="artik">
                        </div>
                        <div class="col-sm-1">
                            <input type="text" id="artom[]" data-date="" data-date-format="YYYY-MM-DD"
                                   data-link-format="yyyy-mm-dd" data-link-field="artom"
                                   autocomplete="off" name="artom[]" class="form-control"
                                   value="<?php echo $deelbetaling->deel_bo_datum; ?>">
                        </div>

                        <div class="col-sm-1">
                            <input type="text" id="deel_bo_datum[]" data-date="" data-date-format="YYYY-MM-DD"
                                   data-link-format="yyyy-mm-dd" data-link-field="deel_bo_datum"
                                   autocomplete="off" name="deel_bo_datum[]" class="form-control"
                                   value="<?php echo $deelbetaling->deel_bo_datum; ?>">
                        </div>

                        <div class="col-sm-1">
                            <input type="text" id="deel_bo_datum[]" data-date="" data-date-format="YYYY-MM-DD"
                                   data-link-format="yyyy-mm-dd" data-link-field="deel_bo_datum"
                                   autocomplete="off" name="deel_bo_datum[]" class="form-control"
                                   value="<?php echo $deelbetaling->deel_bo_datum; ?>">
                        </div>

                        <div class="col-sm-1">
                            <input type="text" id="deel_bo_datum[]" data-date="" data-date-format="YYYY-MM-DD"
                                   data-link-format="yyyy-mm-dd" data-link-field="deel_bo_datum"
                                   autocomplete="off" name="deel_bo_datum[]" class="form-control"
                                   value="<?php echo $deelbetaling->deel_bo_datum; ?>">
                        </div>

                        <div class="col-sm-1">
                            <input type="text" id="deel_bo_datum[]" data-date="" data-date-format="YYYY-MM-DD"
                                   data-link-format="yyyy-mm-dd" data-link-field="deel_bo_datum"
                                   autocomplete="off" name="deel_bo_datum[]" class="form-control"
                                   value="<?php echo $deelbetaling->deel_bo_datum; ?>">
                        </div>

                        <div class="col-sm-1">
                            <input type="text" id="deel_bo_datum[]" data-date="" data-date-format="YYYY-MM-DD"
                                   data-link-format="yyyy-mm-dd" data-link-field="deel_bo_datum"
                                   autocomplete="off" name="deel_bo_datum[]" class="form-control"
                                   value="<?php echo $deelbetaling->deel_bo_datum; ?>">
                        </div>

                        <div class="col-sm-1">
                            <input type="text" id="deel_bo_datum[]" data-date="" data-date-format="YYYY-MM-DD"
                                   data-link-format="yyyy-mm-dd" data-link-field="deel_bo_datum"
                                   autocomplete="off" name="deel_bo_datum[]" class="form-control"
                                   value="<?php echo $deelbetaling->deel_bo_datum; ?>">
                        </div>

                        <div class="col-sm-1">
                            <select name="deel_valuta[]" id="deel_valuta"
                                    class="form-control">
                                <?php
                                foreach ($valuta as $r) {
                                    if ($r->valutacode == $deelbetaling->deel_valuta) {
                                        $sel = 'selected=selected';
                                    } else {
                                        $sel = '';
                                    }
                                    echo '<option ' . $sel . ' value=' . $r->valutacode . '>' . $r->valutacode . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control" placeholder="bedrag..." name="bedrag_deel[]"
                                   value="<?php echo $deelbetaling->bedrag_deel; ?>"
                                   id="bedrag_deel">
                        </div>
                        <div class="col-sm-1">
                            <select name="status[]" id="status"
                                    class="form-control">
                                <option>Betaling status...</option>
                                <?php
                                foreach ($statussen as $r) {
                                    if ($r->id == $deelbetaling->status_id) {
                                        $sel = 'selected=selected';
                                    } else {
                                        $sel = '';
                                    }
                                    echo '<option ' . $sel . ' value=' . $r->id . '>' . $r->status_omschrijving . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-1 ">
                            <input type="button" class="btn btn-danger pull-right btnDel" value="Delete"
                                   disabled="disabled"/>
                        </div>
                    </div>
                    <?php $count++;
                }
            } else { ?>
                <div class="form-group clonedInput" style="padding-bottom: 30px;">
                    <div class="col-sm-1">
                        <input type="text" class="form-control" placeholder="" name="artik[]"
                               id="artik">
                    </div>
                    <div class="col-sm-1">
                        <input type="text" id="artom[]" data-date="" data-date-format="YYYY-MM-DD"
                               data-link-format="yyyy-mm-dd" data-link-field="artom"
                               autocomplete="off" name="artom[]" class="form-control"
                               value="<?php echo $deelbetaling->deel_bo_datum; ?>">
                    </div>

                    <div class="col-sm-1">
                        <input type="text" id="deel_bo_datum[]" data-date="" data-date-format="YYYY-MM-DD"
                               data-link-format="yyyy-mm-dd" data-link-field="deel_bo_datum"
                               autocomplete="off" name="deel_bo_datum[]" class="form-control"
                               value="<?php echo $deelbetaling->deel_bo_datum; ?>">
                    </div>

                    <div class="col-sm-1">
                        <input type="text" id="deel_bo_datum[]" data-date="" data-date-format="YYYY-MM-DD"
                               data-link-format="yyyy-mm-dd" data-link-field="deel_bo_datum"
                               autocomplete="off" name="deel_bo_datum[]" class="form-control"
                               value="<?php echo $deelbetaling->deel_bo_datum; ?>">
                    </div>

                    <div class="col-sm-1">
                        <input type="text" id="deel_bo_datum[]" data-date="" data-date-format="YYYY-MM-DD"
                               data-link-format="yyyy-mm-dd" data-link-field="deel_bo_datum"
                               autocomplete="off" name="deel_bo_datum[]" class="form-control"
                               value="<?php echo $deelbetaling->deel_bo_datum; ?>">
                    </div>

                    <div class="col-sm-1">
                        <input type="text" id="deel_bo_datum[]" data-date="" data-date-format="YYYY-MM-DD"
                               data-link-format="yyyy-mm-dd" data-link-field="deel_bo_datum"
                               autocomplete="off" name="deel_bo_datum[]" class="form-control"
                               value="<?php echo $deelbetaling->deel_bo_datum; ?>">
                    </div>

                    <div class="col-sm-1">
                        <input type="text" id="deel_bo_datum[]" data-date="" data-date-format="YYYY-MM-DD"
                               data-link-format="yyyy-mm-dd" data-link-field="deel_bo_datum"
                               autocomplete="off" name="deel_bo_datum[]" class="form-control"
                               value="<?php echo $deelbetaling->deel_bo_datum; ?>">
                    </div>

                    <div class="col-sm-1">
                        <input type="text" id="deel_bo_datum[]" data-date="" data-date-format="YYYY-MM-DD"
                               data-link-format="yyyy-mm-dd" data-link-field="deel_bo_datum"
                               autocomplete="off" name="deel_bo_datum[]" class="form-control"
                               value="<?php echo $deelbetaling->deel_bo_datum; ?>">
                    </div>
                    <div class="col-sm-1">
                        <select name="deel_valuta[]" id="deel_valuta"
                                class="form-control">
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
                    <div class="col-sm-1">
                        <input type="text" class="form-control" placeholder="bedrag..." name="bedrag_deel[]"
                               id="bedrag_deel">
                    </div>
                    <div class="col-sm-1">
                        <select name="status[]" id="status"
                                class="form-control">
                            <option>Betaling status...</option>
                            <?php
                            foreach ($statussen as $r) {
                                if ($r->id == $deelbetaling->status_id) {
                                    $sel = 'selected=selected';
                                } else {
                                    $sel = '';
                                }
                                echo '<option ' . $sel . ' value=' . $r->id . '>' . $r->status_omschrijving . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-1 ">
                        <input type="button" class="btn btn-danger pull-right btnDel" value="Delete"
                               disabled="disabled"/>
                    </div>
                </div>
            <?php } ?>
            <div class="form-group">
                <div class="col-sm-12">
                    <input type="button" class="btn btn-success pull-right" id="btnAdd"
                           value="Add rows +"/>
                </div>
            </div>
        </div>


        <!--



        <div class="form-group">

            <div class="col-xs-1" style="padding-left: 5px; padding-right: 5px;">
                <label for="name" class="control-label">Artikelcode</label>
                <input type="text" class="form-control" name="book[0].artik" placeholder="Artikelcode" />
            </div>
            <div class="col-xs-1" style="padding-left: 5px; padding-right: 5px;">
                <label for="name" class="control-label">ArtikelOmsch</label>
                <input type="text" class="form-control" name="book[0].artom" placeholder="Omschrijving Artikel" />
            </div>
            <div class="col-xs-1" style="padding-left: 5px; padding-right: 5px;">
                <label for="name" class="control-label">Leverancier</label>
                <input type="text" class="form-control" name="book[0].lever" placeholder="Leverancier" />
            </div>

            <div class="col-xs-1" style="padding-left: 5px; padding-right: 5px;">
                <label for="name" class="control-label">Offertenr</label>
                <input type="text" class="form-control" name="book[0].ofnr" placeholder="Offertenr" />
            </div>

            <div class="col-xs-1" style="padding-left: 5px; padding-right: 5px;">
                <label for="name" class="control-label">Offertedatum</label>
                <input type="text" class="form-control" name="book[0].ofdatum" placeholder="Offertedatum" />
            </div>

            <div class="col-xs-1" style="padding-left: 5px; padding-right: 5px;">
                <label for="name" class="control-label">Uploadofferte</label>
                <input type="text" class="form-control" name="book[0].ofupload" placeholder="Uploadofferte" />
            </div>

            <div class="col-xs-1" style="padding-left: 5px; padding-right: 5px;">
                <label for="name" class="control-label">Omschrijving</label>
                <input type="text" class="form-control" name="book[0].omsch" placeholder="Omschrijving" />
            </div>

            <div class="col-xs-1" style="padding-left: 5px; padding-right: 5px;">
                <label for="name" class="control-label">Aantal</label>
                <input type="text" class="form-control" name="book[0].aantal" placeholder="Aantal" />
            </div>
            <div class="col-xs-1" style="padding-left: 5px; padding-right: 5px;">
                <label for="name" class="control-label">Eenheid</label>
                <input type="text" class="form-control" name="book[0].eenheid" placeholder="Eenheid" />
            </div>
            <div class="col-xs-1" style="padding-left: 5px; padding-right: 5px;">
                <label for="name" class="control-label">Valuta Soort</label>
                <input type="text" class="form-control" name="book[0].valuta" placeholder="Valuta Soort" />
            </div>
            <div class="col-xs-1" style="padding-left: 5px; padding-right: 5px;">
                <label for="name" class="control-label">Prijs</label>
                <input type="text" class="form-control" name="book[0].price" placeholder="Prijs" />
            </div>

            <div class="col-xs-1" style="padding-left: 5px; padding-right: 5px;">
                <label for="name" class="control-label">Totaal</label>
                <input type="text" class="form-control" name="book[0].totaal" placeholder="Totaal" />
            </div>

            <div class="col-xs-1" style="padding-left: 5px; padding-right: 5px;">

                <button type="button" class="btn btn-default addButton"><i class="fa fa-plus"></i></button>
            </div>
        </div>


        <div class="form-group hide" id="bookTemplate">
            <div class="col-xs-1" style="padding-left: 5px; padding-right: 5px;">
                <input type="text" class="form-control" name="artik" placeholder="Artikel" />
            </div>
            <div class="col-xs-1" style="padding-left: 5px; padding-right: 5px;">
                <input type="text" class="form-control" name="artom" placeholder="Omschrijving Artikel" />
            </div>
            <div class="col-xs-1" style="padding-left: 5px; padding-right: 5px;">
                <input type="text" class="form-control" name="lever" placeholder="Leverancier" />
            </div>

            <div class="col-xs-1" style="padding-left: 5px; padding-right: 5px;">
                <input type="text" class="form-control" name="ofnr" placeholder="Offertenr" />
            </div>

            <div class="col-xs-1" style="padding-left: 5px; padding-right: 5px;">
                <input type="text" class="form-control" name="ofdatum" placeholder="Offertedatum" />
            </div>

            <div class="col-xs-1" style="padding-left: 5px; padding-right: 5px;">
                <input type="text" class="form-control" name="ofupload" placeholder="Uploadofferte" />
            </div>

            <div class="col-xs-1" style="padding-left: 5px; padding-right: 5px;">
                <input type="text" class="form-control" name="omsch" placeholder="Omschrijving" />
            </div>

            <div class="col-xs-1" style="padding-left: 5px; padding-right: 5px;">
                <input type="text" class="form-control" name="aantal" placeholder="Aantal" />
            </div>

            <div class="col-xs-1" style="padding-left: 5px; padding-right: 5px;">
                <input type="text" class="form-control" name="eenheid" placeholder="Eenheid" />
            </div>

            <div class="col-xs-1" style="padding-left: 5px; padding-right: 5px;">
                <input type="text" class="form-control" name="valuta" placeholder="Valuta soort" />
            </div>

            <div class="col-xs-1" style="padding-left: 5px; padding-right: 5px;">
                <input type="text" class="form-control" name="price" placeholder="Prijs" />
            </div>

            <div class="col-xs-1" style="padding-left: 5px; padding-right: 5px;">
                <input type="text" class="form-control" name="totaal" placeholder="Totaal" />
            </div>
            <div class="col-xs-1" style="padding-left: 5px; padding-right: 5px;">
                <button type="button" class="btn btn-default removeButton"><i class="fa fa-minus"></i></button>
            </div>
        </div>
    -->

    </div>


    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" <?php echo ($afdelingaanvr->bstl_hoofd_inventory) == "Accoord" ? "disabled" : "" ?>
                class="btn btn-primary" id="btn_submit">Save changes
        </button>
    </div>
</form>

<script>


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


    $('.selectpicker').selectpicker({});

    $(document).ready(function () {
        $("#voorbereider_opmerking").hide();
        $("#cologistiek_opmerking").hide();
        $("#hoofd_opmerking").hide();
        $("#terug_sturen").hide();

        $('#bstl_voorbereider').on('change', function () {
            var selection = $(this).val();
            switch (selection) {
                case "Geen Accoord":
                    $("#voorbereider_opmerking").show()
                    break;
                default:
                    $("#voorbereider_opmerking").hide()
            }
        });

        $('#bstl_co_logistiek').on('change', function () {
            var selection = $(this).val();
            switch (selection) {
                case "Geen Accoord":
                    $("#cologistiek_opmerking").show()
                    break;
                default:
                    $("#cologistiek_opmerking").hide()
            }
        });

        $('#bstl_hoofd_inventory').on('change', function () {
            var selection = $(this).val();
            switch (selection) {
                case "Geen Accoord":
                    $("#hoofd_opmerking").show()
                    $("#terug_sturen").show()
                    break;
                case "Afgekeurd":
                    $("#hoofd_opmerking").show()
                    break;
                default:
                    $("#hoofd_opmerking").hide()
                    $("#terug_sturen").hide()
            }
        });

        getArtikel();


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


        var titleValidators = {
                row: '.col-xs-4',   // The title is placed inside a <div class="col-xs-4"> element
                validators: {
                    notEmpty: {
                        message: 'The title is required'
                    }
                }
            },
            isbnValidators = {
                row: '.col-xs-4',
                validators: {
                    notEmpty: {
                        message: 'The ISBN is required'
                    },
                    isbn: {
                        message: 'The ISBN is not valid'
                    }
                }
            },
            priceValidators = {
                row: '.col-xs-2',
                validators: {
                    notEmpty: {
                        message: 'The price is required'
                    },
                    numeric: {
                        message: 'The price must be a numeric number'
                    }
                }
            },
            bookIndex = 0;

        $('#inputform')
            .formValidation({
                framework: 'bootstrap',
                icon: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    'book[0].title': titleValidators,
                    'book[0].isbn': isbnValidators,
                    'book[0].price': priceValidators
                }
            })

            // Add button click handler
            .on('click', '.addButton', function () {
                bookIndex++;
                var $template = $('#bookTemplate'),
                    $clone = $template
                        .clone()
                        .removeClass('hide')
                        .removeAttr('id')
                        .attr('data-book-index', bookIndex)
                        .insertBefore($template);

                // Update the name attributes
                $clone
                    .find('[name="title"]').attr('name', 'book[' + bookIndex + '].title').end()
                    .find('[name="isbn"]').attr('name', 'book[' + bookIndex + '].isbn').end()
                    .find('[name="price"]').attr('name', 'book[' + bookIndex + '].price').end();

                // Add new fields
                // Note that we also pass the validator rules for new field as the third parameter
                $('#inputform')
                    .formValidation('addField', 'book[' + bookIndex + '].title', titleValidators)
                    .formValidation('addField', 'book[' + bookIndex + '].isbn', isbnValidators)
                    .formValidation('addField', 'book[' + bookIndex + '].price', priceValidators);
            })

            // Remove button click handler
            .on('click', '.removeButton', function () {
                var $row = $(this).parents('.form-group'),
                    index = $row.attr('data-book-index');

                // Remove fields
                $('#inputform')
                    .formValidation('removeField', $row.find('[name="book[' + index + '].title"]'))
                    .formValidation('removeField', $row.find('[name="book[' + index + '].isbn"]'))
                    .formValidation('removeField', $row.find('[name="book[' + index + '].price"]'));

                // Remove element containing the fields
                $row.remove();
            });


    });

    function getArtikel() {

        var selectedItem = '<?php echo $afdelingaanvr->bstl_artikelcode;?>';
        var textselected = "selected=selected";
        $.ajax({
            type: "GET",
            url: 'apps/<?php echo app_name;?>/ajax/getArtikel.php',
            contentType: "application/json;charset=utf-8",
            dataType: "json",
            success: function (data) {
                var html = '';
                html += '<option>Kies Artikelcode</option>';
                $.each(data, function (index, value) {
                    var txt1 = value['id'];
                    if (selectedItem == txt1) {
                        html += '<option selected="selected" value="' + value['id'] + '">' + value['artikel'] + '</option>';
                    } else {
                        html += '<option value="' + value['id'] + '">' + value['artikel'] + '</option>';
                    }

                });
                $('#bstl_artikelcode').html(html);
                $('.selectpicker').selectpicker('refresh');
            }
        });
    }

    $("#bstl_artikelcode").change(function () {
        setArtikelValues($(this).val());
    });

    function setArtikelValues(artikelcode) {
        $.post("apps/<?php echo app_name;?>/ajax/setArtikelInfo.php", {artikelcode: artikelcode}, function (data) {
            var response = jQuery.parseJSON(data);
            if (data != '' || data != undefined || data != null) {
                $('#bstl_omschrijving').val(response.artikelomschrijving);
                $('#bstl_eenheid').val(response.eenheid);
                $('#bstl_verbruik_voorgaand_jr').val(response.geleverd);
            }
        });
    }

</script>

