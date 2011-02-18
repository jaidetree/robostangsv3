<?php
/**
 * The Robostangs Rotator System
 *
 * This module is used to setup our rotator and seperate some of the more
 * intense logic so our template doesn't get too messy.
 * 
 * @author Jay Zawrotny <jayzawrotny@gmail.com>
 * @version 1.0
 * @package RoboStangs2011
 */
/**
 * The Robostangs Rotator Class
 *
 * The RoboRotator class handles displaying the items, and the styles
 * each item has based on their type.
 *
 * @package RoboStangs2011
 * @subpackage RoboRotator
 */
class RoboRotator
{
	public static $width, $height;
	public static $slides = array();
	public static $setup = false;
	public static $total_posts = 0;
    public static $ui_counter = 0;
	public static $total_slides = 0;

	public static function insert($total_slides, $width, $height)
	{
		self::$width = $width;
		self::$height = $height;
		self::get_posts();
		self::build_slides();
		self::build_ui();
	}
	
	public static function build_ui()
	{

		$div = new div();
		$ul = new ul();
		$div->id = 'rotator-ui';
		$ul->class = 'clearfix';

		for( $i = 0; $i < self::$total_posts; $i++ )
		{
			$ul->insert( self::build_ui_control() );
	  	}


		$div->insert( $ul );

		echo $div;
	}	

	public static function build_ui_control()
	{
		$li = new li();
		$a = new a();
		$a->href = '#';
		$a->rel = self::$ui_counter;
		
		if( self::$ui_counter == 0 )
		{
			$a->class = 'selected';
		}
	
		$li->insert( &$a )->insert( '&bull;' );
		self::$ui_counter = self::$ui_counter + 1;

		return $li;
	}

	public static function build_slides()
	{
		$div = new div();
		$div->id = "rotator-container";

		$ul = new ul();
		$ul->id = "rotator-slides";
		$ul->classname = "clearfix";

		foreach( self::$slides as $slide )
		{
			$ul->insert( $slide );
		}

		$div->insert($ul);
		echo $div;
	}
	public static function setup()
	{

		add_image_size( 'rotator-thumbnail', self::$width, self::$height, false );
		add_action( 'wp_head', '\RoboRotator::load_css_file' );
		
		self::$setup = true;
	}

	public static function load_css_file()
	{
		if( ! file_exists( THEME_PATH . 'css/rotator.css' ) )
		{
			return false;
		}

		$link = new link("\t\t");
		$link->rel = 'stylesheet';
		$link->href = THEME_DIR . '/css/rotator.css';

		echo $link;
	}

	public static function get_posts()
	{
    	query_posts( 'post_type=rotator&posts_per_page=6&orderby=date&order=DESC' );

		if( ! have_posts() )
		{
			return false;
		}

		while( have_posts() )
		{
			the_post();

			self::build_slide();
			self::$total_posts++;
		}

	}

	public static function build_slide()
	{
		$post_id = get_the_ID();
		$rotator_slide_type = get_post_meta( $post_id, '_rotator_type', true );

		switch( $rotator_slide_type )
		{
        	case 'link':
				self::$slides[] = new RoboRotatorLinkSlide($post_id);
				break;
			case 'post':
				self::$slides[] = new RoboRotatorPostSlide($post_id);
				break;
			case 'youtube':
				self::$slides[] = new RoboRotatorYoutubeSlide($post_id);
				break;
			case 'image':
				self::$slides[] = new RoboRotatorImageSlide($post_id);
				break;
		}
	}
}

/*
 * Run our RoboRotator Setup Function
 */
RoboRotator::setup();
/***********************************/

class RoboRotatorSlide
{
	var $post_id = 0;
	var $width = 0;
	var $height = 0;
    var $li = null;
                                                    
	public function init($post_id)
	{
		$this->post_id = $post_id;
		$this->width = RoboRotator::$width;
		$this->height = RoboRotator::$height;
		$this->li = new li();
		$this->li->class = "slide";
		$this->li->id = 'slide-' . $this->post_id;
	}

	public function get_image()
	{
		return get_the_post_thumbnail( $post_id, 'rotator-thumbnail' );
	}

	public function get_image_src()
	{
		$id = get_post_thumbnail_id($this->post_id);
		$image_data = wp_get_attachment_image_src( $id, 'rotator-thumbnail' );

		return $image_data;
	}

	public function __toString()
	{
		return $this->build();
	}

	public function build()
	{
		return $this->li->html();
	}

	public function add_paragraph()
	{
		$p = new p();
		$p->insert( get_the_content() );

		return $p;
	}
	public function add_title()
	{
		$h2 = new h2();
		$h2->insert( get_the_title() );

		return $h2;
	}
}
class RoboRotatorLinkSlide extends RoboRotatorSlide
{

	public function __construct($post_id)
	{
		$this->init($post_id);
		$a = new a();
		$this->set_link( &$a );

		$this->li->class .= ' link-slide';
		$this->li->insert( &$a )->insert( $this->get_image() );
	}	

	private function set_link( $a )
	{
	   $link = get_post_meta( $this->post_id, 'url-link', true );
	   $a->href = $link;
	}
}
/**
 * Rotator Post Slide Class
 *
 * @todo Description
 */
class RoboRotatorPostSlide extends RoboRotatorSlide
{

	public function __construct($post_id)
	{
		$this->init($post_id);
		$a = new a();
		$this->set_link( &$a );

		$this->li->class .= ' post-slide';
		$image_data = $this->get_image_src();
		$style = sprintf( "background: url(%s) no-repeat;width: %dpx;height: %dpx;", $image_data[0], $image_data[1], $image_data[2] );
		$div = new div();
		$div->style = $style;
		$div->insert( $this->add_title() );
		$this->li->insert( &$a )->insert( &$div )->insert( $this->add_paragraph() );
	}	

	private function set_link( $a )
	{
	   $post_id = get_post_meta( $this->post_id, 'post-id', true );
	   $link = get_permalink( $post_id );
	   $a->href = $link;
	}

}
/**
 * Rotator Youtube Slide Class
 *
 * @todo Description
 */
class RoboRotatorYoutubeSlide extends RoboRotatorSlide
{
	public function __construct($post_id)
	{
		$this->init($post_id);
		$video_id = $this->get_video_id();

		$iframe = new iframe();
		$iframe->title = 'Youtube Video Player';
		$iframe->width = 597;
		$iframe->height = 300;
		$iframe->src = "http://www.youtube.com/embed/{$video_id}?wmode=transparent";
		$iframe->frameborder = 0;
		$iframe->allowfullscreen = true;

		$this->li->class .= ' youtube-slide';
		$this->li->insert( &$iframe );
	}	


	public function get_video_id()
	{
		return get_post_meta( $this->post_id, 'youtube', true );
	}
}

/**
 * Rotator Image Slide Class
 */
class RoboRotatorImageSlide extends RoboRotatorSlide
{

	public function __construct($post_id)
	{
		$this->init($post_id);
		$this->li->class .= ' image-slide';
		$this->li->insert( $this->get_image() );
	}	
}

?>
