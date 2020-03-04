<?php require_once(TEMPLATE_PATH . 'header.include.php'); ?>
    <section class="content">
        <!-- Default box -->
        <div class="box animated bounceInRight">
            <div class="box-header with-border">
                <h3 class="box-title">Afgifte </h3>
            </div>
            <div class="box-body">
                <?php if (hasPermissionPDO($mis_connPDO, $activemenuitem['id'], 'UPDATE')) { ?>
                    <div id="showinfo" class="alert alert-danger" style="display:none;">
                        <i class="fa fa-ban"></i>
                        <b>Alert!</b>
                        <div id="wijzigVerwijder"></div>
                    </div>
                <?php } ?>
                <a data-toggle="modal" href="apps/<?php echo app_name; ?>/modals/afgifte.php?action=new"
                   data-target="#remoteModal">
                    <button class="btn btn-primary btn-sm"> Invoeren</button>
                </a>
                <?php if (hasPermissionPDO($mis_connPDO, $activemenuitem['id'], 'UPDATE')) { ?>
                    <button disabled data-toggle="modal" href="" data-target="#remoteModal"
                            class="btn btn-warning btn-sm inputDisabled">Wijzigen
                    </button>
                <?php } ?>
                <?php if (hasPermissionPDO($mis_connPDO, $activemenuitem['id'], 'DELETE')) { ?>
                    <button disabled class="btn btn-danger btn-sm inputDisabledDelete" data-href="" data-toggle="modal"
                            data-target="#confirm-delete" href="#">DELETE
                    </button>
                <?php } ?>
                <p>
                <p>
                <table id="mainTable" class="table table-bordered table-striped dataTable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Aanvraag nr</th>
                        <th>MAB NO</th>
                        <th>Verstrekte colli</th>
                        <th>Verstrekkingsdatum</th>
                        <th>Ontvangen door</th>
                        <th>Opmerkingen</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $count = 1;
                    foreach ($afgifte as $r) {
                        echo '<tr class="clickable-row" id =' . $r->id . ' naam ="' . $r->ntv_gegevens_van_ontvangst . '"">
                          <td>' . $count . '</td>
                          <td>' . $r->aanvraag_nr . '</td>
                          <td>' . $r->afg_mab_no . '</td>
                          <td>' . $r->afg_verstrekte_colli . '</td>
                          <td>' . $r->afg_verstrekkingsdatum . '</td>
                          <td>' . $r->afg_ontvangendoor . '</td>
                          <td>' . $r->afg_opmerkingen . '</td>
                          '; ?>
                        </td>
                        </tr>
                        <?php
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
            <div class="modal-dialog modal-extra-large">
                <div class="modal-content">
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </section><!-- /.content -->
    <script type="text/javascript">
        $(document).ready(function () {
            $('#mainTable tr').click(function (event) {
                $(this).addClass('active').siblings().removeClass('active');

                $('.inputDisabled').prop("disabled", false); // Element(s) are now enabled.
                $('.inputDisabled').attr('href', "apps/<?php echo app_name;?>/modals/afgifte.php?action=update&id=" + $(this).attr('id'));

                $('.inputDisabledDelete').prop("disabled", false); // Element(s) are now enabled.
                $('.inputDisabledDelete').attr('data-href', "apps/<?php echo app_name;?>/afgifte.php?action=delete&id=" + $(this).attr('id'));

                $('#wijzigVerwijder').empty();
                $('#wijzigVerwijder').append('U heeft "' + $(this).attr('naam') + '"geselecteerd, u kunt nu wijzigen of verwijderen!');
                $("#showinfo").show();

            });
            $('#mainTable').on('click', '.clickable-row', function (event) {
                $(this).addClass('active').siblings().removeClass('active');
            });
        });
    </script>
<?php require_once(TEMPLATE_PATH . 'footer.include.php'); ?>