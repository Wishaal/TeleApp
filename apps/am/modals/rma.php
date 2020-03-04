<?php
require_once('../../../php/conf/config.php');
require_once('../php/config.php');

include "../domain/Rma.php";
$rma = Rma::find($_GET['id']);

include "../domain/Fabrikant.php";
include "../domain/Rmadetail.php";
include "../domain/Rmafile.php";
include "../domain/Site.php";
include "../domain/Statustype.php";

$fabrikantrecord = Fabrikant::all(array('fabrikantid', 'name', 'contact'));
$rmadetailrecord = Rmadetail::where('rmavolgnr', '=', $_GET['id'])->get();
$rmafilerecord = Rmafile::where('rmavolgnr', '=', $_GET['id'])->get();
$siterecord = Site::all(array('locid', 'locname', 'adres'));
$statustyperecord = Statustype::whereBetween('statusnr', array(200, 201))->get();

if ($_GET['action'] == 'new') {
} else {
    $fabrecord = Fabrikant::where('fabrikantid', '=', $rma->fabrikantid)->get();
    $sitrecord = Site::where('locid', '=', $rma->siteid)->get();
}

?>
<form action="apps/<?php echo app_name; ?>/rma.php?action=<?php echo $_GET['action']; ?>&recordId=<?php echo $_GET['id']; ?>"
      method="post" name="inputform" id="inputform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?php if ($_GET['action'] == 'new') {
                echo 'Send';
            } else {
                echo 'Received';
            } ?> RMA</h4>
    </div>
    <div class="modal-body">
        <?php
        if ($_GET['action'] == 'new') {
            ?>
            <input class="form-control" id="created_user" type="hidden" name="created_user"
                   value="<?php echo $_SESSION[mis][user][username]; ?>"/>
            <input class="form-control" id="rmavolgnr" type="hidden" name="rmavolgnr" value="0"/>
            <?php
        } else {
            ?> <input class="form-control" id="updated_user" type="hidden" name="updated_user"
                      value="<?php echo $_SESSION[mis][user][username]; ?>"/>
            <input class="form-control" id="rmavolgnr" type="hidden" name="rmavolgnr"
                   value="<?php echo $rma->rmavolgnr; ?>"/>
            <?php
        }
        ?>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group ">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label requiredField" for="rmanr"> Repairnr <span class="asteriskField"
                                                                                                   style="color: red;"> * </span></label>
                            <?php if ($_GET['action'] == 'new') { ?>
                                <input required class="form-control" id="rmanr" type="text" name="rmanr"
                                       value="<?php echo $rma->rmanr; ?>"/>
                            <?php } else { ?>
                                <input disabled class="form-control" type="text" value="<?php echo $rma->rmanr; ?>"/>
                                <input id="rmanr" type="hidden" name="rmanr" value="<?php echo $rma->rmanr; ?>"/>
                            <?php } ?>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label requiredField" for="reqdatum"> Requestdate <span
                                        class="asteriskField" style="color: red;"> * </span></label>
                            <?php if ($_GET['action'] == 'new') { ?>
                                <input required class="form-control" id="reqdatum" type="text" name="reqdatum"
                                       value="<?php echo ($_GET['action'] == 'new') ? date('Y-m-d') : (($rma->reqdatum == '0000-00-00') ? '' : $rma->reqdatum); ?>"
                                       data-date='' data-date-format="YYYY-MM-DD" data-link-format="yyyy-mm-dd"
                                       data-link-field="reqdatum" autocomplete="off"/>
                            <?php } else { ?>
                                <input disabled class="form-control" type="text" value="<?php echo $rma->reqdatum; ?>"/>
                                <input id="reqdatum" type="hidden" name="reqdatum"
                                       value="<?php echo $rma->reqdatum; ?>"/>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="form-group ">
                    <label class="control-label requiredField" for="fabrikantid"> Vendorname <span class="asteriskField"
                                                                                                   style="color: red;"> * </span></label>
                    <div>
                        <?php if ($_GET['action'] == 'new') { ?>
                            <select required class="select form-control" id="fabrikantid" name="fabrikantid">
                                <option></option>
                                <?php
                                foreach ($fabrikantrecord as $r) {
                                    if ($r->fabrikantid == $rma->fabrikantid) {
                                        $sel = 'selected=selected';
                                    } else {
                                        $sel = '';
                                    }
                                    echo '<option ' . $sel . ' value=' . $r->fabrikantid . '>' . $r->name . " - " . $r->contact . '</option>';
                                }
                                ?>
                            </select>
                        <?php } else { ?>
                            <input disabled class="form-control" type="text"
                                   value="<?php echo $fabrecord[0]->name . " - " . $fabrecord[0]->contact; ?>"/>
                            <input id="fabrikantid" type="hidden" name="fabrikantid"
                                   value="<?php echo $rma->fabrikantid; ?>"/>
                        <?php } ?>
                    </div>
                </div>
                <div class="form-group ">
                    <label class="control-label" for="partnr"> Part-nr <span class="asteriskField" style="color: red;"> * </span>
                    </label>
                    <div>
                        <input required class="form-control" id="partnr" type="text" name="partnr"
                               value="<?php echo $rma->partnr; ?>"/>
                    </div>
                </div>
                <div class="form-group ">
                    <label class="control-label" for="productname"> Productname <span class="asteriskField"
                                                                                      style="color: red;"> * </span>
                    </label>
                    <div>
                        <input required class="form-control" id="productname" type="text" name="productname"
                               value="<?php echo $rma->productname; ?>"/>
                    </div>
                </div>
                <div class="form-group ">
                    <label class="control-label" for="swnr"> Software release </label>
                    <div>
                        <input class="form-control" id="swnr" type="text" name="swnr"
                               value="<?php echo $rma->swnr; ?>"/>
                    </div>
                </div>
                <div class="form-group ">
                    <label class="control-label" for="siteid"> Site Identity <span class="asteriskField"
                                                                                   style="color: red;"> * </span>
                    </label>
                    <div>
                        <?php if ($_GET['action'] == 'new') { ?>
                            <select required class="select form-control" id="siteid" name="siteid">
                                <option></option>
                                <?php
                                foreach ($siterecord as $r) {
                                    if ($r->locid == $rma->siteid) {
                                        $sel = 'selected=selected';
                                    } else {
                                        $sel = '';
                                    }
                                    echo '<option ' . $sel . ' value=' . $r->locid . '>' . $r->locname . " - " . $r->adres . '</option>';
                                }
                                ?>
                            </select>
                        <?php } else { ?>
                            <input disabled class="form-control" type="text"
                                   value="<?php echo $sitrecord[0]->locname . " - " . $sitrecord[0]->adres; ?>"/>
                            <input id="siteid" type="hidden" name="siteid" value="<?php echo $rma->siteid; ?>"/>
                        <?php } ?>
                    </div>
                </div>
                <?php if ($_GET['action'] == 'new') { ?>
                    <input class="form-control" id="statusnr" type="hidden" name="statusnr"
                           value="<?php echo ($_GET['action'] == 'new') ? '200' : $rma->statusnr; ?>"/>
                <?php } else { ?>
                    <div class="form-group ">
                        <label class="control-label" for="statusnr"> RMA Status <span class="asteriskField"
                                                                                      style="color: red;"> * </span>
                        </label>
                        <div>
                            <select required class="select form-control" id="statusnr" name="statusnr">
                                <option></option>
                                <?php
                                foreach ($statustyperecord as $r) {
                                    if ($r->statusnr == $rma->statusnr) {
                                        $sel = 'selected=selected';
                                    } else {
                                        $sel = '';
                                    }
                                    echo '<option ' . $sel . ' value=' . $r->statusnr . '>' . $r->statusnaam . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="col-md-6">
                <!--
			<div class="form-group ">
				<label class="control-label" for="siteid"> Order Acknowledgement-nr <span class="asteriskField" style="color: red;"> * </span> </label>
				<div>
				<?php if ($_GET['action'] == 'new') { ?>
					<input required class="form-control" id="orderacknr" type="text" name="orderacknr" value="<?php echo $rma->orderacknr; ?>"/>
				<?php } else { ?>
					<input disabled class="form-control" type="text" value="<?php echo $rma->orderacknr; ?>"/>
					<input id="orderacknr" type="hidden" name="orderacknr" value="<?php echo $rma->orderacknr; ?>"/>
				<?php } ?>
				</div>
			</div>
			<div class="form-group ">
				<label class="control-label" for="siteid"> RP-nr <span class="asteriskField" style="color: red;"> * </span> </label>
				<div>
				<?php if ($_GET['action'] == 'new') { ?>
					<input required class="form-control" id="rpnr" type="text" name="rpnr" value="<?php echo $rma->rpnr; ?>"/>
				<?php } else { ?>
					<input disabled class="form-control" type="text" value="<?php echo $rma->rpnr; ?>"/>
					<input id="rpnr" type="hidden" name="rpnr" value="<?php echo $rma->rpnr; ?>"/>
				<?php } ?>
				</div>
			</div>
			<div class="form-group ">
				<label class="control-label" for="ernr"> ER-nr </label>
				<div>
					<input class="form-control" id="ernr" type="text" name="ernr" value="<?php echo $rma->ernr; ?>"/>
				</div>
			</div>
			-->
                <div class="form-group ">
                    <label class="control-label" for="garantie"> Warranty </label>
                    <div>
                        <?php if ($_GET['action'] == 'new') { ?>
                            <input class="form-control" id="garantie" type="text" name="garantie"
                                   value="<?php echo $rma->garantie; ?>"/>
                        <?php } else { ?>
                            <input disabled class="form-control" type="text" value="<?php echo $rma->garantie; ?>"/>
                            <input id="garantie" type="hidden" name="garantie" value="<?php echo $rma->garantie; ?>"/>
                        <?php } ?>
                    </div>
                </div>
                <div class="form-group ">
                    <label class="control-label" for="prijs"> Price </label>
                    <div>
                        <?php if ($_GET['action'] == 'new') { ?>
                            <input class="form-control" id="prijs" type="text" name="prijs"
                                   value="<?php echo(!empty($rma->prijs) ? $rma->prijs : '0'); ?>"/>
                        <?php } else { ?>
                            <input disabled class="form-control" type="text"
                                   value="<?php echo(!empty($rma->prijs) ? $rma->prijs : '0'); ?>"/>
                            <input id="prijs" type="hidden" name="prijs"
                                   value="<?php echo(!empty($rma->prijs) ? $rma->prijs : '0'); ?>"/>
                        <?php } ?>
                    </div>
                </div>
                <div class="form-group ">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label" for="shipdatum"> Ship date <span class="asteriskField"
                                                                                          style="color: red;"> * </span>
                            </label>
                            <?php if ($_GET['action'] == 'new') { ?>
                                <input required class="form-control" id="shipdatum" type="text" name="shipdatum"
                                       value="<?php echo ($rma->shipdatum == '0000-00-00') ? '' : $rma->shipdatum; ?>"
                                       data-date="" data-date-format="YYYY-MM-DD" data-link-format="yyyy-mm-dd"
                                       data-link-field="shipdatum" autocomplete="off"/>
                            <?php } else { ?>
                                <input disabled class="form-control" type="text"
                                       value="<?php echo $rma->shipdatum; ?>"/>
                                <input id="shipdatum" type="hidden" name="shipdatum"
                                       value="<?php echo $rma->shipdatum; ?>"/>
                            <?php } ?>
                        </div>
                        <div class="col-md-6">
                            <?php if ($_GET['action'] == 'new') { ?>
                            <?php } else { ?>
                                <label class="control-label" for="recdatum"> Received
                                    date <?php if ($_GET['action'] == 'new') {
                                        echo "";
                                    } else {
                                        echo '<span class="asteriskField" style="color: red;"> * </span>';
                                    } ?></label>
                                <input class="form-control" id="recdatum" type="text" name="recdatum"
                                       value="<?php echo ($rma->recdatum == '0000-00-00') ? '' : $rma->recdatum; ?>"
                                       data-date="" data-date-format="YYYY-MM-DD" data-link-format="yyyy-mm-dd"
                                       data-link-field="recdatum" autocomplete="off"
                                    <?php if ($_GET['action'] == 'new') {
                                        echo "disabled";
                                    } else {
                                        echo "required";
                                    } ?> />
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="form-group ">
                    <label class="control-label" for="awbnr"> AWB-nr </label>
                    <div>
                        <?php if ($_GET['action'] == 'new') { ?>
                            <input class="form-control" id="awbnr" type="text" name="awbnr"
                                   value="<?php echo $rma->awbnr; ?>"/>
                        <?php } else { ?>
                            <input disabled class="form-control" type="text" value="<?php echo $rma->awbnr; ?>"/>
                            <input id="awbnr" type="hidden" name="awbnr" value="<?php echo $rma->awbnr; ?>"/>
                        <?php } ?>
                    </div>
                </div>
                <?php if ($_GET['action'] == 'new') { ?>
                <?php } else { ?>
                    <div class="form-group ">
                        <label class="control-label" for="oronr"> Oro-nr <?php if ($_GET['action'] == 'new') {
                                echo "";
                            } else {
                                echo '<span class="asteriskField" style="color: red;"> * </span>';
                            } ?></label>
                        <div>
                            <input <?php if ($_GET['action'] == 'new') {
                                echo "disabled";
                            } else {
                                echo "required";
                            } ?> class="form-control" id="oronr" type="text" name="oronr"
                                 value="<?php echo $rma->oronr; ?>"/>
                        </div>
                    </div>
                <?php } ?>
                <div class="form-group ">
                    <label class="control-label" for="opmerking"> Remark </label>
                    <div>
                        <textarea class="form-control" id="opmerking" type="text"
                                  name="opmerking"><?php echo $rma->opmerking; ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label" for="serienr"> Serienr (Send<?php if ($_GET['action'] == 'new') {
                            echo "";
                        } else {
                            echo " / Received";
                        } ?>) </label>
                    <div class="input_fields_wrap">
                        <?php if ($_GET['action'] == 'new') { ?>
                            <div class="col-md-6"><input type="text" name="serienr[]">
                                <button type="button" class="btn btn-default add_field_button"><i
                                            class="fa fa-plus"></i></button>
                            </div>
                        <?php } else {
                            for ($idx = 0; $idx < count($rmadetailrecord); $idx++) {
                                if ($idx == 0) {
                                    ?>
                                    <div class="col-md-6"><input type="hidden" name="serienr[]"
                                                                 value="<?php echo $rmadetailrecord[$idx][serienr]; ?>"/><input
                                                disabled type="text"
                                                value="<?php echo $rmadetailrecord[$idx][serienr]; ?>"/> / <input
                                                type="text" name="reserienr[]"
                                                value="<?php echo $rmadetailrecord[$idx][reserienr]; ?>"/>
                                        <button type="button" class="btn btn-default add_field_button"><i
                                                    class="fa fa-plus"></i></button>
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <div class="col-md-6"><input type="hidden" name="serienr[]"
                                                                 value="<?php echo $rmadetailrecord[$idx][serienr]; ?>"/><input
                                                disabled type="text"
                                                value="<?php echo $rmadetailrecord[$idx][serienr]; ?>"/> / <input
                                                type="text" name="reserienr[]"
                                                value="<?php echo $rmadetailrecord[$idx][reserienr]; ?>"/><a href="#"
                                                                                                             class="remove_field">
                                            <button type="button" class="btn btn-default removeButton"><i
                                                        class="fa fa-minus"></i></button>
                                        </a></div>
                                    <?php
                                }
                            }
                        } ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="btn_submit">Save changes</button>
    </div>
</form>

<script>
    $('#reqdatum').datetimepicker({
        pickTime: false,
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
    $('#shipdatum').datetimepicker({
        pickTime: false,
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
    $('#recdatum').datetimepicker({
        pickTime: false,
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });

    var max_fields = 20; //maximum input boxes allowed
    var wrapper = $(".input_fields_wrap"); //Fields wrapper
    var add_button = $(".add_field_button"); //Add button ID

    var x = 1; //initlal text box count
    $(add_button).click(function (e) { //on add input button click
        e.preventDefault();
        if (x < max_fields) { //max input box allowed
            x++; //text box increment
            <?php if ($_GET['action'] == 'new') { ?>
            $(wrapper).append('<div class="col-md-6"><input type="text" name="serienr[]"/><a href="#" class="remove_field"><button type="button" class="btn btn-default removeButton"><i class="fa fa-minus"></i></button></a></div>'); //add input box
            <?php } else { ?>
            $(wrapper).append('<div class="col-md-6"><input disabled type="text" name="serienr[]"/> / <input type="text" name="reserienr[]"/><a href="#" class="remove_field"><button type="button" class="btn btn-default removeButton"><i class="fa fa-minus"></i></button></a></div>'); //add input box
            <?php } ?>
        }
    });

    $(wrapper).on("click", ".remove_field", function (e) { //user click on remove text
        e.preventDefault();
        $(this).parent('div').remove();
        x--;
    })
</script>