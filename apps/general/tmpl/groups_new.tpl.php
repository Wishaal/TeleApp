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
                        <small> Groups</small>
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
                                    <h3 class="box-title">New Group</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                        
                        <form action="apps/general/groups.php?action=new" method="post">
                            
                            <div class="form-group">
								<label for="description">Description</label>
								<input type="text" name="Desc" class="form-control" id="Desc">
							</div>
                             <!-- radio -->
                            <?php 
								define ('IMAGEPATH','../../assets/_layout/img/maps/');
								foreach(glob(IMAGEPATH.'*') as $filename){ ?>
								<label>
                                                    <input type="radio" name="iconradio" id="iconradio" value="<?php echo basename($filename); ?>" <?php echo ( basename($filename) == $data['Icon'] ? 'checked' : '' ) ?> >
                                                    <img src="../../assets/_layout/img/maps/<?php echo basename($filename); ?>" />
                                </label>
							<?php }
							?>
                            <div class="form-group">
								<label>&nbsp;</label>
								<button class="btn btn-success" type="submit">Submit</button>
								 <a class="button-white" href="apps/general/groups.php"><button class="btn btn-danger">Cancel</button></a>
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