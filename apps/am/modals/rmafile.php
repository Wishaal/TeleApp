<?php
require_once('../../../php/conf/config.php');
require_once('../php/config.php');
require_once('../php/functions.php');

include "../domain/Rmafile.php";
include "../domain/Rma.php";
include "../domain/Filetype.php";
include "../domain/Fabrikant.php";

$rmarecord = Rma::find($_GET['id']);
$filetyperecord = Filetypen::where('soort', '=', 'RMA')->get();
$fabrecord = Fabrikant::where('fabrikantid', '=', $rmarecord->fabrikantid)->get();
?>
<form enctype="multipart/form-data"
      action="apps/<?php echo app_name; ?>/rmafile.php?action=<?php echo $_GET['action']; ?>&parent=<?php echo $_GET['parent']; ?>&recordId=<?php echo $_GET['id']; ?>"
      method="post" name="inputform" id="inputform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?php echo ucfirst($_GET['action']); ?> RMA Files</h4>
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
            <label class="control-label requiredField"> Repairnr </label>
            <input disabled class="form-control" type="text" value="<?php echo $rmarecord->rmanr; ?>"/>
            <input required class="form-control" id="rmavolgnr" type="hidden" name="rmavolgnr"
                   value="<?php echo $rmarecord->rmavolgnr; ?>"/>
            <input class="form-control" id="filenaam" type="hidden" name="filenaam"/>
            <input class="form-control" id="typenr" type="hidden" name="typenr"/>
        </div>
        <div class="form-group ">
            <label class="control-label requiredField"> Vendor </label>
            <input disabled class="form-control" type="text" value="<?php echo $fabrecord[0]->name; ?>"/>
        </div>
        <div class="col-sm-12 form-group">
            <div class="col-sm-3"><label class="control-label requiredField" for="serienr"> Type </label></div>
            <div class="col-sm-7"><label class="control-label requiredField" for="serienr"> File </label></div>
            <div class="col-sm-2"><label class="control-label requiredField" for="serienr"> </label></div>
        </div>
        <?php
        for ($idx = 0; $idx < count($filetyperecord); $idx++) {
            $rmafilerecord = Rmafile::where('rmavolgnr', '=', $_GET['id'])->where('typenr', '=', $filetyperecord[$idx]->typenr)->get();

            $fabsrec = explode(',', $filetyperecord[$idx]->fabrikantids);
            if (in_array($rmarecord->fabrikantid, $fabsrec)) {
                ?>
                <div class="col-sm-12 form-group">
                    <div class="col-sm-3">
                        <input id="multitypenr[]" type="hidden" name="multitypenr[]"
                               value="<?php echo $filetyperecord[$idx]->typenr; ?>"/>
                        <input id="multitypefile[]" type="hidden" name="multitypefile[]"
                               value="<?php echo $rmafilerecord[$idx]->filenaam; ?>"/>
                        <input class="form-control" disabled id="typenaam[]" type="text" name="typenaam[]"
                               value="<?php echo $filetyperecord[$idx]->typenaam; ?>"/>
                    </div>
                    <div class="col-sm-7"><input class="form-control" id="fileTmp[]" type="file" name="fileTmp[]"></div>
                    <div class="col-sm-2"><?php if (!empty($rmafilerecord[0]->filenaam)) { ?><a target="_blank"
                                                                                                href="apps/<?php echo app_name; ?>/documenten/rma/<?php echo $rmafilerecord[0]->filenaam; ?>">
                                Bekijk</a><?php } else {
                            echo "";
                        } ?></div>
                </div>
                <?php
            }
        }
        ?>
        <div class="col-sm-12 form-group "><br><br></div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="btn_submit">Save changes</button>
    </div>
</form>