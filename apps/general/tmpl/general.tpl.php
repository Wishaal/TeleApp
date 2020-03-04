	<?php require_once(TEMPLATE_PATH . 'head.php'); ?>
	
	<?php require_once(TEMPLATE_PATH . 'header_wrapper.php'); ?>
	<?php 
	$sql = "SELECT count(distinct(username)) as a ,DATEPART(HOUR,datum) uur
			FROM log_users where username > '' and datum between '" . date("Y-m-d") . " 00:00:00.000' and '" . date("Y-m-d") . " 23:59:59.000' 
			group by DATEPART(hour,datum)
			order by DATEPART(hour,datum)";
	$result = $mis_connPDO->query($sql);
	//$rows = $result->fetch(PDO::FETCH_NUM);
	$data = array();
	// Parse returned data, and displays them
	while($row = $result->fetch(PDO::FETCH_ASSOC)) {
		$data[] = $row;
	}
	
	
	$sql2 = "select count(*) as aantal ,browser,os from (Select  username,
			case 
			when browser like '%Internet%' then SUBSTRING(browser,0, 19) 
			when browser like '%Google%' then SUBSTRING(browser,0, 14)
			when browser like '%Fire%' then SUBSTRING(browser,0, 17)
			when browser like '%Unknown%' then SUBSTRING(browser,0, 8)
			 end as browser
			,os
			  FROM [telesur_mis].[dbo].[browsers_os] where username <> ''
			  group by username,browser,os
			) b group by browser,os";
	$result2 = $mis_connPDO->query($sql2);
	//$rows = $result->fetch(PDO::FETCH_NUM);
	$data2 = array();
	// Parse returned data, and displays them
	while($row = $result2->fetch(PDO::FETCH_ASSOC)) {
		$data2[] = $row;
	}
?>
<script type="text/javascript">
var x_labels = [<?php foreach($data as $item){	echo $item['uur'].","; 	} ?>]
$(function () {
        $('#container').highcharts({
            chart: {
                type: 'spline'
				
            },
            title: {
                text: 'Users online per hour'
            },
            xAxis: {
        title: {
            text: 'DATUM <?php echo date("Y-m-d");  ?>'
        },
        labels: {
            formatter: function() {
                return x_labels[this.value];
            }
        },
        showLastLabel: true,
    },credits: {
    enabled: false
  },
            yAxis: {
                min: 0,
                title: {
                    text: 'Totaal'
                }
            },
            tooltip: {
                crosshairs: true,
                shared: true
            },
             plotOptions: {
                spline: {
                    marker: {
                        radius: 4,
                        lineColor: '#666666',
                        lineWidth: 1
                    }
                }
            },
                series: [{
				marker: {
                    symbol: 'square'
                },
                name: 'Logins',
				//color: '#2C6700',
                data: [<?php foreach($data as $item){	echo $item['a'].","; 	} ?>]
            }]
        });
    }); 
	
	$(function () {

    $(document).ready(function () {

        // Build the chart
        $('#containerx').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
			credits: {
    enabled: false
  },
            title: {
                text: 'Browser usage till November, 2015'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
			 legend: {
            align: 'right',
            verticalAlign: 'top',
            y: 100,
            layout: 'vertical'
        },       

            series: [{
                name: "Brands",
                colorByPoint: true,
                data: [
				<?php foreach($data2 as $item){	?>
					{
						name: "<?php echo $item['browser'].' on '.$item['os'];?>",
						y: <?php echo $item['aantal'];?>
					},
				<?php } ?>]
            }]
        });
    });
});
	</script>
	 <div class="wrapper row-offcanvas row-offcanvas-left">

							<?php require_once(TEMPLATE_PATH . 'sidebar.php'); ?>
 

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        General
                        <small>Menu's & App settings</small>
                    </h1>
                    	<?php require_once(TEMPLATE_PATH . 'breadcrumb.tpl.php'); ?>
                </section>

                <!-- Main content -->
                <section class="content">
					<div class="row">                       
						<div class="col-xs-6">
							<div class="box">

							<div class="box-body">
								<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
							</div>
							</div>
						</div>
						<div class="col-xs-6">
							<div class="box">

							<div class="box-body">
								<div id="containerx" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
							</div>
							</div>
						</div>
					</div>
					<!-- Table -->
					<div class="row">
						<div class="col-xs-12">
						<div class="box box-primary">
							<div class="box-header">
								<!-- tools box -->
								<div class="pull-right box-tools">
										<button class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="" style="margin-right: 5px;" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
									</div><!-- /. tools -->
								<i class="fa fa-map-marker"></i>
								<h3 class="box-title">
									Users Online
								</h3>
							</div>
							<div class="box-body table-responsive">
								<div class="row">
									<div class="col-xs-12">
										<table class="table table-bordered table-striped dataTable" id="mainTable">
											<thead>
												<tr>
													<th>Username</th> 
													<th>IP Adress</th> 
													<th>Activity</th>
													<th>Last Seen at</th>
												</tr>
											</thead>
												<tbody>
													<!-- table data -->
													<?php
														$dataonlineusers = "SELECT * FROM online_users"; 
														$result_onlineusers = $mis_connPDO->query($dataonlineusers);
														//$rows = $result->fetch(PDO::FETCH_NUM);
														$datausers = array();
														// Parse returned data, and displays them
														while($row = $result_onlineusers->fetch(PDO::FETCH_ASSOC)) {
														$datausers[] = $row;
														}
													foreach($datausers as $r) {
													echo ' <tr>
															  <td>'.$r['username'].'</td>
															  <td>'.$r['ip_address'].'</td>
															  <td>'.$r['activity'].'</td>
															  <td>'.$r['datum'].'</td>
															</tr>';
														//$i++;
													}
													?>
												</tbody>
										</table>
										<!-- Modal -->
									<div class="modal fade" id="remoteModal" tabindex="-1" role="dialog" aria-labelledby="remoteModalLabel" aria-hidden="true">
										<div class="modal-dialog modal-lg">
											<div class="modal-content"></div>
										</div>
									</div>
									</div><!-- /.box-body-->
								</div>
							</div>
						</div><!-- /.box -->
						</div>
					</div>
				</section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
		
	
<?php require_once(TEMPLATE_PATH . 'footer.php'); ?>