<!----- Create go to top code---->
		<a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button">
		<span class="glyphicon glyphicon-chevron-up"></span></a>		
<!----- End go to top code---->
<!----- Create global modal for delete---->
		<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
					</div>
					<div class="modal-body">
						<p>You are about to delete one record, this procedure is irreversible.</p>
						<p>Do you want to proceed?</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						<a href="#" class="btn btn-danger danger">Delete</a>
					</div>
				</div>
			</div>
		</div>
<!----- End global modal for delete---->
		<!-- jQuery 2.0.2 -->
		<script src="assets/_layout/js/jquery.min.js" type="text/javascript"></script>
        <!-- jQuery UI 1.10.3 -->
        <script src="assets/_layout/js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
        <script src="http://harvesthq.github.io/chosen/chosen.jquery.js"></script>
        <!-- Bootstrap -->
        <script src="assets/_layout/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="assets/_layout/js/typeahead.bundle.js" type="text/javascript"></script>
		<script src="assets/_layout/js/bootstrap-tagsinput.js" type="text/javascript"></script>
		<script>
	      $(function() {
	        $('.chosen-select').chosen();
	      });
	    </script>
		<!-- InputMask -->
        <script src="assets/_layout/js/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
        <script src="assets/_layout/js/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
        <script src="assets/_layout/js/plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>
        <!-- date-range-picker -->
        <!-- <script src="assets/_layout/js/moment.js" type="text/javascript"></script>
		<script src="assets/_layout/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>		
		<script src="assets/_layout/js/jquery-1.8.3.min.js" type="text/javascript"></script>		
		-->
		<script src="assets/_layout/js/bootstrap-datetimepicker.js" type="text/javascript"></script>

		<!-- DataTables -->
		<script src="assets/_layout/plugins/datatables/jquery.dataTables.min.js"></script>
		<script src="assets/_layout/plugins/datatables/dataTables.bootstrap.min.js"></script>

<!--        <script type="text/javascript" language="javascript" src="//cdn.datatables.net/1.10.3/js/jquery.dataTables.min.js"></script>-->
<!--        <script src="assets/_layout/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>-->
		<script src="assets/_layout/plugins/bootstrap-select/js/bootstrap-select.min.js"></script>
		<!-- Scroll to div -->
		<script src="assets/_layout/js/jquery.scrollTo.js" type="text/javascript"></script>
        <!-- iCheck -->
        <script src="assets/_layout/js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
		<!-- fullCalendar 2.2.5 -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
		<script src="assets/_layout/js/plugins/daterangepicker/daterangepicker.js"></script>
		<script src="assets/_layout/js/plugins/fullcalendar/fullcalendar.min.js"></script>
		<!-- charts -->
		<script src= "assets/_layout/js/chart/highcharts.js"></script>
		<script src="assets/_layout/js/chart/modules/exporting.js"></script>
        <!-- Modal plugin -->
		<script src="assets/_layout/js/modal.js" type="text/javascript"></script>
		<!-- AdminLTE App -->
        <script src="assets/_layout/js/AdminLTE/app.js" type="text/javascript"></script>
        <script src="assets/_layout/scripts/jquery.cookie.js" type="text/javascript"></script>

