<?php require_once(TEMPLATE_PATH . 'head.php'); ?>

<?php require_once(TEMPLATE_PATH . 'header_wrapper.php'); ?>
    <div class="wrapper row-offcanvas row-offcanvas-left">

        <?php require_once(TEMPLATE_PATH . 'sidebar.php'); ?>

        <!-- Right side column. Contains the navbar and content of the page -->
        <aside class="right-side">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Woningen-Verhuuradministratie
                    <small> Main</small>
                </h1>
                <?php require_once(TEMPLATE_PATH . 'breadcrumb.tpl.php'); ?>
            </section>
            <!-- Main content -->
            <section class="content">
                <?php
                if (!empty($showMessage)) {
                    echo '<div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <b>Alert!</b>' . $showMessage . '</div>';
                }
                ?>
                <div class="row">
                    <div class="col-md-6">
                        <button class="btn btn-danger btn" type="button" data-toggle="modal" data-target="#woningModal">
                            Klik hier om een woning te reserveren!
                        </button><p></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <!-- Custom Tabs -->
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tab_1" data-toggle="tab">Mijn Reserveringen</a></li>
                                <li><a href="#tab_2" data-toggle="tab">Wachtlijst</a></li>
                                <li><a href="#tab_3" data-toggle="tab">Historie</a></li>
                                <li class="pull-right"><i class="fa fa-gear"></i></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                    <table id="example1" class="table table-bordered table-striped dataTable">
                                        <thead>
                                        <tr>
                                            <th>Start</th>
                                            <th>Eind</th>
                                            <th>Locatie</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach ($reserveringen as $item) {
                                            $date = date_create($item['start']);
                                            $begin = date_format($date, 'd-M-y H:i:s');

                                            $date = date_create($item['end']);
                                            $end = date_format($date, 'd-M-y H:i:s');
                                            echo '<tr>
											<td>' . $begin . '</td>
											<td>' . $end . '</td>
											<td>' . $item['title'] . '</td>
											<td>' . $item['description'] . '</td>
											<td>
											 <a href="apps/woningen/mijnreserveringen.php?action=annulering&id=' . $item['id'] . '" class="btn btn-warning btn-sm">Annuleren</a>
											</td>
										</tr>';

                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="tab_2">
                                    <table id="example1" class="table table-bordered table-striped dataTable">
                                        <thead>
                                        <tr>
                                            <th>Start</th>
                                            <th>Eind</th>
                                            <th>Locatie</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach ($wachtlijsInfos as $item) {
                                            echo '<tr>
											<td>' . $item['start'] . '</td>
											<td>' . $item['end'] . '</td>
											<td>' . $item['title'] . '</td>
											<td>' . $item['description'] . '</td>
											<td>
											 <a href="apps/woningen/mijnreserveringen.php?action=annuleringWachtlijst&id=' . $item['id'] . '" class="btn btn-warning btn-sm">Annuleren</a>
											</td>
										</tr>';
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane" id="tab_3">
                                    <table id="example1" class="table table-bordered table-striped dataTable">
                                        <thead>
                                        <tr>
                                            <th>Start</th>
                                            <th>Eind</th>
                                            <th>Locatie</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach ($historie as $item) {

                                            echo '<tr>
											<td>' . $item['start'] . '</td>
											<td>' . $item['end'] . '</td>
											<td>' . $item['title'] . '</td>
											<td>' . $item['description'] . '</td>
										</tr>';

                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div>
                        <!-- nav-tabs-custom -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-6">
                        <div class="box box-primary">
                            <div class="box-body">
                                <!-- THE CALENDAR -->
                                <div id="calendar" class="fc fc-ltr fc-unthemed">
                                    <div class="fc-toolbar"></div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /. box -->
                    </div>
                    <!-- /.col -->
                </div>
            </section><!-- /.content -->
        </aside><!-- /.right-side -->
    </div><!-- ./wrapper -->
    <!-- Update content of remote modal, this code removes all cached data-->
    <div id="fullCalModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 id="modalTitle" class="modal-title"></h4>
                </div>
                <div id="modalBody" class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            //change image info in modal
            $('#w_id').on('change', function () {
                $('#image-zoom img').attr("src", $('option:selected', this).attr('myImg'));
            });

            // page is now ready, initialize the calendar...

            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                events: 'http://teleapp/telesur_mis/apps/woningen/json.php?type=<?php echo getEmployeeStatus($db, $_SESSION['mis']['user']['id']);?>'
                , eventClick: function (event, jsEvent, view) {
                    $('#modalTitle').html(event.title);
                    $('#modalBody').html(event.description);
                    $('#fullCalModal').modal();
                }
            })


        });
    </script>
    <!-- /.modal -->
    <div class="modal fade" id="woningModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <?php
                $employeeSoort = getEmployeeStatus($db, $_SESSION['mis']['user']['id']);

                if ($employeeSoort == 'STAF') {
                    $woningen = querySelectPDO($db, "SELECT *
												  FROM woningen a, woningSoort b,locaties c
												  where a.ws_id=b.ws_id and a.loc_id=c.loc_id and (a.ws_id='4' or a.ws_id='3')");
                } elseif ($employeeSoort == 'DIR') {
                    $woningen = querySelectPDO($db, "SELECT *
												  FROM woningen a, woningSoort b,locaties c
												  where a.ws_id=b.ws_id and a.loc_id=c.loc_id and (a.ws_id='2' or a.ws_id='3')");
                } else {
                    $woningen = querySelectPDO($db, "SELECT * FROM woningen a, woningSoort b,locaties c
													where a.ws_id=b.ws_id and a.loc_id=c.loc_id and (a.ws_id='1' or a.ws_id='3')");
                }
                ?>

                <form class="form-horizontal" name="inputform" method="post" id="inputform">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Woning reserveren</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"
                                           for="naam">Periode*</label class="col-sm-2 control-label">

                                    <div class="col-sm-8">
                                        <input type="text" name="daterange" id="daterange" data-date-format="yyyy-mm-dd"
                                               class="form-control" value="<?php echo $_POST['daterange']; ?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"
                                           for="Woning">Woning</label class="col-sm-2 control-label">

                                    <div class="col-sm-8">
                                        <select class="form-control" id="w_id" name="w_id" required="required">
                                            <option>Kies een woning!</option>
                                            <?php
                                            foreach ($woningen as $group) {
                                                echo '<option value=' . $group['w_id'] . ' myImg=' . $group['image'] . ' ' . ($group['w_id'] == $_POST['w_id'] ? 'selected="selected"' : "") . ' >' . $group['loc_omschrijving'] . ' ' . $group['w_code'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group" id="wachtlijstDisplay" style="display: none">
                                    <label class="col-sm-9 control-label"
                                           for="Woning">Op de wachtlijst staan?</label class="col-sm-2 control-label">

                                    <div class="col-sm-3">
                                        <label>
                                            <input type="radio" name="wachtlijst" value="1" class="minimal"/>
                                            Ja
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div id="image-zoom">
                                    <img class="img-thumbnail zoom" src=""
                                         alt="A.u.b. woning opnieuw kiezen om foto te bezichten">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="btn_submit">Save changes</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <script type="text/javascript">
        $(document).ready(function () {
            $('form').on('submit', function (e) {

                e.preventDefault();
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: "apps/woningen/rules.php",
                    data: $('form').serialize(),
                    success: function (message) {
                        if (message['wachtlijst'] != null) {
                            $("#wachtlijstDisplay").show();
                        } else {
                            $("#wachtlijstDisplay").hide();
                        }

                        if (message['error'].length === 0) {

                        } else {
                            alert(message['error'][0]);
                        }

                        if (message['status'].length === 0) {

                        } else {
                            alert(message['status'][0]);
                            $(location).attr('href', 'apps/woningen/mijnreserveringen.php');
                        }


                    },
                    error: function () {
                        alert("Error");
                    }
                });
            });
        });
        $(function () {
            $('input[name="daterange"]').daterangepicker({
                "autoApply": true,
                "dateLimit": {
                    "days": 2
                },
                "minDate": "12/31/2017",
                "maxDate": "<?php
                    $a_date = date("Y-m-d", strtotime("+3 months"));
                    echo $sixMonthsBackDate = date("m/d/Y", strtotime($a_date));?>"
                ,
                isInvalidDate: function (date) {
                    return (date.day() == 4) ? true : false;
                }
            });
        });

        $('input[name="daterange"]').click(function(){
            $("#wachtlijstDisplay").hide();
         });

        $("#w_id").change(function () {
            $("#wachtlijstDisplay").hide();
        });


    </script>
<?php require_once(TEMPLATE_PATH . 'footer.php'); ?>