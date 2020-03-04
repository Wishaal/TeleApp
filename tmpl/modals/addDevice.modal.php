<form action="" method="POST" >
<!-- Filter Modal -->
<div class="modal fade add-modal" tabindex="-1" role="dialog" aria-labelledby="AddModal" aria-hidden="true">
	<div class="modal-dialog"> 
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Add New Device</h4>
			</div>
			<div class="modal-body">
				<p>Enter the details below to add a new device to your account.</p>
	
				<div class="form-group">
					<label for="DeviceSN">Device Serial Number: </label>
					<input type="text" name="query" id="query"  class="form-control" >
				</div>
				<div class="form-group">
					<label for="DeviceNum">Device IMEI: </label>
					<input type="text" name="num" id="num" class="form-control" >
				</div>
			</div>
			<div class="modal-footer">
				<input type="submit" class="btn btn-primary" value="Save" />
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
</form>