<?php
require_once('../../../php/conf/config.php');
require_once('../php/config.php');
include "../domain/Aanvragennr.php";
$aanvragennr = Aanvragennr::find($_GET['id']);
?>
<form action="apps/<?php echo app_name; ?>/aanvragennr.php?action=<?php echo $_GET['action']; ?>&recordId=<?php echo $_GET['id']; ?>"
      method="post" name="inputform" id="inputform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?php echo ucfirst($_GET['action']); ?> Aanvraagnrs</h4>
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
        <div class="form-group ">
            <label class="control-label requiredField" for="aanvraagnr">
                Code <span class="asteriskField" style="color: red;"> * </span>
            </label>
            <input required class="form-control" id="aanvraagnr" name="aanvraagnr" placeholder="Code" type="text"
                   value="<?php echo $aanvragennr->aanvraagnr; ?>"/>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="btn_submit">Save changes</button>
    </div>
</form>