<?php


/**
* Generic Bitbucket class
*/
class Bitbucket {

	static function echo_errors ( $issues ) {
		
		// If the repository is private
	    if ( empty($issues) ) {
		    echo '<h4>' . __( 'Your issues are private!', 'bim') . '</h4>';
		    echo '<p>' . sprintf( __( 'Check your settings and make it public in your <a target="_blank" href="%s">bitbucket admin page</a>', 'bim'), get_bitbucket_issues_admin() ) . '</p>';
		    return 1;
	    }
	    
	    // If the resource isn't found
	    if ( isset($issues->error) ) {
		    echo '<h3>' . __( 'Unable to find your repository', 'bim') . '</h3>';
		    echo '<p>' . 
		    	sprintf(
		    		__( 'Check your username and repository name on the <a href="%s">Settings -> General</a> page.', 'bim'), admin_url( '/options-general.php' )
		    	) . '</p>';
		    return 1;
	    }
		
	}

}
