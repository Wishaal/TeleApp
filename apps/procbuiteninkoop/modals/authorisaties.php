<?php
require_once('../../../php/conf/config.php');
require_once('../php/database.php');
include "../../../domain/procurementBuitenInkoop/Authorisatie.php";
include "../../../domain/procurementBuitenInkoop/Valuta.php";
include "../../../domain/procurementBuitenInkoop/Koers.php";
$koersen = Koers::all(array('id', 'koers', 'valuta'));
$valuta = Valuta::all(array('valutacode', 'valutanaam'));
$authorisatie = Authorisatie::find($_GET['id']);
?>
<form class="form-horizontal" enctype="multipart/form-data"
      action="apps/<?php echo app_name; ?>/authorisaties.php?action=<?php echo $_GET['action']; ?>&recordId=<?php echo $_GET['id']; ?>"
      method="post" name="inputform" id="inputform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?php echo ucfirst($_GET['action']); ?> Authorisatie</h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label class="col-sm-2 control-label" for="naam">Authorisatie #</label>
            <div class="col-sm-10">
                <input type="text" id="authorisatienr" name="authorisatienr" class="form-control"
                       value="<?php echo $authorisatie->authorisatienr; ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="naam">Onderwerp</label>
            <div class="col-sm-10">
                <input type="text" id="Onderwerp" name="Onderwerp" class="form-control"
                       value="<?php echo $authorisatie->Onderwerp; ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="Projectcode">Projectcode</label>
            <div class="col-sm-10">
                <input type="text" id="Projectcode" name="Projectcode" class="form-control"
                       value="<?php echo $authorisatie->Projectcode; ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="Projectcode">Grootboek reknr.</label>
            <div class="col-sm-10">
                <input type="text" id="grootboekreknr" name="grootboekreknr" class="form-control"
                       value="<?php echo $authorisatie->grootboekreknr; ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-sm-4 control-label" for="naam">Valuta</label>
                    <div class="col-sm-8">
                        <select class="form-control" id="valuta" name="valuta">
                            <?php
                            foreach ($valuta as $r) {
                                if ($r->valutacode == $authorisatie->valuta) {
                                    $sel = 'selected=selected';
                                } else {
                                    $sel = '';
                                }
                                echo '<option ' . $sel . ' value=' . $r->valutacode . '>' . $r->valutacode . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="naam">Bedrag</label>
                    <div class="col-sm-10">
                        <input type="text" id="bedrag" name="bedrag" class="form-control"
                               value="<?php echo $authorisatie->bedrag; ?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="Projectcode">Omschrijving</label>
            <div class="col-sm-10">
                <textarea id="omschrijving" name="omschrijving"
                          class="form-control"><?php echo $authorisatie->omschrijving; ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="naam">Authorisatie
                file <?php if (!empty($authorisatie->file)) { ?><a
                    href="apps/<?php echo app_name; ?>/documenten/authorisaties/<?php echo $authorisatie->file; ?>">
                        (download)</a><?php } ?></label>
            <div class="col-sm-10">
                <input id="authorisatiefileTmp" name="authorisatiefileTmp" type="file">
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
</script>

