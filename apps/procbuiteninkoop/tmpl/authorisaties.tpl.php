<?php require_once(TEMPLATE_PATH . 'header.include.php'); ?>
    <section class="content">
        <!-- Default box -->
        <div class="row">
            <?php if (hasPermissionPDO($mis_connPDO, $activemenuitem['id'], 'UPDATE')) { ?>
                <div id="showinfo" class="alert alert-danger" style="display:none;">
                    <i class="fa fa-ban"></i>
                    <b>Alert!</b>
                    <div id="wijzigVerwijder"></div>
                </div>
            <?php } ?>
            <div class="col-md-6">
                <div class="box animated bounceInRight">
                    <div class="box-header with-border">
                        <h3 class="box-title">Authorisaties </h3>
                    </div>
                    <div class="box-body">

                        <a data-toggle="modal" href="apps/<?php echo app_name; ?>/modals/authorisaties.php?action=new"
                           data-target="#remoteModal">
                            <button class="btn btn-primary btn-sm"> Invoeren</button>
                        </a>
                        <?php if (hasPermissionPDO($mis_connPDO, $activemenuitem['id'], 'UPDATE')) { ?>
                            <button disabled data-toggle="modal" href="" data-target="#remoteModal"
                                    class="btn btn-warning btn-sm inputDisabled">Wijzigen
                            </button>
                        <?php } ?>
                        <?php if (hasPermissionPDO($mis_connPDO, $activemenuitem['id'], 'SELECT')) { ?>
                            <button disabled data-toggle="modal" href="" data-target="#remoteModal"
                                    class="btn btn-success btn-sm inputDisabledBesteding">Bestedingsoverzicht
                            </button>
                        <?php } ?>
                        <?php if (hasPermissionPDO($mis_connPDO, $activemenuitem['id'], 'DELETE')) { ?>
                            <button disabled class="btn btn-danger btn-sm inputDisabledDelete" data-href=""
                                    data-toggle="modal"
                                    data-target="#confirm-delete" href="#">DELETE
                            </button>
                        <?php } ?>
                        <p>
                        <table id="mainTable" class="table table-bordered table-striped dataTable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Valuta</th>
                                <th>Bedrag</th>
                                <th>Authorisatie #</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $count = 1;
                            foreach ($Authorisatie as $r) {
                                echo '<tr class="clickable-row" id =' . $r->id . ' naam ="' . $r->authorisatienr . '"">
                                    <td>' . $count . '</td>
                                    <td>' . $r->valuta . '</td>
                                    <td>' . number_format($r->bedrag, 2) . '</td>
                                    <td>' . $r->authorisatienr . '</td>
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
            </div>
            <div class="col-md-6">
                <div class="box animated bounceInRight">
                    <div class="box-header with-border">
                        <h3 class="box-title">Inkoop items </h3>
                    </div>
                    <div class="box-body">
                        <button disabled data-toggle="modal" href="" data-target="#remoteModal"
                                class="btn btn-primary btn-sm inputDisabledInkoop" id="selectInkoop">Bekijk inkoop item
                        </button>
                        <button disabled data-toggle="modal" href="" data-target="#remoteModal"
                                class="btn btn-success btn-sm inputDisabledInkoopScore" id="selectInkoop">Score Bekijken
                        </button>
                        <p>
                        <table id="inkoopitems" class="table table-bordered table-striped dataTable">
                            <thead>
                            <tr>
                                <th>Type</th>
                                <th>PO #</th>
                                <th>PO Datum</th>
                                <th>Leverancier</th>
                                <th>Omschrijving</th>
                                <th>Te betalen</th>
                            </tr>
                            </thead>
                            <tbody class="clickable-row" id="2">
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>

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
                $('#inkoopitems tbody').empty();
                $.ajax({
                    url: "apps/procbuiteninkoop/ajax/getAuthInkoop.php?id=" + $(this).attr('id'),
                    type: 'GET',
                    dataType: 'html',
                    success: function (data) {
                        $('#inkoopitems tbody').append(data);
                        inkoop();
                    },
                    error: function () {
                        console.log('error');
                    }
                });
                $('.inputDisabled').prop("disabled", false); // Element(s) are now enabled.
                $('.inputDisabled').attr('href', "apps/<?php echo app_name;?>/modals/authorisaties.php?action=update&id=" + $(this).attr('id'));

                $('.inputDisabledBesteding').prop("disabled", false); // Element(s) are now enabled.
                $('.inputDisabledBesteding').attr('href', "apps/<?php echo app_name;?>/modals/bestedingsoverzicht.php?id=" + $(this).attr('id'));

                $('.inputDisabledDelete').prop("disabled", false); // Element(s) are now enabled.
                $('.inputDisabledDelete').attr('data-href', "apps/<?php echo app_name;?>/authorisaties.php?action=delete&id=" + $(this).attr('id'));

                $('#wijzigVerwijder').empty();
                $('#wijzigVerwijder').append('U heeft "' + $(this).attr('naam') + '"geselecteerd, u kunt nu wijzigen of verwijderen!');
                $("#showinfo").show();

            });


            $('#mainTable').on('click', '.clickable-row', function (event) {
                $(this).addClass('active').siblings().removeClass('active');
            });
            $('#inkoopitems').on('click', '.clickable-row', function (event) {
                $(this).addClass('active').siblings().removeClass('active');
            });
        });

        function inkoop() {
            $('#inkoopitems tr').click(function (event) {
                $(this).addClass('active').siblings().removeClass('active');
                $('.inputDisabledInkoop').prop("disabled", false); // Element(s) are now enabled.
                $('.inputDisabledInkoop').attr('href', "apps/<?php echo app_name;?>/modals/buitenlandseinkoop-readonly.php?id=" + $(this).attr('id'));

                $('.inputDisabledInkoopScore').prop("disabled", false); // Element(s) are now enabled.
                $('.inputDisabledInkoopScore').attr('href', "apps/<?php echo app_name;?>/modals/buitenlandseinkoop-score.php?id=" + $(this).attr('id'));

                $('#selectInkoop').empty();
                $('#selectInkoop').append('Bekijk inkoop item');

            });
        }
    </script>
<?php require_once(TEMPLATE_PATH . 'footer.include.php'); ?>