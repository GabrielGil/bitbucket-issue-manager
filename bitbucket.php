<?php

/*************************************************************************

Plugin Name:		Bitbucket Issue Manager
Plugin URI:			http://gabrielgil.es/bitbucket-issue-manager
Description:		Adds useful widgets to track your recent bitbucket issues. I pretend add more features soon. (Front-end widgets, issue listing page etc). That's why the plugin is called <strong>Manager</strong> and not just <strong>Dashboard widgets</strong>.
Version:			0.8.1
Author:				Gabriel Gil
Author URI:			http://gabrielgil.es/
License:			GPLv2 or later
License URI:		http://www.gnu.org/licenses/gpl-2.0.html
GitHub Plugin URI:	gabrielgil/bitbucket-issue-manager

**************************************************************************/


/*************************************************************************

						INDEX
					
			* -> License
			* -> Options
			* -> Dashboard widget
			* ----> Hook Widget
			* ----> Add Content
			* -> Plugin Options Area
			* ----> Options link on plugins list
			* ----> Owner and repository name option field
			* -> Helper functions


**************************************************************************/



/*************************************************************************

						LICENSE

**************************************************************************/


/*  Copyright 2014  Gabriel Gil  (email : hello@gabrielgil.es)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/



/*************************************************************************

						OPTIONS FIELDS

**************************************************************************/


/*
 * Add settings fields to general settings page
 * 
 * Hooks into admin_init to add options to save the username and
 * repository names.
 */

add_action( 'admin_init', function ()
{
	// Add the section to reading settings so we can add our
 	// fields to it
 	add_settings_section(
		'bim-settings-section',
		'Bitbucket Issue Manager Settings',
		'bim_setting_section_callback',
		'general'
	);
	
	// Add the username field
	add_settings_field(
		'bim-username',
		'BitBucket Username',
		'bim_username_field_callback',
		'general',
		'bim-settings-section'
	);
	// Register the field so we can sanitize it.
	register_setting( 'general', 'bim-username' );
	
	add_settings_field(
		'bim-respository',
		'BitBucket Respository',
		'bim_respository_field_callback',
		'general',
		'bim-settings-section'
	);
	register_setting( 'general', 'bim-respository' );

});


/*
 * Callback functions
 * 
 * The following functions prints the info, and the input elements.
 */

function bim_setting_section_callback ()
{
	echo '<p>Here you can set you BitBucket username and the repository you want manage.</p>';
}

function bim_username_field_callback ()
{
	echo '<input id="bim-username" name="bim-username" type="text" value="' . get_option( 'bim-username' ) . '" class="regular-text code" />';
}

function bim_respository_field_callback ()
{
	echo '<input id="bim-respository" name="bim-respository" type="text" value="' . get_option( 'bim-respository' ) . '" class="regular-text code" />';
}

// Define constrants with the saved username and repository.
define('BITBUCKET_USERNAME',	get_option( 'bim-username' ));
define('BITBUCKET_REPOSITORY',	get_option( 'bim-respository' ));


/*
 * Uninstall hook
 * 
 * Register the uninstall hook to be called when the plugin is uninstalled
 * via the Plugins page.
 */

// Register the hook
if ( function_exists('register_uninstall_hook') )
	register_uninstall_hook( __FILE__, 'uninstall_bim');

// Callback function
function uninstall_bim() {
	//if uninstall not called from WordPress exit
	if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) 
	    exit();
	
	// For Single site
	if ( !is_multisite() ) 
	{
	    delete_option( 'bim-username' );
	    delete_option( 'bim-respository' );
	}
}



/*************************************************************************

						DASHBOARD WIDGET

**************************************************************************/


/*
 * Dashboard Widget
 * 
 * Register the widgets this plugin gonna add. We di it under the
 * wp_dashboard_setup action.
 */

add_action('wp_dashboard_setup', function ()
{
	wp_add_dashboard_widget (
		'bitbucket_resolved_issues',
		__('Últimas incidencias resueltas'),
		'bitbucket_resolved_issues_content'
	);
	
	wp_add_dashboard_widget(
		'bitbucket_pending_issues',
		__('Últimas incidencias pendientes'),
		'bitbucket_pending_issues_content'
	);
});


/*
 * Pending Dashboard Widget
 *
 * Simple widgets to display a list of the last 5 solved issues
 */

include_once('widgets/dashboard_resolved.php');


/*
 * Pending Dashboard Widget
 *
 * Simple widgets to display a list of the last 5 solved issues
 */

include_once('widgets/dashboard_pending.php');



/*************************************************************************

						PLUGIN OPTIONS AREA

**************************************************************************/


/*
 * Link from the all plugins list page
 *
 * Generates a link under the plkugin's title, in the plugins list.
 */

add_filter('plugin_action_links', function ($links, $file) {
 
    if ( $file == 'bitbucket-issue-manager/bitbucket.php' ) {
        /* Insert the link at the end*/
        $links['settings'] = sprintf( '<a href="%s"> %s </a>', admin_url( 'options-general.php' ), __( 'Settings', 'plugin_domain' ) );
    }
    return $links;
 
}, 10, 2);



/*
 * Options Page
 *
 * Creates the options page to store the Client ID
 */

add_action('admin_init', 'seo_meta_description_register');

function seo_meta_description_register ()
{
	register_setting('reading', 'meta_description', 'sanitize_html');
}

function sanitize_html ($input)
{
	return strip_tags(substr($input, 0, 160));
}

add_action( 'admin_menu', 'seo_meta_description' );

function seo_meta_description()
{
	add_settings_field( 'meta_description', __('Default description for the meta tag'), 'description_input_area', 'reading' );
	
	//add_settings_section( 'test-id-setting', 'Title of my section', 'test_output', 'general' );
	function description_input_area($args){
		echo '<textarea name="meta_description" rows="5" cols="50" id="meta_description" class="large-text code">'.get_option('meta_description').'</textarea>';
	}
}



/*************************************************************************

						HELPER FUNCTIONS

**************************************************************************/

/*
 * File Get Contents using CURLS
 *
 * Retrieves the content of the given URL using CURL
 */

function file_get_contents_curl($url) {
	$ch = curl_init();
	
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
	curl_setopt($ch, CURLOPT_URL, $url);
	
	$data = curl_exec($ch);
	
	//var_dump($data);
	curl_close($ch);
	
	return $data;
}


/*
 * Get BitBucket issue URL
 *
 * Generates the URL for the given bitbucket issue ID
 */

function get_bitbucket_issue_url ( $id )
{
	return 'https://bitbucket.org/' . BITBUCKET_USERNAME . '/' . BITBUCKET_REPOSITORY ."/issue/$id/";
}
