<?php
require_once('../../../php/conf/config.php');
require_once('../php/database.php');
include "../../../domain/procurementBuitenInkoop/Ontvangst.php";
$ontvangst = Ontvangst::find($_GET['id']);
?>
<form class="form-horizontal"
      action="apps/<?php echo app_name; ?>/ontvangst.php?action=<?php echo $_GET['action']; ?>&recordId=<?php echo $_GET['id']; ?>"
      method="post" name="inputform" id="inputform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?php echo ucfirst($_GET['action']); ?> Afgifte</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="naam">Afgerond een mail naar proc?</label>
                    <div class="col-sm-9">

                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="naam">Vertrekt/Niet verstrekt</label>
                    <div class="col-sm-9">
                        <input type="text" id="ontv_gemiddelde_levertijd" name="ontv_gemiddelde_levertijd"
                               class="form-control" value="<?php echo $ontvangst->ontv_gemiddelde_levertijd; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="naam">MAB No</label>
                    <div class="col-sm-9">
                        <input type="text" id="ontv_oronr" name="ontv_oronr" class="form-control"
                               value="<?php echo $ontvangst->ontv_oronr; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="naam">Verstrekte colli</label>
                    <div class="col-sm-9">
                        <input type="text" id="ontv_gegevens_van_ontvangst" name="ontv_gegevens_van_ontvangst"
                               class="form-control" value="<?php echo $ontvangst->ontv_gegevens_van_ontvangst; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="naam">Verstrekkingsdatum</label>
                    <div class="col-sm-9">
                        <input type="text" id="ontv_lokatie_ontvangst" name="ontv_lokatie_ontvangst"
                               class="form-control" value="<?php echo $ontvangst->ontv_lokatie_ontvangst; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="naam">Ontvangendoor</label>
                    <div class="col-sm-9">
                        <input type="text" id="ontv_ontvangen_colli" name="ontv_ontvangen_colli" class="form-control"
                               value="<?php echo $ontvangst->ontv_ontvangen_colli; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="naam">Datum ontv melding (mail) ORO</label>
                    <div class="col-sm-9">
                        <input type="text" id="ontv_aantal" name="ontv_aantal" class="form-control"
                               value="<?php echo $ontvangst->ontv_aantal; ?>">
                    </div>
                </div>

            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="naam">Belanghebbende gemeld (mail)</label>
                    <div class="col-sm-9">
                        <input type="text" id="ontv_seedstock" name="ontv_seedstock" class="form-control"
                               value="<?php echo $ontvangst->ontv_seedstock; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="naam">Keuring</label>
                    <div class="col-sm-9">
                        <input type="text" id="ontv_ontvangen_door" name="ontv_ontvangen_door" class="form-control"
                               value="<?php echo $ontvangst->ontv_ontvangen_door; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="naam">Verwerkt in Exact</label>
                    <div class="col-sm-9">
                        <input type="text" id="ontv_vrachtkosten" name="ontv_vrachtkosten" class="form-control"
                               value="<?php echo $ontvangst->ontv_vrachtkosten; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="naam">Afgifte stukken sec</label>
                    <div class="col-sm-9">
                        <input type="text" id="ontv_aantal_defect" name="ontv_aantal_defect" class="form-control"
                               value="<?php echo $ontvangst->ontv_aantal_defect; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="naam">Prestatie H-INV</label>
                    <div class="col-sm-9">
                        <input type="text" id="ontv_staat_defect" name="ontv_staat_defect" class="form-control"
                               value="<?php echo $ontvangst->ontv_staat_defect; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="naam">Documenten verstuurd naar FM door secr</label>
                    <div class="col-sm-9">
                        <input type="text" id="ontv_niet_compleet" name="ontv_niet_compleet" class="form-control"
                               value="<?php echo $ontvangst->ontv_niet_compleet; ?>">
                    </div>
                </div
                >
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="naam">Opmerkingen</label>
                    <div class="col-sm-9">
                        <input type="text" id="ontv_opmerkingen" name="ontv_opmerkingen" class="form-control"
                               value="<?php echo $ontvangst->ontv_opmerkingen; ?>">
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
</script>

