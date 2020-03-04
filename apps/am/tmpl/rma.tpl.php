<?php require_once(TEMPLATE_PATH . 'header.include.php');
require_once('php/functions.php');
?>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">RMA - Return Merchandise Authorization</h3>
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
                    <a data-toggle="modal" href="apps/<?php echo app_name; ?>/modals/rma.php?action=new"
                       data-target="#remoteModal">
                        <button class="btn btn-primary btn-sm"> Send RMA</button>
                    </a>
                <?php } ?>
                <?php if (hasPermissionPDO($mis_connPDO, $activemenuitem['id'], 'UPDATE')) { ?>
                    <button disabled data-toggle="modal" href="" data-target="#remoteModal"
                            class="btn btn-warning btn-sm inputDisabled"> Receive RMA
                    </button>
                <?php } ?>
                <?php if (hasPermissionPDO($mis_connPDO, $activemenuitem['id'], 'UPDATE')) { ?>
                    <button disabled data-toggle="modal" href="" data-target="#remoteModal"
                            class="btn btn-warning btn-sm inputDisabledFiles"> Upload RMA Files
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
                        <th>Repairnr</th>
                        <th>Vendor</th>
                        <th>Quantity</th>
                        <th>Warranty</th>
                        <th>OROnr</th>
                        <th>Shipdate</th>
                        <th>Receivedate</th>
                        <th>Status</th>
                        <th>Docs</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    $count = 1;
                    foreach ($Rmaen as $item) {
                        $Rmafilerecs = Rmafile::where('rmavolgnr', '=', $item->rmavolgnr)->count();

                        echo '<tr class="clickable-row" id="' . $item->rmavolgnr . '" naam="' . $item->statusnr . '">
                            <td>' . $count . '</td>
                            <td>' . $item->rmanr . '</td>
							<td>' . getFabrikant('fabrikantid', $item->fabrikantid) . '</td>
							<td>' . $item->aantal . '</td>
							<td>' . $item->garantie . '</td>
							<td>' . $item->oronr . '</td>
							<td>' . $item->shipdatum . '</td>
							<td>' . $item->recdatum . '</td>
							<td>' . getStatusType('statusnr', $item->statusnr) . '</td>
							<td>' . $Rmafilerecs . '</td>
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

                <?php if (hasPermissionPDO($mis_connPDO, $activemenuitem['id'], 'INSERT')) { ?>
                $('.inputDisabled').prop("disabled", false); // Element(s) are now enabled.
                $('.inputDisabled').attr('href', "apps/<?php echo app_name;?>/modals/rma.php?action=update&id=" + $(this).attr('id'));
                <?php } ?>

                $('.inputDisabledDelete').prop("disabled", false); // Element(s) are now enabled.
                $('.inputDisabledDelete').attr('data-href', "apps/<?php echo app_name;?>/rma.php?action=delete&id=" + $(this).attr('id'));

                $('.inputDisabledFiles').prop("disabled", false); // Element(s) are now enabled.
                $('.inputDisabledFiles').attr('href', "apps/<?php echo app_name;?>/modals/rmafile.php?action=new&parent=rma&id=" + $(this).attr('id'));

                if ($(this).attr('naam') == '201') {
                    $('.inputDisabled').prop("disabled", true);
                    $('.inputDisabledDelete').prop("disabled", true);
                    $('.inputDisabledFiles').prop("disabled", true);
                }
            });
            $('#mainTable').on('click', '.clickable-row', function (event) {
                $(this).addClass('active').siblings().removeClass('active');
            });
        });
    </script>
<?php require_once(TEMPLATE_PATH . 'footer.include.php'); ?>