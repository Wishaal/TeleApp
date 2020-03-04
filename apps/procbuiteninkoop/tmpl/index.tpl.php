<?php require_once(TEMPLATE_PATH . 'header.include.php'); ?>
    <section class="content">
        <div class="box animated bounceInRight">
            <div class="box-header with-border">
                <h3 class="box-title">Zoeken... </h3>
            </div>
            <div class="box-body">
                <form method="get" class="form-horizontal">
                    <div class="row">
                        <div class="col-md-8">
                            <input type="text" class="search-query form-control" id="search" name="search"
                                   placeholder="Zoeken op... aanvraagnummer, po nummer, contactpersoon, afdeling, aanvraagdatum, artikelcode, artikelomschrijving"/>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <select class="  search-query form-control" id="type" name="type">
                                    <option value="aanvraag">Aanvraag Informatie</option>
                                    <option value="leverancier">Leverancier</option>
                                </select>
                                <span class="input-group-btn">
                                            <button class="btn btn-danger btnSearch" type="button">
                                                <span class=" glyphicon glyphicon-search"></span>
                                            </button>
                                        </span>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-md-12">
                        <resultaat>
                            <div id='loadingmessage' style='display:none'>
                                <center><img src='assets/_layout/images/ajax-loader.gif'/></center>
                            </div>
                        </resultaat>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- /.content -->
    </aside><!-- /.right-side -->
    </div>
    <!-- ./wrapper -->
    <script type="text/javascript">
        $(document).ready(function () {

            $('.btnSearch').click(function () {
                if ($('#search').val() == '') {
                    $('#blank').show();
                }
                else {
                    $('#boxResult').show();
                    //$('#loadingmessage').show();
                    makeAjaxRequest();
                }
            });

            $('form').submit(function (e) {
                e.preventDefault();
                makeAjaxRequest();
                return false;
            });

            function makeAjaxRequest() {
                $('#loadingmessage').show();
                $.ajax({
                    url: 'apps/procbuiteninkoop/ajax/search.php',
                    type: 'get',
                    data: {name: $('input#search').val(), type: $('#type').val()},
                    success: function (response) {
                        $('resultaat').html(response);
                        $('#loadingmessage').hide(); //hide when data's ready
                    }
                });

            }
        });
    </script>
<?php require_once(TEMPLATE_PATH . 'footer.include.php'); ?>