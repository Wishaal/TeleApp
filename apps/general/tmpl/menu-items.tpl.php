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
                        <small>Menu's & App settings</small>
                    </h1>
                    	<?php require_once(TEMPLATE_PATH . 'breadcrumb.tpl.php'); ?>
                </section>

                <!-- Main content -->
                <section class="content">
						<!-- ## Panel Content  -->
						 <?php
                    	if(isset($_GET['msg']) && $_GET['msg'] == 'deleted'){
							echo '<div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <b>Alert!</b> Item deleted succesfully!</div>';	
						}
						
						if(isset($_GET['msg']) && $_GET['msg'] == 'saved'){
							echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <b>Alert!</b> Item added succesfully!</div>';	
						}
						
						if(isset($_GET['msg']) && $_GET['msg'] == 'updated'){
							echo '<div class="alert alert-info alert-dismissable">
                                        <i class="fa fa-info"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <b>Alert!</b> Item edited succesfully!</div>';	
						}
                    ?>
						<div class="row">                       
							<div class="col-xs-12">
								<a class="btn btn-default" href="apps/general/menu-items.php?action=new">
                                        <i class="fa fa-edit"></i> New
                                    </a>
									<p>
							</div>
						</div>
						<div class="row">
                        
						<div class="col-xs-12">
						
                            <div class="box">
                                
								<div class="box-header">
								   <h3 class="box-title">Menu's</h3>
                                   
								   <div class="box-tools">
                                        <div class="input-group">
                                            <input type="text" name="table_search" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive no-padding">
                                   
									<?php
							$menudata = array();
							foreach($data as $key => $item){
								$menudata[$item['id']] = $item;
							}
							
							//proces 1 adds all items to its parents
							foreach($data as $key => $item){
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
 <table class="table table-hover">
							<thead> 
								<tr> 
									<th>Id</th> 
									<th>Title</th> 
									<th>Link</th> 
									<th>Status</th> 
                                    <th>Actions</th> 
								</tr> 
							</thead> 
							<tbody> 
								<?php
									foreach($menudata as $item){
										
										if($item['title']){
										echo '<tr> 
												<td>' . $item['id'] . '</td> 
												<td>' . $item['title'] . '</td> 
												<td>' . $item['link'] . '</td> 
												<td>' . ($item['active'] == 1 ? 'Actief' : 'Niet actief') . '</td> 
												<td><div class="btn-group">
                                            <button type="button" class="btn btn-default">Action</button>
                                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="apps/general/menu-items.php?action=edit&amp;id=' . $item['id'] . '" class="icon edit">EDIT</a></li>
                                                <li><a href="apps/general/menu-items.php?action=delete&amp;id=' . $item['id'] . '" class="icon delete">DELETE</a></li>
                                            </ul>
                                        </div>
													
													
												</td>
											</tr>';
										}
										
										if(is_array($item['sub'])){
											foreach($item['sub'] as $item2){
												if($item2['title']){
													echo '<tr> 
														<td>' . $item2['id'] . '</td> 
														<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $item2['title'] . '</td> 
														<td>' . $item2['link'] . '</td> 
														<td>' . ($item2['active'] == 1 ? 'Actief' : 'Niet actief') . '</td> 
														<td>
															<div class="btn-group">
                                            <button type="button" class="btn btn-default">Action</button>
                                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="apps/general/menu-items.php?action=edit&amp;id=' . $item2['id'] . '" class="icon edit">EDIT</a></li>
                                                <li><a href="apps/general/menu-items.php?action=delete&amp;id=' . $item2['id'] . '" class="icon delete">DELETE</a></li>
                                            </ul>
                                        </div>
														</td>
													</tr>';
												}
											
												if(is_array($item2['sub'])){
													foreach($item2['sub'] as $item3){
														if($item3['title']){
															echo '<tr> 
															<td>' . $item3['id'] . '</td> 
															<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $item3['title'] . '</td> 
															<td>' . $item3['link'] . '</td> 
															<td>' . ($item3['active'] == 1 ? 'Actief' : 'Niet actief') . '</td> 
															<td>
																<div class="btn-group">
                                            <button type="button" class="btn btn-default">Action</button>
                                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="apps/general/menu-items.php?action=edit&amp;id=' . $item3['id'] . '" class="icon edit">EDIT</a></li>
                                                <li><a href="apps/general/menu-items.php?action=delete&amp;id=' . $item3['id'] . '" class="icon delete">DELETE</a></li>
                                            </ul>
                                        </div>
															</td>
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
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
					
						
						
					 </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
	
<?php require_once(TEMPLATE_PATH . 'footer.php'); ?>