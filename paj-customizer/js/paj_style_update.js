/********************************
** pajdm Page padding update
**
** For Help and Support please visit greenorbwebdesign.co.uk
**
** paj_style_update.js
** Adjusts padding at top of pages to compensate for change between mobile and desktop menu height
********************************/
jQuery(document).ready(function() {

 var my_json_str = pajdm_divi_php_data.new_pajdm_divi_settings.replace(/&quot;/g, '"');
 var my_php_arr = jQuery.parseJSON(my_json_str);

//var initial_value = jQuery('#main-header').height();
var pajdm_width = my_php_arr['new_breakpoint'];
//var oldheight = initial_value;

//Gather information about current page.
var menu_is_transparent = jQuery( 'body' ).hasClass( 'et_transparent_nav' );
var is_a_pagebuilder = jQuery( "body" ).hasClass( "et_pb_pagebuilder_layout" );
var full_width_top = jQuery(".et_pb_section_0" ).hasClass("et_pb_fullwidth_section" );
var header_fixed = jQuery( "body" ).hasClass( "et_fixed_nav" );

//Get initial top padding for transparent pagebuilder page
if (menu_is_transparent && is_a_pagebuilder && (! full_width_top))  {
    var first_original_padding = jQuery(".et_pb_section_0" ).css("padding-top");
    first_original_padding = parseInt(first_original_padding, 10);
}

if (header_fixed) {
//run calculate menu size padding when page is resized also use timeout to prevent too many calls
var pajdm_resizeTimeout
jQuery(window).resize(function(){
    clearTimeout(pajdm_resizeTimeout)
    pajdm_resizeTimeout = setTimeout(function(){
    pajdm_calculate_menu_size_padding();

    },120);
});
};

function pajdm_calculate_menu_size_padding () {
    if (document.documentElement.clientWidth < 980) {
        jQuery('#page-container').css('margin-top', '');
        jQuery('#main-content').css('margin-top', '');
    } else {
        if (! menu_is_transparent) {
            pajdm_normal_menu_padding();
        } else {
            pajdm_transparent_menu_padding();
        }
    } // end of document < 980 width
} //end of function pajdm_calculate_menu_size_padding

function pajdm_transparent_menu_padding() {
     if (is_a_pagebuilder) {
                pajdm_pagebuilder_padding();
     } else {
         pajdm_transparent_plane_page();
     }
} // end of transparent menu padding

function pajdm_normal_menu_padding () {
    pajdm_get_main_header_height(function (main_header_height) {
        var topheight = jQuery('#top-header').height();
        var updatedmargin = main_header_height + topheight;
        jQuery('#page-container').css("cssText", "padding-top:"+updatedmargin+"px !important;");
    });
} // end of function pajdm_normal_menu_padding

function pajdm_transparent_plane_page () {
    pajdm_get_main_header_height(function (main_header_height) {
        var topheight = jQuery('#top-header').height();
        var transparent_padding = main_header_height + topheight + 58;
        jQuery('#main-content .container ').css("cssText", "padding-top:"+transparent_padding+"px !important;");
    });
} // end of function pajdm_normal_menu_padding

function pajdm_pagebuilder_padding () {
    if (! full_width_top) {
        pajdm_get_main_header_height(function (main_header_height) {
            var topheight = jQuery('#top-header').height();
            var headingheight = main_header_height + topheight;
            var newpadding = first_original_padding + headingheight;
            jQuery('.et_pb_section_0 ').css("cssText", "padding-top:"+newpadding+"px !important;");
        }); // end of pajdm_get_main_header_height
    } else {
        //fullwidth header
        pajdm_get_main_header_height(function (main_header_height) {
           var topheight = jQuery('#top-header').height();
           var headingheight = main_header_height + topheight;
           jQuery('.et_pb_slide ').css("cssText", "padding-top:"+headingheight+"px !important;");
        }); // end of pajdm_get_main_header_height
    }
}

function pajdm_get_main_header_height(callback) {
    var pajdm_initial_height = 0;
    var newheight = 10;
    var pajdm_get_main_header_height = setInterval(function(){
        if (pajdm_initial_height == newheight) {
            clearInterval(pajdm_get_main_header_height);
            callback(newheight);
        } else {
            pajdm_initial_height = newheight;
            newheight = jQuery('#main-header').height();
        }
    },100);  // end of timer
} // end of get main height

});
