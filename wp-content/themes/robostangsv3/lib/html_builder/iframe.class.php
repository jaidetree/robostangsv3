<?php 
/**
 * An HTML Abstraction Class
 *
 * Allows a programmer to use an object oriented system to build their HTML
 * 
 * @author Jay Zawrotny <jayzawrotny@gmail.com>
 * @version 1.0
 * @package RoboStangs2011
 */
/**
 * HTML Abstraction Sub Class
 *
 * Creates the single HTML element and allowed attributes if neccesary.
 * @package RoboStangs2011
 * @subpackage HTMLClass
 */    
class iframe extends HTML
{
	protected function set_open_tag()
	{
		$this->open_tag = get_class( $this );
	}
	protected function set_close_tag()
	{
		$this->close_tag = get_class( $this );
	}

	public function __construct($content = '', $indent_level = 0, $after_html = '', $before_html = '' )
	{
		parent::__construct( array(
			'after_html' => $after_html, 
			'before_html' => $before_html,
			'indent_level' => (int)$indent_level,
			'content' => $content,
		) );

		$this->set_attribute( 'frameborder' );
		$this->set_attribute( 'height' );
		$this->set_attribute( 'longdesc' );
		$this->set_attribute( 'marginheight' );
		$this->set_attribute( 'marginwidth' );
		$this->set_attribute( 'name' );
		$this->set_attribute( 'scrolling' );
		$this->set_attribute( 'src' );
		$this->set_attribute( 'width' );
		$this->set_attribute( 'allowfullscreen' );

	}
}
?>

