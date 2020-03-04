<?php
include('php/config.php');
require_once('php/functions.php');

$menuid = menu;

require_once('../../php/conf/config.php');
require_once('../../inc_topnav.php');
require_once('../../inc_sidebar.php');

//add domain
include('domain/Rma.php');
include('domain/Statustype.php');
$mynewquery = ((($_POST['statusnr']) > "") ? " and statusnr = '" . addslashes($_POST['statusnr']) . "'" : "") . (($_POST['begindatum'] != "") ? " and reqdatum>='" . addslashes($_POST['begindatum']) . "'" : "") . (($_POST['einddatum'] != "") ? " and reqdatum<='" . addslashes($_POST['einddatum']) . "'" : "");
$resultaten = "";
$Statustype = Statustype::whereRaw(" statusnr between 200 and 220 ")->orderBy("statusnr")->get();

if (($_SERVER['REQUEST_METHOD'] == 'POST')) {
    $Rma = Rma::whereRaw(" 1=1 " . $mynewquery)->orderBy("reqdatum")->get();

    $count = 1;
    foreach ($Rma as $r) {
        $resultaten .= '<tr>
					<td>' . $count . '</td>
					<td>' . $r->rmanr . '</td>
					<td>' . $r->reqdatum . '</td>
					<td>' . getFabrikant('fabrikantid', $r->fabrikantid) . '</td>
					<td>' . $r->partnr . '</td>
					<td>' . $r->oronr . '</td>
					<td>' . $r->aantal . '</td>
					<td>' . getStatusType('statusnr', $r->statusnr) . '</td>
				  </tr>';
        $count++;
    }
}

$tweededeel = '
        <!-- Main content -->
        <section class="content">
          <!-- Default box -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">RMA per period</h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <p>
                <!---------------------- table toolbar end ------------------------------->
              <table id="mainTable" class="table table-bordered table-striped dataTable">
              <thead> 
                <tr> 
                  <th>#</th> 
                  <th>Repairnr</th>
                  <th>Requestdate</th>
				  <th>Vendor</th>
				  <th>Partnr</th>
				  <th>OROnr</th>
				  <th>Quantity</th>
				  <th>Status</th>
                </tr> 
              </thead> 
              <tbody>' . $resultaten . '</tbody> 
            </table>
            </div><!-- /.box-body -->
          </div><!-- /.box -->
          <!-- Modal -->
        <!-- /.modal -->
        </section><!-- /.content -->
	';

if ($_POST[reporttype] == "pdf") {
    $tweededeel = '
		<html>
			<head>
				<link href="assets/_layout/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
				<style>
				table, td, th {
					border: 0px solid black;
					text-align: left;
					font-size: 14px;
				}
				</style>		
			</head>
			<body>
		' . $tweededeel .
        '	</body>
		</html>';
    require_once("../../php/classes/MPDF57/mpdf.php");
    $mpdf = new mPDF('utf-8', 'A4', '', '', 20, 20, 40, 15, 10, 10);
    $mpdf->mirrorMargins = 0;
    $mpdf->WriteHTML($tweededeel);
    $mpdf->Output('Rma_per_period.pdf', 'D');
    exit;
    die();
}
if ($_POST[reporttype] == "xls") {
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment;Filename=Rma_per_period.xls");
    echo strip_tags($tweededeel, "<h3><table><th><tr><td><br>");
    die();
}

require_once(TEMPLATE_PATH . 'header.include.php');
?>

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">RMA per period</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <form class="form-horizontal" action="" method="post" name="inputform" id="inputform"
                          onSubmit="return validateForm()">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="statusnr">Status RMA</label>
                            <div class="col-sm-10">
                                <select id="statusnr" name="statusnr" class="form-control">
                                    <option value="">All</option>
                                    <?php
                                    foreach ($Statustype as $rs) {
                                        echo '<option value="' . $rs->statusnr . '" ' . ($_POST[statusnr] == $rs->statusnr ? ' selected ' : '') . '>' . $rs->statusnaam . '</option>';

                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="begindatum">Begindate</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="begindatum" type="text" name="begindatum"
                                       value="<?php echo (!isset($_POST['begindatum'])) ? date('Y-m-d', strtotime('first day of last month')) : $_POST['begindatum']; ?>"
                                       data-date="" data-date-format="YYYY-MM-DD" data-link-format="yyyy-mm-dd"
                                       data-link-field="begindatum" autocomplete="off" "/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="einddatum">Enddate</label>
                            <div class="col-sm-10">
                                <input type="text" id="einddatum" class="form-control" name="einddatum" data-date=""
                                       data-date-format="YYYY-MM-DD" data-link-format="yyyy-mm-dd"
                                       data-link-field="einddatum"
                                       value="<?php echo (!isset($_POST['einddatum'])) ? date('Y-m-d') : $_POST['einddatum']; ?>"
                                       autocomplete="off"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="reporttype">Reporttype</label>
                            <div class="col-sm-10">
                                <select id="reporttype" name="reporttype" class="form-control">
                                    <option value="screen">Screen</option>
                                    <option value="pdf">PDF</option>
                                    <option value="xls">Excel</option>
                                </select>
                            </div>
                        </div>
                        <?php if ($_SERVER['REQUEST_METHOD'] == 'POST') { ?>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for=>Aantal records</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly="readonly" class="form-control"
                                           value="<?php echo count($Rma) ?>"/>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for=></label>
                            <div class="col-sm-10">
                                <button class="btn btn-success" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php echo $tweededeel; ?>
    </div><!-- /.content-wrapper -->
    <script>
        $('#begindatum').datetimepicker({
            pickTime: false,
            weekStart: 1,
            todayBtn: 1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            minView: 2,
            forceParse: 0
        });

        $('#einddatum').datetimepicker({
            pickTime: false,
            weekStart: 1,
            todayBtn: 1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            minView: 2,
            forceParse: 0
        });
    </script>
<?php require_once(TEMPLATE_PATH . 'footer.include.php'); ?>