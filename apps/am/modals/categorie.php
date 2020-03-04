<?php
require_once('../../../php/conf/config.php');
require_once('../php/config.php');
include "../domain/Categorie.php";

//error_reporting(E_ALL);
//ini_set("display_errors", 1);

$categorie = Categorie::find($_GET['id']);

$categorierecord = Categorie::all(array('categorienr', 'categorienaam'));
?>
<form action="apps/<?php echo app_name; ?>/categorie.php?action=<?php echo $_GET['action']; ?>&recordId=<?php echo $_GET['id']; ?>"
      method="post" name="inputform" id="inputform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?php echo ucfirst($_GET['action']); ?> Categorie</h4>
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
            <label class="control-label requiredField" for="categorienaam">
                Naam <span class="asteriskField" style="color: red;"> * </span>
            </label>
            <input required class="form-control" id="categorienaam" type="text" name="categorienaam"
                   value="<?php echo $categorie->categorienaam; ?>"/>
        </div>
        <div class="form-group ">
            <label class="control-label" for="parentnr"> Parent </label>
            <div>
                <select class="select form-control" id="parentnr" name="parentnr">
                    <option></option>
                    <?php
                    foreach ($categorierecord as $r) {
                        if ($r->categorienr == $categorie->parentnr) {
                            $sel = 'selected=selected';
                        } else {
                            $sel = '';
                        }
                        echo '<option ' . $sel . ' value=' . $r->categorienr . '>' . $r->categorienr . " - " . $r->categorienaam . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
		<?php
		if ($_GET['action']=='new') {
		?>
        <div class="form-group ">
            <label class="control-label requiredField" for="afkcode">
                Abbreviation <span class="asteriskField" style="color: red;"> * </span>
            </label>
            <input required class="form-control" id="afkcode" type="text" name="afkcode"
                   value="<?php echo $categorie->afkcode; ?>"/>
        </div>
		<?php
		} else {
		?>
            <input required class="form-control" id="afkcode" type="hidden" name="afkcode"
                   value="<?php echo $categorie->afkcode; ?>"/>
		<?php
		}
		?>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="btn_submit">Save changes</button>
    </div>
</form>