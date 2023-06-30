var cover_options_showhide_settings = (function(){

	var initModule = function(){
		showhide_for_arrowtype();
		jQuery('#cover_down_arrow_type').on('change', showhide_for_arrowtype);
	};

    var showhide_for_arrowtype = function() {
		var val = jQuery('#cover_down_arrow_type').val();
        switch( val ) {
            case 'custom':
                jQuery(document.getElementById("cover_down_arrow").parentNode.parentNode).show();
                jQuery(document.getElementById("cover_down_arrow_phone").parentNode.parentNode).show();
                jQuery(document.getElementById("cover_down_arrow_animate").parentNode.parentNode).show();
            break;
            case 'none':
                jQuery(document.getElementById("cover_down_arrow").parentNode.parentNode).hide();
                jQuery(document.getElementById("cover_down_arrow_phone").parentNode.parentNode).hide();
                jQuery(document.getElementById("cover_down_arrow_animate").parentNode.parentNode).hide();
            break;
            case 'black':
            case 'white':
                jQuery(document.getElementById("cover_down_arrow").parentNode.parentNode).hide();
                jQuery(document.getElementById("cover_down_arrow_phone").parentNode.parentNode).hide();
                jQuery(document.getElementById("cover_down_arrow_animate").parentNode.parentNode).show();
            break;
        }
    }

	return {
		initModule : initModule
	}
}());

jQuery(document).ready(function(){
	cover_options_showhide_settings.initModule();
});