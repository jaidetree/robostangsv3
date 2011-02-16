<?php
/**
 * Our main FormInputClass
 *
 * Allows us to add input elements to our meta_boxes without worrying about writing html.
 * This was probably unnecessary, but I like a good challenge.
 * @author Jay Zawrotny <jayzawrotny@gmail.com>
 * @version 1.0
 * @package RoboStangs2011
 */
/**
 * Our main abstract class
 *
 * Handles all our main function along with 2 methods that have to be defined by a sub class:
 * parse_attributes to parse the attributes array before converting to HTML
 * parse_value to parse the value before converting that into HTML
 * @package RoboStangs2011
 * @subpackage FormInputClass
 */
abstract class FormInputClass
{
	/*
	 * Abstract Method Declarations
	 * -----------------------------------------
	 */

	/**
	 * The abstract parse_attributes class
	 * @abstract
	 * @method 
	 * @access public
	 * @param  array $attributes Is also the return value, generally.
	 * @return array
	 */

	/**
	 * The abstract parse_value class
	 * @abstract
	 * @method 
	 * @access public
	 * @param  string $value May also just be returned.
	 * @return string
	 */

	/*
	 * Variables
	 * -----------------------------------------
	 */

	/**
	 * Holds the <input type="type"> variable.
	 * @access protected
	 * @var string
	 */
	protected $type = '';
	/**
	 * The input name attribute
	 * @access protected
	 * @var string
	 */
	protected $name = '';
	/**
	 * The input id attribute
	 * @access protected
	 * @var string
	 */
	protected $id = '';
	/**
	 * The input value attribute or tag inner HTML
	 * @access protected
	 * @var string
	 */
	protected $value = '';
	/**
	 * An string of extra attributes to be used later; formatted for the function: parse_str
	 * @access protected
	 * @var sstring
	 */
    protected $extra_attributes = '';
	/**
	 * The input class attribute
	 * @access protected
	 * @var string
	 */
	protected $class = '';
	
	/**
	 * FormInput Constructor
	 *
	 * Initiates the FormInput class. Sets the necessary attributes.
	 * @method
	 * @access public
	 * @param string $type The type of <input type> attribute, textarea, or select.
	 * @param string $name The name attribute
	 * @param string $value Optional: Either the value attribute or tag HTML content.
	 * @param string $class Optional: The classname
	 * @param string $extra_attributes Optional: A string of optional attributes in key=value&key2=value2 form.
	 */
	function __construct( $type, $name, $id, $value = '', $class = '', $extra_attributes = '' )
	{
		$this->type = (string)$type;
		$this->name = (string)$name;
		$this->id = (string)$id;
		$this->value = $value;
		$this->class = (string)$class;
		$this->extra_attributes = (string)$extra_attributes;
	}

	/**
	 * Add an attribute to be parsed into the HTML
	 *
	 * Appends  it to our extra attributes array to be
	 * parsed into HTML later. <tag name="value">
	 * @access public
	 * @param string $name The HTML attribute name
	 * @param string $value The HTML attribute's value 
	 */
	function add_attribute($name, $value)
	{
		$this->extra_attributes[ $name ] = $value;
	}

	/**
	 * The toString method, to give it contextual functionality.
	 *
	 * I thought it would be neat if you could be like echo $field;
	 * @method
	 * @access public
	 */
	function __toString()
	{
		return $this->draw();
	}

	/**
	 * Get the name attribute of this class/html input element.
	 * 
	 * Just returns the protected $name attribute of this class.
	 * @access public
	 * @return string
	 */
	function getName()
	{
		return $this->name;
	}

	/**
	 * Renders the Class as an HTML input element.
	 *
	 * Discovers it's basic type, luckily at this point there aren't that many.
	 * @access public
	 * @param bool $echo Optional: Default: false; Determines whether to echo the 
	 * rendered HTML immediately
	 * @return string
	 * @todo Come up with a way to allow classes to expand on this.
	 */
	function draw( $echo = false )
	{
		$html = '';
		$tag_open = '';
		$tag_close = '';
		$attributes = '';
		$value = '';

		switch( $this->type )
		{
			case 'select':
				$tag_open = 'select';
				$value = true;
			break;
			case 'textarea':
				$tag_open = 'textarea';
				$tag_close = 'textarea';
				$value = $this->value;
			break;

			default:
				$tag_open = 'input';
            	$attributes['type'] = $this->type;
				$attributes['value'] = $this->value;
			break;
		}

		$html = "<{$tag_open} ";
		$html .= $this->attr_to_str( $attributes );
		$html .= ">";

		if( $value )
		{
			$html .= $this->parse_value($value);
		}

		if( $tag_close )
		{
			$html .= "</{$tag_close}>";
		}

		if( $echo )
		{
			echo $html;
		}

		return $html;


	}
	/**
	 * Abstract method placeholder
	 * 
	 * Defines our abstract method as it's going to get called even if no sub-class is used.
	 * It's a bit of a dummy class. Subclasses will use this to manipulate the element's
	 * HTML tag content.
	 * @abstract
	 * @access protected
	 * @param string $value the value to be parsed before becoming HTML.
	 * @return string
	 */
	protected function parse_value( $value )
	{
		return $value;
	}
	/**
	 * Abstract method attributes placeholder
	 * 
	 * Defines our abstract method as it's going to get called even if no sub-class is used.
	 * It's a bit of a dummy class. Subclasses will use this to manipulate the element's
	 * HTML attributes.
	 * @abstract
	 * @access protected
	 * @param array $attributes the array of attributes to be manipulated then returned.
	 * @return array
	 */
	protected function parse_attributes( $attributes )
	{
		return $attributes;
	}
	/**
	 * Converts our attributes to strings
	 *
	 * It processes all our attributes and converts them into an HTML string.
	 * This also calls our sub-class' parse_attributes function.
	 * @access protected
	 * @param array $attributes An array of attributes to convert to HTML
	 * @return string
	 */
	protected function attr_to_str($attributes)
	{
		$extra_attributes = parse_str( $this->extra_attributes );
		$attributes = array_merge( $attributes, $extra_attributes );
		$this->parse_attributes( $attributes );
        $str = '';

		foreach( (array)$attributes as $name => $value )
		{
			$str .= $name . '"' . $value . '" ';
		}

		$str = preg_replace( "/ $/", '', $str );

		return $str;
	}
}
?>
