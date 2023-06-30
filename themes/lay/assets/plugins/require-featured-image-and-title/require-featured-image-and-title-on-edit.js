jQuery(document).ready(function($) {
	var wasFocused = false;
	setInterval(detectWarn, 1000);
	detectWarn();
    function detectWarn() {
		if ($.find('#postimagediv').length !== 0) {
			var noFeaturedImg = false;
			var noTitle = false;

			if ($('#postimagediv').find('img').length === 0  ) {
				noFeaturedImg = true;
			}
			if ($('#title').val().trim() === '') {
				noTitle = true;
				if(!wasFocused){
					$('#title').focus();
				}
			}

			if(noTitle || noFeaturedImg){
				if ($('body').find("#warning-message").length===0) {
					$('h1').after('<div id="warning-message"></div>');
				}
				var msg;

				if (noFeaturedImg && noTitle) {
					msg = '<p><strong>This Project has no Project Thumbnail and no Title.</strong> Please set them.</p>';
					jQuery('#postimagediv').addClass('highlight');
					jQuery('#titlewrap').addClass('highlight');
				}
				else if(noFeaturedImg){
					msg = '<p><strong>This Project has no Project Thumbnail.</strong> Please set one.</p>';
					jQuery('#postimagediv').addClass('highlight');
					jQuery('#titlewrap').removeClass('highlight');
				}
				else if(noTitle){
					msg = '<p><strong>This Project has no Title.</strong> Please set one.</p>';
					jQuery('#postimagediv').removeClass('highlight');
					jQuery('#titlewrap').addClass('highlight');
				}

				$('#warning-message').addClass("error lay-cyan-border").html(msg);
				$('#publish').attr('disabled','disabled');
			} else {
				$('#warning-message').remove();
				$('#publish').removeAttr('disabled');
				jQuery('#postimagediv').removeClass('highlight');
				jQuery('#titlewrap').removeClass('highlight');
			}
		}
	}

});