<!DOCTYPE html>
<html>  
<head>                    
<meta charset=<?php bloginfo('charset'); ?>">
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'twentyten' ), max( $paged, $page ) );

	?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="stylesheet" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="wrapper" class="hfeed grid960">
	<header id="banner" class="clearfix">
		<div id="branding" class="col-4">
			<?php $heading_tag = ( is_home() || is_front_page() ) ? 'h1' : 'div'; ?>
			<<?php echo $heading_tag; ?> id="site-title">
				<span>
					<a href="<?php echo home_url( '/' ); ?>" title="Robostangs" rel="home">Robostangs</a>
				</span>
			</<?php echo $heading_tag; ?>>
			<div id="site-description">Northville, MI<span>FRC Team # 548</span></div>
		</div>
		<div class="col-4 float-right">
			<ul class="sponsors">
				<li><a href="http://www.usfirst.org" class="first">FIRST</a></li>
				<li><a href="http://www.gm.com" class="gm">General Motors</a></li>
			</ul>
		</div>
	</header>
	<nav id="access" role="navigation" class="col-12">
		<div class="inner-wrap">
			<?php /*  Allow screen readers / text browsers to skip the navigation menu and get right to the good stuff */ ?>
			<div class="skip-link screen-reader-text"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'twentyten' ); ?>"><?php _e( 'Skip to content', 'twentyten' ); ?></a></div>
			<?php /* Our navigation menu.  If one isn't filled out, wp_nav_menu falls back to wp_page_menu.  The menu assiged to the primary position is the one used.  If none is assigned, the menu with the lowest ID is used.  */ ?>
			<? echo get_page_links(); ?>
		</div>
	</nav>
	<div id="main" class="clearfix">
