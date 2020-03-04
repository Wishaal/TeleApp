//jQuery.noConflict();
$(document).ready(function(){
	
	function resourceFilter() {
		var value = $('.werk-type input:checked').val();
		
		$('#resource option.extern').hide();
		$('#resource option.intern').hide();
		
		if(value == 1){
			$('#resource option.extern').hide();
			$('#resource option.intern').show();
		} else if(value == 2) {
			$('#resource option.extern').show();
			$('#resource option.intern').hide();
		}	
	}
	
	
	resourceFilter();
	
	$('.werk-type input').change(function() {
        resourceFilter();	
    });
	
});