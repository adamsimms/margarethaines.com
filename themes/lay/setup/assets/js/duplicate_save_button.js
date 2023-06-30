jQuery(document).ready(function(){
    var $edit = jQuery('.edit-tag-actions');
    if( $edit.length > 0 ) {
        $edit.clone().insertBefore( '#gridder' );
    }


    if( jQuery('body').hasClass('post-php') ) {
        var scrolledDown = false;
        jQuery(document).on('scroll', function(){
            if( window.scrollY > 2500 && scrolledDown == false && jQuery('#post-body').hasClass('columns-2') ){
                scrolledDown = true
                cloneDown();
            } else if( window.scrollY <= 2500 && scrolledDown == true ){
                scrolledDown = false
                removeClone();
            }
        })
    }
    
    var cloneDown = function() {
        // console.log('yoo')
        var $clone = jQuery('#submitdiv').clone();
        $clone.insertAfter('#postbox-container-1').addClass('lay-publish-clone');
        $clone.find('input#publish').on('click', function(e){
            e.preventDefault();
            e.stopPropagation();
            jQuery('#postbox-container-1').not('.lay-publish-clone').find('input#publish').click()
        })
        $clone.find('input#original_publish').on('click', function(e){
            e.preventDefault();
            e.stopPropagation();
            jQuery('#postbox-container-1').not('.lay-publish-clone').find('input#original_publish').click()
        })
    }
    
    var removeClone = function() {
        // console.log('hmm')
        jQuery('.lay-publish-clone').remove();
    }

});

