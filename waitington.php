<?php
/*
Plugin Name: Wait List App
Plugin URI: http://waitington.com
Description: Wait List app - is a plugin to support Waitington branch system
Version: 0.1
Author: Waitington, http://waitington.com
Author URI: http://waitington.com
*/

/*  Copyright 2014  waitington - Where were YOU?  (email : info@waitington.com)
   
*/
?><?php

// some definition we will use
define( 'WAITINGTON_PUGIN_NAME', 'Waitington');
define( 'WAITINGTON_PUGIN_DIRECTORY', 'waitington');
define( 'WAITINGTON_CURRENT_VERSION', '0.1' );
define( 'WAITINGTON_CURRENT_BUILD', '3' );
// i18n plugin domain for language files
define( 'EMU2_I18N_DOMAIN', 'waitington' );


// load language files
function waitington_set_lang_file() {
	# set the language file
	$currentLocale = get_locale();
	if(!empty($currentLocale)) {
		$moFile = dirname(__FILE__) . "/lang/" . $currentLocale . ".mo";
		if (@file_exists($moFile) && is_readable($moFile)) {
			load_textdomain(EMU2_I18N_DOMAIN, $moFile);
		}

	}
}
waitington_set_lang_file();

// Require files within the plugin




//call register settings function


register_activation_hook(__FILE__, 'waitington_activate');
register_deactivation_hook(__FILE__, 'waitington_deactivate');
register_uninstall_hook(__FILE__, 'waitington_uninstall');




//call register settings function
add_action( 'admin_init', 'waitington_register_settings' );
function waitington_register_settings() {
	//register settings
	register_setting( 'waitington-settings-group', 'waitington_branch_id' );	
	register_setting( 'waitington-settings-group', 'waitington_width' );	
	register_setting( 'waitington-settings-group', 'waitington_height' );		
}

register_activation_hook(__FILE__, 'waitington_activate');
register_deactivation_hook(__FILE__, 'waitington_deactivate');
register_uninstall_hook(__FILE__, 'waitington_uninstall');

// activating the default values
function waitington_activate() {
	add_option('waitington_branch_id', 3);
	add_option('waitington_width', 350);
	add_option('waitington_height', 600);
}

// deactivating
function waitington_deactivate() {
	// needed for proper deletion of every option
	delete_option('waitington_branch_id');
	delete_option('waitington_width');
	delete_option('waitington_height');

}

// uninstalling
function waitington_uninstall() {
	# delete all data stored
	delete_option('waitington_branch_id');		
	delete_option('waitington_width');		
	delete_option('waitington_height');		
}

// create custom plugin settings menu
add_action( 'admin_menu', 'waitington_create_menu' );
function waitington_create_menu() {

	// create new top-level menu
	add_menu_page( 
	__('Waitington', EMU2_I18N_DOMAIN),
	__('Waitington', EMU2_I18N_DOMAIN),
	0,
	WAITINGTON_PUGIN_DIRECTORY.'/admin_side/waitington_settings_page.php',
	'',
	plugins_url('icon.png', __FILE__));
	
	
	add_submenu_page( 
	WAITINGTON_PUGIN_DIRECTORY.'/admin_side/waitington_settings_page.php',
	__("Configuration", EMU2_I18N_DOMAIN),
	__("Configuration", EMU2_I18N_DOMAIN),
	0,
	WAITINGTON_PUGIN_DIRECTORY.'/admin_side/waitington_settings_page.php'
	);	
			
	
}

function waitington_content() {	
	$width = get_option( 'waitington_width' );
	$height = get_option( 'waitington_height' );
	echo "<iframe style='width:". $width . "px;height:". $height . "px;border:none;overflow:none;' scrolling='no' src='https://waitington.com/?embed=1&branch_id=" . get_option('waitington_branch_id') . "'></iframe>";
	
}
add_shortcode('waitington','waitington_content')
?>