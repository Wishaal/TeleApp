<?php require_once(TEMPLATE_PATH . 'header.include.php'); ?>
    <section class="content">
        <!-- Default box -->
        <div class="box animated bounceInRight">
            <div class="box-header with-border">
                <h3 class="box-title">Binnenland Inbox Aanvragen </h3>
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
                <table id="mainTable" class="table table-bordered table-striped dataTable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>AANVRAAG #</th>
                        <th>AFDELING</th>
                        <th>ART. CODE</th>
                        <th>ART. NAAM</th>
                        <th>INGEVOERD DOOR</th>
                        <th>INGEVOERD DATUM</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $count = 1;
                    foreach ($buiten as $r) {
                        echo '<tr class="clickable-row" id="' . $r->getAanvraag->aanvraag_nr . '" naam ="' . $r->getAanvraag->aanvraag_nr . '" check="' . $r->getBinnenlandseInkoop->id . '" ">
                   <td>' . $count . '</td>
                    <td>' . $r->getAanvraag->aanvraag_nr . '</td>';
                        if (!empty($r->getBinnenlandseInkoop->id)) {
                            echo '<td>' . $r->getAanvraag->bstl_afdeling . '</td>
                                          <td>' . getArtikelCode($r->getAanvraag->bstl_artikelcode) . '</td>
                                          <td>' . $r->getAanvraag->bstl_omschrijving . '</td>
                                          <td>' . getProfileInfo($mis_connPDO, 'Name', $r->getAanvraag->bstl_ingevoerd_door) . '</td>
                                          <td>' . $r->created_at . '</td>';
                        } else {
                            echo '<td>' . $r->getAanvraag->bstl_afdeling . '</td>
                                          <td>' . getArtikelCode($r->getAanvraag->bstl_artikelcode) . '</td>
                                          <td>' . $r->getAanvraag->bstl_omschrijving . '</td>
                                          <td>' . getProfileInfo($mis_connPDO, 'Name', $r->getAanvraag->bstl_ingevoerd_door) . '</td>
                                          <td>' . $r->created_at . '</td>';
                        }
                        echo "</tr>";
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
                $('.inputDisabled').attr('href', "apps/<?php echo app_name;?>/modals/historie/binnenlandinbox.php?action=update&id=" + $(this).attr('id'));

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