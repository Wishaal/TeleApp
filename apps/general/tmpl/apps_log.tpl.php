	<?php require_once(TEMPLATE_PATH . 'head.php'); ?>
	 
	<?php require_once(TEMPLATE_PATH . 'header_wrapper.php'); ?>
	 <div class="wrapper row-offcanvas row-offcanvas-left">

							<?php require_once(TEMPLATE_PATH . 'sidebar.php'); ?>
 

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        General
                        <small>User log</small>
                    </h1>
                    	<?php require_once(TEMPLATE_PATH . 'breadcrumb.tpl.php'); ?>
                </section>
 <script type="text/javascript" charset="utf-8">
            $(document).ready(function() {
          var oTable = $('#example').dataTable( {
				    "sDom": 'rt<"shadow"iflp><"clear">',
					"sPaginationType": "full_numbers",
					"iDisplayLength": 50,
				    "sScrollY": "400px",
                    "sScrollX": "100%",
					"bScrollCollapse": true,
                    "bProcessing": true,
                    "bServerSide": true,
                    "sAjaxSource": "apps/general/php/server_processing_apps.php",
                    "aoColumns": [
						null,
                        null,
						null,
                        null,
						null
                    ],
                  
                } );
			} );
			
        </script>
                <!-- Main content -->
                <section class="content">
						<!-- ## Panel Content  -->
						<div class="row">
                        <div class="col-xs-12">
		                    <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Users</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">           						
						<table id="example" class="table table-bordered table-striped dataTable"> 
							<thead> 
								<tr>
									<th>User ID</th>
									<th>Root App</th>
									<th>App</th>
									<th>Details</th>
									<th>Created At</th>
								</tr> 
							</thead> 
							<tbody> 
									<td class="dataTables_empty">Loading data from server</td>
							</tbody> 
						</table> 
                        </div>
                    </div>
						</section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
	
<?php require_once(TEMPLATE_PATH . 'footer.php'); ?>