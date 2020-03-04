<?php
require_once('../../../php/conf/config.php');
require_once('../php/database.php');
include "../../../domain/procurementBuitenInkoop/shipper.php";
include "../../../domain/procurementBuitenInkoop/Landen.php";

$landen = Landen::all(array('id', 'nicename'));
$shipper = Shipper::find($_GET['id']);
?>
<form class="form-horizontal"
      action="apps/<?php echo app_name; ?>/shipper.php?action=<?php echo $_GET['action']; ?>&recordId=<?php echo $_GET['id']; ?>"
      method="post" name="inputform" id="inputform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?php echo ucfirst($_GET['action']); ?> Shipper</h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label class="col-sm-2 control-label" for="naam">Naam</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="naam" name="naam" value="<?php echo $shipper->naam; ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="naam">Methode</label>
            <div class="col-sm-10">
                <select class="form-control" id="methode" name="methode">
                    <option value="Sea" <?php echo $shipper->methode; ?> >Sea</option>
                    <option value="Air">Air</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="naam">Land</label>
            <div class="col-sm-10">
                <select class="select form-control" id="land" name="land">
                    <?php
                    foreach ($landen as $r) {
                        if ($r->id == $shipper->land) {
                            $sel = 'selected=selected';
                        } else {
                            $sel = '';
                        }
                        echo '<option ' . $sel . ' value=' . $r->id . '>' . $r->nicename . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="naam">Aanleveradres</label>
            <div class="col-sm-10">
                <textarea type="text" rows="3" class="form-control" id="adres"
                          name="adres"><?php echo $shipper->adres; ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="naam">Contactpersoon</label>
            <div class="col-sm-10">
                <input type="text" id="contact" name="contact" class="form-control"
                       value="<?php echo $shipper->contact; ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="naam">Openingsdagen en tijd</label>
            <div class="col-sm-10">
                <textarea type="text" rows="3" class="form-control" id="dagen"
                          name="dagen"><?php echo $shipper->dagen; ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="naam">Postsluiting en tijd</label>
            <div class="col-sm-10">
                <textarea type="text" rows="3" class="form-control" id="postsluiting"
                          name="postsluiting"><?php echo $shipper->postsluiting; ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="naam">Opmerkingen</label>
            <div class="col-sm-10">
                <textarea type="text" rows="3" class="form-control" id="opmerkingen"
                          name="opmerkingen"><?php echo $shipper->opmerkingen; ?></textarea>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="btn_submit">Save changes</button>
    </div>
</form>
