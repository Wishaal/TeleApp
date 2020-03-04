<?php
require_once('../../../php/conf/config.php');
require_once('../php/database.php');
include "../../../domain/procurementBuitenInkoop/Leverancier.php";

$leverancier = Leverancier::find($_GET['id']);
?>
<form class="form-horizontal"
      action="apps/<?php echo app_name; ?>/leverancier.php?action=<?php echo $_GET['action']; ?>&recordId=<?php echo $_GET['id']; ?>"
      method="post" name="inputform" id="inputform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?php echo ucfirst($_GET['action']); ?> Leverancier</h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label class="col-sm-2 control-label" for="naam">Naam</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $leverancier->name; ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="naam">Adres / Details</label>
            <div class="col-sm-10">
                <textarea type="text" rows="7" class="form-control" id="details"
                          name="details"><?php echo $leverancier->details; ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="naam">Contactpersoon</label>
            <div class="col-sm-10">
                <input type="text" id="contact" name="contact" class="form-control"
                       value="<?php echo $leverancier->contact; ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="naam">Telefoon</label>
            <div class="col-sm-10">
                <input type="text" id="phone" name="phone" class="form-control"
                       value="<?php echo $leverancier->phone; ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="naam">Fax</label>
            <div class="col-sm-10">
                <input type="text" id="fax" name="fax" class="form-control" value="<?php echo $leverancier->fax; ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="naam">Email</label>
            <div class="col-sm-10">
                <input type="text" id="email" name="email" class="form-control"
                       value="<?php echo $leverancier->email; ?>">
            </div>
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

