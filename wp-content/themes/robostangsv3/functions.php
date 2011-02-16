<?php

/* =Constants                     
--------------------------------------------- */
define( 'THEME_DIR', preg_replace( "#^.*/wp-content/#", '/wp-content/', dirname(__FILE__) ) );
define( 'THEME_LIB_DIR', dirname(__FILE__) . '/lib/' );


/* =Variables                     
--------------------------------------------- */
$loaded_extensions = array();

/* =Actions
--------------------------------------------- */
add_action( 'wp_footer', 'grid_overlay' );
add_action( 'wp_head', 'grid_js' );
add_action( 'init', 'theme_init' );


/* func theme_init  *//*{{{*/
function theme_init()
{
	global $loaded_extensions;
	add_theme_support( 'post-thumbnails' );

	get_files( THEME_LIB_DIR . 'html_builder', 'load_library' );

	if( is_admin() )
	{
		get_files( THEME_LIB_DIR . 'form_builder', 'load_library' ); 
		get_files( THEME_LIB_DIR . 'meta_boxes', 'load_library' );
	}

	$uri = explode( '/', $_SERVER['REQUEST_URI'] );

	list( $application, $page, $action ) = $uri;
	
	switch( $application )
	{
	default:
		load_library( THEME_LIB_DIR . 'modules/rotator.php' );
		break;
	}

	/* Register Nav Menus  *//*{{{*/
	register_nav_menus( array(
			'primary' => __( 'Primary Navigation', 'twentyten' ),
		) );      
	register_nav_menus( array(
			'quick-links' => __( 'Quick Links', 'twentyten' ),
		) );            
	/*}}}*/
	/* enqueue js  *//*{{{*/
	wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'jTater', THEME_DIR . '/js/rotator.js' );
	/*}}}*/
	/* custom post types  *//*{{{*/
	$rotator_labels = array(
		'name' => _x( 'Rotator', 'post type general name' ),
		'menu_item' => 'Rotator',
	);
	
	register_post_type( 'rotator', array(
		'labels' => $rotator_labels,
		'public' => true,
		'publicly_queryable' => false,
		'exclude_from_search' => true,
		'show_ui' => true,
		'rewrite' => false,
		'capability_type' => 'post',
		'has_archive' => false,
		'hierarchical' => false,
		'menu_position' => 4,
		'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'custom-fields' ),
	));/*}}}*/
}/*}}}*/

/* =Theme Functions
--------------------------------------------- */
/* func get_page_links() {{{*/
function get_page_links()
{
    global $page_links;

	if( ! $page_links )
	{
		$page_links = wp_nav_menu( array( 
			'container_class' => 'menu-header clearfix', 
			'echo' => 'false', 
			'theme_location' => 'primary' 
			) ); 
	}

	echo $page_links;
}
/*}}}*/
 /*func get_files(){{{*/
function get_files($directory, $callback = false, $filter = '/\.php$/')
{
	$dir = dir( $directory );
	$files = array();
	while( ( $file = $dir->read() ) !== false )
	{	
		if( ! preg_match( "$filter", $file ) )
		{
			continue;
		}
        if( ! $callback )
		{
			$files[] = $directory . "/" . $file;
		}
		call_user_func( $callback, $directory . "/" . $file );
	}
    if( ! $callback )
	{
		return $files;
	}
}/*}}}*/
/*func load_library{{{*/
function load_library($library_file)
{
	global $loaded_extensions;
	if( ! file_exists( $library_file ) )
	{
		return false;
	}
	$loaded_extensions[] = $library_file;
    include $library_file;
}/*}}}*/

/* =Twentyten Functions
--------------------------------------------- */
/* func twentyten_posted_on /*{{{*/
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
/*}}}*/

/* =Grid Functions
--------------------------------------------- */
/* func grid_overlay  *//*{{{*/
function grid_overlay()
{
	echo '<div id="over-grid"></div>
';	
}/*}}}*/
/* func grid_js */ /*{{{*/
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
}/*}}}*/

?>
