<?php
/**
 * GreenShift
 *
 * @package WPSnipHub
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ==========================================================
   Greenshift Night Mode - How to prevent Style flashing
   ========================================================== */
/* 
// via https://greenshiftwp.com/how-to-add-night-mode-in-wordpress/
*/
add_filter( 'body_class', 'wpsh_greenshift_body_classes' );
function wpsh_greenshift_body_classes( $classes ) {
	if ( isset( $_COOKIE['darkmode'] ) ) {
		$classes[] = 'darkmode';
	}
	return $classes;
}

/* ==========================================================
   Greenshift Custom Breakpoints
   ========================================================== */
/* 
// via https://greenshiftwp.com/documentation/for-developers/theme-integration-with-greenshift/
add_filter('greenshift_responsive_breakpoints', function($array){
	return array(
		'mobile' 	=> 576,
		'tablet' 	=> 768,
		'desktop' =>  992
	);
});

// Greenshift Disable Landscape breakpoint :
add_filter( 'greenshift_hide_landscape_breakpoint', '__return_true' );


// Greenshift Container inheritance :
add_filter('gspb_default_row_width_px', function($row){
	return 1200;
});

*/

/* ==================================================================================
   How to register own CSS framework or enable Core Framework addon with Greenshift
   ================================================================================== */
/* 
// via https://greenshiftwp.com/class-first-system-and-how-to-register-own-css-framework-and-components/
// Add additional classes to style presets
add_filter('greenshift_style_preset_classes', 'mycustom_greenshift_style_classes');
function mycustom_greenshift_style_classes($options){
   $options[] = 
   [
	  'value'=> 'mb10',
	  'label'=> "Margin Bottom 10px",
	  'type' => "preset",
	  'css' => ".mb10{margin-bottom:10px}"
   ];
   return $options;
}

// Register your own group and classes. You need to use the next filter greenshift_preset_classes
add_filter('greenshift_preset_classes', 'mycustom_greenshift_preset_classes_group');
function mycustom_greenshift_preset_classes_group($options){
return array(
	array(
	   'label' => esc_html__('My New group Presets', 'textdomain'),
		  'options' => array(
				array(
					'value'=> 'mb10',
					'label'=> "Margin Bottom 10px",
					'type' => "preset",
					'css' => ".mb10{margin-bottom:10px}"
				),
				 array(
					'value'=> 'mb20',
					'label'=> "Margin Bottom 20px",
					'type' => "preset",
					'css' => ".mb20{margin-bottom:20px}"
				)
			)
		)
	);
}

// Register Framework group. You need to use next filter and example
add_filter('greenshift_framework_classes', 'mycustom_greenshift_framework_classes_group');
function mycustom_greenshift_framework_classes_group($options){
return array(
	array(
	   'label' => esc_html__('My New group framework', 'textdomain'),
		  'options' => array(
				array(
					'value'=> 'mb10',
					'label'=> "Margin Bottom 10px",
					'type' => "framework",
				),
				 array(
					'value'=> 'mb20',
					'label'=> "Margin Bottom 20px",
					'type' => "framework",
				)
			)
		)
	);
}

/* ==========================================================
   Using Core Framework with Greenshift
   ========================================================== */
// 
// > Inject utility classes of the Core framework Gutenberg plugin in selector of classes in Greenshift
// For this, enable option in Greenshift settings – CSS Options > Support for Core Framework Utility classes
// Also, we strongly recommend checking if your font size is equal to 100% in the option of Core framework plugin
// via https://greenshiftwp.com/class-first-system-and-how-to-register-own-css-framework-and-components/