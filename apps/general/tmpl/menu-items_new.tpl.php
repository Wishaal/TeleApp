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
                        <small>New Menu Item</small>
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
                                    <h3 class="box-title">Menu's</h3>
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
                        <form action="apps/general/menu-items.php?action=new&amp;id=<?php echo $_GET['id']; ?>" method="post">
                        	
                            <div class="form-group">
								<label for="title">Title</label>
								<input type="text" id="title" class="form-control" name="title" value="">
							</div>
                            
                            <div class="form-group">
								<label for="link">Link</label>
								<input type="text" id="link" class="form-control" name="link" value="">
							</div>
                            
                            <div class="form-group">
								<label for="parent">Parent</label>
								<div>
                                    <select class="form-control" id="parent" name="parent">
                                        <option value="0">Root</option>
                                        <?php
											foreach($menudata as $item){
												
												if($item['title']){
												echo '<option value="' . $item['id'] . '">----' . $item['title'] . '</option>';
												}
												
												if(is_array($item['sub'])){
													foreach($item['sub'] as $item2){
														if($item2['title']){
															echo '<option value="' . $item2['id'] . '">--------' . $item2['title'] . '</option>';
														}
													}
												}
												
											}
										?>
                                    </select>
                                </div>
							</div>
                            
                            <div class="form-group">
								<label for="active">Active</label>
								<input type="checkbox" name="active" class="form-control" id="active" class="checkbox" value="1">  
							</div>
                            
                            <div class="form-group">
								<label>&nbsp;</label>
								<button class="btn btn-success" type="submit">Submit</button>
								 <a class="btn btn-danger" href="apps/general/menu-items.php">Cancel</a>
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