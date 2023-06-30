var misc_options_showhide_settings = (function(){

	var initModule = function(){
		showhide_for_textformats_for_tablet();
		jQuery('#misc_options_textformats_for_tablet').on('change', showhide_for_textformats_for_tablet);

        showhide_for_news();
		jQuery('#misc_options_activate_news_feature').on('change', showhide_for_news);

        showhide_for_transitions();
        jQuery('#misc_options_navigation_transition_out').on('change', showhide_for_transitions)
        jQuery('#misc_options_navigation_transition_in').on('change', showhide_for_transitions)
	};

    var showhide_for_transitions = function() {
        var val1 = jQuery('#misc_options_navigation_transition_out').val()
        var val2 = jQuery('#misc_options_navigation_transition_in').val()
        var show1 = false;
        if( val1 != 'none' ) {
            show1 = true;
        }
        if( show1 ) {
            jQuery(document.getElementById("misc_options_navigation_transition_out_duration").parentNode.parentNode).show()
            jQuery(document.getElementById("misc_options_navigation_transition_out_easing").parentNode.parentNode).show()
        } else {
            jQuery(document.getElementById("misc_options_navigation_transition_out_duration").parentNode.parentNode).hide()
            jQuery(document.getElementById("misc_options_navigation_transition_out_easing").parentNode.parentNode).hide()
        }

        var show2 = false;
        if( val2 != 'none' ) {
            show2 = true;
        }
        if( show2 ) {
            jQuery(document.getElementById("misc_options_use_revealing_transition_on_first_visit").parentNode.parentNode).show();
            jQuery(document.getElementById("misc_options_navigation_transition_in_duration").parentNode.parentNode).show()
            jQuery(document.getElementById("misc_options_navigation_transition_in_easing").parentNode.parentNode).show()
        } else {
            jQuery(document.getElementById("misc_options_use_revealing_transition_on_first_visit").parentNode.parentNode).hide();
            jQuery(document.getElementById("misc_options_navigation_transition_in_duration").parentNode.parentNode).hide()
            jQuery(document.getElementById("misc_options_navigation_transition_in_easing").parentNode.parentNode).hide()
        }

        var show3 = false;
        if( val1.indexOf('up') != -1 || val1.indexOf('down') != -1 || val2.indexOf('up') != -1 || val2.indexOf('down') != -1 ) {
            show3 = true;
        }
        if( show3 == true ) {
            jQuery(document.getElementById("misc_options_navigation_transition_y_translate_desktop").parentNode.parentNode).show()
            jQuery(document.getElementById("misc_options_navigation_transition_y_translate_phone").parentNode.parentNode).show()
        } else {
            jQuery(document.getElementById("misc_options_navigation_transition_y_translate_desktop").parentNode.parentNode).hide()
            jQuery(document.getElementById("misc_options_navigation_transition_y_translate_phone").parentNode.parentNode).hide()
        }
        

    }

	var showhide_for_textformats_for_tablet = function(){
		var val = jQuery('#misc_options_textformats_for_tablet').is(':checked');
		if(val){
			jQuery(document.getElementById("misc_options_textformats_tablet_breakpoint").parentNode.parentNode).show();
		}
		else{
			jQuery(document.getElementById("misc_options_textformats_tablet_breakpoint").parentNode.parentNode).hide();
		}		
	};

    var showhide_for_news = function(){
		var val = jQuery('#misc_options_activate_news_feature').is(':checked');
		if(val){
			jQuery(document.getElementById("misc_options_news_feature_name").parentNode.parentNode).show();
            jQuery(document.getElementById("misc_options_news_feature_slug").parentNode.parentNode).show();
		}
		else{
			jQuery(document.getElementById("misc_options_news_feature_name").parentNode.parentNode).hide();
            jQuery(document.getElementById("misc_options_news_feature_slug").parentNode.parentNode).hide();
		}		
	};

	return {
		initModule : initModule
	}
}());

jQuery(document).ready(function(){
	misc_options_showhide_settings.initModule();
});