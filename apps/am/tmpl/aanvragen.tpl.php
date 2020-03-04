<?php require_once(TEMPLATE_PATH . 'header.include.php');
require_once('php/functions.php');

include('domain/Optiepermissie.php');
$mynewquery = 'systeem="AM" AND systeempad="Aanvragen" AND optie="Accoord" AND gebruiker="' . $_SESSION[mis][user][username] . '"';
$accoordbutton = Optiepermissie::whereRaw($mynewquery)->count();

$mynewquery = 'systeem="AM" AND systeempad="Aanvragen" AND optie="Final" AND gebruiker="' . $_SESSION[mis][user][username] . '"';
$finalbutton = Optiepermissie::whereRaw($mynewquery)->count();

$mynewquery = 'systeem="AM" AND systeempad="Aanvragen" AND optie="FinalPrint" AND gebruiker="' . $_SESSION[mis][user][username] . '"';
$finalprintbutton = Optiepermissie::whereRaw($mynewquery)->count();

$mynewquery = 'systeem="AM" AND systeempad="Aanvragen" AND optie="Remark" AND gebruiker="' . $_SESSION[mis][user][username] . '"';
$remarkbutton = Optiepermissie::whereRaw($mynewquery)->count();

$mynewquery = 'systeem="AM" AND systeempad="Aanvragen" AND optie="Return" AND gebruiker="' . $_SESSION[mis][user][username] . '"';
$returnbutton = Optiepermissie::whereRaw($mynewquery)->count();
$returnrow = Optiepermissie::whereRaw($mynewquery)->get();
//print_r($returnrow[0]["categorie"]);