<!--		<script>-->
<!--		$(document).ready(function() {-->
<!--			if ($.cookie("pop") == null) {-->
<!--				$("#ageModal").modal("show");-->
<!--			$.cookie("pop", "2");-->
<!--			}-->
<!--		});-->
<!--		</script>-->

		<!-- Update content of remote modal, this code removes all cached data-->
		<script type="text/javascript">
		$(document).ready(function(){
			 $(window).scroll(function () {
					if ($(this).scrollTop() > 50) {
						$('#back-to-top').fadeIn();
					} else {
						$('#back-to-top').fadeOut();
					}
				});
				// scroll body to 0px on click
				$('#back-to-top').click(function () {
					$('#back-to-top').tooltip('hide');
					$('body,html').animate({
						scrollTop: 0
					}, 800);
					return false;
				});
		});
		</script>
		
		<script type="text/javascript">
		$(document).ready(function(){
			<?php if (empty($_SESSION['mis']['user']['badgenr'])){
				if (strpos($_SESSION['mis']['user']['username'],'namic') !== false) {

					} else { ?>
					$("#ProfileModal").modal('show');
					<?php }
		}?>

			 $(window).scroll(function () {
					if ($(this).scrollTop() > 5) {
						$('#back-to-top2').fadeIn();
					} else {
						$('#back-to-top2').fadeIn();
					}
				});
				// scroll body to 0px on click
				$('#back-to-top2').click(function () {
					$('#back-to-top2').tooltip('hide');
					$('body,html').animate({
						scrollTop: 0
					}, 800);
					return false;
				});
		});
		</script>


			<script>
				$('#myModal').on('hide.bs.modal', function(e) {
					$(this).removeData('bs.modal');
				});
			</script>
			<script>
			$('#remoteModal').on('hide.bs.modal', function(e) {
				$(this).removeData('bs.modal');
			});
		</script>
		<!--- This code is used to filter datatables --->
		 <script type="text/javascript">
           //Tab load based on url paramater
			$(function(){
			  var hash = window.location.hash;
			  hash && $('ul.nav a[href="' + hash + '"]').tab('show');
			});
			$(function() {
                $("#mainTable").dataTable({
				"sDom": '<"row view-filter"<"col-sm-12"<"pull-left"l><"pull-right"f><"clearfix">>>t<"row view-pager"<"col-sm-12"<"pull-left"i><"pull-right"p><"clearfix">>>',
				"bStateSave": true,
                "scrollX": true

				});
            });
			$(function() {
                $("#example1").dataTable();
            });

           $(function() {
               $("#table1").dataTable();
           });

           $(function() {
               $("#table2").dataTable();
           });
        </script>
		<!-- This code is used to show a modal when a user tries to delete a record -->
		 <script>
        $('#confirm-delete').on('show.bs.modal', function(e) {
            $(this).find('.danger').attr('href', $(e.relatedTarget).data('href'));
            
           // $('.debug-url').html('Delete: <strong>' + $(this).find('.danger').attr('href') + '</strong>');
        })
		 </script>
		<script type="text/javascript">
        $(function () {
            $('#datetimepicker8').datetimepicker();
            $('#datetimepicker9').datetimepicker();
            $("#datetimepicker8").on("dp.change",function (e) {
               $('#datetimepicker9').data("DateTimePicker").setMinDate(e.date);
            });
            $("#datetimepicker9").on("dp.change",function (e) {
               $('#datetimepicker8').data("DateTimePicker").setMaxDate(e.date);
            });
        });
    </script>



<!--		<div class="modal fade" id="ageModal" tabindex="-1" role="dialog" aria-labelledby="ageModalLabel" aria-hidden="true">-->
<!--		  <div class="modal-dialog">-->
<!--		    <div class="modal-content">-->
<!--		      <div class="modal-header">-->
<!--		        <h4 class="modal-title" id="ageModalLabel">Notificatie</h4>-->
<!--		      </div>-->
<!--		      <div class="modal-body">-->
<!--			  <h2>Maintenance</h2>-->
<!--			  <p>TeleApp,-->
<!--			  maakt hierbij bekend dat er in het kader van een verbeterde dienstverlening werkzaamheden zullen worden uitgevoerd omstreeks 07.00u op vrijdag 21 december 2018 tot en met 08.00u op vrijdag 21 december 2018 .</p>-->
<!--		      <p>Als gevolg hiervan zult u geen gebruik kunnen maken van TeleApp</p></div>-->
<!--		      <div class="modal-footer">-->
<!--		        <button type="button" class="btn btn-default" data-dismiss="modal">Gelezen</button>-->
<!--		      </div>-->
<!--		    </div>-->
<!--		  </div>-->
<!--		</div>-->


    <!-- Piwik 
	<script type="text/javascript">
	  var _paq = _paq || [];
	  _paq.push(['trackPageView']);
	  _paq.push(['enableLinkTracking']);
	  (function() {
	    var u="//telsur62a/piwik/";
	    _paq.push(['setTrackerUrl', u+'piwik.php']);
	    _paq.push(['setSiteId', 3]);
	    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
	    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
	  })();
	</script>

	<noscript><p><img src="//telsur62a/piwik/piwik.php?idsite=3" style="border:0;" alt="" /></p></noscript>-->
	<!---End Piwik Code -->
    </body>
</html>