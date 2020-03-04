<?php
require_once('../../../php/conf/config.php');
require_once('../php/config.php');
require_once('../php/functions.php');

include "../domain/Werkorder.php";
include "../domain/Afdeling.php";
include "../domain/Personeel.php";
include "../domain/Aanvragen.php";

$afdelingrecord = Afdeling::all(array('afdelingcode', 'afdelingnaam'));
$personeelrecord = Personeel::all(array('badgenr', 'naam', 'voornaam', 'afdelingcode'));
$aanvragenrecord = Aanvragen::find($_GET['id']);

$werkorder = Werkorder::find($_GET['id']);

$specifiekaanvraagnr = ($_GET['action'] == 'new') ? $aanvragenrecord->aanvraagnr : $werkorder->aanvraagnr;
$specwerkorder = Werkorder::find($specifiekaanvraagnr);
if ($_GET['action'] == 'new') {
    $specifiekvolgnr = $specwerkorder->volgnr;
    $specifiekvolgnr = $specifiekvolgnr + 1;
    if (empty($werkorder->afdelingcode)) {
        $werkorder->afdelingcode = "OP&W";
    }
} else {
    $specifiekvolgnr = $werkorder->volgnr;
}

if ($_GET['action'] == 'approve' || $_GET['action'] == 'cancelreq') {
    if (empty($werkorder->taakafgemeld)) {
        $werkorder->taakafgemeld = date('Y-m-d');
    }
}
?>
<form action="apps/<?php echo app_name; ?>/werkorder.php?action=<?php echo $_GET['action']; ?>&parent=<?php echo $_GET['parent']; ?>&recordId=<?php echo $_GET['id']; ?>"
      method="post" name="inputform" id="inputform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?php echo ucfirst($_GET['action']); ?> Workorder</h4>
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
                    <label class="control-label requiredField" for="aanvraagnr">
                        Requestnr <span class="asteriskField" style="color: red;"> * </span>
                    </label>
                    <input class="form-control" id="aanvraagnr" type="hidden" name="aanvraagnr"
                           value="<?php echo ($_GET['action'] == 'new') ? $aanvragenrecord->aanvraagnr : $werkorder->aanvraagnr; ?>"/>
                    <input disabled class="form-control" type="text"
                           value="<?php echo ($_GET['action'] == 'new') ? $aanvragenrecord->aanvraagnr : $werkorder->aanvraagnr; ?>"/>
                </div>
                <div class="form-group ">
                    <label class="control-label requiredField" for="volgnr">
                        Nr <span class="asteriskField" style="color: red;"> * </span>
                    </label>
                    <input class="form-control" id="volgnr" type="hidden" name="volgnr"
                           value="<?php echo $specifiekvolgnr; ?>"/>
                    <input disabled class="form-control" type="text" value="<?php echo $specifiekvolgnr; ?>"/>
                </div>
                <div class="form-group ">
                    <label class="control-label requiredField" for="afdelingcode">
                        Department <span class="asteriskField" style="color: red;"> * </span>
                    </label>
                    <?php
                    if ($_GET['action'] == 'approve' || $_GET['action'] == 'cancelreq') {
                        ?>
                        <input class="form-control" id="afdelingcode" type="hidden" name="afdelingcode"
                               value="<?php echo $werkorder->afdelingcode; ?>"/>
                        <?php
                    }
                    ?>
                    <select class="select form-control" <?php echo ($_GET['action'] == 'approve' || $_GET['action'] == 'cancelreq') ? 'disabled' : 'id="afdelingcode" name="afdelingcode" required'; ?> >
                        <option></option>
                        <?php
                        foreach ($afdelingrecord as $r) {
                            if ($r->afdelingcode == $werkorder->afdelingcode) {
                                $sel = 'selected=selected';
                            } else {
                                $sel = '';
                            }
                            echo '<option ' . $sel . ' value=' . $r->afdelingcode . '>' . $r->afdelingcode . " - " . $r->afdelingnaam . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group ">
                    <label class="control-label requiredField" for="taaknaam">
                        Taskname <span class="asteriskField" style="color: red;"> * </span>
                    </label>
                    <input class="form-control" id="taaknaam" type="hidden" name="taaknaam"
                           value="<?php echo ($_GET['action'] == 'new') ? 'Request Approval' : $werkorder->taaknaam; ?>"/>
                    <input disabled class="form-control" type="text"
                           value="<?php echo ($_GET['action'] == 'new') ? 'Request Approval' : $werkorder->taaknaam; ?>"/>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group ">
                    <label class="control-label requiredField" for="badgenr">
                        Badgenr <?php echo ($_GET['action'] == 'approve' || $_GET['action'] == 'cancelreq') ? '<span class="asteriskField" style="color: red;"> * </span>' : ''; ?>
                    </label>
                    <select class="select form-control" id="badgenr"
                            name="badgenr" <?php echo ($_GET['action'] == 'approve' || $_GET['action'] == 'cancelreq') ? 'required' : 'disabled'; ?>>
                        <option></option>
                        <?php
                        foreach ($personeelrecord as $r) {
                            if ($r->badgenr == $werkorder->badgenr) {
                                $sel = 'selected=selected';
                            } else {
                                $sel = '';
                            }
                            if (($_GET['action'] == 'approve' || $_GET['action'] == 'cancelreq') && $r->badgenr == $_SESSION[mis][user][badgenr]) {
                                $sel = 'selected=selected';
                            }
                            echo '<option ' . $sel . ' value=' . $r->badgenr . '>' . $r->naam . ' ' . $r->voornaam . ' Afdeling: ' . $r->afdelingcode . ' - (' . $r->badgenr . ')</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group ">
                    <label class="control-label requiredField" for="taakverstuurd">
                        Senddate <span class="asteriskField" style="color: red;"> * </span>
                    </label>
                    <input <?php echo ($_GET['action'] == 'approve' || $_GET['action'] == 'cancelreq') ? 'disabled' : 'required'; ?>
                            class="form-control" id="taakverstuurd" type="text" name="taakverstuurd"
                            value="<?php echo ($_GET['action'] == 'new') ? date('Y-m-d') : (($werkorder->taakverstuurd == '0000-00-00') ? '' : $werkorder->taakverstuurd); ?>"
                            data-date="" data-date-format="YYYY-MM-DD" data-link-format="yyyy-mm-dd"
                            data-link-field="taakverstuurd" autocomplete="off"/>
                </div>
                <div class="form-group ">
                    <label class="control-label requiredField" for="taakafgemeld">
                        Duedate <?php echo ($_GET['action'] == 'approve' || $_GET['action'] == 'cancelreq') ? '<span class="asteriskField" style="color: red;"> * </span>' : ''; ?>
                    </label>
                    <input <?php echo ($_GET['action'] == 'approve' || $_GET['action'] == 'cancelreq') ? 'required' : 'disabled'; ?>
                            class="form-control" id="taakafgemeld" type="text" name="taakafgemeld"
                            value="<?php echo ($werkorder->taakafgemeld == '0000-00-00') ? '' : $werkorder->taakafgemeld; ?>"
                            data-date="" data-date-format="YYYY-MM-DD" data-link-format="yyyy-mm-dd"
                            data-link-field="taakafgemeld" autocomplete="off"/>
                </div>
                <div class="form-group ">
                    <label class="control-label requiredField" for="opmerking">
                        Remark
                    </label>
                    <textarea class="form-control" id="opmerking" type="text"
                              name="opmerking" <?php echo ($_GET['action'] == 'new') ? 'disabled' : ''; ?>><?php echo $werkorder->opmerking; ?></textarea>
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
    $('#taakverstuurd').datetimepicker({
        pickTime: false,
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });

    $('#taakafgemeld').datetimepicker({
        pickTime: false,
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
</script>