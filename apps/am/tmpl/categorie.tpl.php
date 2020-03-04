<?php require_once(TEMPLATE_PATH . 'header.include.php');
require_once('php/functions.php');
?>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Category </h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i
                                class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i
                                class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <!---------------------- table toolbar start ------------------------------->
                <?php if (hasPermissionPDO($mis_connPDO, $activemenuitem['id'], 'UPDATE')) { ?>
                    <div id="showinfo" class="alert alert-danger" style="display:none;">
                        <i class="fa fa-ban"></i>
                        <b>Alert!</b>
                        <div id="wijzigVerwijder"></div>
                    </div>
                <?php } ?>
                <?php if (hasPermissionPDO($mis_connPDO, $activemenuitem['id'], 'INSERT')) { ?>
                    <a data-toggle="modal" href="apps/<?php echo app_name; ?>/modals/categorie.php?action=new"
                       data-target="#remoteModal">
                        <button class="btn btn-primary btn-sm"> Insert</button>
                    </a>
                <?php } ?>
                <?php if (hasPermissionPDO($mis_connPDO, $activemenuitem['id'], 'UPDATE')) { ?>
                    <button disabled data-toggle="modal" href="" data-target="#remoteModal"
                            class="btn btn-warning btn-sm inputDisabled"> Update
                    </button>
                <?php } ?>
                <?php if (hasPermissionPDO($mis_connPDO, $activemenuitem['id'], 'DELETE')) { ?>
                    <button disabled class="btn btn-danger btn-sm inputDisabledDelete" data-href="" data-toggle="modal"
                            data-target="#confirm-delete" href="#"> Delete
                    </button>
                <?php } ?>
                <p>
                    <!---------------------- table toolbar end ------------------------------->
                <table id="mainTable" class="table table-bordered table-striped dataTable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Description</th>
                        <th>Parent</th>
						<th>Abbreviation</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    $count = 1;
                    foreach ($Categorieen as $item) {
                        echo '<tr class="clickable-row" id =' . $item->categorienr . ' naam ="' . $item->categorienr . '">
                            <td>' . $count . '</td>
                            <td>' . $item->categorienaam . '</td>
							<td>' . getCategorie('categorienr', $item->parentnr) . '</td>
							<td>' . $item->afkcode . '</td>
                          </tr>';
                        $count++;
                    }
                    ?>
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
        <!-- Modal -->
        <div class="modal fade" id="remoteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <script type="text/javascript">
        $(document).ready(function () {
            $('#mainTable tr').click(function (event) {
                $(this).addClass('active').siblings().removeClass('active');

                $('.inputDisabled').prop("disabled", false); // Element(s) are now enabled.
                $('.inputDisabled').attr('href', "apps/<?php echo app_name;?>/modals/categorie.php?action=update&id=" + $(this).attr('id'));

                $('.inputDisabledDelete').prop("disabled", false); // Element(s) are now enabled.
                $('.inputDisabledDelete').attr('data-href', "apps/<?php echo app_name;?>/categorie.php?action=delete&id=" + $(this).attr('id'));

                $('#wijzigVerwijder').empty();
                $('#wijzigVerwijder').append('U heeft "' + $(this).attr('naam') + '"geselecteerd, u kunt nu wijzigen of verwijderen!');
                //$("#showinfo").show();

            });
            $('#mainTable').on('click', '.clickable-row', function (event) {
                $(this).addClass('active').siblings().removeClass('active');
            });
        });
    </script>
<?php require_once(TEMPLATE_PATH . 'footer.include.php'); ?>