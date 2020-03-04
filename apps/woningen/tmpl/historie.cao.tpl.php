<?php require_once(TEMPLATE_PATH . 'head.php'); ?>
 
<?php require_once(TEMPLATE_PATH . 'header_wrapper.php'); ?>
 <div class="wrapper row-offcanvas row-offcanvas-left">

<?php require_once(TEMPLATE_PATH . 'sidebar.php'); ?>

		<!-- Right side column. Contains the navbar and content of the page -->
		<aside class="right-side">
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<h1>
					Woningen-Verhuuradministratie
					<small> Historie</small>
				</h1>
					<?php require_once(TEMPLATE_PATH . 'breadcrumb.tpl.php'); ?>
			</section>
			<!-- Main content -->
			<section class="content">
				<div class="row">
					<div class="col-md-12">
										<table id="example1" class="table table-bordered table-striped dataTable">
											<thead>
											<tr>
												<th>Start</th>
												<th>Eind</th>
												<th>Locatie</th>
												<th>Wie?</th>
												<th>Status</th>
											</tr>
											</thead>
											<tbody>
											<?php
											foreach($historie as $item){
												$date = new DateTime($item['start']);
												$date2 = new DateTime($item['end']);
												$datum1 =  $date->format('Y-M-d H:i');
												$datum2 =  $date2->format('Y-M-d H:i');
												echo '<tr>
											<td>' . $datum1 . '</td>
											<td>' . $datum2 . '</td>
											<td>' . $item['title'] . '</td>
											<td>' . getEmployee($db,$item['badgenr']) . '</td>
											<td>' . $item['description'] . '</td>
										</tr>';

											}
											?>
											</tbody>
										</table>
					</div>
					<!-- /.col -->
					<!-- /.col -->
				</div>
			</section><!-- /.content -->
		</aside><!-- /.right-side -->
	</div><!-- ./wrapper -->
	<!-- Update content of remote modal, this code removes all cached data-->

<?php require_once(TEMPLATE_PATH . 'footer.php'); ?>