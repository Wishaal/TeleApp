<?php
require_once('../../../php/conf/config.php');
require_once('../php/database.php');

include "../../../domain/procurementBuitenInkoop/User.php";
include "../../../domain/procurementBuitenInkoop/Role.php";
include "../../../domain/procurementBuitenInkoop/UserRole.php";

$user = User::find($_GET['id']);
$rollen = Role::all();
$userRollen = UserRole::where('user_id', '=', $user->id)->get();
$selectedgroupsArr = array();
foreach ($userRollen as $group) {
    $selectedgroupsArr[] = $group->role_id;
}
?>
<form class="form-horizontal"
      action="apps/<?php echo app_name; ?>/users.php?action=<?php echo $_GET['action']; ?>&recordId=<?php echo $_GET['id']; ?>"
      method="post" name="inputform" id="inputform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?php echo ucfirst($_GET['action']); ?> User</h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label class="col-sm-2 control-label" for="naam">Username</label>
            <div class="col-sm-10">
                <input type="text" id="username" name="username" class="form-control"
                       value="<?php echo $user->username; ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="einddatum">Rollen</label>
            <div class="col-sm-8">
                <select name="rollen[]" id="rollen" class="selectpicker form-control" multiple>
                    <?php
                    foreach ($rollen as $rol) {
                        $sel = '';
                        if (in_array($rol->id, $selectedgroupsArr)) {
                            $sel = 'selected="selected"';
                        }
                        echo '<option ' . $sel . ' value=' . $rol->id . '>' . $rol->rolnaam . '</option>';
                    }
                    ?>
                </select>
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
    $('.selectpicker').selectpicker({});
</script>

