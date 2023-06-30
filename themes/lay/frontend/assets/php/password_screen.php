<?php

// import layout_controller from '../layout/layout_controller';

// var PasswordFormView = Backbone.Marionette.View.extend({
//     template: _.template(`
//         <div class="password-input-wrap">
//             <div class="password-input-wrap-inner">
//                 <input placeholder="Password" type="password" autocomplete="off"/><div class="password-ok">OK</div>
//             </div>
//         </div>`),
//     className: 'password-form',
//     events: {
//         'click .password-ok': 'onPasswordSubmit',
//         'keyup input': 'onKeyUp'
//     },
//     onKeyUp: function(event){
//         if(event.keyCode === 13){
//             this.triggerMethod('password:submit');
//         }
//     },
//     onPasswordSubmit: function(){
//        var password = this.$el.find('input').val();
//        layout_controller.showLayout(password);
//     }
// });

// export {PasswordFormView};

class Lay_Password_Screen{

    public function __construct(){

    }

    public static function postIsPassworded($id, $type){
        // show password protection
        // error_log(print_r($type, true));
        if( ($type == 'project' || $type == 'page') && post_password_required( $id ) ) {
            return true;
        }
        return false;
    }

    public static function getPasswordScreen(){
        return 
        '<div class="lay-content">
            <div class="password-form">
                <div class="password-input-wrap">
                    <div class="password-input-wrap-inner">
                        <input placeholder="Password" type="password" autocomplete="off"/><div class="password-ok">OK</div>
                    </div>
                </div>
            </div>
        </div>';
    }

    // modified version, taken from: class-wp-rest-posts-controller.php
    // returns 'accessible', 'wrongpassword' or 'protected'
	public static function getPasswordStatus( $id, $type, $password = '' ) {
        // only type post/project and page can be passworded
        if ( $type == 'category' ) {
            return 'accessible';
        }

        $post = get_post( $id );
        
        // error_log(print_r($post, true));

		if ( empty( $post->post_password ) ) {
			// No password required, can access content
			return 'accessible';
        }
        
        // admin always gets access
        // removed this as this confused users, they thought password protection was disabled
        // if( current_user_can( 'administrator' ) ){
        //     return 'accessible';
        // }

		// No password, no auth.
		if ( $password == '' ) {
			return 'protected';
		}

		// Double-check the request password.
		if(hash_equals( $post->post_password, $password )){
            return 'accessible';
        }else{
            return 'wrongpassword';
        }
	}

}