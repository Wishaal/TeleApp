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
                    <div class="box-body">

                        <div class="btn-group">
                            <button type="button" disabled class="btn btn-success inputDisabled">Binnenland</button>
                            <button type="button" disabled class="btn btn-success dropdown-toggle inputDisabled"
                                    data-toggle="dropdown">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu" role="menu" id="binnenlandmenu">
                                <?php
                                $userbinnenland = Role::whereRolnaam('BINNENLAND_BAK')->first();
                                foreach ($userbinnenland->users as $a) {
                                    $user = User::find($a->user_id);
                                    echo '<li><a class="binnenland" 
                                                    data-toggle="modal" 
                                                    href="apps/' . app_name . '/modals/bakmelding.php?action=assign&type=0&user_id=' . $user->id . '"
                                                    data-target="#remoteModal">' . $user->username . '</a></li>';
                                }
                                ?>
                            </ul>
                        </div>
                        <div class="btn-group">
                            <button type="button" disabled class="btn btn-warning inputDisabled">Buitenland</button>
                            <button type="button" disabled class="btn btn-warning dropdown-toggle inputDisabled"
                                    data-toggle="dropdown">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu" role="menu" id="buitenlandmenu">
                                <?php
                                $userbinnenland = Role::whereRolnaam('BUITENLAND_BAK')->first();
                                foreach ($userbinnenland->users as $a) {
                                    $user = User::find($a->user_id);
                                    echo '<li><a class="binnenland" 
                                                    data-toggle="modal" 
                                                    href="apps/' . app_name . '/modals/bakmelding.php?action=assign&type=1&user_id=' . $user->id . '"
                                                    data-target="#remoteModal">' . $user->username . '</a></li>';
                                }
                                ?>
                            </ul>
                        </div>
                        <button disabled data-toggle="modal" href="" data-target="#remoteModal"
                                class="btn btn-primary inputDisabledInventory">Terug sturen naar Inventory
                        </button>
                        <p>
                        <table id="mainTable" class="table table-bordered table-striped dataTable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Aanvraag Nr</th>
                                <th>Artikelcode</th>
                                <th>Omschrijving</th>
                                <th>Ingevoerd door</th>
                                <th>Aanvraag Datum</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $count = 1;
                            // foreach ($openAanvragen as $a) {

                            foreach ($openAanvragen as $r) {
                                echo '<tr class="clickable-row" id =' . $r->getAanvraag->id . ' naam ="' . $r->getAanvraag->aanvraag_nr . '"">
                                    <td>' . $count . '</td>
                                    <td>' . $r->getAanvraag->aanvraag_nr . '</td>
                                    <td>' . getArtikelCode($r->getAanvraag->bstl_artikelcode) . '</td>
                                    <td>' . $r->getAanvraag->bstl_omschrijving . '</td>
                                    <td>' . getProfileInfo($mis_connPDO, 'username', $r->getAanvraag->bstl_ingevoerd_door) . '</td>
                                    <td>' . $r->getAanvraag->bstl_aanvraag_datum . '</td>
                                    '; ?>
                                </td>
                                </tr>
                                <?php
                                $count++;
                                //    }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
            <div class="col-md-6">
                <div class="box animated bounceInRight">
                    <div class="box-body">
                        <button disabled data-toggle="modal" href="" data-target="#remoteModal"
                                class="btn btn-danger inputDisabledBezetAanvragen">Terug sturen!
                        </button>
                        <p>




                        <table id="bezetAanvragen" class="table table-bordered table-striped dataTable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Aanvraag Nr</th>
                                <th>Artikelcode</th>
                                <th>Omschrijving</th>
                                <th>Aanvraag Datum</th>
                                <th>Toegekend aan</th>
                                <th>Datum</th>
                            </tr>
                            </thead>
                            <tbody class="clickable-row" id="2">
                            <?php
                            $count = 1;
                            foreach ($bezetAanvragen as $r) {

                                // foreach ($a->getAanvragen as $r) {
                                echo '<tr class="clickable-row" id =' . $r->getAanvraag->id . ' naam ="' . $r->getAanvraag->aanvraag_nr . '"">
                                                    <td>' . $count . '</td>
                                                    <td>' . $r->getAanvraag->aanvraag_nr . '</td>
                                                    <td>' . getArtikelCode($r->getAanvraag->bstl_artikelcode) . '</td>
                                                    <td>' . $r->getAanvraag->bstl_omschrijving . '</td>
                                                    <td>' . $r->getAanvraag->bstl_aanvraag_datum . '</td>
                                                    <td>' . $r->getUser->username . '</td>
                                                    <td>' . $r->updated_at . '</td>
                                                    '; ?>
                                </td>
                                </tr>
                                <?php
                                $count++;
                                // }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div><!-- /.box-body getProfileInfo($mis_connPDO, 'username', getBadgePDO($mis_connPDO, $r->getUser->username)) -->
                </div><!-- /.box -->
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="remoteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
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
                // binnenlandmenu
                var selectedId = $(this).attr('id');
                $('#binnenlandmenu a').each(function () {
                    this.href += '&aanvraag_id=' + selectedId;
                })
                $('#buitenlandmenu a').each(function () {
                    this.href += '&aanvraag_id=' + selectedId;
                })
                // $('.binnenland').attr('href', "apps/<?php echo app_name;?>/modals/authorisaties.php?action=update&id=" + $(this).attr('id'));

                $('#wijzigVerwijder').append('U heeft "' + $(this).attr('naam') + '"geselecteerd, u kunt nu wijzigen of verwijderen!');
                $("#showinfo").show();

                $('.inputDisabledInventory').prop("disabled", false); // Element(s) are now enabled.
                $('.inputDisabledInventory').attr('href', "apps/<?php echo app_name;?>/modals/inbox_terug_sturen.php?action=sendBack&id=" + $(this).attr('id'));

            });

            $('#bezetAanvragen tr').click(function (event) {
                $(this).addClass('active').siblings().removeClass('active');
                $('.inputDisabledBezetAanvragen').prop("disabled", false); // Element(s) are now enabled.
                $('.inputDisabledBezetAanvragen').attr('href', "apps/<?php echo app_name; ?>/modals/bakmelding.php?action=reassign&aanvraag_id=" + $(this).attr('id'));


            });

            $('#mainTable').on('click', '.clickable-row', function (event) {
                $(this).addClass('active').siblings().removeClass('active');
            });
            $('#bezetAanvragen').on('click', '.clickable-row', function (event) {
                $(this).addClass('active').siblings().removeClass('active');
            });
        });
        //zet bezet aanvragen tabel datatable
        $(function () {
            $("#bezetAanvragen").dataTable({
                "sDom": '<"row view-filter"<"col-sm-12"<"pull-left"l><"pull-right"f><"clearfix">>>t<"row view-pager"<"col-sm-12"<"pull-left"i><"pull-right"p><"clearfix">>>',
                "bStateSave": true
            });
        });
    </script>
<?php require_once(TEMPLATE_PATH . 'footer.include.php'); ?>