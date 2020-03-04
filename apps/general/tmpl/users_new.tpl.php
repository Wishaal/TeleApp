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
                        <small>New User </small>
                    </h1>
                    	<?php require_once(TEMPLATE_PATH . 'breadcrumb.tpl.php'); ?>
                </section>

                <!-- Main content -->
                <section class="content">
						 <form  action="apps/general/users.php?action=new" onsubmit="return validateForm()" method="post">
						 <!-- ## Panel Content  -->
						<div class="row">
                        <div class="col-xs-12">
							<div class="row">   
							<div class="col-md-6">
                            <div class="box box-danger">
                                <div class="box-body">
                                        
										<div class="form-group">
											<label for="username">Username</label>
											<input type="text" class="form-control" required id="username" name="username" value="">
										</div>										
										<div class="form-group">
											<label for="email">Email</label>
											<input type="text" class="form-control" id="email" name="email" value="">
										</div>
										<div class="form-group">
											<label for="badge">Badge nr</label>
											<input type="text" class="form-control" id="badgenr" name="badgenr" value="">
										</div>
                                    <div class="form-group">
                                        <label for="afd">Afdeling</label>
                                        <select name="afd" id="afd" required class="form-control">
                                            <option value=''></option>
                                            <option value='Leeg'>Niet van toepassing</option>
                                            <?php
                                            foreach($afd as $group1){
                                                echo '<option value=' . $group1['afdeling'] . '>' . $group1['naam'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Active?</label>
                                        <input type="checkbox" name="active" id="active" class="checkbox" value="1">
                                    </div>
								</div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
						
						<div class="col-md-6">
                            <div class="box box-danger">
                                <div class="box-body">
									<div class="form-group">
										<label for="usergroup">Usergroup</label>
										<select name="usergroup[]" id="usergroup" required class="form-control" multiple="multiple" size="15">
										<?php
										foreach($usergroups as $group){
											echo '<option value=' . $group['id'] . '>' . $group['name'] . '</option>';
										}
										?>
										</select>
									</div>

                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
						</div> 
						<div class="form-group">
							<label>&nbsp;</label>
							<button class="btn btn-success" type="submit">Submit</button>
							 <a class="btn btn-danger" href="apps/general/users.php">Cancel</a>
						</div>
						
                    </div>
					</div><!-- ./wrapper -->
						</form>
						</section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div>
	
<?php require_once(TEMPLATE_PATH . 'footer.php'); ?>