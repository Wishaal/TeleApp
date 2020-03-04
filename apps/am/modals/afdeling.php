<?php
require_once('../../../php/conf/config.php');
require_once('../php/config.php');
include "../domain/Afdeling.php";
$parentafdeling = Afdeling::all(array('afdelingcode', 'afdelingnaam', 'onderdirectoraat'));
$afdeling = Afdeling::find($_GET['id']);
?>
<form action="apps/<?php echo app_name; ?>/afdeling.php?action=<?php echo $_GET['action']; ?>&recordId=<?php echo $_GET['id']; ?>"
      method="post" name="inputform" id="inputform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?php echo ucfirst($_GET['action']); ?> Afdeling</h4>
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
            <label class="control-label requiredField" for="afdelingcode">
                Code <span class="asteriskField" style="color: red;"> * </span>
            </label>
            <input required class="form-control" id="afdelingcode" name="afdelingcode" placeholder="Code" type="text"
                   value="<?php echo $afdeling->afdelingcode; ?>"/>
        </div>
        <div class="form-group ">
            <label class="control-label requiredField" for="afdelingnaam">
                Naam <span class="asteriskField" style="color: red;"> * </span>
            </label>
            <input required class="form-control" id="afdelingnaam" type="text" name="afdelingnaam"
                   value="<?php echo $afdeling->afdelingnaam; ?>"/>
        </div>
        <div class="form-group">
            <label class="control-label" for="onderdirectoraat">Onderdirectoraat</label>
            <select class="select form-control" id="onderdirectoraat" name="onderdirectoraat">
                <option></option>
                <?php
                foreach ($parentafdeling as $r) {
                    if ($r->afdelingcode == $afdeling->onderdirectoraat) {
                        $sel = 'selected=selected';
                    } else {
                        $sel = '';
                    }
                    if (empty($r->onderdirectoraat)) {
                        echo '<option ' . $sel . ' value=' . $r->afdelingcode . '>' . $r->afdelingcode . " - " . $r->afdelingnaam . '</option>';
                    }
                }
                ?>
            </select>
        </div>
        <div class="form-group ">
            <label class="control-label requiredField" for="kostenplaatscode">
                Kostenplaats <span class="asteriskField" style="color: red;"> * </span>
            </label>
            <input required class="form-control" id="kostenplaatscode" type="text" name="kostenplaatscode"
                   value="<?php echo $afdeling->kostenplaatscode; ?>"/>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="btn_submit">Save changes</button>
    </div>
</form>