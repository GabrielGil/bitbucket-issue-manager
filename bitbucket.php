<?php

/*************************************************************************

Plugin Name:		Bitbucket Issue Manager
Plugin URI:			http://gabrielgil.es/bitbucket-issue-manager
Description:		Adds useful widgets to track your recent bitbucket issues. I pretend add more features soon. (Front-end widgets, issue listing page etc). That's why the plugin is called <strong>Manager</strong> and not just <strong>Dashboard widgets</strong>.
Version:			0.9-beta.1
Author:				Gabriel Gil
Author URI:			http://gabrielgil.es/
Text Domain:		bim
License:			GPLv2 or later
License URI:		http://www.gnu.org/licenses/gpl-2.0.html
GitHub Plugin URI:	gabrielgil/bitbucket-issue-manager

**************************************************************************/


/*************************************************************************

						INDEX

			* -> License
			* -> Options
			* -> Notices
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

						REQUIRES

**************************************************************************/

require_once( 'class/bitbucket.general.php' );
require_once( 'class/bitbucket.issue.php' );



/*************************************************************************

						LOCALIZATION

**************************************************************************/

add_action('plugins_loaded', function () {
	load_plugin_textdomain( 'bim', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
});


/*************************************************************************

						OPTIONS FIELDS

**************************************************************************/


/**
 * Add settings fields to general settings page.
 *
 * Hooks into admin_init to add options to save the username and
 * repository names.
 *
 * @since 0.7
 *
 * @return null Description.
 */

add_action( 'admin_init', function ()
{
	// Add the section to reading settings so we can add our
 	// fields to it
 	add_settings_section(
		'bim-settings-section',
		__( 'Bitbucket Issue Manager Settings', 'bim' ),
		'bim_setting_section_callback',
		'general'
	);

	// Add the username field
	add_settings_field(
		'bim-username',
		__( 'BitBucket Username', 'bim' ),
		'bim_username_field_callback',
		'general',
		'bim-settings-section'
	);
	// Register the field so we can sanitize it.
	register_setting( 'general', 'bim-username' );

	add_settings_field(
		'bim-repository',
		__( 'BitBucket Repository', 'bim' ),
		'bim_repository_field_callback',
		'general',
		'bim-settings-section'
	);
	register_setting( 'general', 'bim-repository' );

});


/*
 * Delete errors
 *
 * Delete wrong options saved on previous plugin version.
 */

add_action( 'admin_init', function ()
{
	if(get_option( 'bim-respository' )){
		update_option( 'bim-repository', get_option( 'bim-respository' ));
		delete_option( 'bim-respository' );
	}
});



/*************************************************************************

						NOTICES

**************************************************************************/


if ( !get_option( 'bim-username' ) || !get_option( 'bim-repository' ) )
{
	add_action( 'admin_notices', function ()
	{
		?>
	    <div class="updated">
	        <p><?php printf( __( 'Config Bitbucket username and the repository you want to track under Settings, General options page!', 'bim' ), admin_url( '/options-general.php#bim' ) ); ?></p>
	    </div>
	    <?php
	});
}


/*
 * Callback functions
 *
 * The following functions prints the info, and the input elements.
 */

function bim_setting_section_callback ()
{
	echo '<a id="bim"></a>
		<p>' . __( 'Here you can set you BitBucket username and the repository you want manage.', 'bim') . '</p>';
}

function bim_username_field_callback ()
{
	echo '<input id="bim-username" name="bim-username" type="text" value="' . get_option( 'bim-username' ) . '" class="regular-text code" />';
}

function bim_repository_field_callback ()
{
	echo '<input id="bim-repository" name="bim-repository" type="text" value="' . get_option( 'bim-repository' ) . '" class="regular-text code" />';
}

// Define constrants with the saved username and repository.
define('BITBUCKET_USERNAME',	get_option( 'bim-username' ));
define('BITBUCKET_REPOSITORY',	get_option( 'bim-repository' ));


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
	    delete_option( 'bim-repository' );
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
		__('Last solved issues', 'bim'),
		'bitbucket_resolved_issues_content'
	);

	wp_add_dashboard_widget(
		'bitbucket_pending_issues',
		__('Last pending issues', 'bim'),
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
        $links['settings'] = sprintf( '<a href="%s"> %s </a>', admin_url( 'options-general.php#bim' ), __( 'Settings', 'bim' ) );
    }
    return $links;

}, 10, 2);



/*************************************************************************

						HELPER FUNCTIONS

**************************************************************************/


/*
 * Get BitBucket endpoint
 *
 * Returns the bitbucket endpoint according API version
 */
function get_bitbucket_endpoint($version = 1)
{

	if ( $version==1 ) {
		$version = 1;
	} else {
		$version = 2;
	}
	return "https://bitbucket.org/api/$version.0";
}

function get_bitbucket_issues_admin ()
{
	return 'https://bitbucket.org/' . BITBUCKET_USERNAME . '/' . BITBUCKET_REPOSITORY . '/admin/issues';
}



