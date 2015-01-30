<?php

/*
 * Widget content
 *
 * Retrieves the issues and generate the widget content's html.
 */

function bitbucket_pending_issues_content() {

	// Fetch non resolved issues
	$issues = Bitbucket_Issue::get_issues( 'new' );

	//echo '<pre>'.print_r($issues, true) . '</pre>';

	// Display errors
    if ( Bitbucket::echo_errors( $issues ) == 1 ) {
	    return;
    }


    if ( count($issues->issues) < 1 )
    {
	    echo '<h4>' . __( 'No pending issues.', 'bim') . '</h4><p>' . __( 'Nothing to do! Add issues on your Bitbucket repository page.', 'bim' ) . '</p>';
		return;

    }

	// List issues
	Bitbucket_Issue::print_dashboard_issue_listing( $issues );

	echo '<a target="_blank" style="" class="button-secondary" href="http://bitbucket.com/' . BITBUCKET_USERNAME . '/' . BITBUCKET_REPOSITORY .'/issues?status=!resolved">' . __( 'View all on Bitbucket\'s site', 'bim' ) .'</a>';

}