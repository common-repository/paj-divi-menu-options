<?php
//  =============================================================
//  = pajdm Divi menu options Wordpress Plugin                    =
//  = For Help and Support please visit greenorbwebdesign.co.uk =
//  = Main pajdm Divi File                                        =
//  =============================================================

defined( 'ABSPATH' ) or die( 'No No No!' );

//Load Scripts needed
add_action( 'customize_preview_init', 'pajdm_customizer_script' );
function pajdm_customizer_script() {
	wp_enqueue_script(
		  'paj_customizer',
		   plugin_dir_url(__FILE__).'js/paj_customizer.js',
		  array( 'jquery','customize-preview' ),
		  '',
		  true
	);
}


function pajdm_load_header_scripts() {
wp_register_script ( 'pajdm-new-style-settings', plugins_url ( 'js/paj_style_update.js', __FILE__ ), array( 'jquery' ), '2.2.1', true );
}
add_action( 'wp_enqueue_scripts', 'pajdm_load_header_scripts' );


//  =============================
//  = Sanitize Functions        =
//  =============================
function pajdm_sanitize_integer( $input ) {
	if( is_numeric( $input ) ) {
		return intval( $input );
	}
}

function pajdm_sanitize_heading( $input ) {
    $input = '';
  	return ( $input );
}

function pajdm_sanitize_checkbox( $input ){
    //returns true if checkbox is checked
    return ( isset( $input ) ? true : false );
}


function pajdm_sanitize_radio( $input, $setting ){
    //input must be a slug: lowercase alphanumeric characters, dashes and underscores are allowed only
    $input = sanitize_key($input);

    //get the list of possible radio box options
    $choices = $setting->manager->get_control( $setting->id )->choices;

    //return input if valid or return default option
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}


