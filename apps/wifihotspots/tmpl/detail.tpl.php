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
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Selecteer een tijdsperiode</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <form class="form-horizontal" action="" method="post" name="inputform" id="inputform"
                                      onSubmit="return validateForm()">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="datum1">Lokatie</label>
                                        <div class="col-sm-10">
                                            <select class="selectpicker form-control" id="location" data-live-search="true" name="location">
                                                <option>Kies een lokatie</option>
                                                <?php
                                                foreach ($locations as $r) {
                                                    if ($_POST['location'] == $r->location){
                                                        $sel = "selected=selected";
                                                    }else{
                                                        $sel = "";
                                                    }
                                                    echo '<option '.$sel. ' value="'.$r->location.'">' . $r->location . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="datum1">Begindatum</label>
                                        <div class="col-sm-10">
                                            <input type="text" id="datum1" class="form-control" name="datum1"
                                                   data-date=""
                                                   data-date-format="YYYY-MM-DD" data-link-format="yyyy-mm-dd"
                                                   data-link-field="datum1" value="<?php if (isset($_POST['datum1'])) {
                                                echo $_POST['datum1'];
                                            } ?>" autocomplete="off"/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="datum2">Einddatum</label>
                                        <div class="col-sm-10">
                                            <input type="text" id="datum2" class="form-control" name="datum2"
                                                   data-date=""
                                                   data-date-format="YYYY-MM-DD" data-link-format="yyyy-mm-dd"
                                                   data-link-field="datum2" value="<?php if (isset($_POST['datum2'])) {
                                                echo $_POST['datum2'];
                                            } ?>" autocomplete="off"/>
                                        </div>
                                    </div>
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
                <?php if ($_SERVER['REQUEST_METHOD'] == 'POST') { ?>
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
                                                    {
                                                        name: "<?php echo $data[0]['location'];?>" ,
                                                        data: [<?php    $count = 0;    foreach ($data as $r) { ?>

                                                            <?php echo $r['totaal'].',';?>

                                                            <?php } ?>]
                                                    }]

                                            });
                                        });
                                    </script>
                                    <div id="container" style="min-width: 400px; height: 600px; margin: 0 auto"></div>
                                </div>
                            </div>
                        </div>
                    </div>

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
                                    <h3 class="box-title">Geregistreerde gebruikers
                                                <a class="btn btn-success" href="apps/<?php echo app_name; ?>/exports/detail.php">Exporteren Naar
                                                    Excel</a></h3>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="" class="table table-bordered table-striped dataTable">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Mobielnummer</th>
                                            <th>Lokatie</th>
                                            <th>MAC</th>
                                            <th>IP</th>
                                            <th>Datum</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php

                                        $count = 1;
                                        foreach ($dataTable as $r) {

                                            echo '<tr> 

												<td>' . $count . '</td> 
												<td>' . $r['mobile'] . '</td> 
												<td>' . $r['location'] . '</td> 
												<td>' . $r['client_mac'] . '</td> 
												<td>' . $r['client_ip'] . '</td> 
												<td>' . $r['created_at'] . '</td> 
											</tr>';
                                            $count++;
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </section><!-- /.content -->
        </aside><!-- /.right-side -->
    </div>     <!-- ./wrapper -->
    <script type="text/javascript">
        $(function () {
            $('#datum1').datetimepicker({
                pickTime: false,
                weekStart: 1,
                todayBtn: 1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 2,
                minView: 2,
                forceParse: 0
            });
            $('#datum2').datetimepicker({
                pickTime: false,
                weekStart: 1,
                todayBtn: 1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 2,
                minView: 2,
                forceParse: 0
            });
        });
    </script>
<?php require_once(TEMPLATE_PATH . 'footer.php'); ?>