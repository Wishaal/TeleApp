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


                <div class="row">
                    <h1>BEZIG MET ONDERHOUD</h1>
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

                <form class="form-horizontal" action="" method="POST" name="inputform" id="inputform">
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
                                <?php if ($wachtlijst == 1) { ?>
                                    <div class="form-group">
                                        <label class="col-sm-12 control-label"
                                               for="Woning">Wilt u op de Wachtlijst staan voor
                                            <br><?php echo $messageWachtlijst; ?>
                                            ?</label class="col-sm-2 control-label">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"></label><label>
                                            <input type="radio" name="wachtlijst" value="3" class="minimal"/>
                                            Ja
                                        </label>
                                    </div>
                                <?php } ?>

                            </div>
                            <div class="col-md-6">
                                <div id="image-zoom">
                                    <img class="img-thumbnail zoom" src=""
                                         alt="A.u.b. woning opnieuw kiezen om foto te bezichten">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <?php echo $message; ?>
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
        //		$(function() {
        //			$('input[name="daterange"]').daterangepicker({
        //				"autoApply": true,
        //				"dateLimit": {
        //					"days": 2
        //				},
        //				"minDate": "<?php //echo $sixMonthsBackDate = date("m/d/Y");?>//",
        //				"maxDate": "<?php
        //					$a_date = date("Y-m-t", strtotime("+3 months"));
        //					echo $sixMonthsBackDate = date("m/d/Y", strtotime($a_date));?>//"
        //			});
        //		});
    </script>
<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') { ?>
    <script>
        $(document).ready(function () {
            <?php if($modalshow == true){ ?>
            $("#woningModal").modal('show');
            <?php } ?>
        });
    </script>
<?php } ?>
<?php require_once(TEMPLATE_PATH . 'footer.php'); ?>