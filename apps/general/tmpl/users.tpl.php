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
                    <small>Users</small>
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
                    <div class="col-xs-3">
                        <a class="btn btn-default" href="apps/general/users.php?action=new">
                            <i class="fa fa-edit"></i> New
                        </a>
                        <?php if (hasPermissionPDO($mis_connPDO, $activemenuitem['id'], 'UPDATE')) { ?>
                            <a class="InputEdit" href="">
                                <button disabled class="btn btn-warning InputEdit">Edit</button>
                            </a>
                        <?php } ?>
                        <?php if (hasPermissionPDO($mis_connPDO, $activemenuitem['id'], 'DELETE')) { ?>
                            <button disabled class="btn btn-danger inputDisabledDelete" data-href="" data-toggle="modal"
                                    data-target="#confirm-delete" href="#">Delete
                            </button>
                        <?php } ?>
                    </div>
                    <div class="col-xs-6">

                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">

                            <label>Filteren op:</label>
                            <select name="group">
                                <?php
                                $dataqueryx = 'SELECT id,name FROM usergroups';
                                $dataresultset = $mis_connPDO->query($dataqueryx);
                                $datax = array();
                                // Parse returned data, and displays them
                                while ($rowx = $dataresultset->fetch(PDO::FETCH_ASSOC)) {
                                    $datax[] = $rowx;
                                    ?>
                                    <option value="<?php echo $rowx['id'] ?>" <?php if ($rowx['id'] == $_POST['group']) {
                                        echo 'selected="selected"';
                                    } else {
                                    } ?>><?php echo $rowx['name'] ?></option>
                                <?php } ?>

                            </select>
                            <button class="btn btn-success">Zoeken</button>
                            <a href="apps/general/users.php" class="btn btn-warning">Reset</a>
                        </form>
                    </div>
                </div>
                <p></p>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Users</h3>
                            </div><!-- /.box-header -->
                            <div class="box-body table-responsive">


                                <?php
                                if (isset($_GET['msg']) && $_GET['msg'] == 'deleted') {
                                    echo '<div class="notice success"><span>Item deleted succesfully!</span></div>';
                                }

                                if (isset($_GET['msg']) && $_GET['msg'] == 'saved') {
                                    echo '<div class="notice success"><span>Item added succesfully!</span></div>';
                                }

                                if (isset($_GET['msg']) && $_GET['msg'] == 'updated') {
                                    echo '<div class="notice success"><span>Item edited succesfully!</span></div>';
                                }
                                ?>
                                <table id="mainTable" class="table table-bordered table-striped dataTable">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Afdeling</th>
                                        <th>Naam</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Badge nr</th>
                                        <th>Rollen</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($data as $item) {
//                                        $name = getNameLDAP($item['username']);
//                                        $email =  ( $item['email'] == '' ? getEmailLDAP($item['username']) : $item['email']);
                                        echo '<tr class="clickable-row" id =' . $item['id'] . ' naam ="' . $item['username'] . '""> 
												<td>' . $item['id'] . '</td> 
												<td>' . $item['afd'] . '</td> 
												<td>' . $item['name'] . '</td> 
												<td>' . $item['username'] . '</td> 
												<td>' . $item['email'] . '</td>
												<td>' . $item['badge'] . '</td> 
												<td>' . getUsergroups($item['id']) . '</td> 
												<td>' . ($item['status'] == 1 ? '<span class="badge bg-green">Active</span>' : '<span class="badge bg-red">Inactive</span>') . '</td> 
											</tr>';

//                                        $query = "	UPDATE users SET name = '" . $name . "' ,email = '" . $email . "' WHERE id = '" .    $item['id'] . "'";
//                                        $resultset = $mis_connPDO->query($query);

                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
            </section><!-- /.content -->
        </aside><!-- /.right-side -->
    </div><!-- ./wrapper -->
    <script type="text/javascript">
        $(document).ready(function () {
            $('#mainTable tr').click(function (event) {
                $(this).addClass('active').siblings().removeClass('active');

                $('.InputEdit').prop("disabled", false); // Element(s) are now enabled.
                $('.InputEdit').attr('href', "apps/general/users.php?action=edit&id=" + $(this).attr('id'));

                $('.inputDisabledDelete').prop("disabled", false); // Element(s) are now enabled.
                $('.inputDisabledDelete').attr('data-href', "apps/general/users.php?action=delete&id=" + $(this).attr('id'));

                $('#wijzigVerwijder').empty();
                $('#wijzigVerwijder').append('U heeft "' + $(this).attr('naam') + '"geselecteerd, u kunt nu wijzigen of verwijderen!');
                $("#showinfo").show();

            });
            $('#mainTable').on('click', '.clickable-row', function (event) {
                $(this).addClass('active').siblings().removeClass('active');
            });
        });
    </script>
<?php require_once(TEMPLATE_PATH . 'footer.php'); ?>