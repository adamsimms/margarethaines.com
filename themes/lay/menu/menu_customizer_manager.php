<?php 

class LayMenuCustomizerManager{

    public static $menu_amount;
    public static $menu_customizer_instances;

    public function __construct(){
        LayMenuCustomizerManager::$menu_amount = intval(get_option('misc_options_menu_amount', 1));
        LayMenuCustomizerManager::instantiate_menu_customizer();

        add_action( 'customize_register', array($this, 'register_panel'), 10 );
    }

    // register global panel
    public function register_panel($wp_customize){
        $wp_customize->add_panel( 'navigation_panel', array(
            'priority'       => 4,
            'capability'     => 'edit_theme_options',
            'theme_supports' => '',
            'title'          => 'Menu Style'
        ) );
    }

    public static function get_customizer_properties_for_js(){
        // one object that contains all infos for all 4 menus for:
        // hidewhenscrollingdown
        // hidewhenscrollingdown_show_on_mouseover
        // hide
        // nav_position

        return array(
            'nav_hidewhenscrollingdown' => CSS_Output::nav_get_hide_when_scrolling_down('primary'),
            'nav_hidewhenscrollingdown_second_menu' => CSS_Output::nav_get_hide_when_scrolling_down('second_menu'),
            'nav_hidewhenscrollingdown_third_menu' => CSS_Output::nav_get_hide_when_scrolling_down('third_menu'),
            'nav_hidewhenscrollingdown_fourth_menu' => CSS_Output::nav_get_hide_when_scrolling_down('fourth_menu'),
           
            'nav_hidewhenscrolling_show_on_mouseover' => get_theme_mod('nav_hidewhenscrolling_show_on_mouseover', 1) == 1 ? true : false,
            'nav_hidewhenscrolling_show_on_mouseover_second_menu' => get_theme_mod('nav_hidewhenscrolling_show_on_mouseover_second_menu', 1) == 1 ? true : false,
            'nav_hidewhenscrolling_show_on_mouseover_third_menu' => get_theme_mod('nav_hidewhenscrolling_show_on_mouseover_third_menu', 1) == 1 ? true : false,
            'nav_hidewhenscrolling_show_on_mouseover_fourth_menu' => get_theme_mod('nav_hidewhenscrolling_show_on_mouseover_fourth_menu', 1) == 1 ? true : false,
            
            'nav_fadeout_whenscrollingdown' => CSS_Output::nav_get_fadeout_when_scrolling_down('primary'),
            'nav_fadeout_whenscrollingdown_second_menu' => CSS_Output::nav_get_fadeout_when_scrolling_down('second_menu'),
            'nav_fadeout_whenscrollingdown_third_menu' => CSS_Output::nav_get_fadeout_when_scrolling_down('third_menu'),
            'nav_fadeout_whenscrollingdown_fourth_menu' => CSS_Output::nav_get_fadeout_when_scrolling_down('fourth_menu'),

            'nav_hide' => get_theme_mod('hide_primary_menu', 0),
            'nav_hide_second_menu' => get_theme_mod('hide_second_menu', 0),
            'nav_hide_third_menu' => get_theme_mod('hide_third_menu', 0),
            'nav_hide_fourth_menu' => get_theme_mod('hide_fourth_menu', 0),

            'nav_position' => get_theme_mod('nav_position', 'top-right'),
            'nav_position_second_menu' => get_theme_mod('nav_position_second_menu', 'top-right'),
            'nav_position_third_menu' => get_theme_mod('nav_position_third_menu', 'top-right'),
            'nav_position_fourth_menu' => get_theme_mod('nav_position_fourth_menu', 'top-right'),
        );

    }
    
    private static function instantiate_menu_customizer(){
        // instantiate menus, put them in the $menu_instances_array
        LayMenuCustomizerManager::$menu_customizer_instances = array();

        switch( LayMenuManager::$menu_amount ){
            case 1:
                $primary_menu_instance = new LayMenuCustomizer(PRIMARY_MENU);
                LayMenuCustomizerManager::$menu_customizer_instances []= $primary_menu_instance;
            break;
            case 2:
                $primary_menu_instance = new LayMenuCustomizer(PRIMARY_MENU);
                $second_menu_instance = new LayMenuCustomizer(SECOND_MENU);

                LayMenuCustomizerManager::$menu_customizer_instances []= $primary_menu_instance;
                LayMenuCustomizerManager::$menu_customizer_instances []= $second_menu_instance;
            break;
            case 3:
                $primary_menu_instance = new LayMenuCustomizer(PRIMARY_MENU);
                $second_menu_instance = new LayMenuCustomizer(SECOND_MENU);
                $third_menu_instance = new LayMenuCustomizer(THIRD_MENU);
                
                LayMenuCustomizerManager::$menu_customizer_instances []= $primary_menu_instance;
                LayMenuCustomizerManager::$menu_customizer_instances []= $second_menu_instance;
                LayMenuCustomizerManager::$menu_customizer_instances []= $third_menu_instance;
            break;
            case 4:
                $primary_menu_instance = new LayMenuCustomizer(PRIMARY_MENU);
                $second_menu_instance = new LayMenuCustomizer(SECOND_MENU);
                $third_menu_instance = new LayMenuCustomizer(THIRD_MENU);
                $fourth_menu_instance = new LayMenuCustomizer(FOURTH_MENU);
                
                LayMenuCustomizerManager::$menu_customizer_instances []= $primary_menu_instance;
                LayMenuCustomizerManager::$menu_customizer_instances []= $second_menu_instance;
                LayMenuCustomizerManager::$menu_customizer_instances []= $third_menu_instance;
                LayMenuCustomizerManager::$menu_customizer_instances []= $fourth_menu_instance;
            break;
        }
    }

}
new LayMenuCustomizerManager();