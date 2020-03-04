<?php
require_once('../../../../php/conf/config.php');
require_once('../../php/database.php');
require_once('../../php/functions.php');

include "../../../../domain/procurementBuitenInkoop/Bestelling.php";
include "../../../../domain/procurementBuitenInkoop/User.php";
include "../../../../domain/procurementBuitenInkoop/UserRole.php";
include "../../../../domain/procurementBuitenInkoop/Role.php";
include "../../../../domain/procurementBuitenInkoop/Authorisatie.php";

$bestelling = Bestelling::find($_GET['id']);
$authorisatie = Authorisatie::all(array('id', 'authorisatienr', 'Onderwerp', 'Projectcode'));
?>
<form disabled class="form-horizontal">
    <div disabled class="modal-header">
        <button type="button" disabled class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 disabled class="modal-title">Bestelling</h4>
    </div>
    <div disabled class="modal-body">
        <!-- start basic details like request date and user info-->
        <div disabled class="row">
            <div disabled class="col-md-6">
                <div disabled class="form-group">
                    <label disabled class="col-sm-3 control-label" for="naam">Aanvraag datum</label>
                    <div disabled class="col-sm-9">
                        <input type="text" id="bstl_aanvraag_datum" name="bstl_aanvraag_datum" disabled
                               class="form-control"
                               value="<?php echo (!empty($bestelling->bstl_aanvraag_datum)) ? $bestelling->bstl_aanvraag_datum : date("Y-m-d"); ?>">
                    </div>
                </div>
                <div disabled class="form-group">
                    <label disabled class="col-sm-3 control-label" for="naam">Afdeling</label>
                    <div disabled class="col-sm-9">
                        <input type="text" id="bstl_afdeling" name="bstl_afdeling" disabled class="form-control"
                               value="<?php echo (!empty($bestelling->bstl_afdeling)) ? $bestelling->bstl_afdeling : getAppUserAfdeling(); ?>">
                    </div>
                </div>
                <div disabled class="form-group">
                    <label disabled class="col-sm-3 control-label" for="naam">Contactpersoon</label>
                    <div disabled class="col-sm-9">
                        <input type="text" id="bstl_contactpersoon" name="bstl_contactpersoon" disabled
                               class="form-control" value="<?php echo $bestelling->bstl_contactpersoon; ?>">
                    </div>
                </div>
            </div>
            <div disabled class="col-md-6">
                <div disabled class="form-group">
                    <label disabled class="col-sm-3 control-label" for="naam">Auth #</label>
                    <div disabled class="col-sm-9">
                        <select disabled class="select form-control" id="authorisatie_id" name="authorisatie_id">
                            <option>Geen</option>
                            <?php
                            foreach ($authorisatie as $r) {
                                if ($r->id == $bestelling->authorisatie_id) {
                                    $sel = 'selected=selected';
                                } else {
                                    $sel = '';
                                }
                                echo '<option ' . $sel . ' value=' . $r->id . '>' . $r->authorisatienr . ' | Projectcode: ' . $r->Projectcode . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div disabled class="form-group">
                    <label disabled class="col-sm-3 control-label" for="naam">Ingevoerd door</label>
                    <div disabled class="col-sm-9">
                        <input type="text" id="bstl_ingevoerd_door" name="bstl_ingevoerd_door" disabled
                               class="form-control"
                               value="<?php echo (!empty($bestelling->bstl_ingevoerd_door)) ? $bestelling->bstl_ingevoerd_door : $_SESSION['mis']['user']['badgenr']; ?>">
                    </div>
                </div>
                <div disabled class="form-group">
                    <label disabled class="col-sm-3 control-label" for="naam">T.b.v</label>
                    <div disabled class="col-sm-9">
                        <input type="text" id="bstl_tbv" name="bstl_tbv" disabled class="form-control" value="IM">
                    </div>
                </div>
            </div>
        </div>
        <hr style="margin: 0 0 10px 0;border-style: solid;border-color: #2B8836;border-width: 1px 0 0 0;">
        <!---- end basic info --->
        <div disabled class="row">
            <div disabled class="col-md-6">
                <div disabled class="form-group">
                    <label disabled class="col-sm-3 control-label" for="naam">Artikelcode</label>
                    <div disabled class="col-sm-9">
                        <select disabled class="selectpicker form-control" data-live-search="true" id="bstl_artikelcode"
                                name="bstl_artikelcode">
                            <option>Loading...</option>
                        </select>
                    </div>
                </div>
                <div disabled class="form-group">
                    <label disabled class="col-sm-3 control-label" for="naam">Omschrijving</label>
                    <div disabled class="col-sm-9">
                        <textarea id="bstl_omschrijving" name="bstl_omschrijving" disabled
                                  class="form-control"><?php echo $bestelling->bstl_omschrijving; ?></textarea>
                    </div>
                </div>
                <div disabled class="form-group">
                    <label disabled class="col-sm-3 control-label" for="naam">Te bestellen</label>
                    <div disabled class="col-sm-9">
                        <input type="text" id="bstl_te_bestellen" name="bstl_te_bestellen" disabled class="form-control"
                               value="<?php echo $bestelling->bstl_te_bestellen; ?>">
                    </div>
                </div>
                <div disabled class="form-group">
                    <label disabled class="col-sm-3 control-label" for="naam">Eenheid</label>
                    <div disabled class="col-sm-9">
                        <input type="text" id="bstl_eenheid" name="bstl_eenheid" disabled class="form-control"
                               value="<?php echo $bestelling->bstl_eenheid; ?>">
                    </div>
                </div>
                <div disabled class="form-group">
                    <label disabled class="col-sm-3 control-label" for="naam">Huidig voorraad</label>
                    <div disabled class="col-sm-9">
                        <input type="text" id="bstl_huidig_voorraad" name="bstl_huidig_voorraad" disabled
                               class="form-control" value="<?php echo $bestelling->bstl_huidig_voorraad; ?>">
                    </div>
                </div>
            </div>
            <div disabled class="col-md-6">
                <div disabled class="form-group">
                    <label disabled class="col-sm-3 control-label" for="naam">Verbruik voorgaand jr</label>
                    <div disabled class="col-sm-9">
                        <input type="text" id="bstl_verbruik_voorgaand_jr" name="bstl_verbruik_voorgaand_jr" disabled
                               class="form-control" value="<?php echo $bestelling->bstl_verbruik_voorgaand_jr; ?>">
                    </div>
                </div>
                <div disabled class="form-group">
                    <label disabled class="col-sm-3 control-label" for="naam">Opmerkingen</label>
                    <div disabled class="col-sm-9">
                        <textarea id="bstl_opmerkingen" name="bstl_opmerkingen" disabled
                                  class="form-control"><?php echo $bestelling->bstl_opmerkingen; ?></textarea>

                    </div>
                </div>
            </div>
        </div>
        <div disabled class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
</form>