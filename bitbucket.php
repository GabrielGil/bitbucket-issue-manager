<?
/*************************************************************************

Plugin Name:		Bitbucket issue manager
Plugin URI:			http://gabrielgil.es/bitbucket-issue-manager
GitHub Plugin URI:	gabrielgil/bitbucket-issue-manager
Description:		Adds useful widgets to track your recent bitbucket issues
Version:			0.7
Author:				Gabriel Gil
Author URI:			http://gabrielgil.es/

**************************************************************************/


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
	
	add_settings_field(
		'bim-username',
		'BitBucket Username',
		'bim_username_field_callback',
		'general',
		'bim-settings-section'
	);
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


function bim_setting_section_callback ()
{
	echo '<p>Bitbucket Issue Manager</p>';
}


function bim_username_field_callback ()
{
	echo '<input id="bim-username" name="bim-username" type="text" value="' . get_option( 'bim-username' ) . '" />';
}

function bim_respository_field_callback ()
{
	echo '<input id="bim-respository" name="bim-respository" type="text" value="' . get_option( 'bim-respository' ) . '" />';
}


define('BITBUCKET_USERNAME',	get_option( 'bim-username' ));
define('BITBUCKET_REPOSITORY',	get_option( 'bim-respository' ));


/*************************************************************************

						INDEX
					
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
