<?php
require_once('../../../php/conf/config.php');
require_once('../php/config.php');

include "../domain/Filetype.php";
include "../domain/Fabrikant.php";

//error_reporting(E_ALL);
//ini_set("display_errors", 1);

$filetype = Filetypen::find($_GET['id']);
$fabrikantrecord = Fabrikant::all(array('fabrikantid', 'name', 'contact'));
?>
<form action="apps/<?php echo app_name; ?>/filetype.php?action=<?php echo $_GET['action']; ?>&recordId=<?php echo $_GET['id']; ?>"
      method="post" name="inputform" id="inputform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?php echo ucfirst($_GET['action']); ?> Filetype</h4>
    </div>
    <div class="modal-body">
        <?php
        if ($_GET['action'] == 'new') {
            ?> <input id="created_user" type="hidden" name="created_user"
                      value="<?php echo $_SESSION[mis][user][username]; ?>"/> <?php
        } else {
            ?> <input id="updated_user" type="hidden" name="updated_user"
                      value="<?php echo $_SESSION[mis][user][username]; ?>"/> <?php
        }
        ?>
        <div class="form-group ">
            <label class="control-label requiredField" for="typenaam">
                Naam <span class="asteriskField" style="color: red;"> * </span>
            </label>
            <input required class="form-control" id="typenaam" type="text" name="typenaam"
                   value="<?php echo $filetype->typenaam; ?>"/>
        </div>
        <div class="form-group ">
            <label class="control-label requiredField" for="soort">
                Type <span class="asteriskField" style="color: red;"> * </span>
            </label>
            <input required class="form-control" id="soort" type="text" name="soort"
                   value="<?php echo (empty($filetype->soort)) ? 'RMA' : $filetype->soort; ?>"/>
        </div>
        <div class="form-group ">
            <label class="control-label requiredField" for="fabrikantid"> Manufacturer </label>
            <div>
                <select multiple="multiple" class="select form-control" id="fabrikantid" name="fabrikantid[]" size="10">
                    <?php
                    $fabar = explode(",", $filetype->fabrikantids);
                    foreach ($fabrikantrecord as $r) {
                        if (in_array($r->fabrikantid, $fabar)) {
                            $sel = 'selected=selected';
                        } else {
                            $sel = '';
                        }
                        echo '<option ' . $sel . ' value=' . $r->fabrikantid . '>' . $r->name . " - " . $r->contact . '</option>';
                    }
                    ?>
                </select>
                <input id="fabrikantids" type="hidden" name="fabrikantids"/>
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="btn_submit">Save changes</button>
    </div>
</form>

<script>
    $('#fabrikantid').on('blur', function () {
        var selected = [];

        $(this).find('option:selected').each(function (i, e) {
            selected.push(e.value);
        });
        $('#fabrikantids').val(selected.join(','));
    });
</script>