<?php
require_once('../../../php/conf/config.php');
require_once('../php/config.php');

include "../domain/Aanvragen.php";
include "../domain/Afdeling.php";
include "../domain/Personeel.php";
include "../domain/Artikel.php";
include "../domain/Categorie.php";

$categorierecord = Categorie::all(array('categorienr', 'categorienaam', 'afkcode'));
$artikelrecord = Artikel::all(array('artikelcode', 'artikelnaam'));
$afdelingrecord = Afdeling::all(array('afdelingcode', 'afdelingnaam'));
$personeelrecord = Personeel::all(array('badgenr', 'naam', 'voornaam', 'afdelingcode'));

$aanvragen = Aanvragen::find($_GET['id']);

$legenda = array();
foreach ($categorierecord as $r) {
    $legenda[] = $r->afkcode . "=" . $r->categorienaam;
}
$legendatekst = implode(", ", $legenda);
?>
<form action="apps/<?php echo app_name; ?>/aanvragen.php?action=<?php echo $_GET['action']; ?>&recordId=<?php echo $_GET['id']; ?>"
      method="post" name="inputform" id="inputform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?php echo ucfirst($_GET['action']); ?> Request</h4>
    </div>
    <div class="modal-body">
        <?php
        if ($_GET['action'] == 'new') {
            ?> <input class="form-control" id="created_user" type="hidden" name="created_user"
                      value="<?php echo $_SESSION[mis][user][username]; ?>"/> <?php
        } else {
            ?> <input class="form-control" id="updated_user" type="hidden" name="updated_user"
                      value="<?php echo $_SESSION[mis][user][username]; ?>"/> <?php
        }
        ?>
        <div class="row">
            <div class="form-group ">
                <label class="control-label requiredField" for="statusnr">
                    <?php echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $legendatekst; ?>
                </label>
            </div>

            <div class="col-md-6">
                <div class="form-group ">
                    <label class="control-label requiredField" for="aanvraagnr">
                        Requestnr <span class="asteriskField" style="color: red;"> * </span>
                    </label>
                    <input class="form-control" id="aanvraagnr" type="hidden" name="aanvraagnr"
                           value="<?php echo $aanvragen->aanvraagnr; ?>"/>
                    <input disabled class="form-control" type="text" value="<?php echo $aanvragen->aanvraagnr; ?>"/>
                    <input class="form-control" id="statusnr" type="hidden" name="statusnr"
                           value="<?php echo ($_GET['action'] == 'new') ? '102' : $aanvragen->statusnr; ?>"/>
                </div>
                <div class="form-group ">
                    <label class="control-label requiredField" for="aanvraagdatum">
                        Requestdate <span class="asteriskField" style="color: red;"> * </span>
                    </label>
                    <input required class="form-control" id="aanvraagdatum" type="text" name="aanvraagdatum"
                           value="<?php echo ($_GET['action'] == 'new') ? date('Y-m-d') : (($aanvragen->aanvraagdatum == '0000-00-00') ? '' : $aanvragen->aanvraagdatum); ?>"
                           data-date="" data-date-format="YYYY-MM-DD" data-link-format="yyyy-mm-dd"
                           data-link-field="aanvraagdatum" autocomplete="off" "/>
                </div>
                <!--
			<div class="form-group ">
				<label class="control-label requiredField" for="statusnr">
					Status <span class="asteriskField" style="color: red;"> * </span>
				</label>
				<input disabled class="form-control" type="text" value="<?php echo ($_GET['action'] == 'new') ? '102' : $aanvragen->statusnr; ?>"/>
			</div>
			-->
                <div class="form-group ">
                    <label class="control-label requiredField" for="badgenr">
                        Badgenr <span class="asteriskField" style="color: red;"> * </span>
                    </label>
                    <select required class="select form-control" id="badgenr" name="badgenr">
                        <option></option>
                        <?php
                        foreach ($personeelrecord as $r) {
                            if ($r->badgenr == $aanvragen->badgenr) {
                                $sel = 'selected=selected';
                            } else {
                                $sel = '';
                            }
                            if ($_GET['action'] == 'new' && $r->badgenr == $_SESSION[mis][user][badgenr]) {
                                $sel = 'selected=selected';
                            }
                            echo '<option ' . $sel . ' value=' . $r->badgenr . '>' . $r->naam . ' ' . $r->voornaam . ' Afdeling: ' . $r->afdelingcode . ' - (' . $r->badgenr . ')</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group ">
                    <label class="control-label requiredField" for="afdelingcode">
                        Department <span class="asteriskField" style="color: red;"> * </span>
                    </label>
                    <select required class="select form-control" id="afdelingcode" name="afdelingcode">
                        <option></option>
                        <?php
                        foreach ($afdelingrecord as $r) {
                            if ($r->afdelingcode == $aanvragen->afdelingcode) {
                                $sel = 'selected=selected';
                            } else {
                                $sel = '';
                            }
                            echo '<option ' . $sel . ' value=' . $r->afdelingcode . '>' . $r->afdelingcode . " - " . $r->afdelingnaam . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <?php if ($_GET[action] == "new") { ?>
                    <div class="form-group ">
                        <label class="control-label" for="afkcode"> Category <span class="asteriskField"
                                                                                   style="color: red;"> * </span>
                        </label>
                        <div>
                            <select required class="select form-control" id="afkcode" name="afkcode">
                                <option></option>
                                <?php
                                foreach ($categorierecord as $r) {
                                    echo '<option ' . $sel . ' value=' . $r->afkcode . '>' . $r->afkcode . " - " . $r->categorienaam . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                <?php } ?>

                <div class="form-group ">
                    <label class="control-label requiredField" for="artikelcode">
                        Articlecode <span class="asteriskField" style="color: red;"> * </span> <span
                                class="asteriskField" style="color: red;" id="voorraadaantal"></span>
                    </label>
                    <select required class="select form-control" id="artikelcode" name="artikelcode">
                        <option></option>
                        <?php
                        if ($_GET[action] != "new") {
                            foreach ($artikelrecord as $r) {
                                if ($r->artikelcode == $aanvragen->artikelcode) {
                                    $sel = 'selected=selected';
                                } else {
                                    $sel = '';
                                }
                                echo '<option ' . $sel . ' value=' . $r->artikelcode . '>' . $r->artikelcode . " - " . $r->artikelnaam . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group ">
                    <label class="control-label requiredField" for="aantal">
                        Quantity <span class="asteriskField" style="color: red;"> * </span>
                    </label>
                    <input required class="form-control" id="aantal" type="text" name="aantal"
                           value="<?php echo $aanvragen->aantal; ?>"/>
                    <input id="checkaantal" type="hidden" name="checkaantal"/>
                </div>
                <div class="form-group ">
                    <label class="control-label requiredField" for="opmerking">
                        Remark <span class="asteriskField" style="color: red;"> * </span>
                    </label>
                    <textarea required class="form-control" id="opmerking" type="text"
                              name="opmerking"><?php echo $aanvragen->opmerking; ?></textarea>
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
    $('#aanvraagdatum').datetimepicker({
        pickTime: false,
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });

    $("#badgenr").change(function () {
        checkAfdelingcode($(this).val());
    });

    function checkAfdelingcode(badgenr) {
        $.post("apps/<?php echo app_name;?>/ajax/checkafdeling.php", {badgenr: badgenr}, function (data) {
            if (data != '' || data != undefined || data != null) {
                $('#afdelingcode').val(data);
            }
        });
    }

    $("#afkcode").change(function () {
        filterArtikelcode($(this).val());
    });

    function filterArtikelcode(afkcode) {
        $.post("apps/<?php echo app_name;?>/ajax/filterartikel.php", {afkcode: afkcode}, function (data) {
            if (data != '' || data != undefined || data != null) {
                $('#artikelcode').html(data);
            }
        });
    }

    $("#artikelcode").change(function () {
        checkArtikelcode($(this).val());
    });

    function checkArtikelcode(artikelcode) {
        $.post("apps/<?php echo app_name;?>/ajax/checkartikelaantal.php", {artikelcode: artikelcode}, function (data) {
            if (data != '' || data != undefined || data != null) {
                $('#checkaantal').val(data);
                $('#voorraadaantal').html("In voorraad: " + data);
                voorraadaantal
                if (data == '0') {
                    $('#btn_submit').prop("disabled", true);
                    alert('No spareparts available for ' + $("#artikelcode").val());
                } else {
                    checkArtikelAantal();
                }
            }
        });
    }

    $("#aantal").blur(function () {
        checkArtikelAantal();
    });

    function checkArtikelAantal() {
        var w1 = $('#checkaantal').val();
        var w2 = $('#aantal').val();

        if (w1 - w2 < 0) {
            $('#btn_submit').prop("disabled", true);
            alert('Not enough spareparts available for ' + $("#artikelcode").val());
        } else {
            $('#btn_submit').prop("disabled", false);
        }
    }


</script>