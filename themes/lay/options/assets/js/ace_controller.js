var ace_controller = (function(){

	var jqueryMap = {
		$customHeadTextarea: null,
		$customCSSTextarea: null,
		$customDesktopCSSTextarea: null,
		$customMobileCSSTextarea: null,
		$customHTMLTopTextarea: null,
		$customHTMLBottomTextarea: null
	};

	var initCustomHTMLTopEditor = function(){
		var editor = ace.edit("lay-custom-htmltop-editor");
	    editor.setTheme("ace/theme/xcode");
	    editor.getSession().setMode("ace/mode/html");
	    editor.setShowPrintMargin(false);
	    document.getElementById('lay-custom-htmltop-editor').style.fontSize='16px';

	    var val = jqueryMap.$customHTMLTopTextarea.val();
	    editor.setValue(val);
	    editor.clearSelection();

	    editor.getSession().on('change', function(e) {
	        // e.type, etc
	        val = editor.getValue();
	        // console.log(val);
	        jqueryMap.$customHTMLTopTextarea.val(val);
	    });
	};

	var initCustomHTMLBottomEditor = function(){
		var editor = ace.edit("lay-custom-htmlbottom-editor");
	    editor.setTheme("ace/theme/xcode");
	    editor.getSession().setMode("ace/mode/html");
	    editor.setShowPrintMargin(false);
	    document.getElementById('lay-custom-htmlbottom-editor').style.fontSize='16px';

	    var val = jqueryMap.$customHTMLBottomTextarea.val();
	    editor.setValue(val);
	    editor.clearSelection();

	    editor.getSession().on('change', function(e) {
	        // e.type, etc
	        val = editor.getValue();
	        // console.log(val);
	        jqueryMap.$customHTMLBottomTextarea.val(val);
	    });
	};

	var initCustomHeadEditor = function(){
		var editor = ace.edit("lay-custom-head-content-editor");
	    editor.setTheme("ace/theme/xcode");
	    editor.getSession().setMode("ace/mode/html");
	    editor.setShowPrintMargin(false);
	    document.getElementById('lay-custom-head-content-editor').style.fontSize='16px';

	    var val = jqueryMap.$customHeadTextarea.val();
	    editor.setValue(val);
	    editor.clearSelection();

	    editor.getSession().on('change', function(e) {
	        // e.type, etc
	        val = editor.getValue();
	        // console.log(val);
	        jqueryMap.$customHeadTextarea.val(val);
	    });
	};

	var initCustomCSSEditor = function() {
		var editor = ace.edit("lay-custom-css-editor");
	    editor.setTheme("ace/theme/xcode");
	    editor.getSession().setMode("ace/mode/css");
	    editor.setShowPrintMargin(false);
	    document.getElementById('lay-custom-css-editor').style.fontSize='16px';

	    var val = jqueryMap.$customCSSTextarea.val();
	    editor.setValue(val);
	    editor.clearSelection();

	    editor.getSession().on('change', function(e) {
	        // e.type, etc
	        val = editor.getValue();
	        // console.log(val);
	        jqueryMap.$customCSSTextarea.val(val);
	    });	
	}

	var initCustomDesktopCSSEditor = function(){
		var editor = ace.edit("lay-custom-css-desktop-editor");
	    editor.setTheme("ace/theme/xcode");
	    editor.getSession().setMode("ace/mode/css");
	    editor.setShowPrintMargin(false);
	    document.getElementById('lay-custom-css-desktop-editor').style.fontSize='16px';

	    var val = jqueryMap.$customDesktopCSSTextarea.val();
	    editor.setValue(val);
	    editor.clearSelection();

	    editor.getSession().on('change', function(e) {
	        // e.type, etc
	        val = editor.getValue();
	        // console.log(val);
	        jqueryMap.$customDesktopCSSTextarea.val(val);
	    });
	};

	var initCustomMobileCSSEditor = function(){
		var editor = ace.edit("lay-custom-css-mobile-editor");
	    editor.setTheme("ace/theme/xcode");
	    editor.getSession().setMode("ace/mode/css");
	    editor.setShowPrintMargin(false);
	    document.getElementById('lay-custom-css-mobile-editor').style.fontSize='16px';

	    var val = jqueryMap.$customMobileCSSTextarea.val();
	    editor.setValue(val);
	    editor.clearSelection();

	    editor.getSession().on('change', function(e) {
	        // e.type, etc
	        val = editor.getValue();
	        // console.log(val);
	        jqueryMap.$customMobileCSSTextarea.val(val);
	    });
	};

	var setJqueryMap = function(){
		jqueryMap.$customHeadTextarea = jQuery('#misc_options_analytics_code');
		jqueryMap.$customCSSTextarea = jQuery('#custom_css');
		jqueryMap.$customDesktopCSSTextarea = jQuery('#misc_options_desktop_css');
		jqueryMap.$customMobileCSSTextarea = jQuery('#misc_options_mobile_css');
		jqueryMap.$customHTMLTopTextarea = jQuery('#misc_options_custom_htmltop');
		jqueryMap.$customHTMLBottomTextarea = jQuery('#misc_options_custom_htmlbottom');
	};

	var initModule = function(){
		setJqueryMap();
		initCustomHeadEditor();
		initCustomCSSEditor();
		initCustomDesktopCSSEditor();
		initCustomMobileCSSEditor();
		initCustomHTMLTopEditor();
		initCustomHTMLBottomEditor();
	};

	return {
		initModule : initModule
	}

}());

jQuery(document).ready(function(){
	ace_controller.initModule();
});