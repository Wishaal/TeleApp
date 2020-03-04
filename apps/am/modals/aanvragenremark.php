<?php
require_once('../../../php/conf/config.php');
require_once('../php/config.php');

include "../domain/Aanvragen.php";
include "../domain/Afdeling.php";
include "../domain/Personeel.php";
include "../domain/Artikel.php";
include "../domain/Categorie.php";
include "../domain/Werkorder.php";

$aanvragen = Aanvragen::find($_GET['id']);

$categorierecord = Categorie::all(array('categorienr', 'categorienaam', 'afkcode'));
$artikelrecord = Artikel::all(array('artikelcode', 'artikelnaam'));
$afdelingrecord = Afdeling::all(array('afdelingcode', 'afdelingnaam'));
$personeelrecord = Personeel::all(array('badgenr', 'naam', 'voornaam', 'afdelingcode'));
$werkorder = Werkorder::where("aanvraagnr", "=", $_GET['id'])->orderBy('volgnr', 'asc')->get();

$legenda = array();
foreach ($categorierecord as $r) {
    $legenda[] = $r->afkcode . "=" . $r->categorienaam;
}
$legendatekst = implode(", ", $legenda);
?>
<form action="apps/<?php echo app_name; ?>/aanvragen.php?action=<?php echo $_GET['action']; ?>&recordId=<?php echo $_GET['id']; ?>"
      method="post" name="inputform" id="inputform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?php echo ucfirst($_GET['action']); ?> Request</h4>
    </div>
    <div class="modal-body">
        <?php
        ?> <input class="form-control" id="updated_user" type="hidden" name="updated_user"
                  value="<?php echo $_SESSION[mis][user][username]; ?>"/> <?php
        ?>
        <div class="row">
            <div class="form-group ">
                <label class="control-label requiredField" for="statusnr">
                    <?php echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $legendatekst; ?>
                </label>
            </div>

            <div class="col-md-6">
                <div class="form-group ">
                    <label class="control-label requiredField" for="aanvraagnr">
                        Requestnr <span class="asteriskField" style="color: red;"> * </span>
                    </label>
                    <input class="form-control" id="aanvraagnr" type="hidden" name="aanvraagnr"
                           value="<?php echo $aanvragen->aanvraagnr; ?>"/>
                    <input disabled class="form-control" type="text" value="<?php echo $aanvragen->aanvraagnr; ?>"/>
                    <input class="form-control" id="statusnr" type="hidden" name="statusnr"
                           value="<?php echo ($_GET['action'] == 'new') ? '102' : $aanvragen->statusnr; ?>"/>
                </div>
                <div class="form-group ">
                    <label class="control-label requiredField" for="aanvraagdatum">
                        Requestdate <span class="asteriskField" style="color: red;"> * </span>
                    </label>
                    <input class="form-control" id="aanvraagdatum" type="hidden" name="aanvraagdatum"
                           value="<?php echo $aanvragen->aanvraagdatum; ?>"/>
                    <input disabled class="form-control" type="text" value="<?php echo $aanvragen->aanvraagdatum; ?>"/>
                </div>
                <div class="form-group ">
                    <label class="control-label requiredField" for="badgenr">
                        Badgenr <span class="asteriskField" style="color: red;"> * </span>
                    </label>
                    <?php
                    $sel = '';
                    foreach ($personeelrecord as $r) {
                        if ($r->badgenr == $aanvragen->badgenr) {
                            $sel = $r->naam . ' ' . $r->voornaam . ' Afdeling: ' . $r->afdelingcode . ' - (' . $r->badgenr . ')';
                        }
                    }
                    ?>
                    <input class="form-control" id="badgenr" type="hidden" name="badgenr"
                           value="<?php echo $aanvragen->badgenr; ?>"/>
                    <input disabled class="form-control" type="text" value="<?php echo $sel; ?>"/>
                </div>
                <div class="form-group ">
                    <label class="control-label requiredField" for="afdelingcode">
                        Department <span class="asteriskField" style="color: red;"> * </span>
                    </label>
                    <?php
                    $sel = '';
                    foreach ($afdelingrecord as $r) {
                        if ($r->afdelingcode == $aanvragen->afdelingcode) {
                            $sel = $r->afdelingcode . " - " . $r->afdelingnaam;
                        }
                    }
                    ?>
                    <input class="form-control" id="afdelingcode" type="hidden" name="afdelingcode"
                           value="<?php echo $aanvragen->afdelingcode; ?>"/>
                    <input disabled class="form-control" type="text" value="<?php echo $sel; ?>"/>
                </div>
                <div class="form-group ">
                    <label class="control-label requiredField" for="artikelcode">
                        Articlecode <span class="asteriskField" style="color: red;"> * </span> <span
                                class="asteriskField" style="color: red;" id="voorraadaantal"></span>
                    </label>
                    <?php
                    $sel = '';
                    foreach ($artikelrecord as $r) {
                        if ($r->artikelcode == $aanvragen->artikelcode) {
                            $sel = $r->artikelcode . " - " . $r->artikelnaam;
                        }
                    }
                    ?>
                    <input class="form-control" id="artikelcode" type="hidden" name="artikelcode"
                           value="<?php echo $aanvragen->artikelcode; ?>"/>
                    <input disabled class="form-control" type="text" value="<?php echo $sel; ?>"/>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group ">
                    <label class="control-label requiredField" for="aantal">
                        Quantity <span class="asteriskField" style="color: red;"> * </span>
                    </label>
                    <input class="form-control" id="aantal" type="hidden" name="aantal"
                           value="<?php echo $aanvragen->aantal; ?>"/>
                    <input disabled class="form-control" type="text" value="<?php echo $aanvragen->aantal; ?>"/>
                    <input id="checkaantal" type="hidden" name="checkaantal"/>
                </div>
                <div class="form-group ">
                    <label class="control-label requiredField" for="opmerking">
                        Remark <span class="asteriskField" style="color: red;"> * </span>
                    </label>
                    <textarea required class="form-control" id="opmerking" type="text"
                              name="opmerking"><?php echo $aanvragen->opmerking; ?></textarea>
                </div>
                <div class="form-group ">
                    <label class="control-label requiredField" for="opmerking"> Workorder Remark </label>
                    <?php
                    foreach ($werkorder as $r) {
                        ?>
                        <br><span><?php echo $r->volgnr; ?>.</span><textarea class="form-control"
                                                                             id="woopmerking_<?php echo $r->volgnr; ?>"
                                                                             type="text"
                                                                             name="woopmerking_<?php echo $r->volgnr; ?>"><?php echo $r->opmerking; ?></textarea>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="btn_submit">Save changes</button>
    </div>
</form>