include('domain/Aanvragenparts.php');
include('domain/Werkorder.php');
?>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Request Sparepart </h3>
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
                    <a data-toggle="modal" href="apps/<?php echo app_name; ?>/modals/aanvragen.php?action=new"
                       data-target="#remoteModal">
                        <button class="btn btn-primary btn-sm"> Insert</button>
                    </a>
                    <a data-toggle="modal"
                       href="apps/<?php echo app_name; ?>/modals/aanvragen_multi.php?action=newmulti"
                       data-target="#remoteModal">
                        <button class="btn btn-primary btn-sm"> Insert Multiple</button>
                    </a>
                <?php } ?>
                <?php if (hasPermissionPDO($mis_connPDO, $activemenuitem['id'], 'UPDATE')) { ?>
                    <button disabled data-toggle="modal" href="" data-target="#remoteModal"
                            class="btn btn-warning btn-sm inputDisabled"> Update
                    </button>
                <?php } ?>
                <?php if (hasPermissionPDO($mis_connPDO, $activemenuitem['id'], 'DELETE')) { ?>
                    <button disabled class="btn btn-danger btn-sm inputDisabledDelete" data-href="" data-toggle="modal"
                            data-target="#confirm-delete" href="#"> Delete
                    </button>
                <?php } ?>
                <?php if (hasPermissionPDO($mis_connPDO, $activemenuitem['id'], 'UPDATE')) { ?>
                    <button disabled data-toggle="modal" href="" data-target="#remoteModal"
                            class="btn btn-warning btn-sm inputDisabledApproval"> Request Approval
                    </button>
                <?php } ?>
                <?php if ($accoordbutton >= 1) { ?>
                    <button disabled data-toggle="modal" href="" data-target="#remoteModal"
                            class="btn btn-warning btn-sm inputDisabledApprovaldone"> Approve
                    </button>
                    <button disabled data-toggle="modal" href="" data-target="#remoteModal"
                            class="btn btn-warning btn-sm inputDisabledCanceldone"> Cancel Request
                    </button>
                <?php } ?>
                <?php if ($finalbutton >= 1) { ?>
                    <button disabled data-toggle="modal" href="" data-target="#remoteModal"
                            class="btn btn-warning btn-sm inputDisabledFinalize"> Finalize Request
                    </button>
                <?php } ?>
                <?php if ($finalprintbutton >= 1) { ?>
                    <button disabled data-toggle="modal" href="" data-target="#remoteModal"
                            class="btn btn-warning btn-sm inputDisabledFinalizePrint"> Print Delivery
                    </button>
                <?php } ?>
                <?php if ($remarkbutton >= 1) { ?>
                    <button disabled data-toggle="modal" href="" data-target="#remoteModal"
                            class="btn btn-warning btn-sm inputDisabledRemark"> Update Remark
                    </button>
                <?php } ?>
                <?php if ($returnbutton >= 1) { ?>
                    <button disabled data-toggle="modal" href="" data-target="#remoteModal"
                            class="btn btn-warning btn-sm inputDisabledReturnSpare"> Return Spare
                    </button>
                <?php } ?>
                <p>
                    <!---------------------- table toolbar end ------------------------------->
                <table id="mainTable" class="table table-bordered table-striped dataTable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Requestnr</th>
                        <th>Date</th>
                        <th>Badgenr</th>
                        <th>Dept.</th>
                        <th>Article</th>
                        <th>Quantity</th>
                        <th>Serienr</th>
                        <th>Remark</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    $count = 1;
                    foreach ($Aanvragenen as $item) {
                        $mynewquery = 'aanvraagnr="' . $item->aanvraagnr . '"';
                        $avnrs = Aanvragenparts::whereRaw($mynewquery)->get();
                        $snrs = array();
                        for ($idx = 0; $idx < count($avnrs); $idx++) {
                            $snrs[] = $avnrs[$idx]->serienr;
                        }
                        $snrsvar = implode('<br>', $snrs);

                        $worec = Werkorder::whereRaw($mynewquery)->get();
                        $wonrs = array();
                        for ($idx = 0; $idx < count($worec); $idx++) {
                            $wonrs[] = $worec[$idx]->opmerking;
                        }
                        $wonrsvar = implode('<br>', $wonrs);

                        echo '<tr class="clickable-row" id =' . $item->aanvraagnr . ' naam ="' . $item->statusnr . '">
                            <td>' . $count . '</td>
                            <td>' . $item->aanvraagnr . '</td>
							<td>' . $item->aanvraagdatum . '</td>
							<td>' . getPersoneel('badgenr', $item->badgenr) . '</td>
							<td>' . getAfdeling('afdelingcode', $item->afdelingcode) . '</td>
							<td>' . getArtikel('artikelcode', $item->artikelcode) . '</td>
							<td>' . $item->aantal . '</td>
							<td>' . $snrsvar . '</td>
							<td>' . $item->opmerking . (!empty($wonrsvar) ? "<br>" . $wonrsvar : '') . '</td>
							<td>' . getStatusType('statusnr', $item->statusnr) . '</td>
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
                $('.inputDisabled').attr('href', "apps/<?php echo app_name;?>/modals/aanvragen.php?action=update&id=" + $(this).attr('id'));
                <?php } ?>

                $('.inputDisabledDelete').prop("disabled", false); // Element(s) are now enabled.
                $('.inputDisabledDelete').attr('data-href', "apps/<?php echo app_name;?>/aanvragen.php?action=delete&id=" + $(this).attr('id'));

                $('.inputDisabledApproval').prop("disabled", false); // Element(s) are now enabled.
                $('.inputDisabledApproval').attr('href', "apps/<?php echo app_name;?>/modals/werkorder.php?action=new&parent=aanvragen&id=" + $(this).attr('id'));

                $('.inputDisabledApprovaldone').prop("disabled", false); // Element(s) are now enabled.
                $('.inputDisabledApprovaldone').attr('href', "apps/<?php echo app_name;?>/modals/werkorder.php?action=approve&parent=aanvragen&id=" + $(this).attr('id'));

                $('.inputDisabledCanceldone').prop("disabled", false); // Element(s) are now enabled.
                $('.inputDisabledCanceldone').attr('href', "apps/<?php echo app_name;?>/modals/werkorder.php?action=cancelreq&parent=aanvragen&id=" + $(this).attr('id'));

                $('.inputDisabledFinalize').prop("disabled", false); // Element(s) are now enabled.
                $('.inputDisabledFinalize').attr('href', "apps/<?php echo app_name;?>/modals/aanvragenparts.php?action=finalize&parent=aanvragen&id=" + $(this).attr('id'));

                $('.inputDisabledFinalizePrint').prop("disabled", false); // Element(s) are now enabled.
                var waarde = $(this).attr('id')
                $('.inputDisabledFinalizePrint').click(function () {
                    window.open("apps/<?php echo app_name;?>/modals/aanvragenprint_pdf.php?id=" + waarde, 'ReportWindow', 'width=1000, height=800');
                });

                $('.inputDisabledRemark').prop("disabled", false); // Element(s) are now enabled.
                $('.inputDisabledRemark').attr('href', "apps/<?php echo app_name;?>/modals/aanvragenremark.php?action=updateremarks&id=" + $(this).attr('id'));

                $('.inputDisabledReturnSpare').prop("disabled", false); // Element(s) are now enabled.
                $('.inputDisabledReturnSpare').attr('href', "apps/<?php echo app_name;?>/modals/aanvragenreturn.php?action=returnpart&id=" + $(this).attr('id'));

                $('#wijzigVerwijder').empty();
                $('#wijzigVerwijder').append('U heeft "' + $(this).attr('naam') + '"geselecteerd, u kunt nu wijzigen of verwijderen!');
                //$("#showinfo").show();

                switch ($(this).attr('naam')) {
                    case "103":
                    case "100":
                        $('.inputDisabled').prop("disabled", true);
                        $('.inputDisabledDelete').prop("disabled", true);
                        $('.inputDisabledApproval').prop("disabled", true);
                        $('.inputDisabledApprovaldone').prop("disabled", true);
                        $('.inputDisabledFinalize').prop("disabled", true);
                        $('.inputDisabledFinalizePrint').prop("disabled", false);
                        $('.inputDisabledCanceldone').prop("disabled", true);
                        $('.inputDisabledReturnSpare').prop("disabled", false);
                        break;
                    case "101":
                        $('.inputDisabled').prop("disabled", true);
                        $('.inputDisabledDelete').prop("disabled", true);
                        $('.inputDisabledApproval').prop("disabled", true);
                        $('.inputDisabledApprovaldone').prop("disabled", false);
                        $('.inputDisabledFinalize').prop("disabled", true);
                        $('.inputDisabledFinalizePrint').prop("disabled", true);
                        $('.inputDisabledCanceldone').prop("disabled", false);
                        $('.inputDisabledReturnSpare').prop("disabled", true);
                        break;
                    case "102":
                        $('.inputDisabled').prop("disabled", false);
                        $('.inputDisabledDelete').prop("disabled", false);
                        $('.inputDisabledApproval').prop("disabled", false);
                        $('.inputDisabledApprovaldone').prop("disabled", true);
                        $('.inputDisabledFinalize').prop("disabled", true);
                        $('.inputDisabledFinalizePrint').prop("disabled", true);
                        $('.inputDisabledCanceldone').prop("disabled", true);
                        $('.inputDisabledReturnSpare').prop("disabled", true);
                        break;
                    case "104":
                        $('.inputDisabled').prop("disabled", true);
                        $('.inputDisabledDelete').prop("disabled", true);
                        $('.inputDisabledApproval').prop("disabled", true);
                        $('.inputDisabledApprovaldone').prop("disabled", true);
                        $('.inputDisabledFinalize').prop("disabled", false);
                        $('.inputDisabledFinalizePrint').prop("disabled", true);
                        $('.inputDisabledCanceldone').prop("disabled", false);
                        $('.inputDisabledReturnSpare').prop("disabled", true);
                        break;
                    default:
                }


            });
            $('#mainTable').on('click', '.clickable-row', function (event) {
                $(this).addClass('active').siblings().removeClass('active');
            });
        });
    </script>
<?php require_once(TEMPLATE_PATH . 'footer.include.php'); ?>