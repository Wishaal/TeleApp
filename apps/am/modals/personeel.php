<?php
require_once('../../../php/conf/config.php');
require_once('../php/config.php');
include "../domain/Personeel.php";
$personeel = Personeel::find($_GET['id']);
?>
<form action="apps/<?php echo app_name; ?>/personeel.php?action=<?php echo $_GET['action']; ?>&recordId=<?php echo $_GET['id']; ?>"
      method="post" name="inputform" id="inputform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?php echo ucfirst($_GET['action']); ?> Personel</h4>
    </div>
    <div class="modal-body">
        <div class="form-group ">
            <label class="control-label requiredField" for="badgenr">
                Code <span class="asteriskField" style="color: red;"> * </span>
            </label>
            <input required class="form-control" id="badgenr" name="badgenr" placeholder="Code" type="text"
                   value="<?php echo $personeel->badgenr; ?>"/>
        </div>
        <div class="form-group ">
            <label class="control-label requiredField" for="naam">
                Naam <span class="asteriskField" style="color: red;"> * </span>
            </label>
            <input required class="form-control" id="naam" type="text" name="naam"
                   value="<?php echo $personeel->naam; ?>"/>
        </div>
        <div class="form-group ">
            <label class="control-label requiredField" for="voornaam">
                Voornaam <span class="asteriskField" style="color: red;"> * </span>
            </label>
            <input required class="form-control" id="voornaam" type="text" name="voornaam"
                   value="<?php echo $personeel->voornaam; ?>"/>
        </div>
        <div class="form-group ">
            <label class="control-label requiredField" for="afdelingcode">
                Afdeling <span class="asteriskField" style="color: red;"> * </span>
            </label>
            <input required class="form-control" id="afdelingcode" type="text" name="afdelingcode"
                   value="<?php echo $personeel->afdelingcode; ?>"/>
        </div>
        <div class="form-group ">
            <label class="control-label requiredField" for="emailadres">
                E-mail <span class="asteriskField" style="color: red;"> * </span>
            </label>
            <input required class="form-control" id="emailadres" type="text" name="emailadres"
                   value="<?php echo $personeel->emailadres; ?>"/>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="btn_submit">Save changes</button>
    </div>
</form>