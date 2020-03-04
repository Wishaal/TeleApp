<?php
require_once('../../../php/conf/config.php');
require_once('../php/config.php');
include "../domain/Assetpart.php";
//include "../domain/Leverancier.php";
include "../domain/Artikel.php";
include "../domain/Categorie.php";
include "../domain/Valuta.php";
include "../domain/Statustype.php";
include "../domain/Fabrikant.php";

//$leverancierrecord = Leverancier::all(array('id', 'name', 'contact'));
$artikelrecord = Artikel::all(array('artikelcode', 'artikelnaam'));
$categorierecord = Categorie::all(array('categorienr', 'categorienaam', 'afkcode'));
$valutarecord = Valuta::all(array('valutacode', 'valutanaam'));
$statusrecord = Statustype::all(array('statusnr', 'statusnaam'));
$fabrikantrecord = Fabrikant::all(array('fabrikantid', 'name', 'contact'));

$assetpart = Assetpart::find($_GET['id']);

if ($_GET['action'] == 'new') {
    $assetpart->statusnr = 1;
}
?>
<form action="apps/<?php echo app_name; ?>/assetpart.php?action=<?php echo $_GET['action']; ?>&recordId=<?php echo $_GET['id']; ?>"
      method="post" name="inputform" id="inputform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?php echo ucfirst($_GET['action']); ?> Assetpart</h4>
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
            <div class="col-md-6">
                <div class="form-group ">
                    <label class="control-label" for="artikelcode"> Article <span class="asteriskField"
                                                                                  style="color: red;"> * </span>
                    </label>
                    <div>
                        <select required class="select form-control" id="artikelcode" name="artikelcode">
                            <option></option>
                            <?php
                            foreach ($artikelrecord as $r) {
                                if ($r->artikelcode == $assetpart->artikelcode) {
                                    $sel = 'selected=selected';
                                } else {
                                    $sel = '';
                                }
                                echo '<option ' . $sel . ' value=' . $r->artikelcode . '>' . $r->artikelcode . " - " . $r->artikelnaam . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group ">
                    <label class="control-label" for="categorienr"> Category <span class="asteriskField"
                                                                                   style="color: red;"> * </span>
                    </label>
                    <div>
                        <select required class="select form-control" id="categorienr" name="categorienr">
                            <option></option>
                            <?php
                            foreach ($categorierecord as $r) {
                                if ($r->categorienr == $assetpart->categorienr) {
                                    $sel = 'selected=selected';
                                } else {
                                    $sel = '';
                                }
                                echo '<option ' . $sel . ' value=' . $r->categorienr . '>' . $r->afkcode . " - " . $r->categorienaam . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <!--
			<div class="form-group ">
				<label class="control-label requiredField" for="vendorcode"> Vendor</label>
				<div>
					<select class="select form-control" id="vendorcode" name="vendorcode">
						<option></option>
						<?php
                foreach ($leverancierrecord as $r) {
                    if ($r->id == $assetpart->vendorcode) {
                        $sel = 'selected=selected';
                    } else {
                        $sel = '';
                    }
                    echo '<option ' . $sel . ' value=' . $r->id . '>' . $r->name . " - " . $r->contact . '</option>';
                }
                ?>
					</select>
				</div>
			</div>
			-->
                <div class="form-group ">
                    <label class="control-label requiredField" for="fabrikantid"> Manufacturer <span
                                class="asteriskField" style="color: red;"> * </span></label>
                    <div>
                        <select required class="select form-control" id="fabrikantid" name="fabrikantid">
                            <option></option>
                            <?php
                            foreach ($fabrikantrecord as $r) {
                                if ($r->fabrikantid == $assetpart->fabrikantid) {
                                    $sel = 'selected=selected';
                                } else {
                                    $sel = '';
                                }
                                echo '<option ' . $sel . ' value=' . $r->fabrikantid . '>' . $r->name . " - " . $r->contact . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group ">
                    <label class="control-label" for="assetnaam"> Productdescription <span class="asteriskField"
                                                                                           style="color: red;"> * </span>
                    </label>
                    <div>
                        <input required class="form-control" id="assetnaam" type="text" name="assetnaam"
                               value="<?php echo $assetpart->assetnaam; ?>"/>
                    </div>
                </div>
                <div class="form-group ">
                    <label class="control-label" for="serienr"> Serialnr <span class="asteriskField"
                                                                               style="color: red;"> * </span> <span
                                class="asteriskField" style="color: red;" id="serienrcheck"></span></label>
                    <div>
                        <input required class="form-control" id="serienr" type="text" name="serienr"
                               value="<?php echo $assetpart->serienr; ?>" onblur="checkSerienr(this.value)"/>
                    </div>
                </div>
                <div class="form-group ">
                    <label class="control-label" for="partnr"> Partnr <span class="asteriskField"
                                                                            style="color: red;"> * </span> </label>
                    <div>
                        <input required class="form-control" id="partnr" type="text" name="partnr"
                               value="<?php echo $assetpart->partnr; ?>"/>
                    </div>
                </div>
                <div class="form-group ">
                    <label class="control-label" for="revisioncode"> Revision </label>
                    <div>
                        <input class="form-control" id="revisioncode" type="text" name="revisioncode"
                               value="<?php echo $assetpart->revisioncode; ?>"/>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group ">
                    <label class="control-label" for="aantal"> Quantity <span class="asteriskField" style="color: red;"> * </span>
                    </label>
                    <div>
                        <input required class="form-control" id="aantal" type="text" name="aantal"
                               value="<?php echo $assetpart->aantal; ?>"/>
                    </div>
                </div>
                <div class="form-group ">
                    <label class="control-label" for="valutacode"> Currency </label>
                    <div>
                        <select class="select form-control" id="valutacode" name="valutacode">
                            <option></option>
                            <?php
                            foreach ($valutarecord as $r) {
                                if ($r->valutacode == $assetpart->valutacode) {
                                    $sel = 'selected=selected';
                                } else {
                                    $sel = '';
                                }
                                echo '<option ' . $sel . ' value=' . $r->valutacode . '>' . $r->valutacode . " - " . $r->valutanaam . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group ">
                    <label class="control-label" for="prijs"> Price </label>
                    <div>
                        <input class="form-control" id="prijs" type="text" name="prijs"
                               value="<?php echo $assetpart->prijs; ?>"/>
                    </div>
                </div>
                <div class="form-group ">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label" for="garantiedatumbegin"> Warranty begin </label>
                            <input class="form-control" id="garantiedatumbegin" type="text" name="garantiedatumbegin"
                                   value="<?php echo ($assetpart->garantiedatumbegin == '0000-00-00') ? '' : $assetpart->garantiedatumbegin; ?>"
                                   data-date="" data-date-format="YYYY-MM-DD" data-link-format="yyyy-mm-dd"
                                   data-link-field="garantiedatumbegin" autocomplete="off"/>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label" for="garantiedatumbegin"> Warranty end</label>
                            <input class="form-control" id="garantiedatumeind" type="text" name="garantiedatumeind"
                                   value="<?php echo ($assetpart->garantiedatumeind == '0000-00-00') ? '' : $assetpart->garantiedatumeind; ?>"
                                   data-date="" data-date-format="YYYY-MM-DD" data-link-format="yyyy-mm-dd"
                                   data-link-field="garantiedatumeind" autocomplete="off"/>
                        </div>
                    </div>
                </div>
                <div class="form-group ">
                    <label class="control-label" for="oronr"> Oro-nr </label>
                    <div>
                        <input class="form-control" id="oronr" type="text" name="oronr"
                               value="<?php echo $assetpart->oronr; ?>"/>
                    </div>
                </div>
                <div class="form-group ">
                    <label class="control-label" for="opmerking"> Remark </label>
                    <div>
                        <textarea class="form-control" id="opmerking" type="text"
                                  name="opmerking"><?php echo $assetpart->opmerking; ?></textarea>
                        <input class="form-control" id="statusnr" type="hidden" name="statusnr"
                               value="<?php echo $assetpart->statusnr; ?>"/>
                    </div>
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
    $('#garantiedatumbegin').datetimepicker({
        pickTime: false,
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
    $('#garantiedatumeind').datetimepicker({
        pickTime: false,
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });

    function checkSerienr(serienrcheck) {
        $('#serienrcheck').html('');
        trimInputFields();

        $.post("apps/<?php echo app_name;?>/ajax/checkassetpart_serial.php", {serienr: serienrcheck}, function (data) {
            if (data != '' || data != undefined || data != null) {
                $('#serienrcheck').html(data);
            }
        });
    }

    $("#artikelcode").change(function () {
        checkArtikelcode($(this).val());
    });

    function checkArtikelcode(artikelcode) {
        $.post("apps/<?php echo app_name;?>/ajax/checkartikel.php", {artikelcode: artikelcode}, function (data) {
            if (data != '' || data != undefined || data != null) {
                var alledata = data.split("*******");
                $('#assetnaam').val(alledata[0]);

                var hulpstukwaarde = alledata[1];
                if (hulpstukwaarde == 'J') {
                    $('#serienr').prop('disabled', true);
                    $('#serienrcheck').html('');
                } else {
                    $('#serienr').prop('disabled', false);
                    $('#aantal').val('1');
                }
                $('#categorienr').val(alledata[2]);
            }
        });
    }

    function trimInputFields() {
        var allInputs = $(":input");
        allInputs.each(function () {
            $(this).val($.trim($(this).val()));
        });
    };
</script>