<?php require_once(TEMPLATE_PATH . 'header.include.php');
require_once('php/functions.php');
include('domain/Aanvragenparts.php');
?>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Sparepart </h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">
            <!-- Searh Criteria -->
            <div class="row mb-3" style="margin-bottom: 3rem;">
                <div class="col-md-5">
                    <form class="form-inline" id="categoryForm" action="" method="POST">
                        <div class="form-group">
                            <label for="categorie">Choose a category</label>
                            <select name="categorie" id="categrorie" required class="form-control">
                                <?php foreach ($catogorien as $categorie) : ?>
                                    <option value="<?= $categorie->categorienr; ?>" <?php if ($_POST['categorie'] == $categorie->categorienr) echo 'selected="selected"'; ?>><?= $categorie->categorienaam; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" id="detailCheck" name="detailCheck" value="J" onclick="check(this)"> Detail

                        </div>
                        <br>
                        <div class="form-group">
                            <input type="submit" value="Search" name="categorieSubmit" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
            <!---------------------- table toolbar start ------------------------------->
            <?php if (hasPermissionPDO($mis_connPDO, $activemenuitem['id'], 'UPDATE')) { ?>
                <div id="showinfo" class="alert alert-danger" style="display:none;">
                    <i class="fa fa-ban"></i>
                    <b>Alert!</b>
                    <div id="wijzigVerwijder"></div>
                </div>
            <?php

        } ?>
            <?php if (hasPermissionPDO($mis_connPDO, $activemenuitem['id'], 'INSERT')) { ?>
                <a data-toggle="modal" href="apps/<?php echo app_name; ?>/modals/assetpart.php?action=new" data-target="#remoteModal">
                    <button class="btn btn-primary btn-sm"> Insert</button>
                </a>
            <?php

        } ?>
            <?php if (hasPermissionPDO($mis_connPDO, $activemenuitem['id'], 'INSERT')) { ?>
                <a data-toggle="modal" href="apps/<?php echo app_name; ?>/modals/assetpart_multi.php?action=multi" data-target="#remoteModal">
                    <button class="btn btn-primary btn-sm"> Insert Multiple</button>
                </a>
            <?php

        } ?>
            <?php if (hasPermissionPDO($mis_connPDO, $activemenuitem['id'], 'UPDATE')) { ?>
                <button disabled data-toggle="modal" href="" data-target="#remoteModal" class="btn btn-warning btn-sm inputDisabled"> Update
                </button>
            <?php

        } ?>
            <?php if (hasPermissionPDO($mis_connPDO, $activemenuitem['id'], 'DELETE')) { ?>
                <button disabled class="btn btn-danger btn-sm inputDisabledDelete" data-href="" data-toggle="modal" data-target="#confirm-delete" href="#"> Delete
                </button>
            <?php

        } ?>
            <p>
                <div id="detailTable">
                    <!---------------------- table toolbar end ------------------------------->
                    <table class="table table-bordered table-striped dataTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Manufacturer</th>
                                <th>Description</th>
                                <th>Serienr</th>
                                <th>Partnr</th>
                                <th>Revision</th>
                                <th>Article</th>
                                <th>Price</th>
                                <th>Remark</th>
                                <th>Return</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $count = 1;
                            foreach ($assetparts as $part) :
                                /*
                        $mynewquery = 'serienr="'. $item->serienr. '"';
                        $avnrs = Aanvragenparts::whereRaw($mynewquery)->get();
                        $snrs = array();
                        for ($idx=0; $idx<count($avnrs);$idx++) {
                            $snrs[] = $avnrs[$idx]->aanvraagnr;
                        }
                        $snrsvar = implode('<br>', $snrs);
                     */
                                // getArtikelCount($part->artikelcode)



                                ?>
                                <tr class="clickable-row" id=<?= $part->assetpartnr ?> naam="<?= $part->assetpartnr ?>">
                                    <td><?= $count ?></td>
                                    <td><?= getFabrikant('fabrikantid', $part->fabrikantid) ?></td>
                                    <td><?= $part->assetnaam; ?></td>
                                    <td><?= $part->serienr; ?></td>
                                    <td><?= $part->partnr; ?></td>
                                    <td><?= $part->revisioncode; ?></td>
                                    <td><?= $part->artikelcode;  ?></td>
                                    <td><?= $part->prijs; ?> </td>
                                    <td><?= $part->opmerking; ?></td>
                                    <td><?= $part->return_opm; ?></td>
                                </tr>

                                <?php $count++;
                            endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div id="countTable">
                    <table class="table table-bordered table-striped dataTable">
                        <thead>
                            <tr>
                                <th>Article</th>
                                <th>Decription</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $count = 1;
                            foreach ($assetpartsForCount as $part) :

                                ?>
                                <tr class="clickable-row" id=<?= $part->assetpartnr ?> naam="<?= $part->assetpartnr ?>">
                                    <td><?= $part->artikelcode;  ?></td>
                                    <td><?= getArtikelName($part->artikelcode)->assetnaam  ?></td>
                                    <td><?= getArtikelCount($part->artikelcode) ?> </td>
                                </tr>

                                <?php $count++;
                            endforeach; ?>
                        </tbody>
                    </table>
                </div>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
    <!-- Modal -->
    <div class="modal fade" id="remoteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
    //init tables
    $('#countTable').show();
    $('#mainTable').show();

    $(document).ready(function() {





        $('#detailTable tr').click(function(event) {
            $(this).addClass('active').siblings().removeClass('active');

            $('.inputDisabled').prop("disabled", false); // Element(s) are now enabled.
            $('.inputDisabled').attr('href', "apps/<?php echo app_name; ?>/modals/assetpart.php?action=update&id=" + $(this).attr('id'));

            $('.inputDisabledDelete').prop("disabled", false); // Element(s) are now enabled.
            $('.inputDisabledDelete').attr('data-href', "apps/<?php echo app_name; ?>/assetpart.php?action=delete&id=" + $(this).attr('id'));

            $('#wijzigVerwijder').empty();
            $('#wijzigVerwijder').append('U heeft "' + $(this).attr('naam') + '"geselecteerd, u kunt nu wijzigen of verwijderen!');
            //$("#showinfo").show();

        });
        $('#mainTable').on('click', '.clickable-row', function(event) {
            $(this).addClass('active').siblings().removeClass('active');
        });
        $("#countTable table").dataTable()
        $("#detailTable table").dataTable()
        $("#detailCheck").prop('checked', true)

        if ($('#detailCheck').iCheck('update')[0].checked) {
            $("#mainTable").DataTable().clear().destroy();
            var totalRecordsCount = $("#countTable table").DataTable().page.info().recordsTotal;
            var totalRecordsDetail = $("#detailTable table").DataTable().page.info().recordsTotal;

            (totalRecordsCount === 0) ? $("#countTable").hide(): $("#countTable").show();
            (totalRecordsDetail === 0) ? $("#detailTable").hide(): $("#detailTable").show();
        }

    })
</script>
<?php require_once(TEMPLATE_PATH . 'footer.include.php'); ?>