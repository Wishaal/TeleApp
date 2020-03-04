<?php
require_once('../../../php/conf/config.php');
require_once('../php/config.php');
include "../domain/District.php";
$district = District::find($_GET['id']);
?>
<form action="apps/<?php echo app_name; ?>/district.php?action=<?php echo $_GET['action']; ?>&recordId=<?php echo $_GET['id']; ?>"
      method="post" name="inputform" id="inputform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?php echo ucfirst($_GET['action']); ?> District</h4>
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
            <label class="control-label requiredField" for="district_code">
                Code
                <span class="asteriskField" style="color: red;"> * </span>
            </label>
            <input required class="form-control" id="district_code" name="district_code" placeholder="Code" type="text"
                   value="<?php echo $district->district_code; ?>"/>
        </div>
        <div class="form-group ">
            <label class="control-label " for="district_naam">
                Naam
                <span class="asteriskField" style="color: red;"> * </span>
            </label>
            <input required class="form-control" id="district_naam" type="text" name="district_naam"
                   value="<?php echo $district->district_naam; ?>"/>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="btn_submit">Save changes</button>
    </div>
</form>