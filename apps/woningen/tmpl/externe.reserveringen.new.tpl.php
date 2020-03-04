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
                        <small>Externe personen / Afdelingen</small>
                    </h1>
                    	<?php require_once(TEMPLATE_PATH . 'breadcrumb.tpl.php'); ?>
                </section>

                <!-- Main content -->
                <section class="content">
						<!-- ## Panel Content  -->
						<div class="row">
                        <div class="col-xs-12">
		                    <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">New</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                        
                        <form action="apps/woningen/externe.reserveringen.php?action=new" method="post">
                        	
                            <div class="form-group">
								<label for="name">Naam</label>
								<input type="text" id="name" class="form-control" name="name" value="">
							</div>
                            
                            <div class="form-group">
								<label for="description">Opmerking</label>
								<textarea name="description" class="form-control" id="description"></textarea>
							</div>
                            

                            <div class="form-group">
								<label>&nbsp;</label>
								<button class="btn btn-success" type="submit">Submit</button>
								  <a class="btn btn-danger" href="apps/woningen/externe.reserveringen.php">Cancel</a>
							</div>
                            
                            
                        </form>
                     </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
						</section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
	
<?php require_once(TEMPLATE_PATH . 'footer.php'); ?>