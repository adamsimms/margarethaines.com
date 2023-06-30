var footer_options_showhide_settings = (function(){

	var initModule = function(){
		showhide_for_projects();
		jQuery('#all-projects').on('change', showhide_for_projects);
		jQuery('#individual-projects').on('change', showhide_for_projects);
		jQuery('#off-projects').on('change', showhide_for_projects);

		showhide_for_pages();
		jQuery('#all-pages').on('change', showhide_for_pages);
		jQuery('#individual-pages').on('change', showhide_for_pages);
		jQuery('#off-pages').on('change', showhide_for_pages);

		showhide_for_news();
		jQuery('#all-news').on('change', showhide_for_news);
		jQuery('#individual-news').on('change', showhide_for_news);
		jQuery('#off-news').on('change', showhide_for_news);

		showhide_for_categories();
		jQuery('#all-categories').on('change', showhide_for_categories);
		jQuery('#individual-categories').on('change', showhide_for_categories);
		jQuery('#off-categories').on('change', showhide_for_categories);
	};

	var showhide_for_projects = function(){
		var val = jQuery('#all-projects').is(':checked');
		if(val){
			jQuery(document.getElementById("lay_projects_footer").parentNode.parentNode).show();
		}
		else{
			jQuery(document.getElementById("lay_projects_footer").parentNode.parentNode).hide();
		}
	};

	var showhide_for_pages = function(){
		var val = jQuery('#all-pages').is(':checked');
		if(val){
			jQuery(document.getElementById("lay_pages_footer").parentNode.parentNode).show();
		}
		else{
			jQuery(document.getElementById("lay_pages_footer").parentNode.parentNode).hide();
		}
	};

	var showhide_for_news = function() {
		if( jQuery('#all-news').length > 0 ) {
			var val = jQuery('#all-news').is(':checked');
			if(val){
				jQuery(document.getElementById("lay_news_footer").parentNode.parentNode).show();
			}
			else{
				jQuery(document.getElementById("lay_news_footer").parentNode.parentNode).hide();
			}
		}
	}

	var showhide_for_categories = function(){
		var val = jQuery('#all-categories').is(':checked');
		if(val){
			jQuery(document.getElementById("lay_categories_footer").parentNode.parentNode).show();
		}
		else{
			jQuery(document.getElementById("lay_categories_footer").parentNode.parentNode).hide();
		}
	};

	return {
		initModule : initModule
	}
}());

jQuery(document).ready(function(){
	footer_options_showhide_settings.initModule();
});