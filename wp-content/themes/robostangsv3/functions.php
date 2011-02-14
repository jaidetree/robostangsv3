<?php
add_action( 'wp_footer', 'grid_overlay' );
add_action( 'wp_head', 'grid_js' );
function grid_overlay()
{
	echo '<div id="over-grid"></div>
';	
}

function grid_js()
{
	echo '<script type="text/javascript">
	document[\'onkeydown\'] = eventHandler;
		
	function eventHandler (e) {
		var event = e || window.event;
		if( ( event.altKey && event.keyCode === 186 ) || ( event.altKey && event.keyCode === 59 ) )
		{
			if( document.getElementById(\'over-grid\').style.display != \'block\' ) {
				document.getElementById(\'over-grid\').style.display = \'block\';
			}else{
				document.getElementById(\'over-grid\').style.display = \'none\';
			}
		}
	}
</script>
	';
}
function get_page_links()
{
    global $page_links;

	if( ! $page_links )
	{
	$page_links = wp_nav_menu( array( 'container_class' => 'menu-header clearfix', 'echo' => 'false', 'theme_location' => 'primary' ) ); 
	}

	echo $page_links;
}
register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'twentyten' ),
	) );      
register_nav_menus( array(
		'quick-links' => __( 'Quick Links', 'twentyten' ),
	) );            


if ( ! function_exists( 'twentyten_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post—date/time and author.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_posted_on() {
	printf( __( '<span class="%1$s">Posted on</span> %2$s <span class="meta-sep">by</span> %3$s', 'twentyten' ),
		'meta-prep meta-prep-author',
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date()
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'twentyten' ), get_the_author() ),
			get_the_author()
		)
	);
}
endif;    
?>
