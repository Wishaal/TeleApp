<?php require_once(TEMPLATE_PATH . 'header.include.php'); ?>
    <section class="content">
        <!-- Default box -->
        <div class="box animated bounceInRight">
            <div class="box-header with-border">
                <h3 class="box-title">Aanvragen </h3>
            </div>
            <div class="box-body">
                <div id="showinfo" class="alert alert-danger" style="display:none;">
                    <i class="fa fa-ban"></i>
                    <b>Alert!</b>
                    <div id="wijzigVerwijder"></div>
                </div>
                <button disabled data-toggle="modal" href="" data-target="#remoteModal"
                        class="btn btn-warning btn-sm inputDisabled">Bekijken
                </button>
                <p>
                <p>
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs" id="myTab">
                        <li class="active"><a href="#tab_1" data-toggle="tab">Aanvragen</a></li>
                        <li><a href="#tab_2" data-toggle="tab">Afgekeurde aanvragen</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <table id="mainTable" class="table table-bordered table-striped dataTable">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Aanvraag nr</th>
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
                        </div>
                        <div class="tab-pane" id="tab_2">
                            <table id="mainTable" class="table table-bordered table-striped dataTable">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Aanvraag nr</th>
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
                                foreach ($bestellingAfgekeurd as $r) {
                                    echo '<tr class="clickable-row" id =' . $r->id . ' naam ="' . $r->bstl_te_bestellen . '"">
                          <td>' . $count . '</td>
                          <td>' . $r->aanvraag_nr . '</td>
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
                        </div>
                    </div>
                </div>


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
                $('.inputDisabled').attr('href', "apps/<?php echo app_name;?>/modals/historie/bestelling.php?action=update&id=" + $(this).attr('id'));

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