//  =============================
//  = Create Customizer Section =
//  =============================
function pajdm_customize_register($wp_customize){
    $wp_customize->add_section('pajdm_divi_menu_extra', array(
        'title'    => esc_html__('PAJ Divi Menu Options', 'pajdm_divi'),
        'description' => '',
        'priority' => 500,
    ));

//  =============================
//  = Create Custom Controls    =
//  = Custom Headings Control   =
//  =============================
if( class_exists( 'WP_Customize_Control' ) ):
   	class pajdm_Customize_heading extends WP_Customize_Control {
		public $type = 'text';

        public function __construct( $manager, $id, $args = array() ) {
            parent::__construct( $manager, $id, $args );
             $defaults = array(
                'pajdm_heading' => '',
                'pajdm_description' => ''
            );

            $args = wp_parse_args( $args, $defaults );
            $this->pajdm_heading = $args['pajdm_heading'];
            $this->pajdm_description = $args['pajdm_description'];


        }

		public function render_content() { ?>
	        <h3 style="margin-bottom:0px;padding-top:0px;"><?php echo esc_html($this->pajdm_heading); ?></h3>
            <h5 style="margin:0px;"><?php echo esc_html($this->pajdm_description); ?></h5> <hr>
		<?php
		}
	}
endif;

//  =============================
//  = Custom Range Input        =
//  =============================
if( class_exists( 'WP_Customize_Control' ) ):
   	class pajdm_Customize_Range extends WP_Customize_Control {
		public $type = 'range';

        public function __construct( $manager, $id, $args = array() ) {
            parent::__construct( $manager, $id, $args );
            $defaults = array(
                'pajdm_reset' => 980,
                'min' => 0,
                'max' => 2000,
                'step' => 1
            );
            $args = wp_parse_args( $args, $defaults );

            $this->pajdm_reset = $args['pajdm_reset'];
            $this->min = $args['min'];
            $this->max = $args['max'];
            $this->step = $args['step'];
        }

		public function render_content() { ?>
		<label>
			<span class="customize-control-title" style="margin-bottom:-4px;"><?php echo esc_html__( $this->label ); ?></span>
			<input class='range-slider' min="<?php echo $this->min ?>" max="<?php echo $this->max ?>" step="<?php echo $this->step ?>" type='range' <?php $this->link(); ?> value="<?php echo esc_attr( $this->value() ); ?>" oninput="jQuery(this).next('input').val( jQuery(this).val() )">
            <input type="number" min="<?php echo $this->min ?>" max="<?php echo $this->max ?>" step="<?php echo $this->step ?>" class="et-pb-range-input" value="<?php echo esc_attr( $this->value() ); ?>" />
            <div class="reset-button"  onclick="jQuery(this).prevAll('input').val('<?php echo $this->pajdm_reset ?>'); jQuery(this).prevAll('input').change(); ">Reset</div>
		</label>
		<?php
		}
	}
endif;

 if (et_get_option( 'header_style', 'left' ) == 'left') {
    //  =============================
    //  = Breakpoint Heading        =
    //  =============================
    $wp_customize->add_setting( 'breakpoint_heading' , array('sanitize_callback' => 'pajdm_sanitize_heading'));
    $wp_customize->add_control( new pajdm_Customize_heading( $wp_customize, 'breakpoint_heading', array(
        'pajdm_heading'     => esc_html__('Divi Menu Breakpoint'),
	    'section' => 'pajdm_divi_menu_extra',
    ) ) );

    //  =============================
    //  = Breakpoint Slider         =
    //  =============================
    $wp_customize->add_setting( 'pajdm_menu_breakpoint' , array(
        'default'     => 980,
        'type'        => 'option',
        'transport'   => 'postMessage',
        'sanitize_callback' => 'pajdm_sanitize_integer',
    ) );

    $wp_customize->add_control( new pajdm_Customize_Range( $wp_customize, 'pajdm_menu_breakpoint', array(
	    'label'	=>  esc_html__('Menu Breakpoint'),
        'min' => 980,
        'max' => 1600,
        'step' => 1,
	    'section' => 'pajdm_divi_menu_extra',
        'settings' => 'pajdm_menu_breakpoint',
    ) ) );

} else {
    //  =============================
    //  = Not Left Heading        =
    //  =============================
    $wp_customize->add_setting( 'not_left_heading' , array('sanitize_callback' => 'pajdm_sanitize_heading'));
    $wp_customize->add_control( new pajdm_Customize_heading( $wp_customize, 'not_left_heading', array(
        'pajdm_heading'     => esc_html__('Divi Menu Breakpoint'),
        'pajdm_description'     => esc_html__('Please note the Divi Menu Breakpoint only works when the Header Style is in the default position.'),
	    'section' => 'pajdm_divi_menu_extra',
    ) ) );

}// end of if left header style

    //  =============================
    //  = DropDown Padding Heading  =
    //  =============================
    $wp_customize->add_setting( 'dropdown_padding_heading' , array('sanitize_callback' => 'pajdm_sanitize_heading'));
    $wp_customize->add_control( new pajdm_Customize_heading( $wp_customize, 'dropdown_padding_heading', array(
        'pajdm_heading'     => esc_html__('Dropdown menu padding'),
	    'section' => 'pajdm_divi_menu_extra',
    ) ) );

    //  ==================================
    //  = DropDown Padding Top & Bottom  =
    //  ==================================
    $wp_customize->add_setting( 'pajdm_menu_top_bottom' , array(
        'default'     => 20,
        'type'        => 'option',
        'transport'   => 'postMessage',
        'sanitize_callback' => 'pajdm_sanitize_integer',
    ) );

    $wp_customize->add_control( new pajdm_Customize_Range( $wp_customize, 'pajdm_menu_top_bottom', array(
	    'label'	=>  esc_html__('Top & Bottom Padding'),
        'pajdm_reset' => 20,
        'min' => 0,
        'max' => 40,
        'step' => 1,
	    'section' => 'pajdm_divi_menu_extra',
        'settings' => 'pajdm_menu_top_bottom',
    ) ) );

    //  ==================================
    //  = DropDown Padding Left & Right  =
    //  ==================================
    $wp_customize->add_setting( 'pajdm_menu_left_right' , array(
        'default'     => 20,
        'type'        => 'option',
        'transport'   => 'postMessage',
        'sanitize_callback' => 'pajdm_sanitize_integer',
    ) );

    $wp_customize->add_control( new pajdm_Customize_Range( $wp_customize, 'pajdm_menu_left_right', array(
	    'label'	=>  esc_html__('Left & Right Padding'),
        'pajdm_reset' => 20,
        'min' => 0,
        'max' => 50,
        'step' => 1,
	    'section' => 'pajdm_divi_menu_extra',
        'settings' => 'pajdm_menu_left_right',
    ) ) );

    //  ========================================
    //  = DropDown Padding ITEMS Top & Bottom  =
    //  ========================================
    $wp_customize->add_setting( 'pajdm_menu_dropdown_items' , array(
        'default'     => 6,
        'type'           => 'option',
        'transport'   => 'postMessage',
        'sanitize_callback' => 'pajdm_sanitize_integer',
    ) );

    $wp_customize->add_control( new pajdm_Customize_Range( $wp_customize, 'pajdm_menu_dropdown_items', array(
	    'label'	=>  esc_html__('Item Top & Bottom Padding'),
        'pajdm_reset' => 6,
        'min' => 0,
        'max' => 30,
        'step' => 1,
	    'section' => 'pajdm_divi_menu_extra',
        'settings' => 'pajdm_menu_dropdown_items',
    ) ) );

    //  =============================
    //  = Menu Line Heading         =
    //  =============================
    $wp_customize->add_setting( 'line_effect_heading' , array());
    $wp_customize->add_control( new pajdm_Customize_heading( $wp_customize, 'line_effect_heading', array(
        'pajdm_heading'     => esc_html__('Menu Line Effect'),
        'pajdm_description'     => esc_html__('Line Effect can be above or below menu item.'),
	    'section' => 'pajdm_divi_menu_extra',
    ) ) );

    //  =============================
    //  = Main Menu Line Check Box  =
    //  =============================
    $wp_customize->add_setting('pajdm_main_menu_line_option', array(
        'default'    => false,
        'transport'   => 'postMessage',
        'type'       => 'option',
    ));

    $wp_customize->add_control(
        new WP_Customize_Control(
        $wp_customize,
        'pajdm_main_menu_line_option',
        array(
            'label'     => esc_html__('Add to main menu'),
            'section'   => 'pajdm_divi_menu_extra',
            'settings'  => 'pajdm_main_menu_line_option',
            'type'      => 'checkbox',
        ) ) );

    //  =============================
    //  = Sub Menu Line Check Box   =
    //  =============================
    $wp_customize->add_setting('pajdm_dropdown_line_option', array(
        'default'    => false,
        'transport'   => 'postMessage',
        'type'       => 'option',
    ));

    $wp_customize->add_control(
        new WP_Customize_Control(
        $wp_customize,
        'pajdm_dropdown_line_option',
        array(
            'label'     => esc_html__('Add to dropdown menu'),
            'section'   => 'pajdm_divi_menu_extra',
            'settings'  => 'pajdm_dropdown_line_option',
            'type'      => 'checkbox',
        ) ) );

    //  ==================================
    //  = Menu Effect Line Thickness     =
    //  ==================================
    $wp_customize->add_setting( 'pajdm_line_thickness' , array(
        'default'     => 3,
        'type'           => 'option',
        'transport'   => 'postMessage',
        'sanitize_callback' => 'pajdm_sanitize_integer',
    ) );

    $wp_customize->add_control( new pajdm_Customize_Range( $wp_customize, 'pajdm_line_thickness', array(
	    'label'	=>  esc_html__('Line Thickness'),
        'pajdm_reset' => 3,
        'min' => 0,
        'max' => 10,
        'step' => 1,
	    'section' => 'pajdm_divi_menu_extra',
        'settings' => 'pajdm_line_thickness',
    ) ) );

    //  ==================================
    //  = Main Menu Line Position        =
    //  ==================================
    $wp_customize->add_setting( 'pajdm_main_menu_line_position' , array(
        'default'     => 50,
        'type'           => 'option',
        'transport'   => 'postMessage',
        'sanitize_callback' => 'pajdm_sanitize_integer',
    ) );

    $wp_customize->add_control( new pajdm_Customize_Range( $wp_customize, 'pajdm_main_menu_line_position', array(
	    'label'	=>  esc_html__('Line Position'),
        'pajdm_reset' => 50,
        'min' => 0,
        'max' => 150,
        'step' => 5,
	    'section' => 'pajdm_divi_menu_extra',
        'settings' => 'pajdm_main_menu_line_position',
    ) ) );

    //  ==================================
    //  = DropDown Line Position         =
    //  ==================================
    $wp_customize->add_setting( 'pajdm_dropdown_menu_line_position' , array(
        'default'     => 50,
        'type'           => 'option',
        'transport'   => 'postMessage',
        'sanitize_callback' => 'pajdm_sanitize_integer',
    ) );

    $wp_customize->add_control( new pajdm_Customize_Range( $wp_customize, 'pajdm_dropdown_menu_line_position', array(
	    'label'	=>  esc_html__('Drop Down Line Position'),
        'pajdm_reset' => 50,
        'min' => 0,
        'max' => 150,
        'step' => 5,
	    'section' => 'pajdm_divi_menu_extra',
        'settings' => 'pajdm_dropdown_menu_line_position',
    ) ) );

    //  =============================
    //  = Line Color Picker         =
    //  =============================
    $wp_customize->add_setting('pajdm_menu_line_color', array(
        'default'    => '#2ea3f2',
        'type'           => 'option',
        'transport'   => 'postMessage',
        'sanitize_callback' => 'sanitize_hex_color',
        'capability'        => 'edit_theme_options',
    ));

    $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'pajdm_menu_line_color', array(
        'label'    => esc_html__('Menu Line Color'),
        'section'  => 'pajdm_divi_menu_extra',
        'settings' => 'pajdm_menu_line_color',
    )));

    //  ==============================
    //  = DropDown Menu Icon Heading =
    //  ==============================
    $wp_customize->add_setting( 'menu_icon_heading' , array('sanitize_callback' => 'pajdm_sanitize_heading'));
    $wp_customize->add_control( new pajdm_Customize_heading( $wp_customize, 'menu_icon_heading', array(
        'pajdm_heading'     => esc_html__('Menu DropDown Icon'),
	    'section' => 'pajdm_divi_menu_extra',
    ) ) );
    //  ======================================
    //  = DropDown Menu Icon Radio Input     =
    //  ======================================
    $wp_customize->add_setting('pajdm_options_dropdown_menu_icon', array(
        'default'        => 'original',
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
        'transport'   => 'postMessage',
        'sanitize_callback' => 'pajdm_sanitize_radio'
    ));

    $wp_customize->add_control('pajdm_options_dropdown_menu_icon', array(
        'label'      => esc_html__('Select Icon', 'pajdm_divi'),
        'section'    => 'pajdm_divi_menu_extra',
        'settings'   => 'pajdm_options_dropdown_menu_icon',
        'type'       => 'select',
        'choices'    => array(
            'original' => 'Default',
            'arrow' => 'Arrow',
            'triangle' => 'Triangle',
        ),
    ));

}  // end of pajdm_customize_register

