<?

/*
 * Widget content
 *
 * Retrieves the issues and generate the widget content's html.
 */

function bitbucket_pending_issues_content()
{
	
	$bitbucket_request_uri = 'https://bitbucket.org/api/1.0/repositories/' . BITBUCKET_USERNAME . '/' . BITBUCKET_REPOSITORY . '/issues?status=!resolved';
	
    $all_issues = json_decode(file_get_contents_curl($bitbucket_request_uri));
    
    // Shows info if there is any issue right now.
    if ( $all_issues->count < 1 )
    {
	    echo '<h4>No hay incidencias pendientes.</h4><p>Visita la página de incidencias del proyecto que has indicado en la página de opciones y tenlas a un vistazo de tu Wordpress.</p>';
		return;
    
    } elseif ( $all_issues > 0 )
    {
    
	    // Just the last five (Delegate on the endpoint)
	    $all_issues = array_slice($all_issues->issues, 0, 4);
	    
	    // Display it up
	    echo '<ul>';
	    
	    $first_issue = true;
	    
	    foreach ($all_issues as $issue) {
	    	echo '<li>';
	    	echo '<p>';
	    	echo '<span style="float:right;" ><strong>' . date("H:i d-m-Y", strtotime($issue->created_on)) . '</strong></span>';
			echo '<a href="' . get_bitbucket_issue_url( $issue->local_id ) . '" target="_blank">' . $issue->title . '</a>' . '<br />';
			echo $first_issue ? $issue->content : '';
			echo '</p>';
			echo '</li>';
			
			$first_issue = false;
	    }
		
		echo '<ul>';
		
		echo '<a target="_blank" style="" class="button-secondary" href="http://bitbucket.com/gabrielgil/odd-barcelona/issues">Ver todas en Bitbucket</a>';
	
	} else
	{
		echo '<h4>No se qué ha pasado, pero no ha pasado nada y ese es el problema. ¿?</h4>';
		return;
	}
}