<?php
require_once('../../../php/conf/config.php');

require_once('../php/database.php');
include "../../../domain/procurementBuitenInkoop/Status.php";

$status = Status::find($_GET['id']);
?>
<form class="form-horizontal"
      action="apps/<?php echo app_name; ?>/status.php?action=<?php echo $_GET['action']; ?>&recordId=<?php echo $_GET['id']; ?>"
      method="post" name="inputform" id="inputform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?php echo ucfirst($_GET['action']); ?> Status</h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label class="col-sm-2 control-label" for="naam">Soort</label>
            <div class="col-sm-10">
                <input type="text" id="soort" name="soort" class="form-control" value="<?php echo $status->soort; ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="naam">Omschrijving</label>
            <div class="col-sm-10">
                <input type="text" id="status_omschrijving" name="status_omschrijving" class="form-control"
                       value="<?php echo $status->status_omschrijving; ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="naam">Kenmerk</label>
            <div class="col-sm-10">
                <input type="text" id="kenmerk" name="kenmerk" class="form-control"
                       value="<?php echo $status->kenmerk; ?>">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="btn_submit">Save changes</button>
    </div>
</form>

