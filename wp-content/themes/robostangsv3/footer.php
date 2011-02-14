<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content
 * after.  Calls sidebar-footer.php for bottom widgets.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?>
	</div><!-- #footer -->
	</div><!-- #main -->

	<footer id="footer" role="contentinfo">
		<div id="site-info" class="col-3">
			<a href="/" title="home">
				<span id="logo"></span>
				<span class="team">Robostangs</span>
				<span class="number">FRC Team 548</span>
				<span class="location">Northville, MI</span>
			</a>	
		</div>
		<div class="float-right footer-box">
			<div id="footer-headers" class="clearfix">
				<h4 class="col-2">Navigation:</h4>
				<h4 class="col-2">Quick Links:</h4>
				<h4 class="col-3">Official Twitter:</h4>
				<h4 class="col-2">Connect:</h4>
			</div>
			<br class="clearfix">
			<div class="site-nav col-2">
				<?php wp_nav_menu( array( 'container_class' => 'menu-header clearfix', 'theme_location' => 'primary' ) ); ?>
			</div>
			<div class="site-nav col-2">
				<?php wp_nav_menu( array( 'container_class' => 'menu-header clearfix', 'theme_location' => 'quick-links' ) ); ?>
			</div>
			<div id="twitter" class="col-3">
				<div id="tweet">
					<ul id="twitter_update_list">
					</ul>
				</div>
				<a href="http://www.twitter.com/#!/frc548" id="account" class="footer-button">@frc548 on Twitter</a>
			</div>
			<div id="connect" class="col-2">
				<ul>
					<li><a href="mailto:team@robostangs.com">Email Us</a></li>
					<li class="facebook"><a href="http://www.facebook.com/pages/Robostangs-548/116480071723806">Facebook</a></li>
					<li><a href="http://www.thebluealliance.com/team/548">Blue Alliance</a></li>
				</ul>
			</div>
		</div>
		<div class="col-12 clearfix copyright">
        	&copy; Copyright 2011 All Rights Reserved | Designed &amp; Developed (Coded) by <a href="http://www.robostangs.com/">Team 548</a> | Powered by <a href="http://www.wordpress.org">Wordpress</a> + Our Own Modifications
		</div>
	</footer>

</div><!-- #wrapper -->
<script src="http://twitter.com/javascripts/blogger.js"></script>
<script src="http://twitter.com/statuses/user_timeline/frc548.json?callback=twitterCallback2&count=1"></script>
<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
</body>
</html>
