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
        if ($_GET['action'] == 'newmulti') {
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
                           value="<?php echo ($_GET['action'] == 'newmulti') ? '102' : $aanvragen->statusnr; ?>"/>
                </div>
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
                            if ($_GET['action'] == 'newmulti' && $r->badgenr == $_SESSION[mis][user][badgenr]) {
                                $sel = 'selected=selected';
                            }
                            echo '<option ' . $sel . ' value=' . $r->badgenr . '>' . $r->naam . ' ' . $r->voornaam . ' Afdeling: ' . $r->afdelingcode . ' - (' . $r->badgenr . ')</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group ">
                    <label class="control-label requiredField" for="aanvraagdatum">
                        Requestdate <span class="asteriskField" style="color: red;"> * </span>
                    </label>
                    <input required class="form-control" id="aanvraagdatum" type="text" name="aanvraagdatum"
                           value="<?php echo ($_GET['action'] == 'newmulti') ? date('Y-m-d') : (($aanvragen->aanvraagdatum == '0000-00-00') ? '' : $aanvragen->aanvraagdatum); ?>"
                           data-date="" data-date-format="YYYY-MM-DD" data-link-format="yyyy-mm-dd"
                           data-link-field="aanvraagdatum" autocomplete="off" "/>
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
            <div class="col-md-12">
                <div class="form-group ">
                    <label class="control-label requiredField" for="opmerking">
                        Remark <span class="asteriskField" style="color: red;"> * </span>
                    </label>
                    <textarea required class="form-control" id="opmerking" type="text"
                              name="opmerking"><?php echo $aanvragen->opmerking; ?></textarea>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-3">
                    <?php if ($_GET[action] == 'newmulti') { ?>
                        <div class="form-group ">
                            <label class="control-label" for="afkcode"> Category </label>
                            <div>
                                <select class="select form-control" id="afkcode" name="afkcode">
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
                </div>
                <div class="col-md-4">
                    <div class="form-group ">
                        <label class="control-label requiredField" for="artikelcode">
                            Articlecode <span class="asteriskField" style="color: red;"> * </span>
                        </label>
                        <select class="select form-control" id="artikelcode" name="artikelcode">
                            <option></option>
                            <?php
                            if ($_GET[action] != 'newmulti') {
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
                </div>
                <div class="col-md-2">
                    <div class="form-group ">
                        <label class="control-label requiredField" for="voorraadaantal">Voorraad</label>
                        <div>
                            <span class="asteriskField" style="color: red;" id="voorraadaantal"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group ">
                        <label class="control-label requiredField" for="aantal">
                            Quantity <span class="asteriskField" style="color: red;"> * </span>
                        </label>
                        <input class="form-control" id="aantal" type="text" name="aantal"
                               value="<?php echo $aanvragen->aantal; ?>"/>
                        <input id="checkaantal" type="hidden" name="checkaantal"/>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-3">
                    <?php if ($_GET[action] == 'newmulti') { ?>
                        <div class="form-group ">
                            <div>
                                <select class="select form-control" id="afkcode2" name="afkcode2">
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
                </div>
                <div class="col-md-4">
                    <div class="form-group ">
                        <select class="select form-control" id="artikelcode2" name="artikelcode2">
                            <option></option>
                            <?php
                            if ($_GET[action] != 'newmulti') {
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
                </div>
                <div class="col-md-2">
                    <div class="form-group ">
                        <div>
                            <span class="asteriskField" style="color: red;" id="voorraadaantal2"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group ">
                        <input class="form-control" id="aantal2" type="text" name="aantal2"
                               value="<?php echo $aanvragen->aantal; ?>"/>
                        <input id="checkaantal2" type="hidden" name="checkaantal2"/>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-3">
                    <?php if ($_GET[action] == 'newmulti') { ?>
                        <div class="form-group ">
                            <div>
                                <select class="select form-control" id="afkcode3" name="afkcode3">
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
                </div>
                <div class="col-md-4">
                    <div class="form-group ">
                        <select class="select form-control" id="artikelcode3" name="artikelcode3">
                            <option></option>
                            <?php
                            if ($_GET[action] != 'newmulti') {
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
                </div>
                <div class="col-md-2">
                    <div class="form-group ">
                        <div>
                            <span class="asteriskField" style="color: red;" id="voorraadaantal3"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group ">
                        <input class="form-control" id="aantal3" type="text" name="aantal3"
                               value="<?php echo $aanvragen->aantal; ?>"/>
                        <input id="checkaantal3" type="hidden" name="checkaantal3"/>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-3">
                    <?php if ($_GET[action] == 'newmulti') { ?>
                        <div class="form-group ">
                            <div>
                                <select class="select form-control" id="afkcode4" name="afkcode4">
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
                </div>
                <div class="col-md-4">
                    <div class="form-group ">
                        <select class="select form-control" id="artikelcode4" name="artikelcode4">
                            <option></option>
                            <?php
                            if ($_GET[action] != 'newmulti') {
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
                </div>
                <div class="col-md-2">
                    <div class="form-group ">
                        <div>
                            <span class="asteriskField" style="color: red;" id="voorraadaantal4"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group ">
                        <input class="form-control" id="aantal4" type="text" name="aantal4"
                               value="<?php echo $aanvragen->aantal; ?>"/>
                        <input id="checkaantal4" type="hidden" name="checkaantal4"/>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-3">
                    <?php if ($_GET[action] == 'newmulti') { ?>
                        <div class="form-group ">
                            <div>
                                <select class="select form-control" id="afkcode5" name="afkcode5">
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
                </div>
                <div class="col-md-4">
                    <div class="form-group ">
                        <select class="select form-control" id="artikelcode5" name="artikelcode5">
                            <option></option>
                            <?php
                            if ($_GET[action] != 'newmulti') {
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
                </div>
                <div class="col-md-2">
                    <div class="form-group ">
                        <div>
                            <span class="asteriskField" style="color: red;" id="voorraadaantal5"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group ">
                        <input class="form-control" id="aantal5" type="text" name="aantal5"
                               value="<?php echo $aanvragen->aantal; ?>"/>
                        <input id="checkaantal5" type="hidden" name="checkaantal5"/>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="btn_submit" disabled>Save changes</button>
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
        filterArtikelcode(($(this).val()), "1");
    });
    $("#afkcode2").change(function () {
        filterArtikelcode(($(this).val()), "2");
    });
    $("#afkcode3").change(function () {
        filterArtikelcode(($(this).val()), "3");
    });
    $("#afkcode4").change(function () {
        filterArtikelcode(($(this).val()), "4");
    });
    $("#afkcode5").change(function () {
        filterArtikelcode(($(this).val()), "5");
    });

    function filterArtikelcode(afkcode, soort) {
        $.post("apps/<?php echo app_name;?>/ajax/filterartikel.php", {afkcode: afkcode}, function (data) {
            if (data != '' || data != undefined || data != null) {
                switch (soort) {
                    case "1":
                        $('#artikelcode').html(data);
                        break;
                    case "2":
                        $('#artikelcode2').html(data);
                        break;
                    case "3":
                        $('#artikelcode3').html(data);
                        break;
                    case "4":
                        $('#artikelcode4').html(data);
                        break;
                    case "5":
                        $('#artikelcode5').html(data);
                        break;
                }
            }
        });
    }

    $("#artikelcode").change(function () {
        checkArtikelcode($(this).val(), "1");
    });
    $("#artikelcode2").change(function () {
        checkArtikelcode($(this).val(), "2");
    });
    $("#artikelcode3").change(function () {
        checkArtikelcode($(this).val(), "3");
    });
    $("#artikelcode4").change(function () {
        checkArtikelcode($(this).val(), "4");
    });
    $("#artikelcode5").change(function () {
        checkArtikelcode($(this).val(), "5");
    });

    function checkArtikelcode(artikelcode, soort) {
        $.post("apps/<?php echo app_name;?>/ajax/checkartikelaantal.php", {artikelcode: artikelcode}, function (data) {
            if (data != '' || data != undefined || data != null) {
                switch (soort) {
                    case "1":
                        $('#checkaantal').val(data);
                        $('#voorraadaantal').html(data);
                        break;
                    case "2":
                        $('#checkaantal2').val(data);
                        $('#voorraadaantal2').html(data);
                        break;
                    case "3":
                        $('#checkaantal3').val(data);
                        $('#voorraadaantal3').html(data);
                        break;
                    case "4":
                        $('#checkaantal4').val(data);
                        $('#voorraadaantal4').html(data);
                        break;
                    case "5":
                        $('#checkaantal5').val(data);
                        $('#voorraadaantal5').html(data);
                        break;
                }

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
    $("#aantal2").blur(function () {
        checkArtikelAantal();
    });
    $("#aantal3").blur(function () {
        checkArtikelAantal();
    });
    $("#aantal4").blur(function () {
        checkArtikelAantal();
    });
    $("#aantal5").blur(function () {
        checkArtikelAantal();
    });

    function checkArtikelAantal() {
        var w1 = $('#checkaantal').val();
        var w2 = $('#aantal').val();

        var v1 = $('#checkaantal2').val();
        var v2 = $('#aantal2').val();

        var p1 = $('#checkaantal3').val();
        var p2 = $('#aantal3').val();

        var q1 = $('#checkaantal4').val();
        var q2 = $('#aantal4').val();

        var r1 = $('#checkaantal5').val();
        var r2 = $('#aantal5').val();

        $('#btn_submit').prop("disabled", true);
        if (w1 - w2 < 0) {
            $('#aantal').val('');
            alert('Not enough spareparts available for ' + $("#artikelcode").val());
        } else if (v1 - v2 < 0) {
            $('#aantal2').val('');
            alert('Not enough spareparts available for ' + $("#artikelcode2").val());
        } else if (p1 - p2 < 0) {
            $('#aantal3').val('');
            alert('Not enough spareparts available for ' + $("#artikelcode3").val());
        } else if (q1 - q2 < 0) {
            $('#aantal4').val('');
            alert('Not enough spareparts available for ' + $("#artikelcode4").val());
        } else if (r1 - r2 < 0) {
            $('#aantal5').val('');
            alert('Not enough spareparts available for ' + $("#artikelcode5").val());
        } else {
            $('#btn_submit').prop("disabled", false);
        }
    }


</script>