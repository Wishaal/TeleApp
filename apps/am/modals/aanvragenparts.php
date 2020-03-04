<?php
require_once('../../../php/conf/config.php');
require_once('../php/config.php');
require_once('../php/functions.php');

include "../domain/Aanvragenparts.php";
include "../domain/Aanvragen.php";
include "../domain/Personeel.php";
include "../domain/Artikel.php";

$aanvragenrecord = Aanvragen::find($_GET['id']);
$artikelrecord = Artikel::find($aanvragenrecord->artikelcode);
$aanvragenparts = Aanvragenparts::find($_GET['id']);
$personeelrecord = Personeel::all(array('badgenr', 'naam', 'voornaam', 'afdelingcode'));
?>
<form action="apps/<?php echo app_name; ?>/aanvragenparts.php?action=<?php echo $_GET['action']; ?>&parent=<?php echo $_GET['parent']; ?>&recordId=<?php echo $_GET['id']; ?>"
      method="post" name="inputform" id="inputform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?php echo ucfirst($_GET['action']); ?> Finalize Request</h4>
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
        <input class="form-control" id="dbadgenr" type="hidden" name="dbadgenr"
               value="<?php echo $_SESSION[mis][user][badgenr]; ?>"/>
        <div class="form-group ">
            <label class="control-label requiredField"> Requestnr </label>
            <input disabled class="form-control" type="text"
                   value="<?php echo ($_GET['action'] == 'finalize') ? $aanvragenrecord->aanvraagnr : $aanvragenparts->aanvraagnr; ?>"/>
            <input required class="form-control" id="aanvraagnr" type="hidden" name="aanvraagnr"
                   value="<?php echo ($_GET['action'] == 'finalize') ? $aanvragenrecord->aanvraagnr : $aanvragenparts->aanvraagnr; ?>"/>
        </div>
        <div class="form-group ">
            <label class="control-label requiredField"> Quantity </label>
            <input disabled class="form-control" type="text" value="<?php echo $aanvragenrecord->aantal; ?>"/>
        </div>
        <div class="form-group ">
            <label class="control-label requiredField" for="rbadgenr"> Receiver <span class="asteriskField"
                                                                                      style="color: red;"> * </span>
            </label>
            <select required class="select form-control" id="rbadgenr" name="rbadgenr">
                <option></option>
                <?php
                foreach ($personeelrecord as $r) {
                    if ($r->badgenr == $aanvragenparts->rbadgenr) {
                        $sel = 'selected=selected';
                    } else {
                        $sel = '';
                    }
                    echo '<option ' . $sel . ' value=' . $r->badgenr . '>' . $r->naam . ' ' . $r->voornaam . ' Afdeling: ' . $r->afdelingcode . ' - (' . $r->badgenr . ')</option>';
                }
                ?>
            </select>
            <input class="form-control" id="assetpartstatus" type="hidden" name="assetpartstatus"/>
        </div>

        <?php
        if ($artikelrecord->hulpstuk == "J") {
        } else {
            for ($idx = 0; $idx < $aanvragenrecord->aantal; $idx++) {
                ?>
                <div class="col-sm-12 form-group">
                    <div class="col-sm-3">
                        <label class="control-label requiredField" for="serienr"> Serialnr <span class="asteriskField"
                                                                                                 style="color: red;"> * </span></label>
                    </div>
                    <div class="col-sm-8">
                        <input required class="form-control" id="serialnr" type="text" name="serialnr[]"
                               value="<?php echo $aanvragenparts->serienr; ?>"
                               onblur="checkSerieStatus(this.value, <?php echo $idx; ?>)"/>
                    </div>
                </div>
                <div class="form-group "><br><br></div>
                <?php
            }
        }
        ?>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="btn_submit" <?php if ($artikelrecord->hulpstuk == "J") {
            echo "";
        } else {
            echo "disabled";
        } ?> >Save changes
        </button>
    </div>
</form>

<script>
    function checkSerieStatus(serialnr, waarde) {
        if (serialnr != '' && serialnr != undefined && serialnr != null) {
            veldwaarde = 'serienr' + waarde;
            $.post("apps/<?php echo app_name;?>/ajax/checkassetpart_status.php", {
                serialnr: serialnr,
                artikelcode: "<?php echo $aanvragenrecord->artikelcode; ?>"
            }, function (data) {
                if (data != '' || data != undefined || data != null) {
                    $('#assetpartstatus').val(data);

                    if (data == '0') {
                        alert('Please check serial. This serialnr (' + serialnr + ') is not registrated.');
                        $('#btn_submit').prop("disabled", true);
                    } else {
                        $('#btn_submit').prop("disabled", false);
                    }
                }
            });
        }
    }
</script>