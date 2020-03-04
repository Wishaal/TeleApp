<?php
require_once('../../../php/conf/config.php');
require_once('../php/config.php');
include "../domain/Fabrikant.php";
$fabrikant = Fabrikant::find($_GET['id']);
?>
<form action="apps/<?php echo app_name; ?>/fabrikant.php?action=<?php echo $_GET['action']; ?>&recordId=<?php echo $_GET['id']; ?>"
      method="post" name="inputform" id="inputform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?php echo ucfirst($_GET['action']); ?> Manufacturer</h4>
    </div>
    <div class="modal-body">
        <div class="form-group ">
            <label class="control-label requiredField" for="name">
                Name <span class="asteriskField" style="color: red;"> * </span>
            </label>
            <input required class="form-control" id="name" type="text" name="name"
                   value="<?php echo $fabrikant->name; ?>"/>
        </div>
        <div class="form-group ">
            <label class="control-label requiredField" for="contact">
                Contact
            </label>
            <input class="form-control" id="contact" type="text" name="contact"
                   value="<?php echo $fabrikant->contact; ?>"/>
        </div>
        <div class="form-group ">
            <label class="control-label requiredField" for="phone">
                Phone
            </label>
            <input class="form-control" id="phone" type="text" name="phone" value="<?php echo $fabrikant->phone; ?>"/>
        </div>
        <div class="form-group ">
            <label class="control-label requiredField" for="email">
                Email
            </label>
            <input class="form-control" id="email" type="text" name="email" value="<?php echo $fabrikant->email; ?>"/>
        </div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="btn_submit">Save changes</button>
    </div>
</form>