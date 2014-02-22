<?php


/**
* Bitbucket Issue Class
*/
class Bitbucket_Issue {

	function __construct () {
		
	}
	
	
	/*
	 * Get BitBucket issues
	 *
	 * Returns and array with all the issues
	 */
	
	static function get_issues ( $status='open', $limit=5 ) {
	
		$bitbucket_request_uri = get_bitbucket_endpoint() . '/repositories/' . BITBUCKET_USERNAME . '/' . BITBUCKET_REPOSITORY . "/issues?status=$status&limit=$limit";
	    return json_decode(file_get_contents_curl($bitbucket_request_uri));
	}
	
	
	/*
	 * Get BitBucket issue URL
	 *
	 * Generates the URL for the given bitbucket issue ID
	 */
	
	static function get_bitbucket_issue_url ( $id ) {
	
		return 'https://bitbucket.org/' . BITBUCKET_USERNAME . '/' . BITBUCKET_REPOSITORY ."/issue/$id/";
	}
	
	
	/**
	 * Print Dashboard Issue Listing
	 *
	 * Prints all the issues
	 */
	
	static function print_dashboard_issue_listing ( $issues ) {
	
		// Display it up
	    echo '<ul>';
	    
	    $first_issue = true;
	    
	    foreach ($issues->issues as $issue) {
	    	echo '<li>';
	    	echo '<p>';
	    	echo '<span style="float:right;" >
	    			<strong>' . human_time_diff(strtotime($issue->created_on)) . '</strong>' . '</span>';
			echo '<a href="' . Bitbucket_Issue::get_bitbucket_issue_url( $issue->local_id ) . '" target="_blank">' . $issue->title . '</a>'
					. ' ('. human_time_diff(strtotime($issue->utc_last_updated)) . ')'. '<br />';
			echo $first_issue ? $issue->content : '';
			echo '</p>';
			echo '</li>';
			
			$first_issue = false;
	    }
		
		echo '<ul>';
		
	}

}
