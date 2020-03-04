<?php
require_once('../../../php/conf/config.php');
require_once('../php/database.php');
include "../../../domain/procurementBuitenInkoop/EmailGroup.php";
include "../../../domain/procurementBuitenInkoop/EmailUser.php";

$group = EmailGroup::find($_GET['id']);
$email = EmailUser::where('email_group_id', '=', $group->id)->get();
?>
<form class="form-horizontal"
      action="apps/<?php echo app_name; ?>/emailgroups.php?action=<?php echo $_GET['action']; ?>&recordId=<?php echo $_GET['id']; ?>"
      method="post" name="inputform" id="inputform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?php echo ucfirst($_GET['action']); ?> Group</h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label class="col-sm-2 control-label" for="naam">Group Name</label>
            <div class="col-sm-10">
                <input type="text" id="name" name="name" class="form-control" value="<?php echo $group->name; ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="naam">Group members</label>
            <div class="col-sm-10">
                <input type="text" required name="members" id="members" class="form-control" value="<?php
                foreach ($email as $r) {

                    echo $r->email . ',';
                }
                ?>" data-role="tagsinput"/>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="btn_submit">Save changes</button>
    </div>
</form>
<script src="assets/_layout/js/bootstrap-tagsinput.js" type="text/javascript"></script>

