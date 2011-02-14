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
register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'twentyten' ),
	) );      
register_nav_menus( array(
		'quick-links' => __( 'Quick Links', 'twentyten' ),
	) );      
?>
