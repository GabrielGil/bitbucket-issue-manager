<?

/*
 * Widget content
 *
 * Retrieves the issues and generate the widget content's html.
 */

function bitbucket_resolved_issues_content()
{
	global $bitbucket_username;
	global $bitbucket_respository;
	
    $all_issues = json_decode(file_get_contents_curl('https://bitbucket.org/api/1.0/repositories/' . BITBUCKET_USERNAME . '/' . BITBUCKET_REPOSITORY . '/issues?status=resolved'));
    
    // Shows info if there is any issue right now.
    if ( $all_issues->count < 1 )
    {
	    echo '<h4>No hay incidencias resueltas.</h4><p>Visita la página de incidencias del proyecto que has indicado en la página de opciones y tenlas a un vistazo de tu Wordpress.</p>';
		return;
    
    } elseif ( $all_issues > 0 )
    {
    
	    // Just the last five (Delegate on the endpoint)
	    $all_issues = array_slice($all_issues->issues, 0, 5);
	    
	    // Display it up
	    echo '<ul>';
	    
	    foreach ($all_issues as $issue) {
	    	echo '<li>';
	    	echo '<p>';
	    	echo '<span style="float:right;" ><strong>' . date("H:m d-m-Y", strtotime($issue->created_on)) . '</strong></span>';
			echo '<a>' . $issue->title . '</a>' . '<br />';
			echo $issue->content;
			echo '</p>';
			echo '</li>';
	    }
		
		echo '<ul>';
		
		echo '<a target="_blank" style="" class="button-secondary" href="http://bitbucket.com/gabrielgil/odd-barcelona/issues">Ver todas en Bitbucket</a>';
	
	} else
	{
		echo '<h4>No se qué ha pasado, pero no ha pasado nada y ese es el problema. ¿?</h4>';
		return;
	}
}