add_action('customize_register', 'pajdm_customize_register');

//  ==========================
//  = Add CSS to wp_head     =
//  ==========================
add_action( 'wp_head', 'pajdm_customizer_css');
function pajdm_customizer_css()
{
    $new_break_point = intval(get_option('pajdm_menu_breakpoint',980));
    $top_bottom_padding = intval(get_option('pajdm_menu_top_bottom',20));
    $left_right_padding = intval(get_option('pajdm_menu_left_right',20));
    $dropdown_item_padding = intval(get_option('pajdm_menu_dropdown_items',6));
    $underline_color = get_option('pajdm_menu_line_color', '#2ea3f2');
    $line_thickness = intval(get_option('pajdm_line_thickness',3));
    $main_menu_line_position = intval(get_option('pajdm_main_menu_line_position', 50));
    $dropdown_menu_line_position = intval(get_option('pajdm_dropdown_menu_line_position', 50)-50);
    $main_menu_line_option = get_option('pajdm_main_menu_line_option',0);
    $dropdown_line_option = get_option('pajdm_dropdown_line_option', 0);
    $dropdown_menu_icon = get_option('pajdm_options_dropdown_menu_icon');

    $divi_menu_height = absint( et_get_option( 'menu_height', '66' ) + 14);

    $new_pajdm_divi_settings['new_breakpoint'] = $new_break_point;
    $new_pajdm_divi_settings['pajdm_divi_menuheight'] = $divi_menu_height;

    $pajdm_settings_str = json_encode($new_pajdm_divi_settings);
    $params = array('new_pajdm_divi_settings' => $pajdm_settings_str,);

    if ((! is_customize_preview() ) && ($new_break_point > '980')) {
        wp_localize_script( 'pajdm-new-style-settings', 'pajdm_divi_php_data', $params);
        // Enqueued script with localized data.
        wp_enqueue_script('pajdm-new-style-settings');
    }

    //output style updates
    echo '<style type="text/css">';

    if ($new_break_point > '980') {

    if (et_get_option( 'header_style', 'left' ) == 'left') {
        echo '
        @media screen and (max-width: '.$new_break_point.'px) and (min-width: 980px) {
            #top-menu-nav, #top-menu {display: none;}
            #main-header #et_top_search {float: left;margin: 10px 35px 0 0 !important;}
            #et_mobile_nav_menu {display: block;}
            #main-header #et-top-navigation {padding-top:24px;}
            #main-header #logo {max-height:100%;}
            .et_fixed_nav #main-header, .et_fixed_nav #top-header{position: absolute;}
            }
           ';
    } // end of header style if
    } // end of breakpoint if

    if ($top_bottom_padding != 20)
        {  //Drop Down Menu Top and bottom padding
        $sub_menu_position = 20 - $top_bottom_padding;
        echo '
            #main-header .nav li ul {padding-top: ' .$top_bottom_padding.'px ;}
            #main-header .nav li ul {padding-bottom: ' .$top_bottom_padding.'px ;}
            #et-top-navigation ul li li ul.sub-menu {margin-top:'.$sub_menu_position.'px;}
        ';
        } // end top bottom padding if

    if ($left_right_padding != 20)
        {  //Drop Down Menu Left and Right padding
        $item_width =  240-($left_right_padding*2);
        echo '
            #et-top-navigation #top-menu li li  {padding-left: ' .$left_right_padding.'px ;}
            #et-top-navigation #top-menu li li {width: ' .$item_width.'px ;}
            #et-top-navigation #top-menu li li a {width: ' .$item_width.'px ;}
            .nav li.et-reverse-direction-nav li ul {right:' .$item_width.'px ;}   }
        ';
        } // end of left right padding if


    if ($dropdown_line_option == 1) {
        $displaydropdown = 1;
        //remove divi dropdown hover effect
        echo '#top-menu ul.sub-menu a:hover {background:rgba(0,0,0,0) !important;}  ';
    } else {
        $displaydropdown = 0 ;
    }


     if ($dropdown_item_padding != 6)
        { //Drop Down Menu padding between items also reposition flyout menu icon*/
        echo '
            #et-top-navigation #top-menu li li a {padding-top:' .$dropdown_item_padding.'px; padding-bottom:'.$dropdown_item_padding.'px;}

            #et-secondary-nav .menu-item-has-children > a:first-child::after {top:' .$dropdown_item_padding.'px;}
            #top-menu li .menu-item-has-children>a:first-child:after {top:' .$dropdown_item_padding.'px;}
        ';
        }   // end of item padding if

    if ($main_menu_line_option == 1) {
        echo'
            #top-menu .current-cat a::before, #top-menu .current-menu-item a::before,
            #top-menu .current-menu-parent a::before, #top-menu .current-menu-ancestor a::before, #top-menu ul.sub-menu .current-menu-parent a::before,
            #top-menu .current_page_item a::before {
                content: "";
                position: absolute;
                z-index: 2;
                left: 0;
                right: 0;
            }

            #top-menu li a:before {
                content: "";
                position: absolute;
                z-index: -2;
                left: 0;
                right: 100%;
                bottom: '.$main_menu_line_position.'%;
                background:'.$underline_color .';
                height:'.$line_thickness.'px;
                -webkit-transition-property: right;
                transition-property: right;
                -webkit-transition-duration: 0.3s;
                transition-duration: 0.3s;
                -webkit-transition-timing-function: ease-out;
                transition-timing-function: ease-out;
            }

            /*Drop Down Menu*/
            #top-menu ul.sub-menu a::before {right:100%; bottom:'.$dropdown_menu_line_position.'%; opacity:'.$displaydropdown.'}
            #top-menu ul.sub-menu .current-menu-item a::before {right:0;opacity:'.$displaydropdown.'}

            /* Sub Drop Down Menu*/
            #top-menu ul ul.sub-menu a::before {right:100% !important; bottom:'.$dropdown_menu_line_position.'%; opacity:'.$displaydropdown.'}
            #top-menu ul ul.sub-menu .current-menu-item a::before {right:0 !important;opacity:'.$displaydropdown.'}

            #top-menu li a:hover {
                opacity: 1 !important;
            }

            #top-menu li a:hover:before {
                right: 0;
            }

            #top-menu ul li a:hover:before {
                right: 0 !important;
            }

            #top-menu li li a:before {
                /* bottom: 10%; */
            }

            #top-menu li.centered-inline-logo-wrap a:before {opacity:0 !important;}
        ';
    }   // end if main line menu

    if ($dropdown_menu_icon =='arrow'){
        echo '
            #top-menu .menu-item-has-children > a:first-child::after,
            #et-secondary-nav .menu-item-has-children > a:first-child::after {content:"\22" !important; font-size:0.85em !important;right:0px; }
            #top-menu li .menu-item-has-children>a:first-child:after {content:"\2b" !important; }
            ';
    } else if ($dropdown_menu_icon =='triangle'){
        echo '
            #top-menu .menu-item-has-children > a:first-child::after,
            #et-secondary-nav .menu-item-has-children > a:first-child::after {content:"\43" !important;  }
            #top-menu li .menu-item-has-children>a:first-child:after {content:"\45" !important; }
            ';
    }

    echo '</style> ';
} //End of CSS Output
?>