<?php require_once(TEMPLATE_PATH . 'header.include.php'); ?>
    <section class="content">
        <!-- Default box -->
        <div class="nav-tabs-custom animated bounceInRight">

            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1-1" data-toggle="tab">Aanvragen vanuit Afdeling</a></li>
                <li><a href="#tab_2-2" data-toggle="tab">Item Besteld</a></li>
                <li class="pull-left header"><i class="fa fa-th"></i> Aanvraag</li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="tab_1-1">
                    <?php if (hasPermissionPDO($mis_connPDO, $activemenuitem['id'], 'UPDATE')) { ?>
                        <div id="showinfo" class="alert alert-danger" style="display:none;">
                            <i class="fa fa-ban"></i>
                            <b>Alert!</b>
                            <div id="wijzigVerwijder"></div>
                        </div>
                    <?php } ?>
                    <?php if (getInkoopPermisson('Voorbereider')) { ?>
                        <a data-toggle="modal" href="apps/<?php echo app_name; ?>/modals/afdelingaanvr.php?action=new"
                           data-target="#remoteModal">
                            <button class="btn btn-primary btn-sm"> Afdelingaanvr</button>
                        </a>
                    <?php } ?>
                    <?php if (hasPermissionPDO($mis_connPDO, $activemenuitem['id'], 'UPDATE')) { ?>
                        <button disabled data-toggle="modal" href="" data-target="#remoteModal"
                                class="btn btn-warning btn-sm inputDisabled">Wijzigen
                        </button>
                    <?php } ?>
                    <?php if (getInkoopPermisson('Voorbereider')) { ?>
                        <?php if (hasPermissionPDO($mis_connPDO, $activemenuitem['id'], 'DELETE')) { ?>
                            <button disabled class="btn btn-danger btn-sm inputDisabledDelete" data-href=""
                                    data-toggle="modal"
                                    data-target="#confirm-delete" href="#">DELETE
                            </button>
                        <?php } ?>
                    <?php } ?>
                    <p>
                    <p>
                    <table id="mainTable" class="table table-bordered table-striped dataTable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Ref nr</th>
                            <th>afdeling</th>
                            <th>naam</th>
                            <th>datumtijd</th>
                            <th>auto</th>
                            <th>projnr</th>
                            <th>goedbriefr</th>
                            <th>bestover</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $count = 1;
                        foreach ($afdelingaanvr as $r) {
                            echo '<tr class="clickable-row" id =' . $r->id . ' refnr ="' . $r->refnr . '"">
                          <td>' . $count . '</td>
                          <td>' . $r->refnr . '</td>
                          <td>' . $r->afdeling . '</td>
                          <td>' . $r->naam . '</td>
                          <td>' . $r->datumtijd . '</td>
                          <td>' . $r->auto . '</td>
                          <td>' . $r->projnr . '</td>
                          <td>' . $r->goedbrief . '</td>
                          <td>' . $r->bestover . '</td>
                          '; ?>
                            </td>
                            </tr>
                            <?php
                            $count++;
                        }
                        ?>
                        </tbody>
                    </table>
                </div><!-- /.tab_1-1 -->

                <div class="tab-pane" id="tab_2-2">
                    <?php if (hasPermissionPDO($mis_connPDO, $activemenuitem['id'], 'UPDATE')) { ?>
                        <div id="showinfos" class="alert alert-danger" style="display:none;">
                            <i class="fa fa-ban"></i>
                            <b>Alert!</b>
                            <div id="wijzigVerwijders"></div>
                        </div>
                    <?php } ?>
                    <?php if (getInkoopPermisson('Voorbereider')) { ?>
                        <a data-toggle="modal" href="apps/<?php echo app_name; ?>/modals/afdelingaanvr.php?action=new"
                           data-target="#remoteModal">
                            <button class="btn btn-primary btn-sm"> Afdelingitem</button>
                        </a>
                    <?php } ?>
                    <?php if (hasPermissionPDO($mis_connPDO, $activemenuitem['id'], 'UPDATE')) { ?>
                        <button disabled data-toggle="modal" href="" data-target="#remoteModal"
                                class="btn btn-warning btn-sm inputDisabled">Wijzigen
                        </button>
                    <?php } ?>
                    <?php if (getInkoopPermisson('Voorbereider')) { ?>
                        <?php if (hasPermissionPDO($mis_connPDO, $activemenuitem['id'], 'DELETE')) { ?>
                            <button disabled class="btn btn-danger btn-sm inputDisabledDelete" data-href=""
                                    data-toggle="modal"
                                    data-target="#confirm-delete" href="#">DELETE
                            </button>
                        <?php } ?>
                    <?php } ?>
                    <p>
                    <table id="mainTableitem" class="table table-bordered table-striped dataTable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Aanvraag nr</th>
                            <th>Referentie nr</th>
                            <th>Invoerdatum</th>
                            <th>Afdeling</th>
                            <th>Artikelcode</th>
                            <th>Te Bestellen</th>
                            <th>Eenheid</th>
                            <th>Opmerkingen</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $count = 1;
                        foreach ($bestelling as $r) {
                            echo '<tr class="clickable-row" id =' . $r->id . ' naam ="' . $r->bstl_te_bestellen . '"">
                          <td>' . $count . '</td>
                          <td>' . $r->aanvraag_nr . '</td>
                          <td>' . $r->refnr . '</td>
                          <td>' . $r->bstl_aanvraag_datum . '</td>
                          <td>' . $r->bstl_afdeling . '</td>
                          <td>' . getArtikelCode($r->bstl_artikelcode) . '</td>
                          <td>' . $r->bstl_te_bestellen . '</td>
                          <td>' . $r->bstl_eenheid . '</td>
                          <td>' . $r->bstl_opmerkingen . '</td>
                          '; ?>
                            </td>
                            </tr>
                            <?php
                            $count++;
                        }
                        ?>
                        </tbody>
                    </table>
                </div><!-- /.tab-pane -->

            </div><!-- /.box-body -->
        </div><!-- /.box -->
        <!-- Modal -->
        <div class="modal fade" id="remoteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-extra-large" style="width: 95%; max-width:95%;">
                <div class="modal-content modal-extra-large" style="width: 95%; max-width:95%;">
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
                $('.inputDisabled').attr('href', "apps/<?php echo app_name;?>/modals/afdelingaanvr.php?action=update&id=" + $(this).attr('id'));

                $('.inputDisabledDelete').prop("disabled", false); // Element(s) are now enabled.
                $('.inputDisabledDelete').attr('data-href', "apps/<?php echo app_name;?>/afdelingaanvr.php?action=delete&id=" + $(this).attr('id'));

                $('#wijzigVerwijder').empty();
                $('#wijzigVerwijder').append('U heeft refnr "' + $(this).attr('refnr') + '"geselecteerd, u kunt nu wijzigen of verwijderen!');
                $("#showinfo").show();

            });
            $('#mainTable').on('click', '.clickable-row', function (event) {
                $(this).addClass('active').siblings().removeClass('active');
            });

            $('#mainTableitem tr').click(function (event) {
                $(this).addClass('active').siblings().removeClass('active');

                $('.inputDisabled').prop("disabled", false); // Element(s) are now enabled.
                $('.inputDisabled').attr('href', "apps/<?php echo app_name;?>/modals/afdelingaanvr.php?action=update&id=" + $(this).attr('id'));

                $('.inputDisabledDelete').prop("disabled", false); // Element(s) are now enabled.
                $('.inputDisabledDelete').attr('data-href', "apps/<?php echo app_name;?>/afdelingaanvr.php?action=delete&id=" + $(this).attr('id'));

                $('#wijzigVerwijders').empty();
                $('#wijzigVerwijders').append('U heeft "' + $(this).attr('naam') + '"geselecteerd, u kunt nu wijzigen off verwijderen!');
                $("#showinfos").show();

            });
            $('#mainTableitem').on('click', '.clickable-row', function (event) {
                $(this).addClass('active').siblings().removeClass('active');
            });
        });


    </script>
<?php require_once(TEMPLATE_PATH . 'footer.include.php'); ?>