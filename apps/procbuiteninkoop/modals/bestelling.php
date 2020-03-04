<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../../../php/conf/config.php');
require_once('../php/database.php');
require_once('../php/functions.php');

include "../../../domain/procurementBuitenInkoop/Bestelling.php";
include "../../../domain/procurementBuitenInkoop/User.php";
include "../../../domain/procurementBuitenInkoop/UserRole.php";
include "../../../domain/procurementBuitenInkoop/Role.php";
include "../../../domain/procurementBuitenInkoop/Authorisatie.php";
include "../../../domain/procurementBuitenInkoop/AanvraagLog.php";

$bestelling = Bestelling::find($_GET['id']);
$authorisatie = Authorisatie::all(array('id', 'authorisatienr', 'Onderwerp', 'Projectcode'));

$log = AanvraagLog::where('aanvraag_id', "=", $bestelling->id)->get();
?>
<form class="form-horizontal"
      action="apps/<?php echo app_name; ?>/bestelling.php?action=<?php echo $_GET['action']; ?>&recordId=<?php echo $_GET['id']; ?>"
      method="post" name="inputform" id="inputform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?php echo ucfirst($_GET['action']); ?> Bestelling |
            Aanvraagnr: <?php echo $bestelling->aanvraag_nr; ?></h4>
    </div>
    <div class="modal-body">
        <!-- start basic details like request date and user info-->
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="naam">Aanvraag datum</label>
                    <div class="col-sm-9">
                        <input readonly type="text" id="bstl_aanvraag_datum" name="bstl_aanvraag_datum"
                               class="form-control"
                               value="<?php echo (!empty($bestelling->bstl_aanvraag_datum)) ? $bestelling->bstl_aanvraag_datum : date("Y-m-d"); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="naam">Afdeling</label>
                    <div class="col-sm-9">
                        <input type="text" id="bstl_afdeling" readonly name="bstl_afdeling" class="form-control"
                               value="<?php echo (!empty($bestelling->bstl_afdeling)) ? $bestelling->bstl_afdeling : getAppUserAfdeling(); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="naam">Contactpersoon</label>
                    <div class="col-sm-9">
                        <input type="text" id="bstl_contactpersoon" name="bstl_contactpersoon" class="form-control"
                               value="<?php echo $bestelling->bstl_contactpersoon; ?>">
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="naam">Auth #</label>
                    <div class="col-sm-9">
                        <select class="select form-control" id="authorisatie_id" name="authorisatie_id">
                            <option value="0">Geen</option>
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
                        <input class="form-control" readonly
                               value="<?php echo (!empty($bestelling->bstl_ingevoerd_door)) ? strtok(getProfileInfo($mis_connPDO, 'werkvoorn', $bestelling->bstl_ingevoerd_door), " ") . ' ' . getProfileInfo($mis_connPDO, 'werknaam', $bestelling->bstl_ingevoerd_door) : strtok(getProfileInfo($mis_connPDO, 'werkvoorn', $_SESSION['mis']['user']['badgenr']), " ") . ' ' . getProfileInfo($mis_connPDO, 'werknaam', $_SESSION['mis']['user']['badgenr']); ?>">
                        <input type="hidden" id="bstl_ingevoerd_door" name="bstl_ingevoerd_door" class="form-control"
                               value="<?php echo (!empty($bestelling->bstl_ingevoerd_door)) ? $bestelling->bstl_ingevoerd_door : $_SESSION['mis']['user']['badgenr']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="naam">T.b.v</label>
                    <div class="col-sm-9">
                        <input type="text" id="bstl_tbv" name="bstl_tbv" class="form-control" readonly value="IM">
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
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="naam">Artikelcode</label>
                    <div class="col-sm-9">
                        <select class="selectpicker form-control" data-live-search="true" id="bstl_artikelcode"
                                name="bstl_artikelcode">
                            <option>Loading...</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="naam">Omschrijving</label>
                    <div class="col-sm-9">
                        <textarea id="bstl_omschrijving" readonly name="bstl_omschrijving"
                                  class="form-control"><?php echo $bestelling->bstl_omschrijving; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="naam">Te bestellen</label>
                    <div class="col-sm-9">
                        <input type="text" id="bstl_te_bestellen" name="bstl_te_bestellen" class="form-control"
                               value="<?php echo $bestelling->bstl_te_bestellen; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="naam">Eenheid</label>
                    <div class="col-sm-9">
                        <input type="text" id="bstl_eenheid" readonly name="bstl_eenheid" class="form-control"
                               value="<?php echo $bestelling->bstl_eenheid; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="naam">Huidig voorraad</label>
                    <div class="col-sm-9">
                        <input type="text" id="bstl_huidig_voorraad" name="bstl_huidig_voorraad" class="form-control"
                               value="<?php echo $bestelling->bstl_huidig_voorraad; ?>">
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="naam">Verbruik voorgaand jr</label>
                    <div class="col-sm-9">
                        <input type="text" id="bstl_verbruik_voorgaand_jr" readonly name="bstl_verbruik_voorgaand_jr"
                               class="form-control" value="<?php echo $bestelling->bstl_verbruik_voorgaand_jr; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="naam">Opmerkingen</label>
                    <div class="col-sm-9">
                        <textarea id="bstl_opmerkingen" name="bstl_opmerkingen"
                                  class="form-control"><?php echo $bestelling->bstl_opmerkingen; ?></textarea>

                    </div>
                </div>
                <?php if (getInkoopPermisson('Voorbereider')) { ?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="naam">Voorbereider</label>
                        <div class="col-sm-9">
                            <select <?php echo ($bestelling->bstl_voorbereider) == "Accoord" ? "disabled" : "" ?>
                                    name="bstl_voorbereider" id="bstl_voorbereider" class="form-control">
                                <option></option>
                                <option value="Accoord" <?php echo ($bestelling->bstl_voorbereider) == "Accoord" ? "selected=selected" : "" ?>>
                                    Accoord
                                </option>
                            </select>
                        </div>
                    </div>
                    <div id="voorbereider_opmerking" class="form-group">
                        <label class="col-sm-3 control-label" for="naam">Opmerkingen</label>
                        <div class="col-sm-9">
                            <textarea <?php echo ($bestelling->bstl_voorbereider) == "Accoord" ? "disabled" : "" ?>
                                    id="bstl_voorbereider_opmerking" name="bstl_voorbereider_opmerking"
                                    class="form-control"></textarea>
                        </div>
                    </div>
                <?php } ?>

                <?php if (getInkoopPermisson('Co- logistiek') && ($bestelling->bstl_voorbereider) == "Accoord") { ?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="naam">Hoofd IM</label>
                        <div class="col-sm-9">
                            <select <?php echo ($bestelling->bstl_co_logistiek) == "Accoord" ? "disabled" : "" ?>
                                    name="bstl_co_logistiek" id="bstl_co_logistiek" class="form-control">
                                <option></option>
                                <option value="Accoord" <?php echo ($bestelling->bstl_co_logistiek) == "Accoord" ? "selected=selected" : "" ?>>
                                    Accoord
                                </option>
                                <option value="Geen Accoord" <?php echo ($bestelling->bstl_co_logistiek) == "Geen Accoord" ? "selected=selected" : "" ?>>
                                    Geen Accoord
                                </option>
                            </select>
                        </div>
                    </div>
                    <div id="cologistiek_opmerking" class="form-group">
                        <label class="col-sm-3 control-label" for="naam">Opmerkingen</label>
                        <div class="col-sm-9">
                            <textarea <?php echo ($bestelling->bstl_co_logistiek) == "Accoord" ? "disabled" : "" ?>
                                    name="bstl_co_logistiek_opmerking" id="bstl_co_logistiek_opmerking"
                                    class="form-control"></textarea>
                        </div>
                    </div>
                <?php } ?>

                <?php if (getInkoopPermisson('Hoofd Inventory') && ($bestelling->bstl_co_logistiek) == "Accoord") { ?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="naam">Hoofd PROV</label>
                        <div class="col-sm-9">
                            <select <?php echo ($bestelling->bstl_hoofd_inventory) == "Accoord" ? "disabled" : "" ?>
                                    name="bstl_hoofd_inventory" id="bstl_hoofd_inventory" class="form-control">
                                <option></option>
                                <option value="Accoord" <?php echo ($bestelling->bstl_hoofd_inventory) == "Accoord" ? "selected=selected" : "" ?>>
                                    Accoord
                                </option>
                                <option value="Geen Accoord" <?php echo ($bestelling->bstl_hoofd_inventory) == "Geen Accoord" ? "selected=selected" : "" ?>>
                                    Geen Accoord
                                </option>
                                <option value="Afgekeurd" <?php echo ($bestelling->bstl_hoofd_inventory) == "Afgekeurd" ? "selected=selected" : "" ?>>
                                    Afgekeurd
                                </option>
                            </select>
                        </div>
                    </div>
                    <div id="hoofd_opmerking" class="form-group">
                        <label class="col-sm-3 control-label" for="naam">Opmerkingen</label>
                        <div class="col-sm-9">
                            <textarea <?php echo ($bestelling->bstl_hoofd_inventory) == "Accoord" ? "disabled" : "" ?>
                                    name="bstl_hoofd_inventory_opmerking" id="bstl_hoofd_inventory_opmerking"
                                    class="form-control"></textarea>
                        </div>
                    </div>
                    <?php if (!empty($bestelling->inbox_terug_opmerking)) { ?>
                        <div id="hoofd_opmerking" class="form-group">
                            <label class="col-sm-3 control-label" for="naam">Opmerkingen Procurement Inbox</label>
                            <div class="col-sm-9">
                                <textarea disabled name="inbox_terug_opmerking" id="inbox_terug_opmerking"
                                          class="form-control"><?php echo $bestelling->inbox_terug_opmerking; ?></textarea>
                            </div>
                        </div>
                    <?php } ?>
                    <div id="terug_sturen" class="form-group">
                        <label class="col-sm-3 control-label" for="naam">Terug sturen naar?</label>
                        <div class="col-sm-9">
                            <select <?php echo ($bestelling->bstl_hoofd_inventory) == "Accoord" ? "disabled" : "" ?>
                                    name="terug_naar" id="terug_naar" class="form-control">
                                <option></option>
                                <option value="Voorbereider">Voorbereider</option>
                                <option value="Co-Logistiek">H-IM</option>
                            </select>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" <?php echo ($bestelling->bstl_hoofd_inventory) == "Accoord" ? "disabled" : "" ?>
                class="btn btn-primary" id="btn_submit">Save changes
        </button>
    </div>
</form>
<script>

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
    });

    function getArtikel() {

        var selectedItem = '<?php echo $bestelling->bstl_artikelcode;?>';
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

