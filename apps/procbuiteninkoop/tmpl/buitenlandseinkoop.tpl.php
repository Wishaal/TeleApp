<?php require_once(TEMPLATE_PATH . 'header.include.php'); ?>
    <section class="content">
        <!-- Default box -->
        <div class="nav-tabs-custom animated bounceInRight">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1-1" data-toggle="tab">Aanvragen toegekend aan mij!</a></li>
                <li><a href="#tab_2-2" data-toggle="tab">Alle aanvragen</a></li>
                <li class="pull-left header"><i class="fa fa-th"></i> Buitenlandse Aanvragen</li>
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
                    <!--                        --><?php //if (hasPermissionPDO($mis_connPDO,$activemenuitem['id'], 'INSERT')) { ?>
                    <!--                            <button disabled data-toggle="modal" href="" data-target="#remoteModal"-->
                    <!--                                    class="btn btn-primary btn-sm inputNew">Invoeren-->
                    <!--                            </button>-->
                    <!--                        --><?php //} ?>
                    <?php if (hasPermissionPDO($mis_connPDO, $activemenuitem['id'], 'UPDATE')) { ?>
                        <button disabled data-toggle="modal" href="" data-target="#remoteModal"
                                class="btn btn-warning btn-sm inputDisabled">Wijzigen
                        </button>
                    <?php } ?>
                    <!--                        --><?php //if (hasPermissionPDO($mis_connPDO,$activemenuitem['id'], 'DELETE')) { ?>
                    <!--                            <button disabled class="btn btn-danger btn-sm inputDisabledDelete" data-href="" data-toggle="modal"-->
                    <!--                                    data-target="#confirm-delete" href="#">DELETE-->
                    <!--                            </button>-->
                    <!--                        --><?php //} ?>
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
                            echo '<tr class="clickable-row" id="' . $r->getAanvraag->aanvraag_nr . '" naam ="' . $r->getAanvraag->aanvraag_nr . '" check="' . $r->getBuitenlandseInkoop->id . '" ">
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
                </div><!-- /.tab-pane -->
                <div class="tab-pane" id="tab_2-2">

                    <p>
                    <table id="" class="table table-bordered table-striped dataTable">
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
                        foreach ($buitenAll as $r) {
                            echo '<tr class="clickable-row" id="' . $r->getAanvraag->aanvraag_nr . '" naam ="' . $r->getAanvraag->aanvraag_nr . '" check="' . $r->getBuitenlandseInkoop->id . '" ">
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
                </div><!-- /.tab-pane -->
            </div><!-- /.tab-content -->
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

//                var attr = $(this).attr('check');
//                if (!attr) {
//                    $('.inputNew').prop("disabled", false); // Element(s) are now enabled.
//                    $('.inputNew').attr('href', "apps/<?php //echo app_name;?>///modals/buitenlandseinkoop.php?action=new&id=" + $(this).attr('id'));
//
//                    $('.inputDisabled').prop("disabled", true); // Element(s) are now enabled.
//
//                }else{
//                    $('.inputNew').prop("disabled", true); // Element(s) are now enabled.

                $('.inputDisabled').prop("disabled", false); // Element(s) are now enabled.
                $('.inputDisabled').attr('href', "apps/<?php echo app_name;?>/modals/buitenlandseinkoop.php?action=update&id=" + $(this).attr('id'));
                //'}


                $('.inputDisabledDelete').prop("disabled", false); // Element(s) are now enabled.
                $('.inputDisabledDelete').attr('data-href', "apps/<?php echo app_name;?>/buitenlandseinkoop.php?action=delete&id=" + $(this).attr('id'));

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