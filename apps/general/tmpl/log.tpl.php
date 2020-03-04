<?php require_once(TEMPLATE_PATH . 'head.php'); ?>
<?php require_once(TEMPLATE_PATH . 'header_wrapper.php'); ?>
<div class="wrapper row-offcanvas row-offcanvas-left">
<?php require_once(TEMPLATE_PATH . 'sidebar.php'); ?>
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>SPEC  <small>ADSL</small></h1>
	<?php require_once(TEMPLATE_PATH . 'breadcrumb.tpl.php'); ?>
</section>

<!-- Main content -->
<section class="content">                
<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">User log</h3>
				</div><!-- /.box-header -->
				<div class="box-body">
                <form class="form-horizontal" action="" method="post" name="inputform" id="inputform" onSubmit="return validateForm()">     	                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="begindatum">Begindatum</label>
                        <div class="col-sm-10">
						<input type="text" id="begindatum" class="form-control" name="begindatum" required data-date="" data-date-format="YYYY-MM-DD" data-link-format="yyyy-mm-dd" data-link-field="begindatum" value="<?php if (isset($_POST['begindatum'])) { echo $_POST['begindatum'];} ?>" autocomplete="off" />
						</div>
					</div>
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="einddatum">Einddatum</label>
                        <div class="col-sm-10">
						<input type="text" id="einddatum" class="form-control" name="einddatum" required data-date="" data-date-format="YYYY-MM-DD" data-link-format="yyyy-mm-dd" data-link-field="einddatum" value="<?php if (isset($_POST['einddatum'])) { echo $_POST['einddatum'];} ?>" autocomplete="off" />
						</div>
					</div>
					<div class="form-group">
                        <label class="col-sm-2 control-label" for="einddatum">Aansluitnummer</label>
                        <div class="col-sm-10">
						<input type="text" id="aansluitnummer" name="aansluitnummer" class="form-control" value="<?php if (isset($_POST['aansluitnummer'])) { echo $_POST['aansluitnummer'];} ?>"/></div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="usergroup">Username</label>
						<div class="col-sm-10">
						<select name="username" id="username" class="form-control chosen-select">
						<option></option>>
						<?php
						foreach($users as $group){
							$sel = '';
							if($_POST['username'] == $group['id']){
								$sel = 'selected="selected"';
							}
							else {
								$sel = '';
							}
							echo '<option '.$sel.' value=' . $group['id'] . '>' . $group['username'] . '</option>';
						}
						?>
						</select>
						</div>
					</div>

					<?php if($_SERVER['REQUEST_METHOD'] == 'POST'){ ?>
					<div class="form-group">
                        <label class="col-sm-2 control-label" for=>Aantal records</label>
                        <div class="col-sm-10">
						<input type="text" readonly="readonly" class="form-control" value="<?php echo count($data) ?>"/>
						</div>
						</div>
                    				
                    <?php } ?>
                   <div class="form-group">
								  <label class="col-sm-2 control-label" for=></label>
								  <div class="col-sm-10">
								 <button class="btn btn-success" type="submit">Submit</button>
								 </div>
					</div>
                </div>	
                </form>              
                </div>
			</div>
		</div>
                <?php
				if(isset($data)){
					if(count($data)) {
						$end_result = '';
					?>						
<div class="row">      
	<div class="col-xs-12">
        <div class="btn-group ">
			<button type="button" class="btn btn-success">Export</button>
			<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
				<span class="caret"></span>
				<span class="sr-only">Toggle Dropdown</span>
			</button>
			<ul class="dropdown-menu" role="menu">
				<li><a href="apps/spec/export_excel/ee_log.php">to Excel</a></li>
				<li><a href="apps/spec/export_word/ee_log.php">to Word</a></li>
				<li><a href="apps/spec/export_pdf/ee_log.php">to PDF</a></li>
			</ul>
		</div>
		<div class="box">
        <div class="box-body table-responsive no-padding">	
						<table id="example1" class="table table-bordered table-striped"> 
						<thead> 
							<tr> 
								<th width="25">#</th>
								<th>User</th>
								<th>App</th>
								<th>Date/time</th>
								<th>Query details</th>
							</tr> 
						</thead> 
						<tbody>
						<?php	
						$count = 0;
						foreach($data as $r) {
							$count++;
							 echo '<tr> 
									 <td>' . $count . '</td>
									 <td>' . $r['username'] . '</td> 
									 <td>' . getFullAppnamePDO($mis_connPDO,$r['app']) . '</td>                               
									 <td>' . $r['created_at'] . '</td>                               
									 <td>' . $r['details'] . '</td>                               
								   </tr>';           
						}
						?>
						</tbody> 
						</table>
		</div>
		</div>
	</div>
</div><!-- /.box-body -->				
<?php		
					} else {
						echo '<span class="noresult">No results found</span>';
					}
				}
				
				?>			
								
                    
					 </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
<script type="text/javascript">
			$(function () {
				$('#begindatum').datetimepicker({
					pickTime: false,
					weekStart: 1,
					todayBtn:  1,
					autoclose: 1,
					todayHighlight: 1,
					startView: 2,
					minView: 2,
					forceParse: 0					
				});
				
				 $('#einddatum').datetimepicker({
					pickTime: false,
					weekStart: 1,
					todayBtn:  1,
					autoclose: 1,
					todayHighlight: 1,
					startView: 2,
					minView: 2,
					forceParse: 0					
				});
				
			});
		</script>	
<?php require_once(TEMPLATE_PATH . 'footer.php'); ?>