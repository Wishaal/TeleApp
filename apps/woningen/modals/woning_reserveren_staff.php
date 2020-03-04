<?php
require_once('../../../php/conf/config.php');
require_once('../php/config.php');

$woningen = querySelectPDO($db, 'SELECT *
  FROM woningen a, woningSoort b,locaties c
  where a.ws_id=b.ws_id and a.loc_id=c.loc_id');

?>
<form class="form-horizontal" action="" method="POST" name="inputform" id="inputform">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
 <h4 class="modal-title">Woning reserveren</h4>
</div>
<div class="modal-body">
	<?php echo $message;?>
	<div class="form-group">
		<label class="col-sm-2 control-label"
			   for="naam">Periode*</label class="col-sm-2 control-label">

		<div class="col-sm-10">
            <input type="text" name="daterange" id ="daterange" data-date-format="yyyy-mm-dd" class="form-control" value="" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label"
			   for="Woning">Woning</label class="col-sm-2 control-label">

		<div class="col-sm-10">
			<select class="form-control" id="w_id" name="w_id" required="required">
				<?php
				foreach($woningen as $group){
					echo '<option value=' . $group['w_id'] . '>' . $group['loc_omschrijving'] . ' ' . $group['w_code'] . '</option>';
				}
				?>
			</select></div>
	</div>

</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
<button type="submit" class="btn btn-primary" id="btn_submit">Save changes</button>
</div>
</form>



<script type="text/javascript">
    $(function() {
        $('input[name="daterange"]').daterangepicker({
            "autoApply": true,
            "dateLimit": {
                "days": 2
            },
            "minDate": "<?php echo $sixMonthsBackDate = date("m/d/Y");?>",
            "maxDate": "<?php echo $sixMonthsBackDate = date("m/d/Y", strtotime("+3 months"));?>"
        });
    });
</script>

<script type="text/javascript">
	$('.selectpicker').selectpicker({
	});
</script>