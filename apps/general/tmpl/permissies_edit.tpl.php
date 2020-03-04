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
                        <small>Permissies</small>
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
									<h3 class="box-title">Opvragen</h3>
								</div>
								<!-- /.box-header -->
								<div class="box-body">
									<form class="form-horizontal" id="menus" name="permissionsform" action="apps/general/permissies.php?action=edit&amp;id=<?php echo $_GET['id']; ?>" method="post">
										<div class="form-group">
											<label for="nummer" class="col-sm-1 control-label">Menu</label>
											<div class="col-sm-6">
												<select class="form-control" name='menuid' id="menuid" onchange='this.form.submit()'>
													<?php
													foreach($menus as $group1){
														echo '<option ' . ( $group1['id'] == $_POST['menuid'] ? 'selected="selected"' : '' ) . ' value=' . $group1['id'] . '>' . $group1['title'] . '</option>';
													}
													?>
												</select>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
			<?php if($_SERVER['REQUEST_METHOD'] == 'POST'){ ?>
					<div class="row">
                        <div class="col-xs-12">
			<form id="permissionsform" name="permissionsform" action="apps/general/permissies.php?action=edit&amp;id=<?php echo $_GET['id']; ?>" method="post" style="padding: 0"/>
                    <button class="btn btn-success" type="submit">Submit</button>
                     <a class="btn btn-danger" href="apps/general/permissies.php">Cancel</a>
                    <br /><br />
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Permissies Edit</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                        
						<?php
							$menudata = array();
							foreach($menuitemdata as $key => $item){
								$menudata[$item['id']] = $item;
							}
							
							//proces 1 adds all items to its parents
							foreach($menuitemdata as $key => $item){
								if($item['parent'] != 0){
									$menudata[$item['parent']]['sub'][] = $item;
									unset($data[$key]);		
								}
							}
							
							//proces 2 adds all parents to theirs parents
							foreach($menudata as $k => $item){
								if(is_array($item['sub'])){
									foreach($item['sub'] as $l => $i){
										$menudata[$k]['sub'][$l]['sub'] = $menudata[$i['id']]['sub'];	
										unset($menudata[$i['id']]);	
									}
								}
							}
						?>
                        			
						<table id="sample-table" class="table"> 
							<thead> 
								<tr> 
									<th>Id</th> 
									<th>Title</th> 
									<th>Select</th> 
                                    <th>Insert</th> 
                                    <th>Update</th> 
                                    <th>Delete</th>
                                    <th>Other</th>  
								</tr> 
							</thead> 
							<tbody> 
								<?php
									foreach($menudata as $item){
										
										if($item['title']){
										echo '<tr> 
												<td>' . $item['id'] . '<input type="hidden" name="permission[' . $item['id'] . '][check]" id="menuitem_' . $item['id'] . '" value="1"/></td> 
												<td>' . $item['title'] . '</td> 
												<td><input type="checkbox" ' . ( getPermission($permissiondata, $_GET['id'], $item['id'], 'select') ? 'checked="checked"' : '' ) . ' value="1" name="permission[' . $item['id'] . '][select]" id="select_' . $item['id'] . '"/></td>
												<td><input type="checkbox" ' . ( getPermission($permissiondata, $_GET['id'], $item['id'], 'insert') ? 'checked="checked"' : '' ) . ' value="1" name="permission[' . $item['id'] . '][insert]" id="insert_' . $item['id'] . '"/></td>
												<td><input type="checkbox" ' . ( getPermission($permissiondata, $_GET['id'], $item['id'], 'update') ? 'checked="checked"' : '' ) . ' value="1" name="permission[' . $item['id'] . '][update]" id="update_' . $item['id'] . '"/></td>
												<td><input type="checkbox" ' . ( getPermission($permissiondata, $_GET['id'], $item['id'], 'delete') ? 'checked="checked"' : '' ) . ' value="1" name="permission[' . $item['id'] . '][delete]" id="delete_' . $item['id'] . '"/></td>
												<td><input type="checkbox" ' . ( getPermission($permissiondata, $_GET['id'], $item['id'], 'other') ? 'checked="checked"' : '' ) . ' value="1" name="permission[' . $item['id'] . '][other]" id="other_' . $item['id'] . '"/></td>
											</tr>';
										}
										
										if(is_array($item['sub'])){
											foreach($item['sub'] as $item2){
												if($item2['title']){
													echo '<tr> 
														<td>' . $item2['id'] . '<input type="hidden" name="permission[' . $item2['id'] . '][check]" id="menuitem_' . $item2['id'] . '" value="1"/></td>
														<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $item2['title'] . '</td> 
														<td><input type="checkbox" ' . ( getPermission($permissiondata, $_GET['id'], $item2['id'], 'select') ? 'checked="checked"' : '' ) . ' value="1" name="permission[' . $item2['id'] . '][select]" id="select_' . $item2['id'] . '"/></td>
														<td><input type="checkbox" ' . ( getPermission($permissiondata, $_GET['id'], $item2['id'], 'insert') ? 'checked="checked"' : '' ) . ' value="1" name="permission[' . $item2['id'] . '][insert]" id="insert_' . $item2['id'] . '"/></td>
														<td><input type="checkbox" ' . ( getPermission($permissiondata, $_GET['id'], $item2['id'], 'update') ? 'checked="checked"' : '' ) . ' value="1" name="permission[' . $item2['id'] . '][update]" id="update_' . $item2['id'] . '"/></td>
														<td><input type="checkbox" ' . ( getPermission($permissiondata, $_GET['id'], $item2['id'], 'delete') ? 'checked="checked"' : '' ) . ' value="1" name="permission[' . $item2['id'] . '][delete]" id="delete_' . $item2['id'] . '"/></td>
														<td><input type="checkbox" ' . ( getPermission($permissiondata, $_GET['id'], $item2['id'], 'other') ? 'checked="checked"' : '' ) . ' value="1" name="permission[' . $item2['id'] . '][other]" id="other_' . $item2['id'] . '"/></td>
													</tr>';
												}
											
												if(is_array($item2['sub'])){
													foreach($item2['sub'] as $item3){
														if($item3['title']){
															echo '<tr> 
															<td>' . $item3['id'] . '<input type="hidden" name="permission[' . $item3['id'] . '][check]" id="menuitem_' . $item3['id'] . '" value="1"/></td>
															<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $item3['title'] . '</td> 
															<td><input type="checkbox" ' . ( getPermission($permissiondata, $_GET['id'], $item3['id'], 'select') ? 'checked="checked"' : '' ) . ' value="1" name="permission[' . $item3['id'] . '][select]" id="select_' . $item3['id'] . '"/></td>
															<td><input type="checkbox" ' . ( getPermission($permissiondata, $_GET['id'], $item3['id'], 'insert') ? 'checked="checked"' : '' ) . ' value="1" name="permission[' . $item3['id'] . '][insert]" id="insert_' . $item3['id'] . '"/></td>
															<td><input type="checkbox" ' . ( getPermission($permissiondata, $_GET['id'], $item3['id'], 'update') ? 'checked="checked"' : '' ) . ' value="1" name="permission[' . $item3['id'] . '][update]" id="update_' . $item3['id'] . '"/></td>
															<td><input type="checkbox" ' . ( getPermission($permissiondata, $_GET['id'], $item3['id'], 'delete') ? 'checked="checked"' : '' ) . ' value="1" name="permission[' . $item3['id'] . '][delete]" id="delete_' . $item3['id'] . '"/></td>
															<td><input type="checkbox" ' . ( getPermission($permissiondata, $_GET['id'], $item3['id'], 'other') ? 'checked="checked"' : '' ) . ' value="1" name="permission[' . $item3['id'] . '][other]" id="other_' . $item3['id'] . '"/></td>
														</tr>';
														}
													}
												}
											}
										}
										
									}
								?> 
							</tbody> 
						</table> 

						</form>

					</div><!-- /.box-body -->
                            </div><!-- /.box -->
	<?php } ?>
						</section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

<?php // require_once(TEMPLATE_PATH . 'footer.php'); ?>