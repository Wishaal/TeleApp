<?php require_once(TEMPLATE_PATH . 'head.php'); ?>
<?php require_once(TEMPLATE_PATH . 'header_wrapper.php'); ?>
    <div class="wrapper row-offcanvas row-offcanvas-left">
        <?php require_once(TEMPLATE_PATH . 'sidebar.php'); ?>
        <!-- Right side column. Contains the navbar and content of the page -->
        <aside class="right-side">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>Wifi Hotspot dashboard</h1>
                <?php require_once(TEMPLATE_PATH . 'breadcrumb.tpl.php'); ?>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-header">
                                <!-- tools box -->
                                <div class="pull-right box-tools">
                                    <button class="btn btn-primary btn-sm pull-right" data-widget="collapse"
                                            data-toggle="tooltip" title="" style="margin-right: 5px;"
                                            data-original-title="Collapse"><i class="fa fa-minus"></i></button>
                                </div>
                                <!-- /. tools -->
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body table-responsive">
                                <script type="text/javascript">
                                    $(function () {
                                        Highcharts.chart('container', {
                                            title: {
                                                text: 'Telesur Wifi Hotspot dashboard',
                                                x: -20 //center
                                            },
                                            credits: {
                                                enabled: false
                                            },
                                            subtitle: {
                                                text: 'Source: merakihotspots',
                                                x: -20
                                            },
                                            xAxis: {
                                                categories: [<?php    $count = 0;    foreach ($data as $r) {
                                                    echo "'" . $r['dag'] . "',";
                                                }    ?>]
                                            },
                                            yAxis: {
                                                title: {
                                                    text: 'Aantal geregistreerde gebruikers'
                                                },
                                                plotLines: [{
                                                    value: 0,
                                                    width: 1,
                                                    color: '#808080'
                                                }]
                                            },
                                            tooltip: {
                                                valueSuffix: ' gebruikers'
                                            },
                                            legend: {
                                                layout: 'vertical',
                                                align: 'right',
                                                verticalAlign: 'middle',
                                                borderWidth: 0
                                            },
                                            series: [
                                                <?php
                                                $locations = $data->unique('location');
                                                foreach ($locations as $location){
                                                ?>
                                                {
                                                    name: "<?php echo $location->location;?>" ,
                                                   data: [<?php $count = 0;    foreach ($data as $r) {
                                                       if($location->location == $r->location){
                                                           echo $r['totaal'].",";
                                                       }else{
                                                           echo "0,";
                                                       }
                                                   } ?>]
                                                },
                                               <?php } ?>
                                            ]
                                        });
                                    });
                                </script>
                                <div id="container" style="min-width: 400px; height: 600px; margin: 0 auto"></div>

                            </div>
                        </div>
                    </div>
                </div>
            </section><!-- /.content -->
        </aside><!-- /.right-side -->
    </div>     <!-- ./wrapper -->
<?php require_once(TEMPLATE_PATH . 'footer.php'); ?>