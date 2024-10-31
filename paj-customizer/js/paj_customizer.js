/********************************
** pajdm Customizer
**
** For Help and Support please visit greenorbwebdesign.co.uk
**
** paj_customizer.js
** Provides live previews for certain pajdm_customizer options
********************************/

//Menu Breakpoint
( function( $ ) {
    wp.customize( "pajdm_menu_breakpoint", function( value ) {
        value.bind( function( pajdm_breakpoint_menu ) {

        pajdm_page_container_padding = $('#main-header').attr("data-height-onload");

        pajdm_divi_height = $('#et-top-navigation').attr("data-height");

        max_logo_height = $('#logo').attr("data-height-percentage")+"%";
        nav_top_padding = parseInt(pajdm_divi_height / 2);
        fixed_menu = $( "body" ).hasClass( "et_fixed_nav" );

        if ($( "body" ).hasClass( "et_header_style_left" )) {
        if ($(document).width() < pajdm_breakpoint_menu) {
            //display mobile menu & hide desktop menu
           	$( "#top-menu-nav" ).css( "display", "none");
            $( "#top-menu" ).css( "display", "none");
            $( "#et_mobile_nav_menu" ).css( "display", "block");
            if ($( "body" ).hasClass( "et_fixed_nav" )) {
                $( "#page-container" ).css("padding-top", "80px");
            }
            $( "#main-header #et-top-navigation" ).css( {"display":"block", "padding-top": "24px"});
            $( "#logo" ).css( {"max-height":"100%"});
            $( "#main-header #et_top_search" ).css( {"float":"left", "margin": "10px 35px 0 0"});
            if (fixed_menu) {
                $( ".et_fixed_nav #main-header, .et_fixed_nav #top-header" ).css( {"position":"absolute"});
            }
        } else {
            $( "#top-menu-nav" ).css( "display", "block");
            $( "#top-menu" ).css( "display", "block");
           	$( "#et_top_search" ).css( "display", "block");
            $( "#main-header #et_top_search" ).css( {"float":"right", "margin": "3px 0 0 22px"});
            $( "#et_mobile_nav_menu" ).css( "display", "none");
            $( "#main-header #logo" ).css("max-height", max_logo_height);
            $( ".et_header_style_left #et-top-navigation, .et_header_style_split #et-top-navigation" ).css( {"display":"block", "padding-top": nav_top_padding +"px"});
             if (fixed_menu) {
                $( ".et_fixed_nav #main-header, .et_fixed_nav #top-header" ).css( {"position":"fixed"});
            }
            if ($( "body" ).hasClass( "et_fixed_nav" )) {
                $( "#page-container" ).css("padding-top", pajdm_divi_height +"px");
            }
        }
        } // end if left header
    } );
  } );
//Drop Down Menu Padding Top & Bottom
    wp.customize( "pajdm_menu_top_bottom", function( value ) {
        value.bind( function( pajdm_top_bottom_padding ) {
            submenu_position = 20 - pajdm_top_bottom_padding;
            pajdm_top_bottom_padding = pajdm_top_bottom_padding + "px";
            $( "#main-header .nav li ul" ).css( "padding-top", pajdm_top_bottom_padding );
            $( "#main-header .nav li ul" ).css( "padding-bottom", pajdm_top_bottom_padding );
            $( "#et-top-navigation ul li li ul.sub-menu" ).css( "margin-top", submenu_position + "px" );
        } );
    } );
//Drop  Down Menu Left & Right Padding
    wp.customize( "pajdm_menu_left_right", function( value ) {
        value.bind( function( pajdm_left_right_padding ) {
        item_width = 240-(pajdm_left_right_padding*2);
        item_width = item_width + "px";
        pajdm_left_right_padding = pajdm_left_right_padding + "px";
        $( "#et-top-navigation #top-menu li li" ).css( "padding-left", pajdm_left_right_padding);
        $( "#et-top-navigation #top-menu li li" ).css( "width", item_width);
        $( "#et-top-navigation #top-menu li li a" ).css( "width", item_width);
        $( "#et-top-navigation #top-menu li ul ul.sub-menu" ).css( "right", item_width);
        } );
    } );
// Drop Down Menu Items Top & Bottom Padding
    wp.customize( "pajdm_menu_dropdown_items", function( value ) {
        value.bind( function( pajdm_item_top_bottom ) {
            pajdm_item_top_bottom = pajdm_item_top_bottom + "px";
            $( "#et-top-navigation #top-menu li li a" ).css( "padding-top", pajdm_item_top_bottom );
            $( "#et-top-navigation #top-menu li li a" ).css( "padding-bottom", pajdm_item_top_bottom );
            // reposition flyout menu icon
            $('head').append('<style type="text/css">#et-secondary-nav .menu-item-has-children > a:first-child::after, '+
            '#top-menu li .menu-item-has-children>a:first-child:after {top:'+pajdm_item_top_bottom+';} </style>');

        } );
    } );

//Turn on or off main menu Hover line
        wp.customize( "pajdm_main_menu_line_option", function( value ) {
        value.bind( function( pajdm_main_line_option ) {

                if (pajdm_main_line_option == 1) {
                      $('head').append('<style type="text/css">#top-menu .current-cat a::before, #top-menu .current-menu-item a::before, #top-menu .current-menu-parent a::before, '+
                                '#top-menu a:hover:before {content: "";position: absolute;z-index: 2;left: 0;right: 0; }'+
                                '#top-menu ul.sub-menu a:hover {background:rgba(0,0,0,0) !important;}#top-menu ul.sub-menu a::before {right:100%;opacity:0;}</style>');

                      $('head').append('<style type="text/css"> #top-menu li a:before '+
                                '{content: "";position: absolute;z-index: -2;left: 0;right: 100%;'+
                                'bottom: 50%;background:#2ea3f2; height:3px; -webkit-transition-property: right;'+
                                'transition-property: right; -webkit-transition-duration: 0.3s;transition-duration: 0.3s;'+
                                '-webkit-transition-timing-function: ease-out;transition-timing-function: ease-out;}</style>');
               } else {
                        $('head').append('<style type="text/css"> #top-menu li a:before, #top-menu ul.sub-menu a::before {height:0px;}</style>');
                }

    	} );
        } );
//Turn on or off Drop Down menu Hover line
        wp.customize( "pajdm_dropdown_line_option", function( value ) {
        value.bind( function( pajdm_drop_line_option ) {
               if (pajdm_drop_line_option == 1) {
                $('head').append('<style type="text/css">  #top-menu ul.sub-menu a::before {right:100%; bottom:0%; opacity:1}'+
                '#top-menu ul.sub-menu a:hover:before {right:0%;}'+
                    '#top-menu ul.sub-menu .current-menu-item a::before {right:0;opacity:1} '+
                    '</style>');
            } else {
                $('head').append('<style type="text/css">  #top-menu ul.sub-menu a::before {right:100%; bottom:0%; opacity:0}'+
                   '#top-menu ul.sub-menu .current-menu-item a::before {right:0;opacity:0} '+
                   '</style>');
            } //end of if pajdm_drop_line_option
        } );
    } );
// Hover Line menu Thickness
    wp.customize( "pajdm_line_thickness", function( value ) {
        value.bind( function( pajdm_lthickness ) {
            pajdm_lthickness = pajdm_lthickness + "px";
             $('head').append('<style type="text/css">#top-menu li a:before {height:'+pajdm_lthickness+';} </style>');

        } );
    } );
//Hover Line Main Menu Position
    wp.customize( "pajdm_main_menu_line_position", function( value ) {
        value.bind( function( pajdm_main_line_pos ) {
            pajdm_main_line_pos = pajdm_main_line_pos + "%";
             $('head').append('<style type="text/css">#top-menu li a:before {bottom:'+pajdm_main_line_pos+';} </style>');

        } );
    } );
//Hover Line Drop Down Menu Position
    wp.customize( "pajdm_dropdown_menu_line_position", function( value ) {
        value.bind( function( pajdm_drop_line_pos ) {
            pajdm_drop_line_pos = pajdm_drop_line_pos - 50;
            pajdm_drop_line_pos = pajdm_drop_line_pos + "%";
             $('head').append('<style type="text/css">#top-menu ul.sub-menu a::before {bottom:'+pajdm_drop_line_pos+';} </style>');

        } );
    } );

//Hover Line Drop Down Menu Position
    wp.customize( "pajdm_menu_line_color", function( value ) {
        value.bind( function( pajdm_line_color ) {
             $('head').append('<style type="text/css">#top-menu li a:before {background:'+pajdm_line_color+';} </style>');

        } );
    } );

    //Main Menu Drop Down Icon
    wp.customize( "pajdm_options_dropdown_menu_icon", function( value ) {
        value.bind( function( pajdm_menu_icon ) {
            if (pajdm_menu_icon == 'arrow') {
                pajdmicon = '!';
                pajdm2icon = '+';
                pajdmrotate = '-webkit-transform: rotate(180deg);-moz-transform: rotate(180deg);-o-transform: rotate(180deg);-ms-transform: rotate(180deg);transform: rotate(180deg)';
            } else if (pajdm_menu_icon == 'triangle') {
                pajdmicon = 'C';
                pajdm2icon = 'E';
                pajdmrotate = '-webkit-transform: rotate(0deg);-moz-transform: rotate(0deg);-o-transform: rotate(0deg);-ms-transform: rotate(0deg);transform: rotate(0deg)';
            } else if (pajdm_menu_icon == 'original') {
                pajdmicon = '3';
                pajdm2icon = '3';
                pajdmrotate = '-webkit-transform: rotate(0deg);-moz-transform: rotate(0deg);-o-transform: rotate(0deg);-ms-transform: rotate(0deg);transform: rotate(0deg)';
            }

            $('head').append('<style type="text/css">'+
                '#top-menu .menu-item-has-children > a:first-child::after,'+
                '#et-secondary-nav .menu-item-has-children > a:first-child::after {content:"'+pajdmicon+'" !important; font-size:0.85em !important;right:0px;'+pajdmrotate+'}'+
                '#top-menu li .menu-item-has-children>a:first-child:after {content:"'+pajdm2icon+'" !important; }  '+
                ' </style>');
        } );
    } );

} )( jQuery );