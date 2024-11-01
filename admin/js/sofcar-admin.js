function SofcarReset(){
	if(confirm(jQuery("#SofcarResetMsg").html())==true)jQuery("#SofcarResetFrm").submit();
}

jQuery(document).ready(function() {
 	jQuery('#widget_type').on('change', function (e) {
		if(jQuery('#widget_type').val()=="vehicle"){ jQuery('#widget_model').show(); }else{ jQuery('#widget_model').hide(); }
		if(jQuery('#widget_type').val()=="searcher"){ jQuery('#widget_result_width').show(); }else{ jQuery('#widget_result_width').hide(); }
	});
});
