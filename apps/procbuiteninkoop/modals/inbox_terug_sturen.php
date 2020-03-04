<?php
require_once('../../../php/conf/config.php');
require_once('../php/database.php');

?>
<form class="form-horizontal"
      action="apps/<?php echo app_name; ?>/inbox.php?action=<?php echo $_GET['action']; ?>&recordId=<?php echo $_GET['id']; ?>"
      method="post" name="inputform" id="inputform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?php echo ucfirst($_GET['action']); ?> Terug sturen naar Inventory</h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label class="col-sm-2 control-label" for="naam">Reden?</label>
            <div class="col-sm-10">
                <textarea id="inbox_terug_opmerking" name="inbox_terug_opmerking" class="form-control"
                          required></textarea>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="btn_submit">Save changes</button>
    </div>
</form>