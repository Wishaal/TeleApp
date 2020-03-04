//$.noConflict();
$(document).ready(function() {
	
	$("#inputform #btn_submit").click(function(){
		
		var error = '';
		
		$("#inputform input:not('.notrequired')").each(function(){
			
			var value = $(this).val().trim();		
			if(value == ""){
				$(this).addClass('error');
				error = 'sdadada';
			} else {
				$(this).removeClass('error');
			}
		});
		
		if(error != ''){
			$('.notice.error').show();
			return false;
		} else {
			$('.notice.error').hide();
			$("#inputform").submit();
			return false;
		}
		
		return false;
	});
	
	//$(".export_buttons a:last").hide();
			
});