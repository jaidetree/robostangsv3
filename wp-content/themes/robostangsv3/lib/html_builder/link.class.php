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
class link extends HTML
{
	protected function set_open_tag()
	{
		$this->open_tag = get_class( $this );
	}
	protected function set_close_tag()
	{
		$this->close_tag = '';
	}

	public function __construct( $before_tag='', $indent_level = '' )
	{
		parent::__construct( array(
			'after_tag' => "\n", 
			'before_tag' => $before_tag,
			'indent_level' => (int)$indent_level,
		) );

		$this->set_attribute( 'charset' );
		$this->set_attribute( 'href' );
		$this->set_attribute( 'hreflang' );
		$this->set_attribute( 'media' );
		$this->set_attribute( 'rel' );
		$this->set_attribute( 'rev' );
		$this->set_attribute( 'target' );
		$this->set_attribute( 'type' );
		
	}
}
?>
