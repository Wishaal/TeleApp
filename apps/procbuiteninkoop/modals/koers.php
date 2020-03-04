<?php
require_once('../../../php/conf/config.php');
require_once('../php/database.php');
include "../../../domain/procurementBuitenInkoop/Koers.php";

$koers = Koers::find($_GET['id']);
?>
<form class="form-horizontal"
      action="apps/<?php echo app_name; ?>/koers.php?action=<?php echo $_GET['action']; ?>&recordId=<?php echo $_GET['id']; ?>"
      method="post" name="inputform" id="inputform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?php echo ucfirst($_GET['action']); ?> Koers</h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label class="col-sm-2 control-label" for="naam">USD Koers</label>
            <div class="col-sm-10">
                <input type="text" id="usd_koers" name="usd_koers" class="form-control"
                       value="<?php echo $koers->usd_koers; ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="naam">EURO Koers</label>
            <div class="col-sm-10">
                <input type="text" id="euro_koers" name="euro_koers" class="form-control"
                       value="<?php echo $koers->euro_koers; ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="naam">Omrekeningskoers</label>
            <div class="col-sm-10">
                <input type="text" id="omrekeningskoers" name="omrekeningskoers" class="form-control"
                       value="<?php echo $koers->omrekeningskoers; ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="begindatum">Datum</label>
            <div class="col-sm-10">
                <input class="form-control" id="datum" name="datum" data-date="" data-date-format="YYYY-MM-DD"
                       data-link-format="yyyy-mm-dd" data-link-field="datum" autocomplete="off"
                       value="<?php echo $koers->datum; ?>" type="text">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="btn_submit">Save changes</button>
        </div>
</form>
<script>
    $('#datum').datetimepicker({
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

