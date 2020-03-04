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
            <?php
            if (isset($_GET['msg']) && $_GET['msg'] == 'deleted') {
                echo '<div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <b>Alert!</b> Item deleted succesfully!</div>';
            }

            if (isset($_GET['msg']) && $_GET['msg'] == 'saved') {
                echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <b>Alert!</b> Item added succesfully!</div>';
            }

            if (isset($_GET['msg']) && $_GET['msg'] == 'updated') {
                echo '<div class="alert alert-info alert-dismissable">
                                        <i class="fa fa-info"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <b>Alert!</b> Item edited succesfully!</div>';
            }
            ?>
            <div class="row">
                <div class="col-xs-12">
                    <a class="btn btn-default" href="apps/general/groups.php?action=new">
                        <i class="fa fa-edit"></i> New</a>
                    <p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title"> Groups</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive">

                            <table id="example1" class="table table-bordered table-striped dataTable">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Group Description</th>
                                    <th width="170">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($data as $item) {

                                    echo '<tr> 
											<td>' . $item['GroupID'] . '</td> 
											<td>' . $item['GroupDesc'] . '</td>
											<td>
											<div class="btn-group">
                                            <button type="button" class="btn btn-default">Action</button>
                                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                             <li><a href="apps/general/groups.php?action=edit&amp;id=' . $item['GroupID'] . '" class="icon edit">EDIT</a></li>
											 <li><a data-href="apps/general/groups.php?action=delete&amp;id=' . $item['GroupID'] . '" data-toggle="modal" data-target="#confirm-delete" href="#">DELETE</a></li>
                                            </ul>
                                        </div>
											</td>
										</tr>';

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

<?php require_once(TEMPLATE_PATH . 'footer.php'); ?>    <?php require_once(TEMPLATE_PATH . 'head.php'); ?>

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
            <?php
            if (isset($_GET['msg']) && $_GET['msg'] == 'deleted') {
                echo '<div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <b>Alert!</b> Item deleted succesfully!</div>';
            }

            if (isset($_GET['msg']) && $_GET['msg'] == 'saved') {
                echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <b>Alert!</b> Item added succesfully!</div>';
            }

            if (isset($_GET['msg']) && $_GET['msg'] == 'updated') {
                echo '<div class="alert alert-info alert-dismissable">
                                        <i class="fa fa-info"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <b>Alert!</b> Item edited succesfully!</div>';
            }
            ?>
            <div class="row">
                <div class="col-xs-12">
                    <a class="btn btn-default" href="apps/general/groups.php?action=new">
                        <i class="fa fa-edit"></i> New</a>
                    <p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title"> Groups</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive">

                            <table id="example1" class="table table-bordered table-striped dataTable">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Group Description</th>
                                    <th width="170">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($data as $item) {

                                    echo '<tr> 
											<td>' . $item['GroupID'] . '</td> 
											<td>' . $item['GroupDesc'] . '</td>
											<td>
											<div class="btn-group">
                                            <button type="button" class="btn btn-default">Action</button>
                                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                             <li><a href="apps/general/groups.php?action=edit&amp;id=' . $item['GroupID'] . '" class="icon edit">EDIT</a></li>
											 <li><a data-href="apps/general/groups.php?action=delete&amp;id=' . $item['GroupID'] . '" data-toggle="modal" data-target="#confirm-delete" href="#">DELETE</a></li>
                                            </ul>
                                        </div>
											</td>
										</tr>';

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