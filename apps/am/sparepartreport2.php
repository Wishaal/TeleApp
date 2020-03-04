<?php
include('php/config.php');

$menuid = menu;

require_once('../../php/conf/config.php');
require_once('../../inc_topnav.php');
require_once('../../inc_sidebar.php');

//add domain
include('domain/Artikel.php');
include('domain/Assetpart.php');
$zoekinvoer = "";
if ($_POST['begindatum'] == "") $_POST['begindatum'] = date('Y-m-d', strtotime('first day of last year'));
if ($_POST['einddatum'] == "") $_POST['einddatum'] = date('Y-m-d');
if ($_POST['begindatum'] != "" or $_POST['einddatum'] != "") {
    $zoekinvoer = " and artikelcode IN ( select artikelcode from assetpart where 1=1 " .
        (($_POST['begindatum'] != "") ? " and created_at>='" . addslashes($_POST['begindatum']) . " 00:00:00'" : "") .
        (($_POST['einddatum'] != "") ? " and created_at<='" . addslashes($_POST['einddatum']) . " 00:00:00'" : "") .
        ")";
}

$mynewquery = " 1=1 " . ((($_POST['artikelcode']) > "") ? " and artikelcode LIKE '%" . addslashes($_POST['artikelcode']) . "%'" : "") . $zoekinvoer;
$resultaten = "";

if (($_SERVER['REQUEST_METHOD'] == 'POST')) {
    $Artikelen = Artikel::whereRaw($mynewquery)->get();

    $count = 1;
    foreach ($Artikelen as $r) {
        $assetparts = Assetpart::where("artikelcode", "=", $r->artikelcode)->where("statusnr", "=", '1')->count();
        $insertparts = Assetpart::where("artikelcode", "=", $r->artikelcode)->where("created_at", ">=", addslashes($_POST['begindatum']))->where("created_at", "<=", addslashes($_POST['einddatum']))->get();
        $insertpartsserial = array();
		$insertpartspartnr = array();
        foreach ($insertparts as $rr) {
            $insertpartsserial[] = $rr->serienr;
			$insertpartspartnr[] = $rr->partnr;
        }
        $ips = implode($insertpartsserial, "<br>");
		
		$ipp = array_unique($insertpartspartnr);
		$ippp = array();
		for ($idx=0; $idx<count($ipp); $idx++) {
			$ippcount = Assetpart::where("artikelcode", "=", $r->artikelcode)->where("created_at", ">=", addslashes($_POST['begindatum']))->where("created_at", "<=", addslashes($_POST['einddatum']))->where("partnr", "=", $ipp[$idx])->get()->count();
			if (!empty($ippcount)) {
				$ippp[] = $ipp[$idx]. " (". $ippcount. ")";
			}
		}
		$ipppp = implode($ippp,"<br>");
		$detailipp1 = '<td><nobr>' . $ipppp . '</nobr></td>';
		$detailipp2 = '<th>Partnr</th>';

        if ($_POST['detailtype'] == 'serienr') {
            $detailips1 = '<td>' . $ips . '</td>';
            $detailips2 = '<th>Serial</th>';
        }

        $resultaten .= '<tr>
					<td>' . $count . '</td>
					<td>' . $r->artikelcode . '</td>
					<td>' . $r->artikelnaam . '</td>
					<td>' . $r->minvoorraad . '</td>
					<td>' . $assetparts . '</td>
					<td>' . count($insertparts) . '</td>
					' . $detailipp1 . '
					' . $detailips1 . '
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
			  <h3 class="box-title">Inserted Sparepart per period</h3>
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
				  <th>Code</th>
				  <th>Description</th>
				  <th>Minimum</th>
				  <th>Stock</th>
				  <th>Inserted</th>
				  ' . $detailipp2 . '
				  ' . $detailips2 . '
				</tr> 
			  </thead> 
			  <tbody>' . $resultaten . '</tbody> 
			</table>
			</div><!-- /.box-body -->
		  </div><!-- /.box -->
		  <!-- Modal -->
		<!-- /.modal -->
		</section><!-- /.content -->';

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
    $mpdf->Output('Inserted_Sparepart_per_period.pdf', 'D');
    exit;
    die();
}
if ($_POST[reporttype] == "xls") {
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment;Filename=Inserted_Sparepart_per_period.xls");
    echo strip_tags($tweededeel, "<h3><table><th><tr><td><br>");
    die();
}

require_once(TEMPLATE_PATH . 'header.include.php');
?>

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Inserted Sparepart per period</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <form class="form-horizontal" action="" method="post" name="inputform" id="inputform"
                          onSubmit="return validateForm()">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="artikelcode">Article</label>
                            <div class="col-sm-10">
                                <input type="text" id="artikelcode" class="form-control" name="artikelcode"
                                       value="<?php if (isset($_POST['artikelcode'])) {
                                           echo $_POST['artikelcode'];
                                       } ?>"/>
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
                            <label class="col-sm-2 control-label" for="detailtype">Toon Serienr</label>
                            <div class="col-sm-10">
                                <input type="checkbox" id="detailtype" class="form-control" name="detailtype"
                                       value="serienr" <?php echo (!isset($_POST['detailtype'])) ? "" : " checked "; ?>/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="artikelcode">Reporttype</label>
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
                                           value="<?php echo count($Artikelen) ?>"/>
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