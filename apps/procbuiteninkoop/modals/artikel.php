<?php
require_once('../../../php/conf/config.php');
require_once('../php/database.php');
include "../../../domain/procurementBuitenInkoop/Artikel.php";

$artikel = Artikel::find($_GET['id']);
?>
<form class="form-horizontal"
      action="apps/<?php echo app_name; ?>/artikel.php?action=<?php echo $_GET['action']; ?>&recordId=<?php echo $_GET['id']; ?>"
      method="post" name="inputform" id="inputform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?php echo ucfirst($_GET['action']); ?> Artikel</h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label class="col-sm-2 control-label" for="naam">Artikel</label>
            <div class="col-sm-10">
                <input type="text" readonly id="artikel" name="artikel" class="form-control"
                       value="<?php echo $artikel->artikel; ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="naam">Omschrijving</label>
            <div class="col-sm-10">
                <input type="text" readonly id="artikelomschrijving" name="artikelomschrijving" class="form-control"
                       value="<?php echo $artikel->artikelomschrijving; ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="naam">Eenheid</label>
            <div class="col-sm-10">
                <input type="text" readonly id="eenheid" name="eenheid" class="form-control"
                       value="<?php echo $artikel->eenheid; ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="begindatum">Geleverd</label>
            <div class="col-sm-10">
                <input type="text" id="geleverd" name="geleverd" class="form-control"
                       value="<?php echo $artikel->geleverd; ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="naam">Jaar</label>
            <div class="col-sm-10">
                <input type="text" readonly id="jaar" name="jaar" class="form-control"
                       value="<?php echo $artikel->jaar; ?>">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="btn_submit">Save changes</button>
    </div>
</form>
