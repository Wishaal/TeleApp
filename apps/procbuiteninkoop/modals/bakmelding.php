<?php
require_once('../../../php/conf/config.php');
require_once('../php/database.php');
require_once('../../../domain/procurementBuitenInkoop/User.php');
require('../../../domain/procurementBuitenInkoop/Bestelling.php');

if ($_GET['action'] == 'assign') {
    $aanvraag = Bestelling::find($_GET['aanvraag_id']);
    $werknemer = User::find($_GET['user_id']);
}


?>
<form class="form-horizontal"
      action="apps/<?php echo app_name; ?>/inbox.php?action=<?php echo $_GET['action']; ?>&type=<?php echo $_GET['type']; ?>&recordId=<?php echo $_GET['aanvraag_id']; ?>&userId=<?php echo $_GET['user_id']; ?>"
      method="post" name="inputform" id="inputform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Validatie</h4>
    </div>
    <div class="modal-body">
        <?php if ($_GET['action'] == 'assign') { ?>
            <p>Bent u zeker dat u <?php echo $werknemer->username; ?> wilt koppelen aan
                aanvraag <?php echo $aanvraag->aanvraag_nr; ?> ?</p>
        <?php } else { ?>
            <p>Bent u zeker dat u het onegdaan wilt maken?</p>
        <?php } ?>
        <p>Wil u doorgaan?</p>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Nee</button>
        <button type="submit" class="btn btn-danger" id="btn_submit">Ja, ik ben zeker!</button>
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

