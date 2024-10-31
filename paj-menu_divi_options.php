<?php
   /*
   Plugin Name: PAJ Divi Menu Options
   Description: Adds extra options to the Divi desktop menu via the wordpress customizer.
   Version: 0.93
   Author:Phillip Johnson
   License: GPLv2 or later
   License URI: https://www.gnu.org/licenses/gpl-2.0.html
   */

defined( 'ABSPATH' ) or die( 'No No No!' );  

function pajdm_admin_notice__error() {
	$class = 'notice notice-error';
	$message = __( 'PAJ Customizer Plugin Only Works with the Divi theme or a Divi child theme.', 'pajdm-text-domain' );
	printf( '<div class="%1$s"><p style="font-size:1.3em;">%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
}

//Detect if Divi is the current theme or parent theme. If not display error message.
// If Divi then load main plugin file.
$theme = wp_get_theme();
if (!( 'Divi' == $theme->name || 'Divi' == $theme->parent_theme )) {
       add_action( 'admin_notices', 'pajdm_admin_notice__error' );
} else {
    //get main plugin file.
    $shortcode_filename = plugin_dir_path(__FILE__).'paj-customizer/paj-customizer.php';
    if (file_exists($shortcode_filename)) {
   	    include( $shortcode_filename);
    } else {
        echo "The file $shortcode_filename does not exist";
    }
}

//things to do at uninstall
register_uninstall_hook( __FILE__, 'pajdm_divi_plugin_uninstall' );
function pajdm_divi_plugin_uninstall() {
    delete_option('pajdm_menu_breakpoint');
    delete_option('pajdm_menu_top_bottom');
    delete_option('pajdm_menu_left_right');
    delete_option('pajdm_menu_dropdown_items');
    delete_option('pajdm_menu_line_color');
    delete_option('pajdm_line_thickness');
    delete_option('pajdm_main_menu_line_position');
    delete_option('pajdm_dropdown_menu_line_position');
    delete_option('pajdm_main_menu_line_option');
    delete_option('pajdm_dropdown_line_option');
    delete_option('pajdm_options_dropdown_menu_icon');
}

?>