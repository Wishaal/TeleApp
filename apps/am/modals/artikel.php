<?php
require_once('../../../php/conf/config.php');
require_once('../php/config.php');
include "../domain/Artikel.php";
$artikel = Artikel::find($_GET['id']);
?>
<form action="apps/<?php echo app_name; ?>/artikel.php?action=<?php echo $_GET['action']; ?>&recordId=<?php echo $_GET['id']; ?>"
      method="post" name="inputform" id="inputform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?php echo ucfirst($_GET['action']); ?> Artikel</h4>
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
            <label class="control-label requiredField" for="artikelcode"> Code <span class="asteriskField"
                                                                                     style="color: red;"> * </span></label>
            <input required class="form-control" id="artikelcode" name="artikelcode" placeholder="Code" type="text"
                   value="<?php echo $artikel->artikelcode; ?>"/>
        </div>
        <div class="form-group ">
            <label class="control-label requiredField" for="artikelnaam"> Name <span class="asteriskField"
                                                                                     style="color: red;"> * </span></label>
            <input required class="form-control" id="artikelnaam" type="text" name="artikelnaam"
                   value="<?php echo $artikel->artikelnaam; ?>"/>
        </div>
        <div class="form-group ">
            <label class="control-label requiredField" for="hulpstuk"> Accessory </label>
            <select required class="select form-control" id="badgenr" name="hulpstuk">
                <option value="N" <?php echo ($artikel->hulpstuk == "N") ? "selected" : ""; ?>>Nee</option>
                <option value="J" <?php echo ($artikel->hulpstuk == "J") ? "selected" : ""; ?>>Ja</option>
            </select>
        </div>
        <div class="form-group ">
            <label class="control-label requiredField" for="minvoorraad"> Minimum </label>
            <input class="form-control" id="minvoorraad" type="text" name="minvoorraad"
                   value="<?php echo $artikel->minvoorraad; ?>"/>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="btn_submit">Save changes</button>
    </div>
</form>