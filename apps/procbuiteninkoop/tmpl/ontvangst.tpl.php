<?php require_once(TEMPLATE_PATH . 'header.include.php'); ?>
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Ontvangsten </h3>
            </div>
            <div class="box-body">
                <?php if (hasPermissionPDO($mis_connPDO, $activemenuitem['id'], 'UPDATE')) { ?>
                    <div id="showinfo" class="alert alert-danger" style="display:none;">
                        <i class="fa fa-ban"></i>
                        <b>Alert!</b>
                        <div id="wijzigVerwijder"></div>
                    </div>
                <?php } ?>
                <?php if (hasPermissionPDO($mis_connPDO, $activemenuitem['id'], 'UPDATE')) { ?>
                    <button disabled data-toggle="modal" href="" data-target="#remoteModal"
                            class="btn btn-warning btn-sm inputDisabled">Wijzigen
                    </button>
                <?php } ?>
                <p>
                <p>

                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs" id="myTab">
                        <li class="active"><a href="#tab_1" data-toggle="tab">Lokaal</a></li>
                        <li><a href="#tab_2" data-toggle="tab">Buitenland</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
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
                                foreach ($binnen as $r) {
                                    echo '<tr class="clickable-row" id="' . $r->getBinnenlandseInkoop->getOntvangstBinnenlandseInkoop->id . '" aanvraagID="' . $r->getAanvraag->id . '" type ="' . $r->type . '" naam ="' . $r->getAanvraag->aanvraag_nr . '" check="' . $r->getBinnenlandseInkoop->id . '" ">
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
                        </div>
                        <div class="tab-pane" id="tab_2">
                            <table id="secondTable" class="table table-bordered table-striped dataTable">
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
                                    echo '<tr class="clickable-row" id="' . $r->getBuitenlandseInkoop->getOntvangstBuitenlandseInkoop->id . '" type ="' . $r->type . '" aanvraagID="' . $r->getAanvraag->id . '" naam ="' . $r->getAanvraag->aanvraag_nr . '" check="' . $r->getBuitenlandseInkoop->id . '" ">
                                            <td>' . $count . '</td>
                                            <td>' . $r->getAanvraag->aanvraag_nr . '</td>';
                                    if (!empty($r->getBuitenlandseInkoop->id)) {
                                        echo '<td>' . $r->getAanvraag->bstl_afdeling . '</td>
                                                    <td>' . getArtikelCode($r->getAanvraag->bstl_artikelcode) . '</td>
                                                    <td>' . $r->getAanvraag->bstl_omschrijving . '</td>
                                                    <td>' . $r->getUser->username . '</td>
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
    <script>
        $('#myTab a').click(function (e) {
            e.preventDefault()
            $(this).tab('show')
        });

        // store the currently selected tab in the hash value
        $("ul.nav-tabs > li > a").on("shown.bs.tab", function (e) {
            var id = $(e.target).attr("href").substr(1);
            window.location.hash = id;
        });

        // on load of the page: switch to the currently selected tab
        var hash = window.location.hash;
        $('#myTab a[href="' + hash + '"]').tab('show');
    </script>
    <script type="text/javascript">
        $(document).ready(function () {

            //binnenland
            $('#mainTable tr').click(function (event) {
                $(this).addClass('active').siblings().removeClass('active');


                $('.inputDisabled').prop("disabled", false); // Element(s) are now enabled.
                $('.inputDisabled').attr('href', "apps/<?php echo app_name;?>/modals/ontvangst.php?action=update&id=" + $(this).attr('id') + "&type=" + $(this).attr('type') + "&aanvraagID=" + $(this).attr('aanvraagID'));


                $('#wijzigVerwijder').empty();
                $('#wijzigVerwijder').append('U heeft "' + $(this).attr('naam') + '"geselecteerd, u kunt nu wijzigen of verwijderen!');
                $("#showinfo").show();

            });
            $('#mainTable').on('click', '.clickable-row', function (event) {
                $(this).addClass('active').siblings().removeClass('active');
            });
            //buitenland
            $('#secondTable tr').click(function (event) {
                $(this).addClass('active').siblings().removeClass('active');

                $('.inputDisabled').prop("disabled", false); // Element(s) are now enabled.
                $('.inputDisabled').attr('href', "apps/<?php echo app_name;?>/modals/ontvangst.php?action=update&id=" + $(this).attr('id') + "&type=" + $(this).attr('type') + "&aanvraagID=" + $(this).attr('aanvraagID'));

                $('#wijzigVerwijder').empty();
                $('#wijzigVerwijder').append('U heeft "' + $(this).attr('naam') + '"geselecteerd, u kunt nu wijzigen of verwijderen!');
                $("#showinfo").show();

            });
            $('#secondTable').on('click', '.clickable-row', function (event) {
                $(this).addClass('active').siblings().removeClass('active');
            });
        });
    </script>
<?php require_once(TEMPLATE_PATH . 'footer.include.php'); ?>